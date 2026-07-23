<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Affichage des erreurs pour être sûr de voir ce qui cloche
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Chemin vers le controller (3 niveaux car on est dans view/pages/vitrine/)
require_once("../../../controller/SecurityProvider.php");

if (!isset($_SESSION['id'])) { 
    header("Location: login"); 
    exit; 
}

$role = strtolower($_SESSION['role']);
$showSidebar = ($role === 'admin' || $role === 'prestataire');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Mon Profil | Gorgoorlu</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <?php if ($showSidebar): ?>
        <?php require_once("../../sections/admin/head.php"); ?>
    <?php else: ?>
        <link href="public/templates/templateVitrine/assets/css/one-page-parallax/app.min.css" rel="stylesheet"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <?php endif; ?>

    <style>
        body { background: #f4f7f9 !important; }
        #header { background: #2d353c !important; }
        .profile-container { margin-top: 120px; margin-bottom: 60px; }
        .profile-header { background: linear-gradient(135deg, #00acac 0%, #007373 100%); padding: 40px; border-radius: 12px 12px 0 0; color: white; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .profile-img { width: 130px; height: 130px; object-fit: cover; border: 5px solid rgba(255,255,255,0.8); background: #fff; }
        .edit-photo-btn { position: absolute; bottom: 5px; right: 5px; background: #fff; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #333; }
        .nav-tabs-custom { background: #fff; border-bottom: 1px solid #e2e7eb; padding: 0 20px; }
        .nav-tabs-custom .nav-link { border: none; font-weight: 700; color: #888; padding: 18px 25px; text-transform: uppercase; font-size: 13px; }
        .nav-tabs-custom .nav-link.active { color: #00acac !important; border-bottom: 3px solid #00acac !important; background: none !important; }
        .info-card { padding: 30px; background: #fff; border-radius: 0 0 12px 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        .info-label { font-weight: 700; color: #999; font-size: 11px; text-transform: uppercase; margin-bottom: 5px; display: block; }
        .info-value { font-size: 16px; color: #333; font-weight: 600; margin-bottom: 25px; display: block; }

    /* ... tes styles existants ... */

    /* FIX : Header sombre et texte blanc pour la lisibilité */
    #header { 
        background: #2d353c !important; /* Le gris foncé du template */
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    /* Force le logo et le texte de gauche en blanc */
    #header .navbar-brand, 
    #header .navbar-brand b { 
        color: #ffffff !important; 
    }

    /* Force le nom de l'utilisateur (à droite) en blanc */
    #header .navbar-nav > li > a,
    #header .navbar-nav > li > a > span {
        color: #ffffff !important;
    }

    /* Style pour le lien "Retour au Tableau de bord" */
    #header .navbar-nav > li > a.text-muted {
        color: rgba(255,255,255,0.7) !important;
    }
    #header .navbar-nav > li > a.text-muted:hover {
        color: #ffffff !important;
    }

    /* Garde le rôle (Admin/Prestataire) en vert/teal pour le style */
    #header .text-primary {
        color: #00acac !important;
    }
    <style>
    /* ... tes styles précédents ... */

    /* Harmonisation du menu déroulant (Dropdown) */
    #header .dropdown-menu {
        background: #ffffff !important; /* Garde le fond blanc pour le contraste interne */
        border: none !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
        margin-top: 10px !important;
        border-radius: 8px !important;
        padding: 8px 0 !important;
    }

    /* Style du lien Déconnexion à l'intérieur */
    #header .dropdown-item {
        color: #333 !important;
        padding: 10px 20px !important;
        font-weight: 600 !important;
        display: flex;
        align-items: center;
        transition: all 0.2s;
    }

    #header .dropdown-item:hover {
        background: #f4f7f9 !important;
        color: #ff5b57 !important; /* Passage au rouge au survol */
    }

    /* On cache le séparateur (divider) s'il est tout seul sur la page profil */
    #header .dropdown-divider {
        display: none !important;
    }

    /* Petit triangle (caret) au-dessus du menu pour l'élégance */
    #header .dropdown-menu:before {
        content: '';
        position: absolute;
        top: -7px;
        right: 20px;
        border-left: 7px solid transparent;
        border-right: 7px solid transparent;
        border-bottom: 7px solid #fff;
    }
</style>
    </style>
</head>

<body class="<?= $showSidebar ? 'pace-top' : '' ?>">

    <?php if ($showSidebar): ?>
        <div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
            <?php 
                if ($role === 'admin') {
                    require_once("../../sections/admin/menuHaut.php");
                    require_once("../../sections/admin/menuGauche.php");
                } else {
                    require_once("../../sections/prestataire/menuHaut.php");
                    require_once("../../sections/prestataire/menuGauche.php");
                }
            ?>
            <div id="content" class="content">
                <?php renderMainBody(); ?>
            </div>
            <div class="sidebar-bg"></div>
        </div>
        <?php require_once("../../sections/admin/script.php"); ?>

    <?php else: ?>
        <?php require_once("../../sections/vitrine/menu.php"); ?>
        <div class="container profile-container">
            <?php renderMainBody(); ?>
        </div>
        <?php require_once("../../sections/vitrine/footer.php"); ?>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // FIX POUR LES ONGLETS
            $('.nav-tabs-custom a').on('click', function (e) {
                e.preventDefault();
                $(this).tab('show');
            });
        });
    </script>

</body>
</html>

<?php function renderMainBody() { ?>
    <!-- LE CONTENU DU PROFIL-->
    <div class="profile-header">
        <div class="row align-items-center">
            <div class="col-md-auto text-center">
                <div style="position: relative; display: inline-block;">
                    <img src="public/images/users/<?= $_SESSION['photo'] ?? 'default.png' ?>" class="rounded-circle profile-img">
                    <form action="userMainController" method="POST" enctype="multipart/form-data" id="photoForm">
                        <label class="edit-photo-btn" title="Changer la photo">
                            <i class="fa fa-camera"></i>
                            <input type="file" name="photo_file" hidden onchange="document.getElementById('photoForm').submit()">
                        </label>
                        <input type="hidden" name="frmUpdatePhoto">
                    </form>
                </div>
            </div>
            <div class="col-md ml-md-3">
                <h2 class="m-t-10 m-b-5 text-white f-w-700"><?= $_SESSION['prenom'].' '.$_SESSION['nom'] ?></h2>
                <p class="m-b-0">
                    <span class="badge bg-black-transparent-5 p-x-15 p-y-5">
                        <i class="fa fa-user-tag m-r-5"></i> <?= strtoupper($_SESSION['role']) ?>
                    </span>
                </p>
            </div>
        </div>
    </div>

    <div class="nav-tabs-custom">
        <ul class="nav">
            <li class="nav-item"><a href="#view-info" data-toggle="tab" class="nav-link active">Mon Profil</a></li>
            <li class="nav-item"><a href="#edit-info" data-toggle="tab" class="nav-link">Modifier mes infos</a></li>
            <li class="nav-item"><a href="#security" data-toggle="tab" class="nav-link">Sécurité</a></li>
        </ul>
    </div>

    <div class="tab-content info-card">
        <div class="tab-pane fade show active" id="view-info">
            <div class="row">
                <div class="col-md-6 border-right">
                    <span class="info-label">Identité</span>
                    <span class="info-value"><?= $_SESSION['prenom'].' '.$_SESSION['nom'] ?></span>
                    <span class="info-label">Email</span>
                    <span class="info-value"><?= $_SESSION['email'] ?? 'Non renseigné' ?></span>
                </div>
                <div class="col-md-6 p-l-30">
                    <span class="info-label">Téléphone</span>
                    <span class="info-value"><?= $_SESSION['phone'] ?: 'Aucun numéro' ?></span>
                    <span class="info-label">Adresse</span>
                    <span class="info-value"><?= $_SESSION['adresse'] ?: 'Non précisée' ?></span>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="edit-info">
            <form action="userMainController" method="POST">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="f-w-700">Prénom</label>
                        <input type="text" name="prenom" class="form-control" value="<?= $_SESSION['prenom'] ?>" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="f-w-700">Nom</label>
                        <input type="text" name="nom" class="form-control" value="<?= $_SESSION['nom'] ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="f-w-700">Téléphone</label>
                        <input type="text" name="phone" class="form-control" value="<?= $_SESSION['phone'] ?? '' ?>">
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="f-w-700">Adresse</label>
                        <input type="text" name="adresse" class="form-control" value="<?= $_SESSION['adresse'] ?? '' ?>">
                    </div>
                </div>
                <button type="submit" name="frmUpdateFullInfo" class="btn btn-primary btn-lg">Mettre à jour</button>
            </form>
        </div>

        <div class="tab-pane fade" id="security">
            <form action="userMainController" method="POST" style="max-width: 400px;">
                <div class="form-group">
                    <label class="f-w-700">Nouveau mot de passe</label>
                    <input type="password" name="new_password" class="form-control" required minlength="8">
                </div>
                <div class="form-group">
                    <label class="f-w-700">Confirmer</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
                <button type="submit" name="frmUpdatePassword" class="btn btn-warning text-white">Changer le mot de passe</button>
            </form>
        </div>
    </div>
<?php } ?>