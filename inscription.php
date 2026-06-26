<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Gorgoorlu | Inscription</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    
    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="public/templates/templateAdmin/assets/css/default/app.min.css" rel="stylesheet" />
    <!-- ================== END BASE CSS STYLE ================== -->
</head>
<body class="pace-top">
    <div id="page-loader" class="fade show"><span class="spinner"></span></div>
    
    <div id="page-container" class="fade">
        <div class="login login-with-news-feed">
            <!-- ================== section news-feed ================== -->
             <?php require_once("view/sections/sign_in/news.php") ?>
            

            <!-- ==================Formulaire================== -->
             <?php require_once("view/sections/sign_in/form.php") ?>
            
        </div>
    </div>

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="public/templates/templateAdmin/assets/js/app.min.js"></script>
    <script src="public/templates/templateAdmin/assets/js/theme/default.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="public/js/inscription.js"></script>
	<script src="public/js/Validator.js"></script>
    <!-- ================== END BASE JS ================== -->
</body>
</html>