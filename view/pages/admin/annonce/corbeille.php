<?php
require_once("../../../../model/AnnonceRepository.php");

$annonceRepo = new AnnonceRepository();
$annoncesTrash = $annonceRepo->getTrashAnnoncesWithDetails();
?>

<!DOCTYPE html>
<html lang="en">
	<?php require_once("../../../sections/admin/head.php"); ?>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	
<body>
	<div id="page-loader" class="fade show"><span class="spinner"></span></div>
	
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		<?php require_once("../../../sections/admin/menuHaut.php"); ?>
		<?php require_once("../../../sections/admin/menuGauche.php"); ?>

		 <div id="content" class="content">
			<ol class="breadcrumb float-xl-right">
				<li class="breadcrumb-item"><a href="ListeAnnonce" class="btn btn-sm btn-success text-white fw-bold"><i class="fa fa-arrow-left"></i> Retour à la liste</a></li>
			</ol>
			<h1 class="page-header"># Corbeille <small>Annonces supprimées</small></h1>

			<div class="panel panel-danger">
				<div class="panel-heading">
					<h4 class="panel-title">Annonces en attente de suppression définitive</h4>
				</div>
				<div class="panel-body">
					<table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
						<thead>
							<tr>
								<th width="1%">#</th>
								<th>Annonce</th>
								<th>Supprimée le</th>
								<th>Catégorie / Zone</th>
								<th width="15%">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($annoncesTrash)): ?>
								<?php foreach ($annoncesTrash as $index => $annonce): ?>
									<tr>
										<td><?= $index + 1 ?></td>
										<td><strong><?= htmlspecialchars($annonce['titre']) ?></strong></td>
										<td>
                                            <span class="text-danger">
                                                <i class="fa fa-calendar-times"></i> <?= date('d/m/Y à H:i', strtotime($annonce['deleted_at'])) ?>
                                            </span>
                                        </td>
										<td>
											<small><?= htmlspecialchars($annonce['categorie_nom']) ?> / <?= htmlspecialchars($annonce['nom_quartier']) ?></small>
										</td>
										<td class="text-nowrap">
											<a href="javascript:;" onclick="confirmRestore(<?= $annonce['id'] ?>)" class="btn btn-xs btn-primary" title="Restaurer">
												<i class="fa fa-undo"></i> Restaurer
											</a>
											<a href="javascript:;" onclick="confirmPermanentDelete(<?= $annonce['id'] ?>)" class="btn btn-xs btn-danger" title="Supprimer définitivement">
												<i class="fa fa-times"></i> Supprimer
											</a>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php else: ?>
								<tr><td colspan="5" class="text-center">La corbeille est vide.</td></tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

    <script>
        function confirmRestore(id) {
            Swal.fire({
                title: 'Restaurer l\'annonce ?',
                text: "Elle sera de nouveau visible dans la liste active.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#348fe2',
                confirmButtonText: 'Oui, restaurer !',
                background: '#2d353c', color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "annonceMainController?restore_id=" + id;
                }
            })
        }

        function confirmPermanentDelete(id) {
            Swal.fire({
                title: 'Suppression DÉFINITIVE ?',
                text: "Cette action est irréversible !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff5b57',
                confirmButtonText: 'Supprimer à jamais',
                background: '#2d353c', color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "annonceMainController?permanent_delete_id=" + id;
                }
            })
        }
    </script>

	<?php require_once("../../../sections/admin/config.php"); ?>
	<?php require_once("../../../sections/admin/script.php"); ?>
</body>
</html>