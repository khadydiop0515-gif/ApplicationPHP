<div id="contact" class="content bg-silver-lighter" data-scrollview="true">
    <div class="container">
        <h2 class="content-title">Prêt à rejoindre Gorgoorlu ?</h2>
        <p class="content-desc">
            Contactez-nous pour toute question ou information complémentaire.<br />
            Nous valorisons le sérieux et la confiance au Sénégal.
        </p>
        <div class="row">
            <div class="col-lg-6" data-animation="true" data-animation-type="fadeInLeft">
                <h3>Vous avez une question ? Parlons-en.</h3>
                <p>Gorgoorlu vous aide à trouver rapidement les bonnes opportunités.</p>
                <p>
                    <strong>Gorgoorlu Sénégal</strong><br />
                    Support : +221 77 000 00 00<br />
                    <a href="mailto:contact@gorgoorlu.sn" class="text-primary">contact@gorgoorlu.sn</a>
                </p>
            </div>
            
            <div class="col-lg-6 form-col" data-animation="true" data-animation-type="fadeInRight">
                <!-- FORMULAIRE POINTANT VERS LE CONTROLLER -->
                <form class="form-horizontal" action="userMainController" method="POST">
                    <div class="form-group row m-b-15">
                        <label class="col-form-label col-lg-3 text-lg-right">Nom <span class="text-primary">*</span></label>
                        <div class="col-lg-9">
                            <input type="text" name="contact_name" class="form-control" 
                                   value="<?= $_SESSION['prenom'] ?? '' ?> <?= $_SESSION['nom'] ?? '' ?>" required />
                        </div>
                    </div>
                    <div class="form-group row m-b-15">
                        <label class="col-form-label col-lg-3 text-lg-right">Email <span class="text-primary">*</span></label>
                        <div class="col-lg-9">
                            <input type="email" name="contact_email" class="form-control" 
                                   value="<?= $_SESSION['email'] ?? '' ?>" required />
                        </div>
                    </div>
                    <div class="form-group row m-b-15">
                        <label class="col-form-label col-lg-3 text-lg-right">Message <span class="text-primary">*</span></label>
                        <div class="col-lg-9">
                            <textarea name="contact_message" class="form-control" rows="8" required placeholder="Votre message..."></textarea>
                        </div>
                    </div>
                    <div class="form-group row m-b-15">
                        <label class="col-form-label col-lg-3 text-lg-right"></label>
                        <div class="col-lg-9 text-left">
                            <button type="submit" name="frmContact" class="btn btn-theme btn-primary btn-block">Envoyer le message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>