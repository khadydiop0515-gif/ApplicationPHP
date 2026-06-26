<?php
require_once("../../model/ZoneRepository.php");

class ZoneController
{
    private $zoneRepository;

    public function __construct()
    {
        $this->zoneRepository = new ZoneRepository();
    }

    private function redirect($type, $message, $title, $url = "ListeZone")
    {
        $param = ($type == 'succes') ? 'succes=1' : 'error=1';
        header("Location: $url?$param&message=" . urlencode($message) . "&title=" . urlencode($title));
        exit;
    }

    public function addZone()
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $nom = trim($_POST['nom_quartier'] ?? '');

            if (empty($nom)) {
                $this->redirect('error', "Le nom du quartier est obligatoire.", "Champs vides");
            }

            try {
                if ($this->zoneRepository->add($nom)) {
                    $this->redirect('succes', "La zone a été ajoutée.", "Succès");
                }
            } catch (Exception $e) {
                $this->redirect('error', "Erreur : " . $e->getMessage(), "Erreur système");
            }
        }
    }

    public function updateZone()
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $id = $_POST['id'] ?? null;
            $nom = trim($_POST['nom_quartier'] ?? '');

            if (!$id || empty($nom)) {
                $this->redirect('error', "Données incomplètes.", "Erreur");
            }

            try {
                if ($this->zoneRepository->update($id, $nom)) {
                    $this->redirect('succes', "La zone a été mise à jour.", "Succès");
                } else {
                    $this->redirect('error', "Aucune modification effectuée.", "Info");
                }
            } catch (Exception $e) {
                $this->redirect('error', "Erreur : " . $e->getMessage(), "Erreur");
            }
        }
    }

    public function deleteZone($id)
    {
        try {
            if ($this->zoneRepository->delete($id)) {
                $this->redirect('succes', "Zone supprimée définitivement.", "Suppression");
            }
        } catch (Exception $e) {
            $this->redirect('error', "Impossible de supprimer cette zone car elle est liée à des annonces.", "Erreur de liaison");
        }
    }
}