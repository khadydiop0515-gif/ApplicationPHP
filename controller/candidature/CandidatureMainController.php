<?php
// On démarre la session si aucune est en cours
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclusion du contrôleur 
require_once("CandidatureController.php");

// Instanciation de l'objet
$candCtrl = new CandidatureController();

// Appel de la fonction pour Ajouter la candidature
if (isset($_POST['frmAddCandidature'])) {
    $candCtrl->addCandidature();
}

// POur modififer
if (isset($_POST['frmEditCandidature'])) {
    $candCtrl->updateCandidature();
}

// Suppimer
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $motif = isset($_GET['motif']) ? urldecode($_GET['motif']) : "Non précisé";
    $candCtrl->deleteCandidature($id, $motif);
}

if (isset($_GET['restore_id'])) {
    $candCtrl->restoreCandidature($_GET['restore_id']);
}

if (isset($_GET['permanent_delete_id'])) {
    $candCtrl->permanentDelete($_GET['permanent_delete_id']);
}