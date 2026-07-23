<?php
// On définit les liens par défaut
$linkLeft = "login";
$textLeft = "Créer mon profil étudiant";
$linkRight = "login";
$textRight = "Publier une offre";

// Si l'utilisateur est connecté, on adapte la logique
if (isset($_SESSION['id'])) {
    if ($_SESSION['role'] === 'Etudiant') {
        $linkLeft = "#offres"; // Scroll vers les annonces
        $textLeft = "Voir les opportunités";
        $linkRight = "MesPostulations";
        $textRight = "Suivre mes candidatures";
    } elseif ($_SESSION['role'] === 'Prestataire') {
        $linkLeft = "MonProfil";
        $textLeft = "Gérer mon compte";
        $linkRight = "NouvelleAnnonce";
        $textRight = "Publier une nouvelle offre";
    } elseif ($_SESSION['role'] === 'Admin') {
        $linkLeft = "admin";
        $textLeft = "Panel Administration";
        $linkRight = "ListeAnnonce";
        $textRight = "Gérer les offres";
    }
}
?>

<div id="home" class="content has-bg home">
    <div class="content-bg" style="background-image: url(public/templates/templateVitrine/assets/img/bg/bg-home.jpg);" 
        data-paroller="true" data-paroller-factor="0.5">
    </div>
    <div class="container home-content">
        <h1>Gorgoorlu</h1>
        <h3>Le lieu de rencontre entre étudiants sénégalais et employeurs locaux</h3>
        <p>
            Trouvez un job à temps partiel, une mission ponctuelle ou un freelance en toute confiance.<br />
            Publiez une offre en quelques minutes et choisissez les profils qui correspondent à vos besoins.
        </p>
        
        <!-- Boutons dynamiques -->
        <a href="<?= $linkLeft ?>" class="btn btn-theme btn-primary" <?= ($linkLeft == "#offres") ? 'data-click="scroll-to-target"' : '' ?>>
            <?= $textLeft ?>
        </a>
        <a href="<?= $linkRight ?>" class="btn btn-theme btn-outline-white">
            <?= $textRight ?>
        </a>
        <br /><br />
        <span class="text-white-transparent-8">Des opportunités dès aujourd’hui à Dakar, Thiès, Saint-Louis et partout au Sénégal.</span>
    </div>
</div>