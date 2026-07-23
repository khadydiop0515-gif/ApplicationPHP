<!-- Header -->
<div id="header" class="header navbar-default">
    <div class="navbar-header">
        <a href="DashboardPrestataire" class="navbar-brand"><span class="navbar-logo"></span> <b>Gorgoorlu</b> Pro</a>
    </div>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown navbar-user">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="d-none d-md-inline"><?= $_SESSION['prenom'] . ' ' . $_SESSION['nom'] ?></span> <b class="caret"></b>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="Logout" class="dropdown-item">Déconnexion</a>
            </div>
        </li>
    </ul>
</div>

<!-- Sidebar -->
<div id="sidebar" class="sidebar">
    <div data-scrollbar="true" data-height="100%">
        <ul class="nav">
            <li class="nav-header">Ma Console</li>
            <li><a href="DashboardPrestataire"><i class="fa fa-th-large"></i> <span>Dashboard</span></a></li>
                <li><a href="MonProfil"><i class="fa fa-user-circle"></i> <span>Mon Profil</span></a></li>
            <li class="has-sub">
                <a href="javascript:;"><b class="caret"></b><i class="fa fa-bullhorn"></i> <span>Mes Annonces</span></a>
                <ul class="sub-menu">
                    <li><a href="MesAnnonces">Liste de mes offres</a></li>
                    <li><a href="NouvelleAnnonce">Publier une annonce</a></li>
                </ul>
            </li>
            <ul class="nav">
            <li class="active"><a href="CandidaturesRecues"><i class="fa fa-users"></i> <span>Candidatures Reçues</span></a></li>
            <li><a href="home"><i class="fa fa-eye"></i> <span>Voir le site</span></a></li>
        </ul>
    </div>
</div>
<div class="sidebar-bg"></div>