<?php 
require_once("../../../../controller/SecurityProvider.php"); 
protectAdmin(); 
?>
<?php
require_once("../../../../model/ZoneRepository.php");
$repo = new ZoneRepository();
$zones = $repo->getAll();
?>
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
				<li class="breadcrumb-item">
					<a href="#modal-zone" class="btn btn-sm btn-dark text-white fw-bold" data-toggle="modal">Ajouter</a>
				</li>
				<li class="breadcrumb-item"><a href="CorbeilleZone" class="btn btn-sm btn-dark text-white fw-bold">Corbeille</a></li>
				<li class="breadcrumb-item active"><a href="ListeEtudiant" class="btn btn-sm btn-dark text-white fw-bold">Étudiants</a></li>
				<li class="breadcrumb-item"><a href="ListePrestataire" class="btn btn-sm btn-dark text-white fw-bold">Prestataires</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header"># Zones</h1>
			<!-- end page-header -->
			<!-- begin panel -->
			<div class="panel panel-inverse">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<h4 class="panel-title">Liste des Zones</h4>
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
								<th class="text-nowrap">Actions</th>
							</tr>
						</thead>
							<tbody>
								<?php if (!empty($zones)): ?>
									<?php foreach ($zones as $index => $z): ?>
										<tr>
											<td width="1%"><?= $index + 1 ?></td>
											<td width="1%"><i class="fa fa-map-marker-alt text-danger fa-lg"></i></td>
											<td><strong><?= htmlspecialchars($z['nom_quartier']) ?></strong></td>
											<td>
												<a href="#modal-edit-zone" data-toggle="modal" class="btn btn-xs btn-primary" 
												onclick='editZone(<?= json_encode($z) ?>)'>
													<i class="fa fa-edit"></i> Modifier
												</a>
												<a href="javascript:;" class="btn btn-xs btn-danger" 
												onclick="confirmDeleteZone(<?= $z['id'] ?>)">
													<i class="fa fa-trash"></i> Supprimer
												</a>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
							</tbody>

					</table>
				</div>
			</div>
		</div>
	</div>
		<!-- MODAL AJOUT -->
		<div class="modal fade" id="modal-zone">
			<div class="modal-dialog">
				<div class="modal-content">
					<form action="zoneMainController" method="POST">
						<div class="modal-header"><h4 class="modal-title">Ajouter une zone</h4></div>
						<div class="modal-body">
							<div class="form-group">
								<label>Nom du quartier</label>
								<input type="text" name="nom_quartier" class="form-control" required placeholder="Ex: Dakar Plateau" />
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" name="frmAddZone" class="btn btn-primary">Enregistrer</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- MODAL MODIFIER -->
		<div class="modal fade" id="modal-edit-zone">
			<div class="modal-dialog">
				<div class="modal-content">
					<form action="zoneMainController" method="POST">
						<div class="modal-header"><h4 class="modal-title">Modifier la zone</h4></div>
						<div class="modal-body">
							<input type="hidden" name="id" id="edit_zone_id">
							<div class="form-group">
								<label>Nom du quartier</label>
								<input type="text" name="nom_quartier" id="edit_nom_quartier" class="form-control" required />
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" name="frmEditZone" class="btn btn-warning">Mettre à jour</button>
						</div>
					</form>
				</div>
			</div>
		</div>

	<?php require_once("../../../sections/admin/config.php"); ?>
	<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
	<?php require_once("../../../sections/admin/script.php"); ?>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
