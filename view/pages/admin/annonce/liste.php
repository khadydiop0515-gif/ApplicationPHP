<?php 
require_once("../../../../controller/SecurityProvider.php"); 
protectAdmin(); 

require_once("../../../../model/AnnonceRepository.php");
require_once("../../../../model/CategorieRepository.php");
require_once("../../../../model/ZoneRepository.php");

$annonceRepo = new AnnonceRepository();
$annonces = $annonceRepo->getAllAnnoncesWithDetails();
?>

<!DOCTYPE html>
<html lang="fr">
	<?php require_once("../../../sections/admin/head.php"); ?>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	
<body>
	<div id="page-loader" class="fade show"><span class="spinner"></span></div>
	
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">

		<?php require_once("../../../sections/admin/menuHaut.php"); ?>
		<?php require_once("../../../sections/admin/menuGauche.php"); ?>

		 <div id="content" class="content">
			<ol class="breadcrumb float-xl-right">
				<li class="breadcrumb-item"><a href="CorbeilleAnnonce" class="btn btn-sm btn-dark text-white fw-bold">Corbeille</a></li>
				<li class="breadcrumb-item"><a href="ListeEtudiant" class="btn btn-sm btn-dark text-white fw-bold">Étudiants</a></li>
				<li class="breadcrumb-item"><a href="ListePrestataire" class="btn btn-sm btn-dark text-white fw-bold">Prestataires</a></li>
			</ol>
			
			<h1 class="page-header"># Gestion des Annonces</h1>

			<div class="panel panel-inverse">
				<div class="panel-heading">
					<h4 class="panel-title">Toutes les offres actives sur la plateforme</h4>
				</div>
				<div class="panel-body">
					<table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
						<thead>
							<tr>
								<th width="1%">#</th>
								<th class="text-nowrap">Titre (cliquer pour voir)</th>
								<th class="text-nowrap">Zone</th>
								<th class="text-nowrap">Description</th>
								<th class="text-nowrap">Salaire</th>
								<th class="text-nowrap">Avis (%)</th>
								<th class="text-nowrap">Statut</th>
								<th width="1%">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($annonces)): ?>
								<?php foreach ($annonces as $index => $a): 
									$moyenne = $a['note_moyenne'] ?? 0;
									$pourcentage = round(($moyenne / 5) * 100);
									$totalAvis = $a['total_avis'];
									
									$barClass = 'bg-silver-darker'; 
									if($pourcentage > 0) $barClass = 'bg-danger';
									if($pourcentage >= 50) $barClass = 'bg-warning';
									if($pourcentage >= 80) $barClass = 'bg-success';
								?>
									<tr>
										<td class="f-w-600 text-inverse"><?= $index + 1 ?></td>
										<td>
											<!-- LIEN DIRECT DANS LE TITRE -->
											<a href="detailsAnnonce?id=<?= $a['id'] ?>" class="text-primary f-w-700" title="Voir les détails de l'annonce">
												<?= htmlspecialchars($a['titre']) ?>
											</a><br>
											<small class="text-muted"><?= htmlspecialchars($a['categorie_nom'] ?? 'N/A') ?></small><br>
											<small class="text-info">Le <?= date('d/m/Y', strtotime($a['created_at'])) ?></small>
										</td>
										<td class="text-nowrap">
											<i class="fa fa-map-marker-alt text-danger m-r-5"></i> 
											<?= htmlspecialchars($a['nom_quartier'] ?? 'N/A') ?>
										</td>
										<td><?= nl2br(htmlspecialchars(substr($a['description'], 0, 60))) ?>...</td>
										<td class="text-nowrap f-w-600"><?= number_format($a['salaire'], 0, ',', ' ') ?> F</td>
										
										<td style="min-width: 120px;">
											<div class="d-flex align-items-center">
												<div class="progress progress-xs width-100 m-r-10" style="height: 6px; flex: 1;">
													<div class="progress-bar <?= $barClass ?>" style="width: <?= $pourcentage ?>%"></div>
												</div>
												<small class='f-w-600'><?= $pourcentage ?>%</small>
											</div>
											<small class="text-muted"><?= $totalAvis ?> avis</small>
										</td>

										<td>
											<span class="badge <?= ($a['statut'] == 'Ouvert') ? 'badge-success' : 'badge-warning' ?>">
												<?= $a['statut'] ?>
											</span>
										</td>
										
										<td class="text-center">
											<!-- UNIQUEMENT LE BOUTON SUPPRIMER -->
											<button onclick="confirmDelete(<?= $a['id'] ?>, 'Admin')" class="btn btn-sm btn-danger" title="Modérer / Supprimer">
												<i class="fa fa-trash"></i>
											</button>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php else: ?>
								<tr><td colspan="8" class="text-center">Aucune annonce trouvée.</td></tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
	</div>

	<!-- Scripts -->
	<?php require_once("../../../sections/admin/config.php"); ?>
	<?php require_once("../../../sections/admin/script.php"); ?>
	<script src="/ApplicationPHP/public/js/annonce.js"></script>
	
</body>
</html>