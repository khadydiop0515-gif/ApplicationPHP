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