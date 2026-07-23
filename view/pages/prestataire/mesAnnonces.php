<?php 
require_once("../../../controller/SecurityProvider.php"); 
protectPrestataire(); 

require_once("../../../model/AnnonceRepository.php");
require_once("../../../model/CategorieRepository.php"); 
require_once("../../../model/ZoneRepository.php");      

if (session_status() === PHP_SESSION_NONE) session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'Prestataire') {
    header("Location: login?error=1&message=" . urlencode("Veuillez vous connecter à votre espace professionnel."));
    exit();
}

$repo = new AnnonceRepository();
$mesAnnonces = $repo->getAnnoncesByPrestataire($_SESSION['id']);

$categories = (new CategorieRepository())->getAll(); 
$zones = (new ZoneRepository())->getAll();           
?>

<!DOCTYPE html>
<html lang="fr">
    <?php require_once("../../sections/admin/head.php"); ?>
<body>
    <div id="page-loader" class="fade show"><span class="spinner"></span></div>

    <div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
        
        <?php require_once("../../sections/prestataire/menuHaut.php"); ?>
        <?php require_once("../../sections/prestataire/menuGauche.php"); ?>

        <div id="content" class="content">
            <ol class="breadcrumb float-xl-right">
                <li class="breadcrumb-item"><a href="DashboardPrestataire">Dashboard</a></li>
                <li class="breadcrumb-item active">Mes Annonces</li>
            </ol>
            <h1 class="page-header">Mes Annonces <small>Gestion de vos offres publiées</small></h1>
            
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Liste de mes offres actives</h4>
                    <div class="panel-heading-btn">
                        <a href="NouvelleAnnonce" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> Publier une offre</a>
                    </div>
                </div>
                <div class="panel-body">
                    <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
                        <thead>
                            <tr>
                                <th width="1%">#</th>
                                <th>Titre</th>
                                <th>Zone</th>
                                <th>Candidatures</th>
                                <th>Statut</th>
                                <th width="1%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($mesAnnonces)): ?>
                                <?php foreach($mesAnnonces as $index => $a): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($a['titre']) ?></strong><br>
                                        <small class="text-muted">Posté le <?= date('d/m/Y', strtotime($a['created_at'])) ?></small>
                                    </td>
                                    <td><i class="fa fa-map-marker-alt text-danger"></i> <?= htmlspecialchars($a['nom_quartier']) ?></td>
                                    <td>
                                        <span class="badge badge-info"><?= $a['nb_candidats'] ?> postulant(s)</span>
                                    </td>
                                    <td>
                                        <span class="label <?= ($a['statut'] == 'Ouvert') ? 'label-success' : 'label-warning' ?>">
                                            <?= $a['statut'] ?>
                                        </span>
                                    </td>
                                    <!-- CORRECTION ICI : Ajout du <td> manquant -->
                                    <td class="text-nowrap">
                                        <a href="#modal-edit-annonce" data-toggle="modal" class="btn btn-sm btn-primary" onclick='editAnnonce(<?= htmlspecialchars(json_encode($a), ENT_QUOTES, "UTF-8") ?>)'>
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button onclick="confirmDelete(<?= $a['id'] ?>, 'Prestataire')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6" class="text-center">Vous n'avez pas encore publié d'annonces.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
    </div>

    <!-- MODAL MODIFIER ANNONCE -->
    <div class="modal fade" id="modal-edit-annonce" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modifier mon annonce</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form action="annonceMainController" method="POST" id="editAnnonceForm">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">

                        <div class="form-group">
                            <label class="f-w-700">Titre</label>
                            <input type="text" class="form-control" id="edit_titre" name="titre" required>
                        </div>

                        <div class="form-group">
                            <label class="f-w-700">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="5" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="f-w-700">Salaire (FCFA)</label>
                                <input type="number" class="form-control" id="edit_salaire" name="salaire" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="f-w-700">Statut</label>
                                <select class="form-control" id="edit_statut" name="statut">
                                    <option value="Ouvert">Ouverte</option>
                                    <option value="Pourvu">Pourvue</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="f-w-700">Catégorie</label>
                                <select class="form-control" id="edit_categorie_id" name="categorie_id">
                                    <?php foreach($categories as $c): ?>
                                        <option value="<?= $c['id'] ?>"><?= $c['nom'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="f-w-700">Zone</label>
                                <select class="form-control" id="edit_zone_id" name="zone_id">
                                    <?php foreach($zones as $z): ?>
                                        <option value="<?= $z['id'] ?>"><?= $z['nom_quartier'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="frmEditAnnonce" class="btn btn-primary fw-bold">Enregistrer les modifications</button>
                        <button type="button" class="btn btn-white" data-dismiss="modal">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php require_once("../../sections/admin/script.php"); ?>
    <script src="/ApplicationPHP/public/js/annonce.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>