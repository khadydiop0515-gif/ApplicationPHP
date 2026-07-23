<?php 
require_once("../../../../controller/SecurityProvider.php"); 
protectAdmin(); 
?>
<?php
require_once("../../../../model/CandidatureRepository.php");
require_once("../../../../model/AnnonceRepository.php");
require_once("../../../../model/UserRepository.php");

$repo = new CandidatureRepository();
$annRepo = new AnnonceRepository();
$userRepo = new UserRepository();

$candidatures = $repo->getAllWithDetails();
$annonces = $annRepo->getAllAnnoncesWithDetails(); // Utilise la nouvelle méthode
$etudiants = $userRepo->getAll(); // Récupère tous les utilisateurs actifs
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
				<!--<li class="breadcrumb-item">
					<a href="#modal-add-candidature" class="btn btn-sm btn-dark text-white fw-bold" data-toggle="modal">Ajouter</a>
				</li>-->
				<li class="breadcrumb-item"><a href="CorbeilleCandidature" class="btn btn-sm btn-dark text-white fw-bold">Corbeille</a></li>
				<li class="breadcrumb-item active"><a href="ListeEtudiant" class="btn btn-sm btn-dark text-white fw-bold">Étudiants</a></li>
				<li class="breadcrumb-item"><a href="ListePrestataire" class="btn btn-sm btn-dark text-white fw-bold">Prestataires</a></li>
			</ol>
			<!-- end breadcrumb -->
            
            <h1 class="page-header"># Gestion des Candidatures</h1>

            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Liste des postulants</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
                        <thead>
                            <tr>
                                <th width="1%">#</th>
                                <th class="text-nowrap">Étudiant</th>
                                <th class="text-nowrap">Annonce visée</th>
                                <th class="text-nowrap">Date</th>
                                <th class="text-nowrap">Motivation</th>
                                <th class="text-nowrap">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($candidatures)): ?>
                                <?php foreach($candidatures as $index => $c): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <span class="text-inverse fw-bold"><?= htmlspecialchars($c['prenom'].' '.$c['nom']) ?></span>
                                    </td>
                                    <td><span class="badge badge-info"><?= htmlspecialchars($c['annonce_titre']) ?></span></td>
                                    <td><i class="fa fa-calendar-alt text-muted"></i> <?= date('d/m/Y H:i', strtotime($c['date_postulation'])) ?></td>
                                    <td>
                                        <small class="text-muted"><?= nl2br(htmlspecialchars(substr($c['message_motivation'], 0, 60))) ?>...</small>
                                    </td>
                                    <td>
                                        <!--<a href="#modal-edit-candidature" data-toggle="modal" class="btn btn-xs btn-primary" onclick='editCandidature(<?= json_encode($c) ?>)'>
                                            <i class="fa fa-edit"></i> Modifier
                                        </a>-->
                                        <a href="javascript:;" class="btn btn-xs btn-danger" onclick="confirmDeleteCandidature(<?= $c['id'] ?>)">
                                            <i class="fa fa-trash"></i> Supprimer
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Aucune candidature enregistrée.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ================== section scroll to top ================== -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
	</div>

	<!-- ================== Modal AJOUT ================== -->
	<div class="modal fade" id="modal-add-candidature">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="candidatureMainController" method="POST">
					<div class="modal-header">
                        <h4 class="modal-title">Nouvelle Candidature</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
					<div class="modal-body">
						<div class="form-group">
							<label>Choisir l'étudiant</label>
							<select name="user_id" class="form-control" required>
                                <option value="">-- Sélectionner l'étudiant --</option>
								<?php foreach($etudiants as $u): ?>
									<option value="<?= $u['id'] ?>"><?= $u['prenom'].' '.$u['nom'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group">
							<label>Choisir l'annonce</label>
							<select name="annonce_id" class="form-control" required>
                                <option value="">-- Sélectionner l'annonce --</option>
								<?php foreach($annonces as $a): ?>
									<option value="<?= $a['id'] ?>"><?= $a['titre'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group">
							<label>Message de motivation</label>
							<textarea name="message_motivation" class="form-control" rows="5" placeholder="Pourquoi postulez-vous ?" required></textarea>
						</div>
					</div>
					<div class="modal-footer">
                        <button type="submit" name="frmAddCandidature" class="btn btn-success fw-bold">Enregistrer</button>
                        <button type="button" class="btn btn-white fw-bold" data-dismiss="modal">Fermer</button>
                    </div>
				</form>
			</div>
		</div>
	</div>

	<!-- ================== Modal MODIFICATION ================== -->
	<div class="modal fade" id="modal-edit-candidature">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="candidatureMainController" method="POST">
					<div class="modal-header">
                        <h4 class="modal-title">Modifier la candidature</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
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
							<label>Motivation</label>
							<textarea name="message_motivation" id="edit_message" class="form-control" rows="5"></textarea>
						</div>
					</div>
					<div class="modal-footer">
                        <button type="submit" name="frmEditCandidature" class="btn btn-warning fw-bold">Mettre à jour</button>
                        <button type="button" class="btn btn-white fw-bold" data-dismiss="modal">Fermer</button>
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
