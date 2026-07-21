<?php
require_once("../../model/AvisRepository.php");
require_once("../../controller/MailService.php");

class AvisController {
    private $repo;

    public function __construct() {
        $this->repo = new AvisRepository();
    }

    private function redirect($type, $msg, $title) {
        header("Location: ListeAvis?$type=1&message=".urlencode($msg)."&title=".urlencode($title));
        exit;
    }

    public function addAvis() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $note = $_POST['note'];
        $comm = trim($_POST['commentaire']);
        $annonce_id = $_POST['annonce_id'];
        $user_id = $_SESSION['id'] ?? 1; // 1 par défaut pour tes tests

        if(empty($comm) || empty($annonce_id)) $this->redirect('error', "Champs requis", "Erreur");

        if($this->repo->add($note, $comm, $user_id, $annonce_id)) {
            $this->redirect('succes', "Avis ajouté", "Succès");
        }
    }

    public function updateAvis() {
        $id = $_POST['id'];
        $note = $_POST['note'];
        $comm = trim($_POST['commentaire']);
        $annonce_id = $_POST['annonce_id'];

        if($this->repo->update($id, $note, $comm, $annonce_id)) {
            $this->redirect('succes', "Avis modifié", "Succès");
        }
    }

    public function restoreAvis($id) {
        if($this->repo->activate($id)) {
            header("Location: CorbeilleAvis?succes=1&message=Avis restauré&title=Succès");
            exit;
        }
    }

    public function permanentDelete($id) {
        if($this->repo->delete($id)) {
            header("Location: CorbeilleAvis?succes=1&message=Avis supprimé définitivement&title=Supprimé");
            exit;
        }
    }

    public function deleteAvis($id, $motif) {
        // 1. On récupère les détails via le repository (Plus propre !)
        $avisDetails = $this->repo->getAvisAuthorDetails($id);

        if($this->repo->desactivate($id, $motif)) {
            if ($avisDetails) {
                $sujet = "Modération de votre avis sur Goorgoorlou";
                $corps = "Bonjour " . $avisDetails['prenom'] . ",<br>
                          Votre avis posté sur notre plateforme a été retiré par un modérateur.<br>
                          <b>Raison :</b> $motif";
                
                MailService::sendNotification($avisDetails['email'], $sujet, $corps);
            }
            $this->redirect('succes', "Avis supprimé et auteur notifié", "Succès");
        }
    }
}