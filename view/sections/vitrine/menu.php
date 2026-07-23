<div id="header" class="header navbar navbar-transparent navbar-fixed-top navbar-expand-lg">
    <!-- begin container -->
    <div class="container">
        <!-- begin navbar-brand -->
        <a href="home" class="navbar-brand">
            <span class="brand-logo"></span>
            <span class="brand-text">
                <span class="text-primary">Gorgoorlu</span>
            </span>
        </a>
        <!-- end navbar-brand -->
        
        <!-- begin navbar-toggle -->
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-navbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        
        <!-- begin navbar-collapse -->
        <div class="collapse navbar-collapse" id="header-navbar">
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item"><a class="nav-link" href="home" data-click="scroll-to-target">HOME</a></li>
                <li class="nav-item"><a class="nav-link" href="#about" data-click="scroll-to-target">ABOUT</a></li>
                <li class="nav-item"><a class="nav-link" href="#team" data-click="scroll-to-target">PILIERS</a></li>
                <li class="nav-item"><a class="nav-link" href="#service" data-click="scroll-to-target">SERVICES</a></li>
                <li class="nav-item"><a class="nav-link" href="#work" data-click="scroll-to-target">CATÉGORIES</a></li>
                <li class="nav-item"><a class="nav-link" href="#offres" data-click="scroll-to-target">OPPORTUNITÉS</a></li>
                <li class="nav-item"><a class="nav-link" href="#client" data-click="scroll-to-target">TÉMOIGNAGES</a></li>
                <li class="nav-item"><a class="nav-link" href="#pricing" data-click="scroll-to-target">GUIDE</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact" data-click="scroll-to-target">CONTACT</a></li>

                <?php if(isset($_SESSION['id'])): ?>
                    <!-- SI CONNECTÉ : ON DÉROULE LE MENU UTILISATEUR -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-primary f-w-700" href="#" data-toggle="dropdown">
                            COMPTE <b class="caret"></b>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" style="background: rgba(0,0,0,0.9); border: none; min-width: 200px;">
                            <a class="dropdown-item text-white" href="MonProfil"><i class="fa fa-user m-r-10"></i> MON PROFIL</a>
                            
                            <?php if($_SESSION['role'] === 'Etudiant'): ?>
                                <a class="dropdown-item text-white" href="MesPostulations"><i class="fa fa-file-alt m-r-10"></i> MES CANDIDATURES</a>
                            <?php elseif($_SESSION['role'] === 'Prestataire'): ?>
                                <a class="dropdown-item text-white" href="DashboardPrestataire"><i class="fa fa-th-large m-r-10"></i> MON DASHBOARD</a>
                            <?php elseif($_SESSION['role'] === 'Admin'): ?>
                                <a class="dropdown-item text-white" href="admin"><i class="fa fa-cogs m-r-10"></i> ADMINISTRATION</a>
                            <?php endif; ?>

                            <div class="dropdown-divider" style="border-color: #444;"></div>
                            <a class="dropdown-item text-danger" href="userMainController?action=logout"><i class="fa fa-sign-out-alt m-r-10"></i> DÉCONNEXION</a>
                        </div>
                    </li>
                <?php else: ?>
                    <!-- SI NON CONNECTÉ : ON AFFICHE LE BOUTON CONNEXION -->
                    <li class="nav-item"><a class="nav-link" href="login">CONNEXION</a></li>
                <?php endif; ?>
            </ul>
        </div>
        <!-- end navbar-collapse -->
    </div>
    <!-- end container -->
</div>