<?php 
// 1. Sécurité : On remonte 3 niveaux pour atteindre controller/ depuis view/pages/prestataire/
require_once("../../../controller/SecurityProvider.php"); 
protectPrestataire(); 

if (session_status() === PHP_SESSION_NONE) session_start();

// 2. Anti-Cache
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// 3. Données : On remonte 3 niveaux pour atteindre model/
require_once("../../../model/CandidatureRepository.php");
$candRepo = new CandidatureRepository();
$candidatures = $candRepo->getCandidaturesForPrestataire($_SESSION['id']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Candidatures Reçues | Gorgoorlu</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    
    <!-- On utilise le HEAD de l'admin (remonte 2 niveaux pour view/sections/admin/) -->
    <?php require_once("../../sections/admin/head.php"); ?>
</head>
<body>
    <!-- begin #page-loader -->
    <div id="page-loader" class="fade show"><span class="spinner"></span></div>
    
    <div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
        
        <!-- CORRECTION : Remplacement de layout.php par les sections réelles -->
        <?php require_once("../../sections/prestataire/menuHaut.php"); ?>
        <?php require_once("../../sections/prestataire/menuGauche.php"); ?>

        <div id="content" class="content">
            <h1 class="page-header">Candidatures reçues <small>Liste des étudiants intéressés</small></h1>

            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Suivi des postulants</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
                        <thead>
                            <tr>
                                <th width="1%">#</th>
                                <th>Étudiant</th>
                                <th>Annonce</th>
                                <th>Statut</th> 
                                <th>Message</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($candidatures)): ?>
                                <?php foreach($candidatures as $index => $c): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><strong><?= htmlspecialchars($c['cand_prenom'] . ' ' . $c['cand_nom']) ?></strong></td>
                                    <td><span class="text-primary"><?= htmlspecialchars($c['annonce_titre']) ?></span></td>
                                    <td>
                                        <?php 
                                            $badge = 'badge-warning'; 
                                            if($c['statut'] == 'Acceptée') $badge = 'badge-success';
                                            if($c['statut'] == 'Refusée') $badge = 'badge-danger';
                                        ?>
                                        <span class="badge <?= $badge ?>"><?= $c['statut'] ?></span>
                                    </td>
                                    <td>
                                        <button class="btn btn-xs btn-default" onclick="showMsg('<?= addslashes($c['message_motivation']) ?>')">
                                            <i class="fa fa-eye"></i> Lire
                                        </button>
                                    </td>
                                    <td class="text-nowrap">
                                        <?php if($c['statut'] == 'En attente'): ?>
                                            <button onclick="confirmAcceptCandidature(<?= $c['id'] ?>)" class="btn btn-sm btn-success" title="Accepter">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button onclick="confirmDeleteCandidature(<?= $c['id'] ?>)" class="btn btn-sm btn-danger" title="Refuser">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        <?php else: ?>
                                            <span class="text-muted small"><i class="fa fa-lock"></i> Traité</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6" class="text-center">Aucune candidature reçue pour le moment.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
    </div>

    <!-- SCRIPTS : On remonte 2 niveaux pour view/sections/admin/ -->
    <?php require_once("../../sections/admin/script.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Chemin absolu pour le JS de candidature -->
    <script src="/ApplicationPHP/public/js/candidature.js"></script>

    <script>
        function showMsg(msg) {
            Swal.fire({
                title: 'Message de motivation',
                text: msg,
                icon: 'info',
                confirmButtonText: 'Fermer',
                background: '#2d353c',
                color: '#fff'
            });
        }
    </script>
</body>
</html>