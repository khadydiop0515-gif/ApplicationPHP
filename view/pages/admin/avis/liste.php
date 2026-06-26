<?php
require_once("../../../../model/AvisRepository.php");
require_once("../../../../model/AnnonceRepository.php");

$avisRepo = new AvisRepository();
$annonceRepo = new AnnonceRepository();

$listeAvis = $avisRepo->getAllWithDetails();
$annonces = $annonceRepo->getAllAnnonces('Ouvert'); // Pour le select
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
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

		<!-- ================== section Menu Gauche ================== -->
		<?php require_once("../../../sections/admin/menuGauche.php"); ?>

		<!-- ================== section base content ================== -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb float-xl-right">
				<li class="breadcrumb-item">
					<a href="#modal-avis" class="btn btn-sm btn-dark text-white fw-bold" data-toggle="modal">Ajouter</a>
				</li>
				<li class="breadcrumb-item"><a href="javascript:;" class="btn btn-sm btn-dark text-white fw-bold" data-toggle="modal">Corbeille</a></li>
				<li class="breadcrumb-item active"><a href="javascript:;" class="btn btn-sm btn-dark text-white fw-bold" data-toggle="modal">Users</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header"># Avis</h1>
			<!-- end page-header -->
			<!-- begin panel -->
			<div class="panel panel-inverse">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<h4 class="panel-title">Liste des Avis</h4>
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
								<th class="text-nowrap">Note</th>
								<th class="text-nowrap">Commentaire</th>
								<th class="text-nowrap">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($listeAvis as $index => $avis): ?>
							<tr>
								<td><?= $index + 1 ?></td>
								<td class="with-img"><img src="public/templates/templateAdmin/assets/img/user/user-1.jpg" class="img-rounded height-30" /></td>
								<td><span class="badge badge-warning"><?= $avis['note'] ?> / 5</span></td>
								<td>
									<strong>Annonce: <?= htmlspecialchars($avis['annonce_titre']) ?></strong><br>
									<?= nl2br(htmlspecialchars($avis['commentaire'])) ?>
								</td>
								<td>
									<a href="#modal-edit-avis" data-toggle="modal" class="btn btn-xs btn-primary" onclick='editAvis(<?= json_encode($avis) ?>)'>Modifier</a>
									<a href="javascript:;" class="btn btn-xs btn-danger" onclick="confirmDeleteAvis(<?= $avis['id'] ?>)">Supprimer</a>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<!-- MODAL AJOUT -->
<div class="modal fade" id="modal-avis">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="avisMainController" method="post" id="addAvisForm">
                <div class="modal-header"><h4 class="modal-title">Ajouter un avis</h4></div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Annonce concernée</label>
                        <select name="annonce_id" class="form-control" required>
                            <?php foreach($annonces as $a): ?>
                                <option value="<?= $a['id'] ?>"><?= $a['titre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Note</label>
                        <select name="note" class="form-control">
                            <option value="5">5 - Excellent</option>
                            <option value="4">4 - Très bien</option>
                            <option value="3">3 - Moyen</option>
                            <option value="2">2 - Mauvais</option>
                            <option value="1">1 - Horrible</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Commentaire</label>
                        <textarea name="commentaire" id="commentaire" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="frmAddAvis" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL MODIFIER -->
<div class="modal fade" id="modal-edit-avis">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="avisMainController" method="post">
                <div class="modal-header"><h4 class="modal-title">Modifier l'avis</h4></div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="form-group">
                        <label>Annonce</label>
                        <select name="annonce_id" id="edit_annonce_id" class="form-control">
                            <?php foreach($annonces as $a): ?>
                                <option value="<?= $a['id'] ?>"><?= $a['titre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Note</label>
                        <select name="note" id="edit_note" class="form-control">
                            <option value="5">5</option><option value="4">4</option>
                            <option value="3">3</option><option value="2">2</option><option value="1">1</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Commentaire</label>
                        <textarea name="commentaire" id="edit_commentaire" class="form-control" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer"><button type="submit" name="frmEditAvis" class="btn btn-warning">Modifier</button></div>
            </form>
        </div>
    </div>
</div>

	<?php require_once("../../../sections/admin/config.php"); ?>
	<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fad+e" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
	<?php require_once("../../../sections/admin/script.php"); ?>
</body>
</html>
