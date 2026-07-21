<?php
require_once("../../../../model/UserRepository.php");
$repo = new UserRepository();
// On récupère uniquement les prestataires
$prestataires = $repo->getByRole('Prestataire');
?>
<!DOCTYPE html>
<html lang="fr">
	<!-- ================== section HEAD ================== -->
	<?php require_once("../../../sections/admin/head.php"); ?>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<body>
	<div id="page-loader" class="fade show"><span class="spinner"></span></div>

	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		<?php require_once("../../../sections/admin/menuHaut.php"); ?>
		<?php require_once("../../../sections/admin/menuGauche.php"); ?>

		<div id="content" class="content">
			<ol class="breadcrumb float-xl-right">
				<li class="breadcrumb-item"><a href="CorbeillePrestataire" class="btn btn-sm btn-dark text-white fw-bold">Corbeille</a></li>
				<li class="breadcrumb-item active"><a href="ListeEtudiant" class="btn btn-sm btn-dark text-white fw-bold">Étudiants</a></li>
			</ol>
			
			<h1 class="page-header"># Liste des Prestataires</h1>

			<div class="panel panel-inverse">
				<div class="panel-heading">
					<h4 class="panel-title">Gestion des professionnels et entreprises</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
					</div>
				</div>
				<div class="panel-body">
					<table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
						<thead>
							<tr>
								<th width="1%">#</th>
								<th width="1%" data-orderable="false">Photo</th>
								<th>Nom / Entreprise</th>
								<th>Prénom</th>
								<th>Email</th>
								<th>Téléphone</th>
								<th class="text-nowrap">NINEA</th> <!-- Colonne importante ici -->
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($prestataires as $index => $u): ?>
							<tr>
								<td><?= $index + 1 ?></td>
								<td class="with-img">
									<img src="public/images/users/<?= htmlspecialchars($u['photo']) ?>" class="img-rounded height-30" />
								</td>
								<td><?= htmlspecialchars($u['nom']) ?></td>
								<td><?= htmlspecialchars($u['prenom']) ?></td>
								<td><?= htmlspecialchars($u['email']) ?></td>
								<td><?= htmlspecialchars($u['phone']) ?></td>
								<td><span class="badge badge-primary"><?= htmlspecialchars($u['ninea'] ?: 'N/A') ?></span></td>
								<td>
									<!--<a href="#modal-edit-user" data-toggle="modal" class="btn btn-xs btn-primary" onclick='editUser(<?= json_encode($u) ?>)'>Modifier</a>-->
									<a href="javascript:;" class="btn btn-xs btn-danger" onclick="confirmDeleteUser(<?= $u['id'] ?>)">Supprimer</a>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<!-- MODAL MODIFIER (Adapté pour Prestataire avec NINEA) -->
	<div class="modal fade" id="modal-edit-user">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form action="userMainController" method="post">
					<div class="modal-header"><h4 class="modal-title">Modifier le prestataire</h4></div>
					<div class="modal-body">
						<input type="hidden" name="id" id="edit_id">
						<input type="hidden" name="role" id="edit_role">
						<div class="row">
							<div class="col-md-6 form-group"><label>Nom / Raison Sociale</label><input type="text" name="nom" id="edit_nom" class="form-control"></div>
							<div class="col-md-6 form-group"><label>Prénom Responsable</label><input type="text" name="prenom" id="edit_prenom" class="form-control"></div>
						</div>
						<div class="row">
							<div class="col-md-6 form-group"><label>Email</label><input type="email" name="email" id="edit_email" class="form-control"></div>
							<div class="col-md-6 form-group"><label>Téléphone</label><input type="text" name="phone" id="edit_phone" class="form-control"></div>
						</div>
						<div class="row">
							<div class="col-md-8 form-group"><label>Adresse</label><input type="text" name="adresse" id="edit_adresse" class="form-control"></div>
							<div class="col-md-4 form-group">
								<label>NINEA</label>
								<input type="text" name="ninea" id="edit_ninea" class="form-control" required>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" name="frmEditUser" class="btn btn-warning fw-bold">Enregistrer les modifications</button>
						<button type="button" class="btn btn-white" data-dismiss="modal">Fermer</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php require_once("../../../sections/admin/config.php"); ?>
	<?php require_once("../../../sections/admin/script.php"); ?>
</body>
</html>