<?php
require_once("../../../../model/AvisRepository.php");
$avisRepo = new AvisRepository();
$trashAvis = $avisRepo->getTrashWithDetails();
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
				<li class="breadcrumb-item"><a href="ListeAvis" class="btn btn-sm btn-success text-white"><i class="fa fa-arrow-left"></i> Retour</a></li>
			</ol>
			<h1 class="page-header"># Corbeille des Avis</h1>

			<div class="panel panel-danger">
				<div class="panel-heading"><h4 class="panel-title">Avis supprimés</h4></div>
				<div class="panel-body">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Auteur</th>
								<th>Note</th>
								<th>Commentaire</th>
								<th>Supprimé le</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($trashAvis as $avis): ?>
							<tr>
								<td><strong><?= htmlspecialchars($avis['auteur_nom']) ?></strong></td>
								<td><span class="badge badge-warning"><?= $avis['note'] ?>/5</span></td>
								<td><small><?= htmlspecialchars($avis['commentaire']) ?></small></td>
								<td><span class="text-danger"><?= date('d/m/Y', strtotime($avis['deleted_at'])) ?></span></td>
								<td class="text-nowrap">
									<a href="avisMainController?restore_id=<?= $avis['id'] ?>" class="btn btn-xs btn-primary">Restaurer</a>
									<a href="javascript:;" onclick="confirmDelete(<?= $avis['id'] ?>)" class="btn btn-xs btn-danger">Supprimer</a>
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
    function confirmDelete(id) {
        Swal.fire({
            title: 'Suppression définitive ?',
            text: "Cette action est irréversible !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff5b57',
            confirmButtonText: 'Oui, supprimer à jamais'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "avisMainController?permanent_delete_id=" + id;
            }
        });
    }
    </script>
    <?php require_once("../../../sections/admin/script.php"); ?>
</body>
</html>