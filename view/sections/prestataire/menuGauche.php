<div id="sidebar" class="sidebar">
    <div data-scrollbar="true" data-height="100%">
        <ul class="nav">
            <li class="nav-profile">
                <div class="image">
                    <img src="public/images/users/<?= $_SESSION['photo'] ?? 'default.png' ?>" />
                </div>
                <div class="info">
                    <?= $_SESSION['prenom'] ?>
                    <small>Prestataire</small>
                </div>
            </li>
            <li class="nav-header">Navigation</li>
            <li><a href="DashboardPrestataire"><i class="fa fa-th-large"></i> <span>Dashboard</span></a></li>
            <li class="has-sub">
                <a href="javascript:;"><b class="caret"></b><i class="fa fa-bullhorn"></i> <span>Mes Annonces</span></a>
                <ul class="sub-menu">
                    <li><a href="MesAnnonces">Voir mes offres</a></li>
                    <li><a href="NouvelleAnnonce">Publier une annonce</a></li>
                </ul>
            </li>
            <li><a href="CandidaturesRecues"><i class="fa fa-users"></i> <span>Candidatures</span></a></li>
            <li><a href="home"><i class="fa fa-eye"></i> <span>Voir le site</span></a></li>
            
            <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
        </ul>
    </div>
</div>
<div class="sidebar-bg"></div> <!-- TRÈS IMPORTANT : Sans ça, le fond du menu reste blanc -->