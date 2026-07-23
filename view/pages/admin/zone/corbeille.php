<?php 
require_once("../../../../controller/SecurityProvider.php"); 
protectAdmin(); 
?>
<?php
require_once("../../../../model/ZoneRepository.php");
$repo = new ZoneRepository();
$trash = $repo->getTrash();
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
				<li class="breadcrumb-item"><a href="ListeZone" class="btn btn-sm btn-success text-white"><i class="fa fa-arrow-left"></i> Retour</a></li>
			</ol>
			<h1 class="page-header"># Corbeille des Zones</h1>

			<div class="panel panel-danger">
				<div class="panel-heading"><h4 class="panel-title">Zones supprimées</h4></div>
				<div class="panel-body">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th width="1%">#</th>
								<th>Nom du quartier</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($trash as $index => $z): ?>
							<tr>
								<td><?= $index + 1 ?></td>
								<td><strong><?= htmlspecialchars($z['nom_quartier']) ?></strong></td>
								<td class="text-nowrap">
									<a href="zoneMainController?restore_id=<?= $z['id'] ?>" class="btn btn-xs btn-primary"><i class="fa fa-undo"></i> Restaurer</a>
									<a href="javascript:;" onclick="confirmPermanentDelete(<?= $z['id'] ?>)" class="btn btn-xs btn-danger"><i class="fa fa-times"></i> Supprimer</a>
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
            title: 'Action irréversible !',
            text: "Supprimer définitivement cette zone ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff5b57',
            confirmButtonText: 'Oui, supprimer'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "zoneMainController?permanent_delete_id=" + id;
            }
        });
    }
    </script>
    <?php require_once("../../../sections/admin/script.php"); ?>
</body>
</html>