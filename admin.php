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
</body>
</html>