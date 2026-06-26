<div class="right-content">
    <div class="login-header">
        <div class="brand">
            <span class="logo"></span> <b>Inscription</b>
            <small>Créez votre compte Gorgoorlu</small>
        </div>
        <div class="icon"><i class="fa fa-user-plus"></i></div>
    </div>

    <div class="login-content">
        <form action="userMainController" method="POST" enctype="multipart/form-data" class="margin-bottom-0" id="registerForm">
            
            <div class="row row-space-10">
                <!--prenom-->
                <div class="col-md-6">
                    <div class="form-group m-b-15">
                        <label class="control-label">Prénom <span class="text-danger">*</span></label>
                        <!-- Ajout id="prenom" -->
                        <input type="text" name="prenom" id="prenom" class="form-control form-control-lg" placeholder="Votre prénom" required />
                        <p class="text-danger small"></p> 
                    </div>
                </div>
                <!--nom-->
                <div class="col-md-6">
                    <div class="form-group m-b-15">
                        <label class="control-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" name="nom" id="nom" class="form-control form-control-lg" placeholder="Votre nom" required />
                        <p class="text-danger small"></p> 
                    </div>
                </div>
            </div>

            <!-- Email -->
            <div class="form-group m-b-15">
                <label class="control-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="exemple@mail.com" required />
                <p class="text-danger small"></p> 
            </div>

            <!-- Téléphone -->
            <div class="form-group m-b-15">
                <label class="control-label">Téléphone <span class="text-danger">*</span></label>
                <input type="text" name="phone" id="phone" class="form-control form-control-lg" placeholder="77 000 00 00" required />
                <p class="text-danger small"></p> 
            </div>

            <div class="row row-space-10">
                <!-- Role -->
                <div class="col-md-6">
                    <div class="form-group m-b-15">
                        <label class="control-label">Rôle <span class="text-danger">*</span></label>
                        <select name="role" id="role" class="form-control form-control-lg" required>
                            <option value="" selected disabled>Choisir votre rôle</option>
                            <option value="etudiant">Étudiant</option>
                            <option value="prestataire">Prestataire</option>
                        </select>
                        <p class="text-danger small"></p> 
                    </div>
                </div>
                <!-- NINEA -->
                <div class="col-md-6">
                    <div class="form-group m-b-15">
                        <label class="control-label">NINEA (Optionnel)</label>
                        <input type="text" name="ninea" id="ninea" class="form-control form-control-lg" placeholder="Numéro NINEA" />
                        <p class="text-danger small"></p> 
                    </div>
                </div>
            </div>

            <!-- Adresse -->
            <div class="form-group m-b-15">
                <label class="control-label">Adresse <span class="text-danger">*</span></label>
                <input type="text" name="adresse" id="adresse" class="form-control form-control-lg" placeholder="Votre adresse complète" required />
                <p class="text-danger small"></p> 
            </div>

            <!-- Mot de passe -->
            <div class="form-group m-b-15">
                <label class="control-label">Mot de passe <span class="text-danger">*</span></label>
                <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="********" required />
                <p class="text-danger small"></p> 
            </div>

            <!-- Photo -->
            <div class="form-group m-b-15">
                <label class="control-label">Photo de profil</label>
                <input type="file" name="photo" id="photo" class="form-control" accept="image/*" />
                <p class="text-danger small"></p> 
            </div>

            <div class="login-buttons m-t-30">
                <button type="submit" name="frmRegister" id="btnRegister" class="btn btn-success btn-block btn-lg">Créer mon compte</button>
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