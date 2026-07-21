<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("CategorieController.php");
$catCtrl = new CategorieController();

if (isset($_POST['frmAddCategorie'])) {
    $catCtrl->addCategorie();
}

if (isset($_POST['frmEditCategorie'])) {
    $catCtrl->updateCategorie();
}

if (isset($_GET['delete_id'])) {
    $catCtrl->deleteCategorie($_GET['delete_id']);
}
// ... après les autres conditions ...

if (isset($_GET['restore_id'])) {
    $catCtrl->restoreCategorie($_GET['restore_id']);
}

if (isset($_GET['permanent_delete_id'])) {
    $catCtrl->permanentDelete($_GET['permanent_delete_id']);
}