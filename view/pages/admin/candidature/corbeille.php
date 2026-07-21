<?php
require_once("../../../../model/CandidatureRepository.php");
$repo = new CandidatureRepository();
$trash = $repo->getTrashWithDetails();
?>

<!DOCTYPE html>
<html lang="en">
	<?php require_once("../../../sections/admin/head.php"); ?>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<body>
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		<?php require_once("../../../sections/admin/menuHaut.php"); ?>
		<?php require_once("../../../sections/admin/menuGauche.php"); ?>

		<div id="content" class="content">
			<ol class="breadcrumb float-xl-right">
				<li class="breadcrumb-item"><a href="ListeCandidature" class="btn btn-sm btn-success text-white fw-bold"><i class="fa fa-arrow-left"></i> Retour aux candidatures</a></li>
			</ol>
			<h1 class="page-header"># Corbeille <small>Candidatures archivées</small></h1>

			<div class="panel panel-danger">
				<div class="panel-heading"><h4 class="panel-title">Postulations supprimées</h4></div>
				<div class="panel-body">
					<table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
						<thead>
							<tr>
								<th>Étudiant</th>
								<th>Offre concernée</th>
								<th>Supprimée le</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($trash as $c): ?>
							<tr>
								<td><strong><?= htmlspecialchars($c['prenom'].' '.$c['nom']) ?></strong></td>
								<td><span class="badge badge-info"><?= htmlspecialchars($c['annonce_titre']) ?></span></td>
								<td><span class="text-danger"><?= date('d/m/Y H:i', strtotime($c['deleted_at'])) ?></span></td>
								<td class="text-nowrap">
									<a href="candidatureMainController?restore_id=<?= $c['id'] ?>" class="btn btn-xs btn-primary">
										<i class="fa fa-undo"></i> Restaurer
									</a>
									<a href="javascript:;" onclick="confirmPermanentDelete(<?= $c['id'] ?>)" class="btn btn-xs btn-danger">
										<i class="fa fa-times"></i> Supprimer
									</a>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

    <script>
    function confirmPermanentDelete(id) {
        Swal.fire({
            title: 'Suppression définitive ?',
            text: "Cette candidature sera effacée à jamais !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff5b57',
            confirmButtonText: 'Oui, supprimer définitivement',
            background: '#2d353c', color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "candidatureMainController?permanent_delete_id=" + id;
            }
        });
    }
    </script>
	<?php require_once("../../../sections/admin/script.php"); ?>
</body>
</html>