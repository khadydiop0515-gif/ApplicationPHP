<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="home">Accueil</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Administration</a></li>
        <li class="breadcrumb-item active">Tableau de bord</li>
    </ol>
    <!-- end breadcrumb -->
    
    <h1 class="page-header mb-3">Tableau de bord Goorgoorlu</h1>

    <!-- PREMIÈRE LIGNE : BIENVENUE ET RÉCAPITULATIF -->
    <div class="row">
        <!-- Message de bienvenue -->
        <div class="col-xl-8">
            <div class="card border-0 mb-3 overflow-hidden bg-primary text-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="mb-3 text-white-transparent-6"><b>BIENVENUE, <?= htmlspecialchars($_SESSION['prenom']) ?> !</b></div>
                            <h2 class="mb-2">Mettez en relation étudiants et prestataires</h2>
                            <p class="mb-4 text-white-transparent-7">Vous pilotez actuellement la plateforme. Gérez les opportunités et assurez le suivi des candidatures en un clic.</p>
                            <a href="ListeAnnonce" class="btn btn-light btn-sm fw-bold">Gérer les offres</a>
                            <a href="ListeCandidature" class="btn btn-outline-light btn-sm ml-2 fw-bold">Suivre les candidatures</a>
                        </div>
                        <div class="col-lg-4 text-center d-none d-lg-block">
                            <img src="public/templates/templateAdmin/assets/img/svg/img-1.svg" height="140" alt="Dashboard" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recap rapide -->
        <div class="col-xl-4">
            <div class="card border-0 mb-3">
                <div class="card-body">
                    <div class="mb-3 text-grey"><b>RÉCAPITULATIF GLOBAL</b></div>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center p-x-0">
                            <span><i class="fa fa-briefcase text-primary mr-2"></i> Annonces en ligne</span>
                            <span class="badge badge-primary"><?= $statsAnnonces ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center p-x-0">
                            <span><i class="fa fa-handshake text-success mr-2"></i> Dossiers candidatures</span>
                            <span class="badge badge-success"><?= $statsCandidatures ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center p-x-0">
                            <span><i class="fa fa-graduation-cap text-info mr-2"></i> Étudiants inscrits</span>
                            <span class="badge badge-info"><?= $statsEtudiants ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center p-x-0">
                            <span><i class="fa fa-building text-warning mr-2"></i> Prestataires</span>
                            <span class="badge badge-warning"><?= $statsPrestataires ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DEUXIÈME LIGNE : WIDGETS DE STATISTIQUES -->
    <div class="row">
        <!-- Widget Annonces -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 mb-3 bg-white text-inverse">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="mr-3"><i class="fa fa-bullhorn fa-2x text-primary"></i></div>
                        <div>
                            <h5 class="mb-0">Offres de travail</h5>
                            <small class="text-muted">Total des annonces actives</small>
                        </div>
                    </div>
                    <h2 class="mb-0"><?= $statsAnnonces ?></h2>
                    <div class="mt-3 progress progress-xs">
                        <div class="progress-bar bg-primary" style="width: 70%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Widget Candidatures -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 mb-3 bg-white text-inverse">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="mr-3"><i class="fa fa-file-signature fa-2x text-success"></i></div>
                        <div>
                            <h5 class="mb-0">Candidatures</h5>
                            <small class="text-muted">Interactions plateforme</small>
                        </div>
                    </div>
                    <h2 class="mb-0"><?= $statsCandidatures ?></h2>
                    <div class="mt-3 progress progress-xs">
                        <div class="progress-bar bg-success" style="width: 50%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Widget Avis -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 mb-3 bg-white text-inverse">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="mr-3"><i class="fa fa-star fa-2x text-warning"></i></div>
                        <div>
                            <h5 class="mb-0">Satisfaction</h5>
                            <small class="text-muted">Note moyenne globale</small>
                        </div>
                    </div>
                    <h2 class="mb-0"><?= $moyenneAvis ?> <small class="f-s-14">/ 5</small></h2>
                    <p class="text-muted mb-0 small">Basé sur <?= $totalAvis ?> avis vérifiés</p>
                </div>
            </div>
        </div>
    </div>

    <!-- TROISIÈME LIGNE : ACTIONS ET INFOS -->
    <div class="row">
        <!-- Colonne Actions Rapides -->
        <div class="col-xl-5">
            <div class="card border-0 mb-3">
                <div class="card-body">
                    <h5 class="mb-3">Pilotage rapide</h5>
                    <div class="row">
                        <div class="col-6">
                            <a href="ListeAnnonce" class="btn btn-primary btn-block mb-3 p-10">
                                <i class="fa fa-briefcase d-block mb-1 fa-lg"></i> Annonces
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="ListeCandidature" class="btn btn-success btn-block mb-3 p-10">
                                <i class="fa fa-handshake d-block mb-1 fa-lg"></i> Candidats
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="ListeEtudiant" class="btn btn-info btn-block p-10">
                                <i class="fa fa-users d-block mb-1 fa-lg"></i> Étudiants
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="ListePrestataire" class="btn btn-warning btn-block p-10">
                                <i class="fa fa-industry d-block mb-1 fa-lg"></i> Prestataires
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

		<div class="row">
			<div class="col-xl-12">
				<div class="card border-0 mb-3 bg-inverse text-white">
					<div class="card-body">
						<h5 class="mb-3">Activité des candidatures (7 derniers jours)</h5>
						<!-- ID pour le graphique -->
						<div id="apex-candidatures-chart" style="min-height: 250px;"></div>
					</div>
				</div>
			</div>
		</div>

        <!-- Colonne Info Système -->
        <div class="col-xl-7">
            <div class="card border-0 mb-3">
                <div class="card-body">
                    <h5 class="mb-3">Dernière mise à jour système</h5>
                    <div class="alert alert-secondary mb-0">
                        <i class="fa fa-info-circle mr-2"></i> La base de données est synchronisée. Toutes les données affichées correspondent aux activités en temps réel sur <strong>Goorgoorlu</strong>.
                    </div>
                    <hr>
                    <div class="d-flex align-items-center">
                        <div class="width-40 height-40 rounded-circle bg-silver-darker d-flex align-items-center justify-content-center text-white mr-3">
                            <i class="fa fa-clock"></i>
                        </div>
                        <div>
                            <div class="f-w-600">Session active</div>
                            <div class="small text-muted">Démarrée le <?= date('d/m/Y à H:i') ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>