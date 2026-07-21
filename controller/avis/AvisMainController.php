<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once("AvisController.php");
$ctrl = new AvisController();

if (isset($_POST['frmAddAvis'])) $ctrl->addAvis();
if (isset($_POST['frmEditAvis'])) $ctrl->updateAvis();
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $motif = isset($_GET['motif']) ? urldecode($_GET['motif']) : "Contenu inapproprié";
    $ctrl->deleteAvis($id, $motif);
}
// Dans AvisMainController.php
if (isset($_GET['restore_id'])) {
    $ctrl->restoreAvis($_GET['restore_id']);
}

if (isset($_GET['permanent_delete_id'])) {
    $ctrl->permanentDelete($_GET['permanent_delete_id']);
}