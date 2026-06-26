	<div id="header" class="header navbar-default">
		<!-- begin navbar-header -->
		<div class="navbar-header">
				<a href="index.html" class="navbar-brand"><span class="navbar-logo"></span> <b>Page Admin</b></a>
			<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<!-- end navbar-header --><!-- begin header-nav -->
		<ul class="navbar-nav navbar-right">
			<li class="navbar-form">
				<form action="" method="POST" name="search">
					<div class="form-group">
							<input type="text" class="form-control" placeholder="Faire une recherche" />
						<button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
					</div>
				</form>
			</li>
			<li class="dropdown">
				<a href="#" data-toggle="dropdown" class="dropdown-toggle f-s-14">
					<i class="fa fa-bell"></i>
					<span class="label">5</span>
				</a>
				<div class="dropdown-menu media-list dropdown-menu-right">
					<div class="dropdown-header">NOUVELLES ACTIVITÉS (4)</div>
					<a href="javascript:;" class="dropdown-item media">
						<div class="media-left">
							<i class="fa fa-briefcase media-object bg-silver-darker"></i>
						</div>
						<div class="media-body">
							<h6 class="media-heading">Nouvelle offre publiée</h6>
							<div class="text-muted f-s-10">Il y a 8 minutes</div>
						</div>
					</a>
					<a href="javascript:;" class="dropdown-item media">
						<div class="media-left">
							<img src="public/templates/templateAdmin/assets/img/user/user-1.jpg" class="media-object" alt="" />
							<i class="fa fa-user-plus text-blue media-object-icon"></i>
						</div>
						<div class="media-body">
							<h6 class="media-heading">Nouveau prestataire inscrit</h6>
							<p>Un nouveau profil est prêt à être validé.</p>
							<div class="text-muted f-s-10">25 minutes</div>
						</div>
					</a>
					<a href="javascript:;" class="dropdown-item media">
						<div class="media-left">
							<i class="fa fa-envelope media-object bg-silver-darker"></i>
						</div>
						<div class="media-body">
							<h6 class="media-heading">Nouvelle candidature reçue</h6>
							<div class="text-muted f-s-10">1 heure</div>
						</div>
					</a>
					<div class="dropdown-footer text-center">
						<a href="javascript:;">Voir plus</a>
					</div>
				</div>
			</li>
			<li class="dropdown navbar-user">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<img src="public/templates/templateAdmin/assets/img/user/user-13.jpg" alt="" /> 
					<span class="d-none d-md-inline">
						<?php 
							if(isset($_SESSION['prenom']) && isset($_SESSION['nom'])) {
								echo htmlspecialchars($_SESSION['prenom'] . ' ' . $_SESSION['nom']);
							} else {
								echo "Utilisateur";
							}
						?>
					</span> <b class="caret"></b>
				</a>
				<div class="dropdown-menu dropdown-menu-right">
					<a href="javascript:;" class="dropdown-item">Profil</a>
					<a href="javascript:;" class="dropdown-item">Paramètres</a>
					<div class="dropdown-divider"></div>
					<a href="userMainController?action=logout" class="dropdown-item">Déconnexion</a>
				</div>
			</li>
		</ul>
		<!-- end header-nav -->
	</div>