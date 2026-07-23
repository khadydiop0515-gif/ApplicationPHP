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
require_once("../../../model/CandidatureRepository.php");
$candRepo = new CandidatureRepository();
$candidatures = $candRepo->getCandidaturesForPrestataire($_SESSION['id']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Candidatures Reçues | Gorgoorlu</title>
    <link href="public/templates/templateAdmin/assets/css/default/app.min.css" rel="stylesheet" />
    <link href="public/templates/templateAdmin/assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
</head>
<body>
    <div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
        
        <?php include("layout.php"); ?>

        <div id="content" class="content">
            <h1 class="page-header">Candidatures reçues <small>Liste des étudiants intéressés</small></h1>

            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Suivi des postulants</h4>
                </div>
                <div class="panel-body">
                    <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
                        <!-- Dans le tableau du fichier CandidatureRecues.php -->
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Étudiant</th>
                                <th>Annonce</th>
                                <th>Statut</th> 
                                <th>Message</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($candidatures as $index => $c): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><strong><?= htmlspecialchars($c['cand_prenom'] . ' ' . $c['cand_nom']) ?></strong></td>
                                <td><span class="text-primary"><?= htmlspecialchars($c['annonce_titre']) ?></span></td>
                                <td>
                                    <?php 
                                        $badge = 'badge-warning'; // En attente
                                        if($c['statut'] == 'Acceptée') $badge = 'badge-success';
                                        if($c['statut'] == 'Refusée') $badge = 'badge-danger';
                                    ?>
                                    <span class="badge <?= $badge ?>"><?= $c['statut'] ?></span>
                                </td>
                                <td>
                                    <button class="btn btn-xs btn-default" onclick="showMsg('<?= addslashes($c['message_motivation']) ?>')">Lire</button>
                                </td>
                                <td class="text-nowrap">
                                    <?php if($c['statut'] == 'En attente'): ?>
                                        <button onclick="confirmAcceptCandidature(<?= $c['id'] ?>)" class="btn btn-sm btn-success"><i class="fa fa-check"></i></button>
                                        <button onclick="confirmDeleteCandidature(<?= $c['id'] ?>)" class="btn btn-sm btn-danger" title="Refuser"><i class="fa fa-times"></i></button>
                                    <?php else: ?>
                                        <span class="text-muted small">Traité</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

        <!-- À la fin du fichier CandidatureRecues.php -->
    <script src="public/templates/templateAdmin/assets/js/app.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="public/js/candidature.js"></script>
    <script>
        function showMsg(msg) {
            Swal.fire({
                title: 'Message de motivation',
                text: msg,
                icon: 'info',
                confirmButtonText: 'Fermer'
            });
        }
    </script>
</body>
</html>