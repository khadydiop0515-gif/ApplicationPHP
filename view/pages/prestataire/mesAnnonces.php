<?php 
require_once("../../../controller/SecurityProvider.php"); 
protectPrestataire(); 
?>
<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// 1. Anti-Cache
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// 2. Vérification
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'Prestataire') {
    header("Location: login?error=1&message=" . urlencode("Veuillez vous connecter à votre espace professionnel."));
    exit();
}
require_once("../../../model/AnnonceRepository.php");
$repo = new AnnonceRepository();
$mesAnnonces = $repo->getAnnoncesByPrestataire($_SESSION['id']);
?>

<!DOCTYPE html>
<html lang="fr">
    <!-- On utilise /ApplicationPHP/ pour être sûr que le navigateur trouve les fichiers peu importe l'URL -->
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
                                <th>Actions</th>
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
                                    <td class="text-nowrap">
                                        <a href="ModifierAnnonce?id=<?= $a['id'] ?>" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                        <button onclick="confirmDelete(<?= $a['id'] ?>)" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
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

    <!-- SCRIPTS -->
    <?php require_once("../../sections/admin/script.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- On utilise un chemin qui part de la racine pour éviter les bugs du htaccess -->
    <script src="public/js/annonce.js"></script>
</body>
</html>