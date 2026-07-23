<?php
require_once("../../model/AnnonceRepository.php");
require_once("../../controller/MailService.php");
class AnnonceController
{
    private $annonceRepository;

    public function __construct()
    {
        $this->annonceRepository = new AnnonceRepository();
    }

    //Gestion des messages d'erreur
    public function setErrorAndRedirect($message, $title, $redirectUrl = "ListeAnnonce")
    {
        header("Location: $redirectUrl?error=1&message=" . urlencode($message) . "&title=" . urlencode($title));
        exit;
    }
    //Gestion des messages de succès 
    public function setSuccessAndRedirect($message, $title, $redirectUrl = "ListeAnnonce")
    {
        header("Location: $redirectUrl?succes=1&message=" . urlencode($message) . "&title=" . urlencode($title));
        exit;
    }
    //Ajouter une annonce
    public function addAnnonce()
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $titre = trim($_POST['titre'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $salaire = trim($_POST['salaire'] ?? '');
            $categorie_id = $_POST['categorie_id'] ?? '';
            $zone_id = $_POST['zone_id'] ?? '';
            $created_by = $_SESSION['id'] ?? null; 

            if (empty($titre) || empty($description) || empty($salaire) || empty($categorie_id) || empty($zone_id)) {
                $this->setErrorAndRedirect("Tous les champs sont obligatoires.", "Erreur");
            }

            try {
                $reponse = $this->annonceRepository->addAnnonce($titre, $description, $salaire, $categorie_id, $zone_id, $created_by);
                if ($reponse) {
                    // Redirection selon le rôle
                    $redirect = ($_SESSION['role'] === 'Admin') ? "ListeAnnonce" : "MesAnnonces";
                    $this->setSuccessAndRedirect("Votre annonce est en ligne !", "Succès", $redirect);
                }
            } catch (Exception $e) {
                $this->setErrorAndRedirect("Erreur : " . $e->getMessage(), "Erreur");
            }
        }
    }
    //fonction pour modifier une annonce 
    public function updateAnnonce()
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $id = $_POST['id'];
            $titre = trim($_POST['titre']);
            $description = trim($_POST['description']);
            $salaire = $_POST['salaire'];
            $cat = $_POST['categorie_id'];
            $zone = $_POST['zone_id'];
            $statut = $_POST['statut'];

            try {
                $reponse = $this->annonceRepository->updateAnnonceFull($id, $titre, $description, $salaire, $cat, $zone, $statut);
                if ($reponse) {
                    $this->setSuccessAndRedirect("Annonce mise à jour avec succès.", "Succès");
                }
            } catch (Exception $e) {
                $this->setErrorAndRedirect("Erreur : " . $e->getMessage(), "Erreur");
            }
        }
    }
    //Fonction pour supprimer (désactiver) une annonce

    
    public function deleteAnnonce($id, $motif)
{
    try {
        $annonce = $this->annonceRepository->getAnnonceById($id);
        if (!$annonce) { $this->setErrorAndRedirect("Annonce introuvable.", "Erreur"); }

        // On exécute la désactivation en base
        $reponse = $this->annonceRepository->desactivate($id, $motif);

        if ($reponse) {
            $roleActuel = $_SESSION['role'];
            $urlRedir = ($roleActuel === 'Admin') ? "ListeAnnonce" : "MesAnnonces";

            // LOGIQUE EMAIL : Uniquement si l'Admin supprime l'annonce de quelqu'un d'autre
            if ($roleActuel === 'Admin') {
                require_once("../../model/UserRepository.php");
                $owner = (new UserRepository())->getById($annonce['created_by']);
                
                if ($owner) {
                    $sujet = "Modération : Suppression de votre annonce";
                    $corps = "Bonjour " . htmlspecialchars($owner['prenom']) . ",<br><br>
                              L'administration a retiré votre annonce : <b>".$annonce['titre']."</b>.<br>
                              <b>Motif :</b> $motif";
                    MailService::sendNotification($owner['email'], $sujet, $corps);
                }
            }

            $this->setSuccessAndRedirect("L'annonce a été supprimée.", "Succès", $urlRedir);
        }
    } catch (Exception $e) {
        $this->setErrorAndRedirect("Erreur système.", "Erreur");
    }
}

// Restaurer une annonce
public function restoreAnnonce($id)
{
    try {
        $reponse = $this->annonceRepository->activate($id); // Utilise ta méthode activate() existante
        if ($reponse) {
            $this->setSuccessAndRedirect("L'annonce a été restaurée.", "Succès", "CorbeilleAnnonce");
        }
    } catch (Exception $e) {
        $this->setErrorAndRedirect("Erreur lors de la restauration.", "Erreur", "CorbeilleAnnonce");
    }
}

// Supprimer définitivement
public function permanentDelete($id)
{
    try {
        $reponse = $this->annonceRepository->delete($id); // Utilise ta méthode delete() existante
        if ($reponse) {
            $this->setSuccessAndRedirect("L'annonce a été supprimée définitivement.", "Supprimé", "CorbeilleAnnonce");
        }
    } catch (Exception $e) {
        $this->setErrorAndRedirect("Erreur fatale lors de la suppression.", "Erreur", "CorbeilleAnnonce");
    }
}
}