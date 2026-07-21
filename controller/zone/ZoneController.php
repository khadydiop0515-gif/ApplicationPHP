<?php
require_once("../../model/ZoneRepository.php");

class ZoneController
{
    private $zoneRepository;

    public function __construct() { $this->zoneRepository = new ZoneRepository(); }

    private function redirect($type, $message, $title, $url = "ListeZone")
    {
        $param = ($type == 'succes') ? 'succes=1' : 'error=1';
        header("Location: $url?$param&message=" . urlencode($message) . "&title=" . urlencode($title));
        exit;
    }

    public function addZone() {
        $nom = trim($_POST['nom_quartier'] ?? '');
        if (empty($nom)) $this->redirect('error', "Nom requis", "Erreur");
        if ($this->zoneRepository->add($nom)) $this->redirect('succes', "Zone ajoutée", "Succès");
    }

    public function updateZone() {
        $id = $_POST['id']; $nom = trim($_POST['nom_quartier']);
        if ($this->zoneRepository->update($id, $nom)) $this->redirect('succes', "Zone mise à jour", "Succès");
    }

    // Supprimer (Envoyer en corbeille)
    public function deleteZone($id) {
        if ($this->zoneRepository->desactivate($id)) {
            $this->redirect('succes', "Zone déplacée en corbeille", "Suppression");
        }
    }

    // Restaurer
    public function restoreZone($id) {
        if ($this->zoneRepository->activate($id)) {
            $this->redirect('succes', "Zone restaurée", "Succès", "CorbeilleZone");
        }
    }

    // Suppression réelle
    public function permanentDelete($id) {
        try {
            if ($this->zoneRepository->delete($id)) {
                $this->redirect('succes', "Zone supprimée définitivement", "Supprimé", "CorbeilleZone");
            }
        } catch (Exception $e) {
            $this->redirect('error', "Impossible : zone liée à des annonces", "Erreur", "CorbeilleZone");
        }
    }
}