<!DOCTYPE html>
<html lang="en">
	<!-- ================== section HEAD ================== -->
	<?php require_once("../../../sections/admin/head.php"); ?>
	
<body>
	<!-- ================== section page loader ================== -->
	<div id="page-loader" class="fade show">
		<span class="spinner"></span>
	</div>
	<!-- end #page-loader -->
	
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">

		<!-- ================== sectionMenu haut ================== -->
		<?php require_once("../../../sections/admin/menuHaut.php"); ?>
		
		<!-- ================== section Menu Gauche ================== -->
		<?php require_once("../../../sections/admin/menuGauche.php"); ?>

		<!-- ================== section base content ================== -->
		 <div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb float-xl-right">
				<!-- <li class="breadcrumb-item">
					<a href="#modal-annonce" class="btn btn-sm btn-dark text-white fw-bold" data-toggle="modal">Ajouter</a>
				</li> -->
				<li class="breadcrumb-item"><a href="javascript:;" class="btn btn-sm btn-dark text-white fw-bold" data-toggle="modal">Corbeille</a></li>
				<li class="breadcrumb-item active"><a href="javascript:;" class="btn btn-sm btn-dark text-white fw-bold" data-toggle="modal">Users</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header"># Annonces</h1>
			<!-- end page-header -->
			<!-- begin panel -->
			<div class="panel panel-inverse">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<h4 class="panel-title">Liste des Annonces</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
					</div>
				</div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				<div class="panel-body">
					<table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
						<thead>
							<tr>
								<th width="1%">#</th>
								<th class="text-nowrap">Titre</th>
								<th class="text-nowrap">Description</th>
								<th class="text-nowrap">Salaire</th>
								<th class="text-nowrap">Statut</th>
								<th class="text-nowrap">Actions</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="f-w-600 text-inverse">1</td>
								<td><strong>Développeur Web Full Stack</strong><br><small class="text-muted">Publié il y a 2 jours</small></td>
								<td>Créer et maintenir des applications web modernes avec PHP, MySQL et Bootstrap.</td>
								<td>1 500 000 FCFA</td>
								<td><span class="badge badge-success">Ouverte</span></td>
								<td>
										<a href="#" class="btn btn-xs btn-info" title="Voir l'annonce"><i class="fa fa-eye"></i> Voir</a>
										<!--<a href="#" class="btn btn-xs btn-warning" title="Modifier l'annonce"><i class="fa fa-edit"></i> Modifier</a>-->
										<a href="#" class="btn btn-xs btn-danger" title="Supprimer l'annonce"><i class="fa fa-trash"></i> Supprimer</a>
								</td>
							</tr>
							<tr>
								<td class="f-w-600 text-inverse">2</td>
								<td><strong>Analyste Data</strong><br><small class="text-muted">Publié il y a 5 jours</small></td>
								<td>Analyser les données métier et produire des tableaux de bord utiles à la direction.</td>
								<td>1 200 000 FCFA</td>
								<td><span class="badge badge-info">Ouverte</span></td>
								<td>
										<a href="#" class="btn btn-xs btn-info" title="Voir l'annonce"><i class="fa fa-eye"></i> Voir</a>
										<!--<a href="#" class="btn btn-xs btn-warning" title="Modifier l'annonce"><i class="fa fa-edit"></i> Modifier</a>-->
										<a href="#" class="btn btn-xs btn-danger" title="Supprimer l'annonce"><i class="fa fa-trash"></i> Supprimer</a>
										
								</td>
							</tr>
							<tr>
								<td class="f-w-600 text-inverse">3</td>
								<td><strong>Designer UI/UX</strong><br><small class="text-muted">Publié hier</small></td>
								<td>Concevoir des interfaces modernes et améliorer l’expérience utilisateur des produits digitaux.</td>
								<td>950 000 FCFA</td>
								<td><span class="badge badge-warning">Pourvue</span></td>
								<td>
										<a href="#" class="btn btn-xs btn-info" title="Voir l'annonce"><i class="fa fa-eye"></i> Voir</a>
										<!--<a href="#" class="btn btn-xs btn-warning" title="Modifier l'annonce"><i class="fa fa-edit"></i> Modifier</a>-->
										<a href="#" class="btn btn-xs btn-danger" title="Supprimer l'annonce"><i class="fa fa-trash"></i> Supprimer</a>
										
								</td>
							</tr>
							<tr>
								<td class="f-w-600 text-inverse">4</td>
								<td><strong>Responsable Marketing Digital</strong><br><small class="text-muted">Publié il y a 1 semaine</small></td>
								<td>Gérer les campagnes digitales, le contenu et l’acquisition de nouveaux clients.</td>
								<td>1 300 000 FCFA</td>
								<td><span class="badge badge-danger">Annulée</span></td>
								<td>
										<a href="#" class="btn btn-xs btn-info" title="Voir l'annonce"><i class="fa fa-eye"></i> Voir</a>
										<!--<a href="#" class="btn btn-xs btn-warning" title="Modifier l'annonce"><i class="fa fa-edit"></i> Modifier</a>-->
										<a href="#" class="btn btn-xs btn-danger" title="Supprimer l'annonce"><i class="fa fa-trash"></i> Supprimer</a>
								</td>
							</tr>
							
						</tbody>
					</table>
				</div>
				<!-- end panel-body -->
			</div>
			<!-- end panel -->
		</div>

		<!-- ================== section scroll to top ================== -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
	</div>
<!-- ==================  JS ================== -->
	<?php require_once("../../../sections/admin/script.php"); ?>
	<!-- ================== Modal Ajouter Annonce ================== -->
	<div class="modal fade" id="modal-annonce" tabindex="-1" aria-labelledby="modal-annonce-label" aria-hidden="true"> 
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<h4 class="modal-title">Ajouter une annonce</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>

				<form action="#"  method="POST">
					<div  class="modal-body">

						<!-- Titre -->
						<div class="form-group">
							<label for="titre">Titre</label>
							<input type="text" class="form-control" id="titre" name="titre" required>
						</div>

						<!-- Description -->
						<div class="form-group">
							<label for="description">Description</label>
							<textarea class="form-control" id="description" name="description" rows="4" required></textarea>
						</div>

						<!-- Salaire -->
						<div class="form-group">
							<label for="salaire">Salaire</label>
							<input type="number" class="form-control" id="salaire" name="salaire" min="0" required>
						</div>

						<!-- Statut -->
						<div class="form-group">
							<label for="status">Statut</label>
							<select class="form-control" id="status" name="status" required>
								<option value="">-- Sélectionner --</option>
								<option value="ouvert">Ouverte</option>
								<option value="pourvu">Pourvue</option>
								<option value="annule">Annulée</option>
							</select>
						</div>

					</div>

					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Ajouter</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
					</div>
					
				</form>

			</div>
		</div>
	</div>
	<!-- ================== section config ================== -->
	<?php require_once("../../../sections/admin/config.php"); ?>
	
</body>
</html>