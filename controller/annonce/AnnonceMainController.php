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
    
    $annonceCtrl->deleteAnnonce($_GET['delete_id']); 
}
?>