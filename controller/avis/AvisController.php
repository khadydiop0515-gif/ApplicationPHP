<?php
require_once("../../model/AvisRepository.php");

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
        $note = $_POST['note'];
        $comm = trim($_POST['commentaire']);
        $annonce_id = $_POST['annonce_id'];
        $user_id = $_SESSION['id'];

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

    public function deleteAvis($id) {
        if($this->repo->desactivate($id)) {
            $this->redirect('succes', "Avis supprimé", "Suppression");
        }
    }
}