<?php
require_once("../../model/CategorieRepository.php");

class CategorieController
{
    private $categorieRepository;

    public function __construct() { $this->categorieRepository = new CategorieRepository(); }

    private function redirect($type, $message, $title, $url = "ListeCategorie")
    {
        $param = ($type == 'succes') ? 'succes=1' : 'error=1';
        header("Location: $url?$param&message=" . urlencode($message) . "&title=" . urlencode($title));
        exit;
    }

    public function addCategorie() {
        $nom = trim($_POST['nom'] ?? '');
        if (empty($nom)) $this->redirect('error', "Nom requis", "Erreur");
        if ($this->categorieRepository->add($nom)) $this->redirect('succes', "Catégorie ajoutée", "Succès");
    }

    public function updateCategorie() {
        $id = $_POST['id']; $nom = trim($_POST['nom']);
        if ($this->categorieRepository->update($id, $nom)) $this->redirect('succes', "Catégorie mise à jour", "Succès");
    }

    // Supprimer (Envoyer en corbeille)
    public function deleteCategorie($id) {
        if ($this->categorieRepository->desactivate($id)) {
            $this->redirect('succes', "Catégorie déplacée en corbeille", "Suppression");
        }
    }

    // Restaurer
    public function restoreCategorie($id) {
        if ($this->categorieRepository->activate($id)) {
            $this->redirect('succes', "Catégorie restaurée", "Succès", "CorbeilleCategorie");
        }
    }

    // Suppression réelle
    public function permanentDelete($id) {
        try {
            if ($this->categorieRepository->delete($id)) {
                $this->redirect('succes', "Catégorie supprimée définitivement", "Supprimé", "CorbeilleCategorie");
            }
        } catch (Exception $e) {
            $this->redirect('error', "Action impossible : liée à des annonces", "Erreur", "CorbeilleCategorie");
        }
    }
}