<?php
require_once("../../model/CandidatureRepository.php");

class CandidatureController
{
    private $candidatureRepository;

    public function __construct()
    {
        $this->candidatureRepository = new CandidatureRepository();
    }

    // Fonctions de redirection pour SweetAlert
    private function redirect($type, $message, $title, $url = "ListeCandidature")
    {
        $param = ($type == 'succes') ? 'succes=1' : 'error=1';
        header("Location: $url?$param&message=" . urlencode($message) . "&title=" . urlencode($title));
        exit;
    }

    public function addCandidature()
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $msg = trim($_POST['message_motivation'] ?? '');
            $user_id = $_POST['user_id'] ?? null;
            $annonce_id = $_POST['annonce_id'] ?? null;

            if (empty($msg) || !$user_id || !$annonce_id) {
                $this->redirect('error', "Tous les champs sont obligatoires.", "Champs vides");
            }

            try {
                $res = $this->candidatureRepository->add($msg, $user_id, $annonce_id);
                if ($res) {
                    $this->redirect('succes', "La candidature a été enregistrée.", "Succès");
                }
            } catch (Exception $e) {
                $this->redirect('error', "Erreur : " . $e->getMessage(), "Erreur");
            }
        }
    }

    public function updateCandidature()
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $id = $_POST['id'] ?? null;
            $msg = trim($_POST['message_motivation'] ?? '');
            $annonce_id = $_POST['annonce_id'] ?? null;

            try {
                $res = $this->candidatureRepository->update($id, $msg, $annonce_id);
                if ($res) {
                    $this->redirect('succes', "Modification effectuée.", "Succès");
                }
            } catch (Exception $e) {
                $this->redirect('error', "Erreur : " . $e->getMessage(), "Erreur");
            }
        }
    }

    public function deleteCandidature($id)
    {
        try {
            $res = $this->candidatureRepository->desactivate($id);
            if ($res) {
                $this->redirect('succes', "Candidature supprimée.", "Suppression");
            }
        } catch (Exception $e) {
            $this->redirect('error', "Erreur lors de la suppression.", "Erreur");
        }
    }
}