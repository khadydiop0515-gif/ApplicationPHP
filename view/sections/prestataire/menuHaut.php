<div id="header" class="header navbar-default">
    <div class="navbar-header">
        <a href="DashboardPrestataire" class="navbar-brand"><span class="navbar-logo"></span> <b>Gorgoorlu</b>Pro</a>
        <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
            <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
        </button>
    </div>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown navbar-user">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <img src="public/images/users/<?= $_SESSION['photo'] ?? 'default.png' ?>" alt="" /> 
        <span class="d-none d-md-inline"><?= $_SESSION['prenom'] ?></span> <b class="caret"></b>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        <a href="MonProfil" class="dropdown-item">Paramètres du profil</a>
        <div class="dropdown-divider"></div>
        <a href="/ApplicationPHP/Logout" class="dropdown-item text-danger"><i class="fa fa-sign-out-alt m-r-10"></i> Déconnexion</a>
    </div>
</li>
    </ul>
</div>