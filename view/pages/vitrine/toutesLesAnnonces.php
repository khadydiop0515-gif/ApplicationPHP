<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once("../../../model/AnnonceRepository.php");
require_once("../../../model/CategorieRepository.php");
require_once("../../../model/ZoneRepository.php");

$annonceRepo = new AnnonceRepository();
$catRepo = new CategorieRepository();
$zoneRepo = new ZoneRepository();

// 1. Récupération des filtres depuis l'URL (méthode GET)
$selectedCat = isset($_GET['cat']) && !empty($_GET['cat']) ? intval($_GET['cat']) : null;
$selectedZone = isset($_GET['zone']) && !empty($_GET['zone']) ? intval($_GET['zone']) : null;

// 2. Récupération des données filtrées
$annonces = $annonceRepo->getPublicAnnonces(100, $selectedCat, $selectedZone);

// 3. Données pour remplir les menus déroulants
$categories = $catRepo->getAll();
$zones = $zoneRepo->getAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Rechercher une mission - Gorgoorlu</title>
    <link href="public/templates/templateVitrine/assets/css/one-page-parallax/app.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        #header { background: #2d353c !important; } /* Fix menu */
        .search-bar { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 5px 25px rgba(0,0,0,0.1); margin-top: -50px; position: relative; z-index: 10; }
    </style>
</head>

<body style="background: #f4f7f6;">
    <?php require_once("../../sections/vitrine/menu.php"); ?>

    <!-- Header de page -->
    <div style="background: #2d353c; padding: 100px 0 80px; text-align: center; color: #fff;">
        <div class="container">
            <h1 class="f-s-36 f-w-700">Toutes nos opportunités</h1>
            <p class="f-s-18 op-7">Trouvez la mission qui vous correspond partout au Sénégal</p>
        </div>
    </div>

    <div class="container">
        <!-- BARRE DE RECHERCHE -->
        <div class="search-bar m-b-40">
            <form action="ToutesLesOffres" method="GET" class="row align-items-end">
                <div class="col-md-4">
                    <label class="f-w-700 m-b-10">Catégorie</label>
                    <select name="cat" class="form-control">
                        <option value="">Toutes les catégories</option>
                        <?php foreach($categories as $c): ?>
                            <option value="<?= $c['id'] ?>" <?= ($selectedCat == $c['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($c['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="f-w-700 m-b-10">Zone / Ville</label>
                    <select name="zone" class="form-control">
                        <option value="">Toutes les zones</option>
                        <?php foreach($zones as $z): ?>
                            <option value="<?= $z['id'] ?>" <?= ($selectedZone == $z['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($z['nom_quartier']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-theme btn-block btn-lg f-w-700">
                        <i class="fa fa-search m-r-10"></i> RECHERCHER
                    </button>
                </div>
                <?php if($selectedCat || $selectedZone): ?>
                    <div class="col-12 m-t-15 text-center">
                        <a href="ToutesLesOffres" class="text-danger small f-w-600"><i class="fa fa-times"></i> Réinitialiser les filtres</a>
                    </div>
                <?php endif; ?>
            </form>
        </div>

        <!-- LISTE DES RÉSULTATS -->
        <div class="row">
            <?php if (!empty($annonces)): ?>
                <?php foreach ($annonces as $annonce): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div style="background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); height: 100%; border-top: 3px solid #00acac;">
                            <span class="badge badge-primary m-b-10"><?= htmlspecialchars($annonce['categorie_nom']) ?></span>
                            <h4 class="f-w-700 m-t-0" style="height: 50px; overflow: hidden;"><?= htmlspecialchars($annonce['titre']) ?></h4>
                            
                            <div class="m-b-15">
                                <small class="text-muted"><i class="fa fa-map-marker-alt text-danger"></i> <?= htmlspecialchars($annonce['nom_quartier']) ?></small>
                                <span class="pull-right text-success f-w-700"><?= number_format($annonce['salaire'], 0, ',', ' ') ?> F</span>
                            </div>

                            <p class="text-muted small" style="height: 60px; overflow: hidden;">
                                <?= htmlspecialchars(substr($annonce['description'], 0, 100)) ?>...
                            </p>

                            <a href="detailsAnnonce?id=<?= $annonce['id'] ?>" class="btn btn-block btn-outline-dark f-w-700">Voir les détails</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center p-50">
                    <i class="fa fa-search-minus fa-4x text-silver m-b-20"></i>
                    <h3 class="text-muted">Aucun résultat ne correspond à votre recherche.</h3>
                    <p>Essayez de modifier vos filtres ou <a href="ToutesLesOffres">affichez toutes les offres</a>.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php require_once("../../sections/vitrine/footer.php"); ?>
</body>
</html>