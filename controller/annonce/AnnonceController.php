<?php
require_once("../../model/AnnonceRepository.php");

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

    public function deleteAnnonce($id)
    {
        if (empty($id)) {
            $this->setErrorAndRedirect("Identifiant d'annonce manquant.", "Erreur");
        }

        try {
            $reponse = $this->annonceRepository->desactivate($id);
            if ($reponse) {
                $this->setSuccessAndRedirect("L'annonce a été déplacée dans la corbeille.", "Suppression");
            } else {
                $this->setErrorAndRedirect("Impossible de supprimer cette annonce.", "Erreur");
            }
        } catch (Exception $e) {
            $this->setErrorAndRedirect("Erreur lors de la suppression : " . $e->getMessage(), "Erreur");
        }
    }
}