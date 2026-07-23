<?php
if (session_status() === PHP_SESSION_NONE) session_start();
// Sécurité : on vérifie que c'est un étudiant
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Etudiant') {
    header("Location: home");
    exit;
}

require_once("../../../model/CandidatureRepository.php");
$candRepo = new CandidatureRepository();
$mesDemandes = $candRepo->getCandidaturesByUser($_SESSION['id']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Mes Postulations | Gorgoorlu</title>
    <link href="public/templates/templateVitrine/assets/css/one-page-parallax/app.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        #header { background: #2d353c !important; } /* Menu visible */
        .status-badge { padding: 5px 12px; border-radius: 20px; font-weight: 600; font-size: 12px; }
    </style>
</head>

<body style="background: #f4f7f6;">
    <?php require_once("../../sections/vitrine/menu.php"); ?>

    <div class="container" style="margin-top: 120px; margin-bottom: 60px;">
        <h2 class="f-w-700 m-b-20">Suivi de mes candidatures</h2>
        <p class="m-b-30">Retrouvez ici l'historique de vos postulations et leur état d'avancement.</p>

        <div class="panel" style="background: #fff; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); overflow: hidden;">
            <table class="table table-hover m-b-0">
                <thead style="background: #f8f9fa;">
                    <tr>
                        <th>Offre / Mission</th>
                        <th>Catégorie & Lieu</th>
                        <th>Date d'envoi</th>
                        <th class="text-center">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($mesDemandes)): ?>
                        <?php foreach ($mesDemandes as $c): ?>
                            <tr>
                                <td style="vertical-align: middle;">
                                    <span class="f-w-700 text-inverse"><?= htmlspecialchars($c['annonce_titre']) ?></span>
                                </td>
                                <td style="vertical-align: middle;">
                                    <small class="text-muted">
                                        <?= htmlspecialchars($c['categorie_nom']) ?> | 
                                        <i class="fa fa-map-marker-alt text-danger"></i> <?= htmlspecialchars($c['nom_quartier']) ?>
                                    </small>
                                </td>
                                <td style="vertical-align: middle;">
                                    <?= date('d/m/Y', strtotime($c['date_postulation'])) ?>
                                </td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <?php 
                                        $class = "bg-warning text-white"; // En attente
                                        if($c['statut'] == 'Acceptée') $class = "bg-success text-white";
                                        if($c['statut'] == 'Refusée') $class = "bg-danger text-white";
                                    ?>
                                    <span class="status-badge <?= $class ?>">
                                        <?= $c['statut'] ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center p-40">
                                <i class="fa fa-folder-open fa-3x text-silver m-b-15"></i><br>
                                Vous n'avez pas encore postulé à des offres. <br>
                                <a href="ToutesLesOffres" class="btn btn-sm btn-primary m-t-15">Voir les annonces</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php require_once("../../sections/vitrine/footer.php"); ?>
</body>
</html>