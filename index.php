<!DOCTYPE html>
<html lang="en">
	
<head>
	<meta charset="utf-8" />
	<title>Index Vitrine</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />

	
	<!-- ================== BASE CSS STYLE ================== -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link href="public/templates/templateVitrine/assets/css/one-page-parallax/app.min.css" rel="stylesheet" />
</head>

	<!-- ================= BODY ================== -->
<body data-spy="scroll" data-target="#header" data-offset="51">
	<!-- begin #page-container -->
	<div id="page-container" class="fade">

		<!-- ================== SECTION MENU ================== -->
		<?php require_once("view/sections/vitrine/menu.php"); ?>
		
		<!-- ================== SECTION BANNIERE ================== -->
		<?php require_once("view/sections/vitrine/banniere.php"); ?>
		
		
		<!-- ================== SECTION A PROPOS ================== -->
		<?php require_once("view/sections/vitrine/about.php"); ?>
		
		
		<!-- ================== SECTION CHIFFRAGE ================== -->
		<?php require_once("view/sections/vitrine/chiffrage.php"); ?>
		
		<!-- ================== SECTION EQUIPE ================== -->
		<?php require_once("view/sections/vitrine/team.php"); ?>
		
		
		<!-- ================== SECTION INFO ================== -->
		<?php require_once("view/sections/vitrine/info.php"); ?>
		
		
		<!-- ================== SECTION SERVICES ================== -->
		<?php require_once("view/sections/vitrine/services.php"); ?>
		
		
		<!-- ================== SECTION ACTION ================== -->
		<?php require_once("view/sections/vitrine/action.php"); ?>
		
		
		<!-- ================== SECTION Réalisation ================== -->
		<?php require_once("view/sections/vitrine/realisation.php"); ?>
		
		
		<!-- ================== SECTION CLIENTS ================== -->
		<?php require_once("view/sections/vitrine/clients.php"); ?>
		
		
		<!-- ================== SECTION PRICING ================== -->
		<?php require_once("view/sections/vitrine/pricing.php"); ?>
		
		<!-- ================== SECTION CONTACT ================== -->
		<?php require_once("view/sections/vitrine/contact.php"); ?>

		
		<!-- ================== SECTION FOOTER ================== -->
		<?php require_once("view/sections/vitrine/footer.php"); ?>
		
		<!-- ================== SECTION CONFIG COLOR ================== -->
		<?php require_once("view/sections/vitrine/config.php"); ?>
		
	</div>
	
	<!-- ================== BASE JS ================== -->
	<script src="public/templates/templateVitrine/assets/js/one-page-parallax/app.min.js"></script>
</body>
</html>
