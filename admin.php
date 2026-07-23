<?php 
if (session_status() === PHP_SESSION_NONE) session_start();

// 1. Empêcher le retour arrière du navigateur (Cache)
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

// 2. Vérification de l'identité et du RÔLE
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'Admin') {
    // Si pas connecté ou pas Admin, on redirige vers le login avec un message
    header("Location: login?error=1&message=" . urlencode("Accès refusé. Veuillez vous connecter en tant qu'administrateur."));
    exit();
}

// 1. Inclusions des modèles
require_once("model/AnnonceRepository.php");
require_once("model/UserRepository.php");
require_once("model/CandidatureRepository.php");
require_once("model/AvisRepository.php");
require_once("view/sections/admin/script.php"); 
// 2. Initialisation et récupération des chiffres
$annRepo = new AnnonceRepository();
$userRepo = new UserRepository();
$candRepo = new CandidatureRepository();
$avisRepo = new AvisRepository();

$statsAnnonces = $annRepo->countAllActive();
$statsEtudiants = $userRepo->countByRole('Etudiant');
$statsPrestataires = $userRepo->countByRole('Prestataire');
$statsCandidatures = $candRepo->countAll();
$avisData = $avisRepo->getGlobalStats();

$totalAvis = $avisData['total'] ?? 0;
$moyenneAvis = $avisData['moyenne'] ? number_format($avisData['moyenne'], 1, ',', '') : '0';
$chartData = $candRepo->getStatsLast7Days();

// ... après la récupération de $chartData
$labels = [];
$counts = [];

if (!empty($chartData)) {
    foreach($chartData as $data) {
        $labels[] = date('d M', strtotime($data['date']));
        $counts[] = (int)$data['total'];
    }
} else {
    // Données fictives de remplissage si la base est vide (pour le test)
    $labels = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
    $counts = [0, 0, 0, 0, 0, 0, 0];
}

$jsonLabels = json_encode($labels);
$jsonCounts = json_encode($counts);
?>
<!DOCTYPE html>
<html lang="en">
	<!-- ================== section HEAD ================== -->
	<?php require_once("view/sections/admin/head.php"); ?>
	
	<!-- ================== section BODY ================== -->
<body>
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade show">
		<span class="spinner"></span>
	</div>
	<!-- end #page-loader -->
	
	
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">

		<!-- ================== sectionMenu haut ================== -->
		<?php require_once("view/sections/admin/menuHaut.php"); ?>
		
		
		<!-- ================== section Menu Gauche ================== -->
		<?php require_once("view/sections/admin/menuGauche.php"); ?>
		
		<!-- ================== section Base content ================== -->
		<?php require_once("view/sections/admin/baseContent.php"); ?>
		
		
		<!-- ================== section config ================== -->
		<?php require_once("view/sections/admin/config.php"); ?>
		
		
		<!-- ================== section scroll to top ================== -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		
	</div>
	<!-- end page container -->
	
	<!-- ==================  JS ================== -->
	<?php require_once("view/sections/admin/script.php"); ?>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<!-- ================== Message d'erreur ================== -->
	<?php if(isset($_GET['error']) && $_GET['error'] == 1 && isset($_GET['message']) && isset($_GET['title'])) : ?>
		<script>
			Swal.fire({
				icon: 'error',
				title: '<?php echo htmlspecialchars($_GET['title'], ENT_QUOTES, 'UTF-8'); ?>',
				text: '<?php echo htmlspecialchars($_GET['message'], ENT_QUOTES, 'UTF-8'); ?>'
			});
		</script>
	<?php endif; ?>

	<!-- ================== Message Success ================== -->
	<?php if(isset($_GET['succes']) && $_GET['succes'] == 1 && isset($_GET['message']) && isset($_GET['title'])) : ?>
		<script>
			Swal.fire({
				icon: 'success', 
				title:'<?php echo htmlspecialchars($_GET['title'], ENT_QUOTES, 'UTF-8'); ?>',
				text: '<?php echo htmlspecialchars($_GET['message'], ENT_QUOTES, 'UTF-8'); ?>'
			});
		</script>
	<?php endif; ?>

   
    

    <script>
        // On attend que la page et les scripts soient totalement chargés
        document.addEventListener("DOMContentLoaded", function() {
            var options = {
                series: [{
                    name: 'Candidatures',
                    data: <?php echo $jsonCounts; ?>
                }],
                chart: {
                    type: 'area',
                    height: 250,
                    toolbar: { show: false },
                    foreColor: '#adb5bd' // Couleur du texte (gris clair)
                },
                colors: ['#00acac'], // Couleur Teal du template
                stroke: { curve: 'smooth', width: 3 },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.5,
                        opacityTo: 0.1,
                        stops: [0, 90, 100]
                    }
                },
                dataLabels: { enabled: false },
                xaxis: {
                    categories: <?php echo $jsonLabels; ?>,
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                grid: {
                    borderColor: '#333', // Lignes de fond sombres
                    strokeDashArray: 4
                },
                theme: { mode: 'dark' }
            };

            // On vérifie si l'élément existe avant de dessiner
            var chartElement = document.querySelector("#apex-candidatures-chart");
            if (chartElement) {
                var chart = new ApexCharts(chartElement, options);
                chart.render();
            }
        });
    </script>
</body>
</html>

</body>
</html>
</body>
</html>