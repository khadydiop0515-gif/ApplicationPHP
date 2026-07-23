<div id="pricing" class="content" data-scrollview="true">
    <div class="container">
        <h2 class="content-title">Comment ça marche</h2>
        <p class="content-desc">
            Un parcours simple pour les étudiants comme pour les employeurs.<br />
            Gorgoorlu favorise la confiance, la clarté et la proximité locale.
        </p>
        
        <ul class="pricing-table pricing-col-4">
            <!-- CARTE ETUDIANT -->
            <li data-animation="true" data-animation-type="fadeInUp">
                <div class="pricing-container">
                    <h3>Étudiant</h3>
                    <div class="price"><div class="price-figure"><span class="price-number">Gratuit</span></div></div>
                    <ul class="features">
                        <li>Créer un profil</li>
                        <li>Consulter les offres</li>
                        <li>Postuler en ligne</li>
                        <li>Suivre ses candidatures</li>
                        <li>Accès à des missions locales</li>
                        <li>Support simple et réactif</li>
                    </ul>
                    <div class="footer">
                        <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'Etudiant'): ?>
                            <a href="MesPostulations" class="btn btn-inverse btn-theme btn-block">Voir mon suivi</a>
                        <?php else: ?>
                            <a href="login" class="btn btn-inverse btn-theme btn-block">Créer mon profil</a>
                        <?php endif; ?>
                    </div>
                </div>
            </li>

            <!-- CARTE EMPLOYEUR -->
            <li data-animation="true" data-animation-type="fadeInUp">
                <div class="pricing-container">
                    <h3>Employeur</h3>
                    <div class="price">
                        <div class="price-figure">
                            <span class="price-number">Simple</span>
                            <span class="price-tenure">et rapide</span>
                        </div>
                    </div>
                    <ul class="features">
                        <li>Publier une offre</li>
                        <li>Choisir des profils adaptés</li>
                        <li>Recevoir des candidatures</li>
                        <li>Gérer les contacts facilement</li>
                        <li>Développer votre réseau local</li>
                        <li>Accès à des catégories variées</li>
                    </ul>
                    <div class="footer">
                        <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'Prestataire'): ?>
                            <a href="NouvelleAnnonce" class="btn btn-inverse btn-theme btn-block">Publier maintenant</a>
                        <?php else: ?>
                            <a href="login" class="btn btn-inverse btn-theme btn-block">Poster une offre</a>
                        <?php endif; ?>
                    </div>
                </div>
            </li>

            <!-- CARTE SECURITE -->
            <li class="highlight" data-animation="true" data-animation-type="fadeInUp">
                <div class="pricing-container">
                    <h3>Sécurité</h3>
                    <div class="price">
                        <div class="price-figure">
                            <span class="price-number">Priorité</span>
                            <span class="price-tenure">et sérieux</span>
                        </div>
                    </div>
                    <ul class="features">
                        <li>Respect des engagements</li>
                        <li>Profil vérifié et clair</li>
                        <li>Communication plus fiable</li>
                        <li>Qualité des candidatures</li>
                        <li>Un esprit de proximité</li>
                        <li>Accompagnement professionnel</li>
                    </ul>
                    <div class="footer">
                        <a href="#about" data-click="scroll-to-target" class="btn btn-primary btn-theme btn-block">En savoir plus</a>
                    </div>
                </div>
            </li>

            <!-- CARTE RESULTATS -->
            <li data-animation="true" data-animation-type="fadeInUp">
                <div class="pricing-container">
                    <h3>Résultats</h3>
                    <div class="price"><div class="price-figure"><span class="price-number">Mesurables</span></div></div>
                    <ul class="features">
                        <li>Plus de visibilité</li>
                        <li>Des candidatures ciblées</li>
                        <li>Des missions adaptées</li>
                        <li>Une croissance locale</li>
                        <li>Un réseau professionnel utile</li>
                        <li>Un parcours de confiance</li>
                    </ul>
                    <div class="footer">
                        <a href="#offres" data-click="scroll-to-target" class="btn btn-inverse btn-theme btn-block">Voir les annonces</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>