<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//  Inclusion du contrôleur 
require_once("ZoneController.php");

//  Instanciation de l'objet
$candCtrl = new ZoneController();


// AJOUT
if (isset($_POST['frmAddZone'])) {
    $candCtrl->addZone();
}

// MODIFICATION
if (isset($_POST['frmEditZone'])) {
    $candCtrl->updateZone();
}

// SUPPRESSION 
if (isset($_GET['delete_id'])) {
    $candCtrl->deleteZone($_GET['delete_id']);
}


if (isset($_GET['restore_id'])) $zoneCtrl->restoreZone($_GET['restore_id']);
if (isset($_GET['permanent_delete_id'])) $zoneCtrl->permanentDelete($_GET['permanent_delete_id']);
?>