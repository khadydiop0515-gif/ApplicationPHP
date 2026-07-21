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
                    $this->setSuccessAndRedirect("Annonce publiée avec succès.", "Félicitations");
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
            // 1. On récupère les détails de l'annonce pour avoir l'email de l'auteur
            // Tu peux créer une petite méthode getAnnonceWithAuthorEmail dans ton repo si besoin
            $annonce = $this->annonceRepository->getAnnonceById($id);
            
            // On récupère l'utilisateur pour avoir son email (id de created_by)
            require_once("../../model/UserRepository.php");
            $userRepo = new UserRepository();
            $owner = $userRepo->getById($annonce['created_by']);

            // 2. On désactive en base de données avec le motif
            $reponse = $this->annonceRepository->desactivate($id, $motif);

            if ($reponse && $owner) {
                // 3. On envoie le mail de notification
                $sujet = "Suppression de votre annonce : " . $annonce['titre'];
                $corps = "Nous vous informons que votre annonce <b>'".$annonce['titre']."'</b> a été retirée de notre plateforme.<br><br>
                        <b>Motif de la suppression :</b><br>
                        <blockquote style='color: #555;'>$motif</blockquote>";
                
                MailService::sendNotification($owner['email'], $sujet, $corps);

                $this->setSuccessAndRedirect("L'annonce a été supprimée et l'auteur notifié.", "Succès");
            }
        } catch (Exception $e) {
            $this->setErrorAndRedirect("Erreur : " . $e->getMessage(), "Erreur");
        }
    }

    // Dans AnnonceController.php

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