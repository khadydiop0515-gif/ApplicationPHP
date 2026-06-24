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
				<!--<li class="breadcrumb-item">
					<a href="#modal-user" class="btn btn-sm btn-dark text-white fw-bold" data-toggle="modal">Ajouter</a>
				</li> -->
				<li class="breadcrumb-item"><a href="javascript:;" class="btn btn-sm btn-dark text-white fw-bold" data-toggle="modal">Corbeille</a></li>
				<li class="breadcrumb-item active"><a href="javascript:;" class="btn btn-sm btn-dark text-white fw-bold" data-toggle="modal">Users</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header"># Utilisateurs</h1>
			<!-- end page-header -->
			<!-- begin panel -->
			<div class="panel panel-inverse">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<h4 class="panel-title">Liste des Utilisateurs</h4>
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
								<th width="1%"></th>
								<th width="1%" data-orderable="false"></th>
								<th class="text-nowrap">Nom</th>
								<th class="text-nowrap">Prénom</th>
								<th class="text-nowrap">Email</th>
								<th class="text-nowrap">Téléphone</th>
								<th class="text-nowrap">Rôle</th>
								<th class="text-nowrap">NINEA</th>
								<th class="text-nowrap">Actions</th>
							</tr>
						</thead>
						<tbody>
							<tr class="odd gradeX">
								<td width="1%" class="f-w-600 text-inverse">1</td>
								<td width="1%" class="with-img"><img src="public/templates/templateAdmin/assets/img/user/user-1.jpg" class="img-rounded height-30" /></td>
								<td>Diop</td>
								<td>Awa</td>
								<td>awa@example.com</td>
								<td>772000000</td>
								<td>Étudiant</td>
								<td>123456789</td>
								<td>
									<a href="#modal-user" class="btn btn-xs btn-primary" data-toggle="modal">Modifier</a>
									<a href="javascript:;" class="btn btn-xs btn-danger">Supprimer</a>
								</td>
							</tr>
							<tr class="even gradeC">
								<td class="f-w-600 text-inverse">2</td>
								<td class="with-img"><img src="public/templates/templateAdmin/assets/img/user/user-2.jpg" class="img-rounded height-30" /></td>
								<td>Sarr</td>
								<td>Moussa</td>
								<td>moussa@example.com</td>
								<td>771111111</td>
								<td>Prestataire</td>
								<td>987654321</td>
								<td>
									<a href="#modal-user" class="btn btn-xs btn-primary" data-toggle="modal">Modifier</a>
									<a href="javascript:;" class="btn btn-xs btn-danger">Supprimer</a>
								</td>
							</tr>
							<tr class="odd gradeA">
								<td class="f-w-600 text-inverse">3</td>
								<td class="with-img"><img src="public/templates/templateAdmin/assets/img/user/user-3.jpg" class="img-rounded height-30" /></td>
								<td>Fall</td>
								<td>Ndeye</td>
								<td>ndeye@example.com</td>
								<td>773333333</td>
								<td>Admin</td>
								<td>456789123</td>
								<td>
									<a href="#modal-user" class="btn btn-xs btn-primary" data-toggle="modal">Modifier</a>
									<a href="javascript:;" class="btn btn-xs btn-danger">Supprimer</a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
<!-- ================== Modal Ajouter Annonce ================== -->
	<div class="modal fade" id="modal-user">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Ajouter un utilisateur</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<form action="liste.php" method="post">
					<div class="modal-body">
						<div class="row">
							<div class="col-md-6 form-group">
								<label>Nom</label>
								<input type="text" name="nom" class="form-control" placeholder="Nom" />
							</div>
							<div class="col-md-6 form-group">
								<label>Prénom</label>
								<input type="text" name="prenom" class="form-control" placeholder="Prénom" />
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 form-group">
								<label>Email</label>
								<input type="email" name="email" class="form-control" placeholder="Email" />
							</div>
							<div class="col-md-6 form-group">
								<label>Mot de passe</label>
								<input type="password" name="password" class="form-control" placeholder="Mot de passe" />
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 form-group">
								<label>Téléphone</label>
								<input type="text" name="telephone" class="form-control" placeholder="Téléphone" />
							</div>
							<div class="col-md-6 form-group">
								<label>Photo</label>
								<input type="text" name="photo" class="form-control" placeholder="Nom du fichier" />
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 form-group">
								<label>Adresse</label>
								<input type="text" name="adresse" class="form-control" placeholder="Adresse" />
							</div>
							<div class="col-md-6 form-group">
								<label>Rôle</label>
								<select name="role" class="form-control">
									<option value="Étudiant">Étudiant</option>
									<option value="Prestataire">Prestataire</option>
									<option value="Admin">Admin</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label>NINEA</label>
							<input type="text" name="ninea" class="form-control" placeholder="NINEA" />
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
						<button type="submit" class="btn btn-primary">Enregistrer</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php require_once("../../../sections/admin/config.php"); ?>
	<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
	<?php require_once("../../../sections/admin/script.php"); ?>
</body>
</html>
