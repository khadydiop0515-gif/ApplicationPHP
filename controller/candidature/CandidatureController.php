<?php
require_once("../../model/CandidatureRepository.php");

require_once("../../controller/MailService.php");
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

  
    // À ajouter dans la classe CandidatureController

public function restoreCandidature($id)
{
    try {
        if ($this->candidatureRepository->activate($id)) {
            $this->redirect('succes', "Candidature restaurée avec succès.", "Restauration", "CorbeilleCandidature");
        }
    } catch (Exception $e) {
        $this->redirect('error', "Erreur : " . $e->getMessage(), "Erreur", "CorbeilleCandidature");
    }
}

public function permanentDelete($id)
{
    try {
        if ($this->candidatureRepository->delete($id)) {
            $this->redirect('succes', "Candidature supprimée définitivement.", "Supprimé", "CorbeilleCandidature");
        }
    } catch (Exception $e) {
        $this->redirect('error', "Erreur fatale lors de la suppression.", "Erreur", "CorbeilleCandidature");
    }
}


public function deleteCandidature($id, $motif)
{
    try {
        // 1. On récupère les infos pour le mail (Email étudiant + Titre annonce)
        $details = $this->candidatureRepository->getCandidatureDetails($id);

        // 2. Désactivation en base
        $res = $this->candidatureRepository->desactivate($id, $motif);

        if ($res && $details) {
            // 3. Envoi du mail
            $sujet = "Information sur votre candidature : " . $details['annonce_titre'];
            $corps = "Bonjour " . htmlspecialchars($details['prenom']) . ",<br><br>
                      Nous vous informons que votre candidature pour l'offre <b>'".$details['annonce_titre']."'</b> a été retirée par l'administration.<br><br>
                      <b>Motif :</b><br>
                      <blockquote style='color: #555;'>$motif</blockquote>";
            
            MailService::sendNotification($details['email'], $sujet, $corps);

            $this->redirect('succes', "Candidature supprimée et étudiant notifié.", "Succès");
        }
    } catch (Exception $e) {
        $this->redirect('error', "Erreur : " . $e->getMessage(), "Erreur");
    }
}
}