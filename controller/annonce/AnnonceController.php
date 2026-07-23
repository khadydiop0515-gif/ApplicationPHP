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
            // 1. Récupération des infos de l'annonce
            $annonce = $this->annonceRepository->getAnnonceById($id);
            if (!$annonce) {
                $this->setErrorAndRedirect("Annonce introuvable.", "Erreur");
            }

            // 2. Récupération du propriétaire (Prestataire) pour le mail
            require_once("../../model/UserRepository.php");
            $userRepo = new UserRepository();
            $owner = $userRepo->getById($annonce['created_by']);

            // 3. Désactivation en base de données
            $reponse = $this->annonceRepository->desactivate($id, $motif);

            if ($reponse) {
                // --- LOGIQUE DE REDIRECTION DYNAMIQUE ---
                // Si c'est l'admin, on reste sur le panel admin. 
                // Si c'est le prestataire, on le renvoie sur "MesAnnonces"
                $urlRedirection = ($_SESSION['role'] === 'Admin') ? "ListeAnnonce" : "MesAnnonces";

                // 4. Envoi du mail de notification
                if ($owner) {
                    $sujet = "Information sur votre annonce : " . $annonce['titre'];
                    
                    // On adapte un peu le texte si c'est le prestataire lui-même qui supprime
                    $auteurAction = ($_SESSION['id'] == $owner['id']) ? "vous avez" : "l'administration a";
                    
                    $corps = "Bonjour " . htmlspecialchars($owner['prenom']) . ",<br><br>
                            Nous vous informons que " . $auteurAction . " retiré l'annonce <b>'" . htmlspecialchars($annonce['titre']) . "'</b> de notre plateforme.<br><br>
                            <b>Motif enregistré :</b><br>
                            <blockquote style='color: #555; background: #f9f9f9; padding: 10px; border-left: 4px solid #ccc;'>$motif</blockquote>";
                    
                    MailService::sendNotification($owner['email'], $sujet, $corps);
                }

                $this->setSuccessAndRedirect("L'action a été effectuée et le mail envoyé.", "Succès", $urlRedirection);
            }
        } catch (Exception $e) {
            $this->setErrorAndRedirect("Erreur : " . $e->getMessage(), "Erreur");
        }
    }

// Dans controller/annonce/AnnonceController.php


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