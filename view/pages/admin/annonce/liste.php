<?php
require_once("../../../../model/AnnonceRepository.php");
require_once("../../../../model/CategorieRepository.php");
require_once("../../../../model/ZoneRepository.php");

$annonceRepo = new AnnonceRepository();
$catRepo = new CategorieRepository();
$zoneRepo = new ZoneRepository();

// Données pour le tableauD
$annonces = $annonceRepo->getAllAnnoncesWithDetails();

// Données pour les <select> de la modale
$categories = $catRepo->getAll();
$zones = $zoneRepo->getAll();
?>

<!DOCTYPE html>
<html lang="en">
	<!-- ================== section HEAD ================== -->
	<?php require_once("../../../sections/admin/head.php"); ?>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	
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
					<a href="#modal-annonce" class="btn btn-sm btn-dark text-white fw-bold" data-toggle="modal">Ajouter</a>
				</li>-->
				<li class="breadcrumb-item"><a href="CorbeilleAnnonce" class="btn btn-sm btn-dark text-white fw-bold">Corbeille</a></li>
				<li class="breadcrumb-item active"><a href="ListeEtudiant" class="btn btn-sm btn-dark text-white fw-bold">Étudiants</a></li>
				<li class="breadcrumb-item"><a href="ListePrestataire" class="btn btn-sm btn-dark text-white fw-bold">Prestataires</a></li>
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
								<th class="text-nowrap">Titre & Catégorie</th>
								<th class="text-nowrap">Description</th>
								<th class="text-nowrap">Zone</th> <!-- Nouvelle Colonne dédiée -->
								<th class="text-nowrap">Salaire</th>
								<th class="text-nowrap">Avis (%)</th>
								<th class="text-nowrap">Statut</th>
								<th class="text-nowrap">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($annonces)): ?>
								<?php foreach ($annonces as $index => $annonce): 
									// Calcul avis
									$moyenne = $annonce['note_moyenne'] ?? 0;
									$pourcentage = round(($moyenne / 5) * 100);
									$totalAvis = $annonce['total_avis'];
									
									$barClass = 'bg-silver-darker'; // Gris si 0%
									if($pourcentage > 0) $barClass = 'bg-danger';
									if($pourcentage >= 50) $barClass = 'bg-warning';
									if($pourcentage >= 80) $barClass = 'bg-success';
								?>
									<tr>
										<td class="f-w-600 text-inverse"><?= $index + 1 ?></td>
										
										<!-- Titre et Catégorie uniquement -->
										<td>
											<strong><?= htmlspecialchars($annonce['titre']) ?></strong><br>
											<small class="text-muted">Catégorie : <?= htmlspecialchars($annonce['categorie_nom'] ?? 'N/A') ?></small><br>
											<small class="text-info">Publié le <?= date('d/m/Y', strtotime($annonce['created_at'])) ?></small>
										</td>

										<td><?= nl2br(htmlspecialchars(substr($annonce['description'], 0, 70))) ?>...</td>

										<!-- COLONNE ZONE DÉDIÉE -->
										<td class="text-nowrap">
											<i class="fa fa-map-marker-alt text-danger m-r-5"></i> 
											<span class="f-w-600 text-inverse"><?= htmlspecialchars($annonce['nom_quartier'] ?? 'Non définie') ?></span>
										</td>

										
										
										<td class="text-nowrap f-w-600 text-inverse">
											<?= number_format($annonce['salaire'], 0, ',', ' ') ?> <small>FCFA</small>
										</td>
										
										<!-- Avis -->
										<td style="min-width: 130px;">
											<div class="d-flex align-items-center">
												<div class="progress progress-xs width-100 m-r-10" style="height: 8px; flex: 1; background: #eee;">
													<div class="progress-bar <?= $barClass ?>" style="width: <?= $pourcentage ?>%"></div>
												</div>
												<small class='f-w-700 text-inverse'><?= $pourcentage ?>%</small>
											</div>
											<small class="text-muted"><?= $totalAvis ?> avis</small>
										</td>

										<td>
											<?php 
												$badgeClass = 'badge-success';
												if($annonce['statut'] == 'Pourvu') $badgeClass = 'badge-warning';
												if($annonce['statut'] == 'Annule') $badgeClass = 'badge-danger';
											?>
											<span class="badge <?= $badgeClass ?> p-5" style="min-width: 60px;"><?= $annonce['statut'] ?></span>
										</td>
										
										<td class="text-nowrap">
											<!--<a href="#modal-edit-annonce" data-toggle="modal" class="btn btn-xs btn-warning" onclick="editAnnonce(<?= htmlspecialchars(json_encode($annonce)) ?>)">
												<i class="fa fa-edit"></i>
											</a>-->
											<a href="javascript:;" onclick="confirmDelete(<?= $annonce['id'] ?>)" class="btn btn-lg btn-danger">
												<i class="fa fa-trash"></i>
											</a>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php else: ?>
								<tr><td colspan="8" class="text-center">Aucune annonce trouvée.</td></tr>
							<?php endif; ?>
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

	<!-- ================== Modal Ajouter Annonce ================== -->
	<div class="modal fade" id="modal-annonce" tabindex="-1" aria-labelledby="modal-annonce-label" aria-hidden="true"> 
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<h4 class="modal-title">Ajouter une annonce</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>

			<form action="annonceMainController"  method="POST" id="addAnnonceFrom">
					<div  class="modal-body">
						<!-- Titre -->
						<div class="form-group">
							<label for="titre">Titre</label>
							<input type="text" class="form-control" id="titre" name="titre" required>
							<p class="error-message mt-2"></p>
						</div>

						<!-- Description -->
						<div class="form-group">
							<label for="description">Description</label>
							<textarea class="form-control" id="description" name="description" rows="4" required></textarea>
							<p class="error-message mt-2"></p>
						</div>

						<!-- Salaire -->
						<div class="form-group">
							<label for="salaire">Salaire</label>
							<input type="number" class="form-control" id="salaire" name="salaire" min="0" required>
							<p class="error-message mt-2"></p>
						</div>

						<!--Statut-->
						<!-- <div class="form-group">
							<label for="status">Statut</label>
							<select class="form-control" id="status" name="status" required>
								<option value="">-- Sélectionner --</option>
								<option value="ouvert">Ouverte</option>
								<option value="pourvu">Pourvue</option>
								<option value="annule">Annulée</option>
							</select>
							<p class="error-message mt-2"></p>
						</div>  -->

						<!-- Catégorie -->
						<div class="form-group">
							<label for="categorie_id">Catégorie</label>
							<select class="form-control" id="categorie_id" name="categorie_id" required>
								<option value="">-- Choisir une catégorie --</option>
								<?php foreach($categories as $cat): ?>
									<option value="<?= $cat['id'] ?>"><?= $cat['nom'] ?></option>
								<?php endforeach; ?>
							</select>
							<p class="error-message mt-2"></p>
						</div>

						<!-- Zone -->
						<div class="form-group">
							<label for="zone_id">Zone / Quartier</label>
							<select class="form-control" id="zone_id" name="zone_id" required>
								<option value="">-- Choisir une zone --</option>
								<?php foreach($zones as $z): ?>
									<option value="<?= $z['id'] ?>"><?= $z['nom_quartier'] ?></option>
								<?php endforeach; ?>
							</select>
							<p class="error-message mt-2"></p>
						</div>
					</div>

					<!--Soumission-->
					<div class="modal-footer">
						<button type="submit" name="frmAddAnnonce" class="btn btn-primary fw-bold">Ajouter</button>
						<button type="button" class="btn btn-danger fw-bold" data-dismiss="modal">Annuler</button>
					</div>
					
				</form>

			</div>
		</div>
	</div>

	<!-- ================== Modal Modifier Annonce ================== -->
	<div class="modal fade" id="modal-edit-annonce" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Modifier l'annonce</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<form action="annonceMainController" method="POST" id="editAnnonceForm">
					<div class="modal-body">
						
						<input type="hidden" name="id" id="edit_id">

						<div class="form-group">
							<label>Titre</label>
							<input type="text" class="form-control" id="edit_titre" name="titre" required>
							<p class="error-message mt-2"></p>
						</div>

						<div class="form-group">
							<label>Description</label>
							<textarea class="form-control" id="edit_description" name="description" rows="4" required></textarea>
							<p class="error-message mt-2"></p>
						</div>

						<div class="form-group">
							<label>Salaire</label>
							<input type="number" class="form-control" id="edit_salaire" name="salaire" required>
							<p class="error-message mt-2"></p>
						</div>

						<div class="form-group">
							<label>Catégorie</label>
							<select class="form-control" id="edit_categorie_id" name="categorie_id" required>
								<?php foreach($categories as $cat): ?>
									<option value="<?= $cat['id'] ?>"><?= $cat['nom'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="form-group">
							<label>Zone</label>
							<select class="form-control" id="edit_zone_id" name="zone_id" required>
								<?php foreach($zones as $z): ?>
									<option value="<?= $z['id'] ?>"><?= $z['nom_quartier'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="form-group">
							<label>Statut</label>
							<select class="form-control" id="edit_statut" name="statut" required>
								<option value="Ouvert">Ouverte</option>
								<option value="Pourvu">Pourvue</option>
								<option value="Annule">Annulée</option>
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" name="frmEditAnnonce" class="btn btn-warning fw-bold">Enregistrer les modifications</button>
						<button type="button" class="btn btn-default fw-bold" data-dismiss="modal">Fermer</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- ================== section JS ================== -->
	<?php require_once("../../../sections/admin/config.php"); ?>
	<?php require_once("../../../sections/admin/script.php"); ?>
	
</body>
</html>