<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// 1. EMPÊCHER LE RETOUR ARRIÈRE (Cache)
// Indispensable pour que le bouton "Précédent" du navigateur ne réaffiche pas la page après logout
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

/**
 * Fonction pour protéger la zone ADMIN
 */
function protectAdmin() {
    if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'Admin') {
        header("Location: login?error=1&message=" . urlencode("Accès réservé aux administrateurs."));
        exit();
    }
}

/**
 * Fonction pour protéger la zone PRESTATAIRE
 */
function protectPrestataire() {
    if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'Prestataire') {
        header("Location: login?error=1&message=" . urlencode("Veuillez vous connecter à votre espace pro."));
        exit();
    }
}