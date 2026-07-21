<?php
// On démarre la session 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// On inclut le contrôleur
require_once("AnnonceController.php");

// On instancie l'object
$annonceCtrl = new AnnonceController();

if (isset($_POST['frmAddAnnonce'])) {
    $annonceCtrl->addAnnonce();
}

if (isset($_POST['frmEditAnnonce'])) {
    $annonceCtrl->updateAnnonce(); 
}


if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $motif = isset($_GET['motif']) ? urldecode($_GET['motif']) : "Aucun motif précisé";
    
    $annonceCtrl->deleteAnnonce($id, $motif); 
}

// Dans AnnonceMainController.php

if (isset($_GET['restore_id'])) {
    $annonceCtrl->restoreAnnonce($_GET['restore_id']);
}

if (isset($_GET['permanent_delete_id'])) {
    $annonceCtrl->permanentDelete($_GET['permanent_delete_id']);
}
?>