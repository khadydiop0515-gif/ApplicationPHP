<div class="right-content">
                <div class="login-header">
                    <div class="brand">
                        <span class="logo"></span> <b>Inscription</b>
                        <small>Créez votre compte Gorgoorlu</small>
                    </div>
                    <div class="icon"><i class="fa fa-user-plus"></i></div>
                </div>

                <div class="login-content">
                    
                    <form action="userMainController" method="POST" enctype="multipart/form-data" class="margin-bottom-0">
                        
                        <div class="row row-space-10">
                            <div class="col-md-6">
                                <div class="form-group m-b-15">
                                    <label class="control-label">Prénom <span class="text-danger">*</span></label>
                                    <input type="text" name="prenom" class="form-control form-control-lg" placeholder="Votre prénom" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group m-b-15">
                                    <label class="control-label">Nom <span class="text-danger">*</span></label>
                                    <input type="text" name="nom" class="form-control form-control-lg" placeholder="Votre nom" required />
                                </div>
                            </div>
                        </div>

<!-- Champ Email (inchangé) -->
<div class="form-group m-b-15">
    <label class="control-label">Email <span class="text-danger">*</span></label>
    <input type="email" name="email" class="form-control form-control-lg" placeholder="exemple@mail.com" required />
</div>

<!-- Champ Téléphone (sur toute la largeur pour l'équilibre) -->
<div class="form-group m-b-15">
    <label class="control-label">Téléphone <span class="text-danger">*</span></label>
    <input type="text" name="phone" class="form-control form-control-lg" placeholder="77 000 00 00" required />
</div>

<!-- LIGNE ROLE ET NINEA -->
<div class="row row-space-10">
    <div class="col-md-6">
        <div class="form-group m-b-15">
            <label class="control-label">Rôle <span class="text-danger">*</span></label>
            <select name="role" class="form-control form-control-lg" required>
                <option value="" selected disabled>Choisir votre rôle</option>
                <option value="etudiant">Étudiant</option>
                <option value="prestataire">Prestataire</option>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group m-b-15">
            <label class="control-label">NINEA (Optionnel)</label>
            <input type="text" name="ninea" class="form-control form-control-lg" placeholder="Numéro NINEA" />
        </div>
    </div>
</div>

<!-- Champ Adresse (inchangé) -->
<div class="form-group m-b-15">
    <label class="control-label">Adresse <span class="text-danger">*</span></label>
    <input type="text" name="adresse" class="form-control form-control-lg" placeholder="Votre adresse complète" required />
</div>



                        <div class="form-group m-b-15">
                            <label class="control-label">Mot de passe <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control form-control-lg" placeholder="********" required />
                        </div>

                        <div class="form-group m-b-15">
                            <label class="control-label">Photo de profil</label>
                            <input type="file" name="photo" class="form-control" accept="image/*" />
                        </div>

                        
                       

                        <div class="login-buttons m-t-30">
                            <button type="submit" name="frmRegister" class="btn btn-success btn-block btn-lg">Créer mon compte</button>
                        </div>

                        <div class="m-t-20 text-center text-inverse">
                            Déjà inscrit ? <a href="login.php" class="text-success">Se connecter</a>
                        </div>
                        
                        <hr />
                        <p class="text-center text-grey-darker mb-0">
                            &copy; Gorgoorlu All Right Reserved 2026
                        </p>
                    </form>
                </div>
            </div>