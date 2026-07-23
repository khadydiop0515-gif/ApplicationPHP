<?php
// On récupère le nom de la page actuelle pour gérer la classe 'active'
$current_page = basename($_SERVER['REQUEST_URI']);
?>
<div id="sidebar" class="sidebar">
    <!-- begin sidebar scrollbar -->
    <div data-scrollbar="true" data-height="100%">
        <!-- begin sidebar user -->
        <ul class="nav">
            <li class="nav-profile">
                <a href="MonProfil">
                    <div class="cover with-shadow"></div>
                    <div class="image">
                        <img src="public/images/users/<?= $_SESSION['photo'] ?? 'default.png' ?>" alt="Profil" />
                    </div>
                    <div class="info">
                        <b class="caret pull-right"></b>
                        <?= htmlspecialchars($_SESSION['prenom'] . ' ' . $_SESSION['nom']) ?>
                        <small>Administrateur</small>
                    </div>
                </a>
            </li>
        </ul>
        <!-- end sidebar user -->

        <!-- begin sidebar nav -->
        <ul class="nav">
            <li class="nav-header">Navigation</li>
            
            <!-- Dashboard -->
            <li class="<?= ($current_page == 'admin') ? 'active' : '' ?>">
                <a href="admin">
                    <i class="fa fa-th-large"></i>
                    <span>Tableau de bord</span>
                </a>
            </li>

            <li class="nav-header">Gestion des Offres</li>
            
            <!-- Annonces -->
            <li class="<?= ($current_page == 'ListeAnnonce') ? 'active' : '' ?>">
                <a href="ListeAnnonce">
                    <i class="fa fa-briefcase"></i>
                    <span>Annonces</span>
                </a>
            </li>

            <!-- Candidatures -->
            <li class="<?= ($current_page == 'ListeCandidature') ? 'active' : '' ?>">
                <a href="ListeCandidature">
                    <i class="fa fa-handshake"></i>
                    <span>Candidatures</span>
                </a>
            </li>

            <li class="nav-header">Modération</li>

            <!-- Avis -->
            <li class="<?= ($current_page == 'ListeAvis') ? 'active' : '' ?>">
                <a href="ListeAvis">
                    <i class="fa fa-star"></i>
                    <span>Avis & évaluations</span>
                </a>
            </li>

            <li class="nav-header">Configuration & Utilisateurs</li>

            <!-- Catégories -->
            <li class="<?= ($current_page == 'ListeCategorie') ? 'active' : '' ?>">
                <a href="ListeCategorie">
                    <i class="fa fa-tags"></i>
                    <span>Catégories</span>
                </a>
            </li>

            <!-- Zones -->
            <li class="<?= ($current_page == 'ListeZone') ? 'active' : '' ?>">
                <a href="ListeZone">
                    <i class="fa fa-map-marker-alt"></i>
                    <span>Zones / Villes</span>
                </a>
            </li>

            <!-- Utilisateurs (Menu déroulant pour grouper) -->
            <li class="has-sub <?= ($current_page == 'ListeEtudiant' || $current_page == 'ListePrestataire') ? 'active' : '' ?>">
                <a href="javascript:;">
                    <b class="caret"></b>
                    <i class="fa fa-users"></i>
                    <span>Utilisateurs</span>
                </a>
                <ul class="sub-menu">
                    <li class="<?= ($current_page == 'ListeEtudiant') ? 'active' : '' ?>"><a href="ListeEtudiant">Étudiants</a></li>
                    <li class="<?= ($current_page == 'ListePrestataire') ? 'active' : '' ?>"><a href="ListePrestataire">Prestataires</a></li>
                </ul>
            </li>

            <!-- Système -->
            <li class="nav-header">Système</li>
            <li>
                <a href="userMainController?action=logout" class="text-danger">
                    <i class="fa fa-sign-out-alt"></i>
                    <span>Déconnexion</span>
                </a>
            </li>

            <!-- Bouton pour réduire le menu (UX) -->
            <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
        </ul>
        <!-- end sidebar nav -->
    </div>
    <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>