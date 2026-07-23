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
require_once("../../../model/CandidatureRepository.php");
require_once("../../../model/AvisRepository.php");

$presId = $_SESSION['id'];

// Initialisation des Repos
$annRepo = new AnnonceRepository();
$candRepo = new CandidatureRepository();
$avisRepo = new AvisRepository();

// Récupération des vrais chiffres
$nbAnnonces = $annRepo->countAnnoncesByPrestataire($presId);
$nbPending  = $candRepo->countPendingCandidatures($presId);
$avgRating  = $avisRepo->getGlobalRating($presId);
?>

<!DOCTYPE html>
<html lang="fr">
<?php require_once("../../sections/admin/head.php"); ?>
<body>
    <div id="page-loader" class="fade show"><span class="spinner"></span></div>
    <div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
        
        <?php include("../../sections/prestataire/layout.php"); ?>

        <div id="content" class="content">
            <h1 class="page-header">Tableau de bord <small>Statistiques de votre activité</small></h1>

            <div class="row">
                <!-- WIDGET ANNONCES -->
                <div class="col-xl-4 col-md-6">
                    <div class="widget widget-stats bg-blue">
                        <div class="stats-icon"><i class="fa fa-bullhorn"></i></div>
                        <div class="stats-info">
                            <h4>MES OFFRES ACTIVES</h4>
                            <p><?= $nbAnnonces ?></p>	
                        </div>
                        <div class="stats-link">
                            <a href="MesAnnonces">Gérer mes offres <i class="fa fa-arrow-alt-circle-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- WIDGET CANDIDATURES -->
                <div class="col-xl-4 col-md-6">
                    <div class="widget widget-stats bg-orange">
                        <div class="stats-icon"><i class="fa fa-users"></i></div>
                        <div class="stats-info">
                            <h4>À TRAITER (EN ATTENTE)</h4>
                            <p><?= $nbPending ?></p>	
                        </div>
                        <div class="stats-link">
                            <a href="CandidaturesRecues">Voir les postulants <i class="fa fa-arrow-alt-circle-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- WIDGET REPUTATION -->
                <div class="col-xl-4 col-md-6">
                    <div class="widget widget-stats bg-green">
                        <div class="stats-icon"><i class="fa fa-star"></i></div>
                        <div class="stats-info">
                            <h4>RÉPUTATION GLOBALE</h4>
                            <p><?= $avgRating ?>%</p>	
                        </div>
                        <div class="stats-link">
                            <a href="javascript:;">Satisfaction candidats</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PANNEAU BIENVENUE -->
            <div class="panel panel-inverse">
                <div class="panel-heading"><h4 class="panel-title">Bonjour <?= $_SESSION['prenom'] ?> !</h4></div>
                <div class="panel-body">
                    <p>Bienvenue sur votre espace professionnel. Vous avez actuellement <b><?= $nbPending ?></b> candidature(s) en attente de réponse.</p>
                </div>
            </div>
        </div>
    </div>

    <?php require_once("../../sections/admin/script.php"); ?>
</body>
</html>