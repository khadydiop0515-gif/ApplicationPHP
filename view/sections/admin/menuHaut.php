<?php
// On récupère le nom de la page actuelle pour adapter le menu
$currentPage = basename($_SERVER['REQUEST_URI']);
$isProfilePage = (strpos($currentPage, 'MonProfil') !== false);

require_once __DIR__ . "/../../../model/CandidatureRepository.php";
$notifRepo = new CandidatureRepository();
$attenteCount = $notifRepo->countPendingCandidatures(null);
?>

<div id="header" class="header navbar-default">
    <div class="navbar-header">
        <a href="<?= ($_SESSION['role'] === 'Admin') ? 'admin' : 'DashboardPrestataire' ?>" class="navbar-brand">
            <span class="navbar-logo"></span> 
            <b>Gorgoorlu</b> <span class="text-primary"><?= htmlspecialchars($_SESSION['role']) ?></span>
        </a>
        <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
            <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
        </button>
    </div>

    <ul class="navbar-nav navbar-right">
        
        <?php if (!$isProfilePage): ?>
            <!-- SI ON N'EST PAS SUR LE PROFIL : AFFICHER LA RECHERCHE -->
            <li class="navbar-form">
                <form action="ListeAnnonce" method="GET">
                    <div class="form-group">
                        <input type="text" name="search" class="form-control" placeholder="Rechercher une annonce..." />
                        <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
                    </div>
                </form>
            </li>
        <?php else: ?>
            <!-- SI ON EST SUR LE PROFIL : AFFICHER UN BOUTON RETOUR -->
            <li class="nav-item">
                <a href="<?= ($_SESSION['role'] === 'Admin') ? 'admin' : 'DashboardPrestataire' ?>" class="nav-link text-muted f-w-600">
                    <i class="fa fa-arrow-left m-r-5"></i> Retour au Tableau de bord
                </a>
            </li>
        <?php endif; ?>

        <!-- NOTIFICATIONS -->
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="dropdown-toggle f-s-14">
                <i class="fa fa-bell"></i>
                <?php if($attenteCount > 0): ?><span class="label"><?= $attenteCount ?></span><?php endif; ?>
            </a>
            <div class="dropdown-menu media-list dropdown-menu-right">
                <div class="dropdown-header">NOTIFICATIONS (<?= $attenteCount ?>)</div>
                <!-- ... contenu des notifs ... -->
            </div>
        </li>

        <!-- USER DROPDOWN -->
        <li class="dropdown navbar-user">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="public/images/users/<?= $_SESSION['photo'] ?? 'default.png' ?>" alt="" /> 
                <span class="d-none d-md-inline"><?= htmlspecialchars($_SESSION['prenom'] . ' ' . $_SESSION['nom']) ?></span> <b class="caret"></b>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <?php if (!$isProfilePage): ?>
                    <a href="MonProfil" class="dropdown-item">Mon Profil</a>
                <?php endif; ?>
                <div class="dropdown-divider"></div>
                <a href="userMainController?action=logout" class="dropdown-item text-danger">Déconnexion</a>
            </div>
        </li>
    </ul>
</div>