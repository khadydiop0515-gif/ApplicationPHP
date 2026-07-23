<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (isset($_SESSION['id'])) {
    // Si l'utilisateur est déjà là, on le renvoie vers son espace selon son rôle
    if ($_SESSION['role'] === 'Admin') {
        header("Location: admin");
    } elseif ($_SESSION['role'] === 'Prestataire') {
        header("Location: DashboardPrestataire");
    } else {
        header("Location: home");
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Connexion</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />

	
	<!-- ==================BASE CSS STYLE ================== -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link href="public/templates/templateAdmin/assets/css/default/app.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="public/css/login.css">
	<!-- ================== END BASE CSS STYLE ================== -->
</head>
<body class="pace-top">
	<!-- ================== Section Loader ================== -->
	<div id="page-loader" class="fade show">
		<span class="spinner"></span>
	</div>
	
	
	
	<div id="page-container" class="fade">
	<!-- ================== Section Form ================== -->
	<?php require_once("view/sections/login/form.php") ?>
		
		
	<!-- ================== Section config ================== -->
	<?php require_once("view/sections/login/config.php") ?>
		
	<!-- ================== Section scroll to top ================== -->
	<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
	
	</div>
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="public/templates/templateAdmin/assets/js/app.min.js"></script>
	<script src="public/templates/templateAdmin/assets/js/theme/default.min.js"></script>
	<script src="public/js/login.js"></script>
	<script src="public/js/Validator.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


	<!-- ================== Message d'erreur ================== -->
	<?php if(isset($_GET['error']) && $_GET['error'] == 1 && isset($_GET['message']) && isset($_GET['title'])) : ?>
		<script>
			Swal.fire({
				icon: 'error',
				title:'<?php echo htmlspecialchars($_GET['title'], ENT_QUOTES, 'UTF-8'); ?>',
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
</body>
</html>