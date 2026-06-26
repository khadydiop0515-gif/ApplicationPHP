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
    $candCtrl->deleteCandidature($_GET['delete_id']);
}