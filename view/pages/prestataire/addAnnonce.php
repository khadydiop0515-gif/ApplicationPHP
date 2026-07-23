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

require_once("../../../model/CategorieRepository.php");
require_once("../../../model/ZoneRepository.php");
$categories = (new CategorieRepository())->getAll();
$zones = (new ZoneRepository())->getAll();
?>
<!DOCTYPE html>
<html lang="fr">
<?php require_once("../../sections/admin/head.php"); ?>
<body>
    <div id="page-loader" class="fade show"><span class="spinner"></span></div>

    <div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
        
        <?php require_once("../../sections/prestataire/menuHaut.php"); ?>
        <?php require_once("../../sections/prestataire/menuGauche.php"); ?>

        <div id="content" class="content">
            <h1 class="page-header">Publier une nouvelle mission</h1>

            <div class="panel panel-inverse">
                <div class="panel-heading"><h4 class="panel-title">Détails de l'offre</h4></div>
                <div class="panel-body">
                    <form action="annonceMainController" method="POST" id="addAnnonceFrom">
                        <div class="form-group">
                            <label class="f-w-700">Titre de la mission</label>
                            <input type="text" name="titre" id="titre" class="form-control" placeholder="Ex: Cuisinière pour événement" required>
                            <p class="error-message mt-2"></p>
                        </div>
                        <div class="form-group">
                            <label class="f-w-700">Description complète</label>
                            <textarea name="description" id="description" class="form-control" rows="6" placeholder="Décrivez les tâches, les horaires..." required></textarea>
                            <p class="error-message mt-2"></p>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label class="f-w-700">Salaire proposé (FCFA)</label>
                                <input type="number" name="salaire" id="salaire" class="form-control" required>
                                <p class="error-message mt-2"></p>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="f-w-700">Catégorie</label>
                                <select name="categorie_id" id="categorie_id" class="form-control" required>
                                    <option value="">Choisir...</option>
                                    <?php foreach($categories as $c): ?>
                                        <option value="<?= $c['id'] ?>"><?= $c['nom'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="f-w-700">Zone / Quartier</label>
                                <select name="zone_id" id="zone_id" class="form-control" required>
                                    <option value="">Choisir...</option>
                                    <?php foreach($zones as $z): ?>
                                        <option value="<?= $z['id'] ?>"><?= $z['nom_quartier'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="text-right">
                            <button type="submit" name="frmAddAnnonce" class="btn btn-primary btn-lg f-w-700">Diffuser l'annonce</button>
                            <a href="MesAnnonces" class="btn btn-white btn-lg m-l-10">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <?php require_once("../../sections/admin/script.php"); ?>
    <script src="../../../public/js/validator.js"></script>
    <script src="../../../public/js/annonce.js"></script>
</body>
</html>