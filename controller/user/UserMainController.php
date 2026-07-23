<?php 

require_once("UserController.php");

$controller = new UserController();


if (isset($_POST['frmLogin'])) {
    $controller->auth();
} 

if (isset($_POST['frmRegister'])) {
    $controller->register();
}

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'logout') {
        $controller->logout();
    }
}
if (isset($_POST['frmEditUser'])) {
    $controller->updateUser();
}

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $motif = isset($_GET['motif']) ? urldecode($_GET['motif']) : "Non précisé";
    $controller->deleteUser($id, $motif);
}
// Dans controller/user/UserMainController.php (à la fin)

if (isset($_GET['restore_id'])) {
    $controller->restoreUser($_GET['restore_id']);
}

if (isset($_GET['permanent_delete_id'])) {
    $controller->permanentDelete($_GET['permanent_delete_id']);
}
if (isset($_POST['frmUpdatePhoto'])) {
    $controller->updateProfilePhoto();
}
if (isset($_POST['frmUpdateInfo'])) {
    $controller->updatePersonalInfo();
}

if (isset($_POST['frmUpdatePassword'])) {
    $controller->changePassword();
}

if (isset($_POST['frmContact'])) {
    $controller->sendContactMessage();
}
if (isset($_POST['frmUpdateFullInfo'])) {
    $controller->updateFullProfile();
}