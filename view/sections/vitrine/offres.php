<div id="offres" class="content" data-scrollview="true">
    <div class="container">
        <h2 class="content-title">Dernières opportunités</h2>
        <p class="content-desc">Trouvez le job qui correspond à votre emploi du temps et à vos compétences.</p>
        
        <div class="row">
            <?php if (!empty($annonces)): ?>
                <?php foreach ($annonces as $annonce): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="service" style="background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); transition: all 0.3s;">
                            <div class="info" style="padding-left: 0;">
                                <span class="badge badge-primary mb-2"><?= htmlspecialchars($annonce['categorie_nom']) ?></span>
                                <h4 class="title" style="color: #2d353c;"><?= htmlspecialchars($annonce['titre']) ?></h4>
                                <p class="desc" style="height: 60px; overflow: hidden;">
                                    <?= htmlspecialchars(substr($annonce['description'], 0, 100)) ?>...
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-3" style="border-top: 1px solid #eee; pt-15">
                                    <small><i class="fa fa-map-marker-alt text-danger"></i> <?= htmlspecialchars($annonce['nom_quartier']) ?></small>
                                    <span class="text-success fw-bold"><?= number_format($annonce['salaire'], 0, ',', ' ') ?> FCFA</span>
                                </div>
                                <a href="detailsAnnonce?id=<?= $annonce['id'] ?>" class="btn btn-block btn-outline-dark mt-3 fw-bold">
                                    Voir les détails
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center"><p>Aucune offre disponible pour le moment.</p></div>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-4">
            <a href="ToutesLesOffres" class="btn btn-lg btn-theme">Toutes les annonces <i class="fa fa-arrow-right"></i></a>
        </div>
    </div>
</div>