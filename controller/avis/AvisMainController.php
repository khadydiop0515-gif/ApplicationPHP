<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once("AvisController.php");
$ctrl = new AvisController();

if (isset($_POST['frmAddAvis'])) $ctrl->addAvis();
if (isset($_POST['frmEditAvis'])) $ctrl->updateAvis();
if (isset($_GET['delete_id'])) $ctrl->deleteAvis($_GET['delete_id']);