<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// 1. Inclusions des modèles
require_once("../../../model/AnnonceRepository.php");
require_once("../../../model/AvisRepository.php");
require_once("../../../model/CandidatureRepository.php"); // AJOUTE CETTE LIGNE

// 2. Instanciation des objets
$annonceRepo = new AnnonceRepository();
$avisRepo = new AvisRepository();
$candRepo = new CandidatureRepository(); // AJOUTE CETTE LIGNE

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$annonce = $annonceRepo->getAnnonceFullDetails($id);

if (!$annonce) {
    header("Location: home");
    exit;
}

$note = round($annonce['note_moyenne'] ?? 0);
$listeAvis = $avisRepo->getAvisByAnnonce($id);

// 3. Vérification de la postulation
$dejaPostule = false;
if (isset($_SESSION['id'])) {
    // CORRECTION ICI : Utilise $candRepo au lieu de $repo
    $dejaPostule = $candRepo->hasAlreadyApplied($_SESSION['id'], $id);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title><?= htmlspecialchars($annonce['titre']) ?> | Gorgoorlu</title>
    <link href="public/templates/templateVitrine/assets/css/one-page-parallax/app.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- CORRECTIF POUR LE MENU INVISIBLE -->
    <style>
        #header { background: #2d353c !important; } /* Force le fond du menu en gris foncé */
        #header .navbar-nav > li > a { color: #fff !important; } /* Force le texte en blanc */
        .content { padding-top: 100px; }
    </style>
</head>

<body style="background: #f4f7f6;">

    <?php require_once("../../sections/vitrine/menu.php"); ?>

    <div class="container" style="margin-top: 50px; margin-bottom: 60px;">
        <div class="row">
            <!-- Colonne principale : Description -->
            <div class="col-lg-8">
                <div class="p-40" style="background: #fff; border-radius: 12px; box-shadow: 0 5px 25px rgba(0,0,0,0.05);">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="badge badge-primary mb-2"><?= htmlspecialchars($annonce['categorie_nom']) ?></span>
                            <h1 class="f-s-32 f-w-700 m-t-0"><?= htmlspecialchars($annonce['titre']) ?></h1>
                        </div>
                        <div class="text-right">
                             <div class="text-warning f-s-18">
                                <?php for($i=1; $i<=5; $i++) echo ($i <= $note) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>'; ?>
                             </div>
                             <small class="text-muted">Avis des utilisateurs</small>
                        </div>
                    </div>
                    <hr class="m-y-25">
                    <h4 class="f-w-600 m-b-15"><i class="fa fa-align-left text-primary m-r-10"></i> Description de la mission</h4>
                    <p class="f-s-16 text-inverse" style="line-height: 1.8; white-space: pre-line;">
                        <?= htmlspecialchars($annonce['description']) ?>
                    </p>
                </div>

                <!-- SECTION AVIS -->
                <div class="m-t-40">
                    <div class="d-flex justify-content-between align-items-center m-b-20 border-bottom p-b-10">
                        <h4 class="f-w-600 m-0">
                            <i class="fa fa-comments text-primary m-r-10"></i> 
                            Avis & Témoignages (<?= count($listeAvis) ?>)
                        </h4>
                        <!-- LE BOUTON EST SORTI DE LA CONDITION VIDE -->
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Etudiant'): ?>
                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-avis">
                                <i class="fa fa-pen"></i> Laisser un avis
                            </button>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($listeAvis)): ?>
                        <?php foreach ($listeAvis as $avis): ?>
                            <div class="d-flex m-b-25 p-15" style="background: #fff; border-radius: 8px; border-left: 4px solid #348fe2; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                                <div class="m-r-15">
                                    <?php if(!empty($avis['auteur_photo'])): ?>
                                        <img src="public/images/users/<?= $avis['auteur_photo'] ?>" class="img-circle width-50 height-50" style="object-fit: cover;">
                                    <?php else: ?>
                                        <div class="width-50 height-50 img-circle bg-silver-darker text-white d-flex align-items-center justify-content-center">
                                            <i class="fa fa-user fa-lg"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div style="flex: 1;">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="m-t-0 m-b-5 f-w-700"><?= htmlspecialchars($avis['auteur_nom']) ?></h5>
                                        <span class="text-warning">
                                            <?php for($i=1; $i<=5; $i++) echo ($i <= $avis['note']) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>'; ?>
                                        </span>
                                    </div>
                                    <p class="m-b-5 text-inverse"><?= nl2br(htmlspecialchars($avis['commentaire'])) ?></p>
                                    <small class="text-muted"><i class="far fa-clock"></i> <?= date('d/m/Y', strtotime($avis['created_at'])) ?></small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center p-30 bg-white" style="border-radius: 8px; border: 1px dashed #ccc;">
                            <i class="fa fa-comment-slash fa-2x text-silver-darker m-b-10"></i>
                            <p class="m-b-0">Soyez le premier à donner votre avis sur cette mission !</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Sidebar : Infos & Action -->
            <div class="col-lg-4">
                <div class="p-25" style="background: #fff; border-radius: 12px; box-shadow: 0 5px 25px rgba(0,0,0,0.05); position: sticky; top: 100px;">
                    <h4 class="f-w-700 m-b-20 border-bottom p-b-10">Résumé de l'offre</h4>
                    <ul class="list-unstyled f-s-15">
                        <li class="m-b-15"><i class="fa fa-map-marker-alt text-danger width-30"></i> <strong>Lieu :</strong> <?= htmlspecialchars($annonce['nom_quartier']) ?></li>
                        <li class="m-b-15"><i class="fa fa-money-bill-wave text-success width-30"></i> <strong>Salaire :</strong> <?= number_format($annonce['salaire'], 0, ',', ' ') ?> FCFA</li>
                        <li class="m-b-15"><i class="fa fa-calendar-check text-info width-30"></i> <strong>Publié le :</strong> <?= date('d M Y', strtotime($annonce['created_at'])) ?></li>
                    </ul>
                    <div class="m-t-30">
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Etudiant'): ?>
                            
                            <?php if ($dejaPostule): ?>
                                <!-- Message si déjà postulé -->
                                <div class="alert alert-info text-center">
                                    <i class="fa fa-check-circle fa-2x d-block m-b-10"></i>
                                    <strong>Candidature envoyée</strong><br>
                                    Vous avez déjà postulé à cette offre.
                                </div>
                            <?php else: ?>
                                <!-- Bouton normal -->
                                <button class="btn btn-theme btn-block btn-lg f-w-700" data-toggle="collapse" data-target="#formCandidature">
                                    Postuler maintenant
                                </button>
                                <div id="formCandidature" class="collapse m-t-20">
                                    <form action="candidatureMainController" method="POST">
                                        <input type="hidden" name="annonce_id" value="<?= $annonce['id'] ?>">
                                        <input type="hidden" name="user_id" value="<?= $_SESSION['id'] ?>">
                                        <div class="form-group">
                                            <textarea name="message_motivation" class="form-control" rows="5" required placeholder="Votre motivation..."></textarea>
                                        </div>
                                        <button type="submit" name="frmAddCandidature" class="btn btn-primary btn-block">Envoyer candidature</button>
                                    </form>
                                </div>
                            <?php endif; ?>

                        <?php elseif (!isset($_SESSION['id'])): ?>
                            <a href="login" class="btn btn-dark btn-block btn-lg f-w-700">Connexion pour postuler</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <!-- MODAL AJOUT AVIS (Adapté pour la page de détails) -->
<div class="modal fade" id="modal-avis" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- On pointe vers le contrôleur d'avis -->
            <form action="avisMainController" method="post" id="addAvisForm">
                <div class="modal-header">
                    <h4 class="modal-title">Donner mon avis</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <!-- INFO : On affiche le titre de l'annonce en lecture seule -->
                    <div class="form-group">
                        <label class="f-w-700">Annonce concernée :</label>
                        <p class="form-control-static text-primary f-w-600">
                            <?= htmlspecialchars($annonce['titre']) ?>
                        </p>
                        <!-- CHAMP CACHÉ : On envoie l'ID de l'annonce automatiquement -->
                        <input type="hidden" name="annonce_id" value="<?= $annonce['id'] ?>">
                    </div>

                    <div class="form-group">
                        <label class="f-w-700">Votre note sur 5</label>
                        <select name="note" class="form-control">
                            <option value="5">5 - Excellent</option>
                            <option value="4">4 - Très bien</option>
                            <option value="3">3 - Moyen</option>
                            <option value="2">2 - Passable</option>
                            <option value="1">1 - Mauvais</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="f-w-700">Votre commentaire</label>
                        <textarea name="commentaire" id="commentaire" class="form-control" rows="4" placeholder="Racontez votre expérience sur cette mission..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white f-w-600" data-dismiss="modal">Annuler</button>
                    <!-- IMPORTANT : name="frmAddAvis" pour que le contrôleur reconnaisse l'action -->
                    <button type="submit" name="frmAddAvis" class="btn btn-primary f-w-600">Publier l'avis</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <?php require_once("../../sections/admin/config.php"); ?>
	<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fad+e" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
	<?php require_once("../../sections/admin/script.php"); ?>
</body>
</html>