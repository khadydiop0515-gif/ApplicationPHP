<?php 
session_start();
require_once("../../model/UserRepository.php");
require_once("../../controller/MailService.php");
require_once("../../controller/UploadService.php");
class UserController
{        
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function setErrorAndRedirect($message, $title, $redirectUrl = "login")
    {
        $_SESSION["error"] = $message;
        header("Location: $redirectUrl?error=1&message=" . urlencode($message) . "&title=" . urlencode($title));
        exit;
    }

public function auth() {
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['frmLogin'])){
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        // 1. Cas Admin Statique
        if ($email === "admin@gmail.com" && $password === "passer123"){
            $_SESSION["id"] = 1; 
            $_SESSION["nom"] = "Mbaye";
            $_SESSION["prenom"] = "Andalla";
            $_SESSION["email"] = "admin@gmail.com";
            $_SESSION["role"] = "Admin";
            $_SESSION["photo"] = "default.png";
            $_SESSION["phone"] = "77 631 92 00"; 
            $_SESSION["adresse"] = "Dakar, Sénégal";
            
            header("Location: admin?succes=1&message=Bienvenue");
            exit;
        }

        // 2. Cas Base de données
        $user = $this->userRepository->login($email, $password);
        if($user){
            // ON STOCK TOUT DANS LA SESSION ICI
            $_SESSION["id"] = $user['id']; 
            $_SESSION["nom"] = $user['nom'];
            $_SESSION["prenom"] = $user['prenom'];
            $_SESSION["role"] = $user['role'];
            $_SESSION["email"] = $user['email'];      // AJOUTÉ
            $_SESSION["phone"] = $user['phone'];      // AJOUTÉ
            $_SESSION["adresse"] = $user['adresse'];  // AJOUTÉ
            $_SESSION["photo"] = $user['photo'];      // AJOUTÉ
            $_SESSION["ninea"] = $user['ninea'];      // AJOUTÉ
            $_SESSION["created_at"] = $user['created_at']; // AJOUTÉ POUR LA DATE

            $url = ($user['role'] === 'Admin') ? "admin" : (($user['role'] === 'Prestataire') ? "DashboardPrestataire" : "home");
            header("Location: $url?succes=1&message=".urlencode("Heureux de vous revoir"));
            exit;
        } else {
            $this->setErrorAndRedirect("Identifiants incorrects", "Erreur de connexion", "login");
        }
    }
}
    

    public function register() {
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['frmRegister'])){
        $prenom = trim($_POST['prenom'] ?? '');
        $nom = trim($_POST['nom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $phone = trim($_POST['telephone'] ?? ''); 
        $adresse = trim($_POST['adresse'] ?? '');
        $ninea = trim($_POST['ninea'] ?? '');
        
        $role = (isset($_POST['role']) && !empty($_POST['role'])) ? $_POST['role'] : 'Etudiant';

        if($this->userRepository->findByEmail($email)){
            $this->setErrorAndRedirect("Cet email est déjà utilisé.", "Erreur", "inscription");
        }

        $resId = $this->userRepository->register($nom, $prenom, $email, $password, $phone, "default.png", $adresse, $role, $ninea, 1);

        if($resId){
            $_SESSION["id"] = $resId;
            $_SESSION["email"] = $email;
            $_SESSION["nom"] = $nom;
            $_SESSION["prenom"] = $prenom;
            $_SESSION["role"] = $role; 
            
            // --- LOGIQUE DE REDIRECTION APRÈS INSCRIPTION ---
            if ($role === 'Admin') {
                $url = "admin";
            } elseif ($role === 'Prestataire') {
                $url = "DashboardPrestataire";
            } else {
                $url = "home";
            }

            header("Location: $url?succes=1&message=" . urlencode("Compte créé avec succès !") . "&title=" . urlencode("Bienvenue"));
            exit;
        } else {
            $this->setErrorAndRedirect("Une erreur est survenue en base de données.", "Erreur", "inscription");
        }
    }
}

    public function logout() {
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        header("Location: login"); 
        exit;
    }

    
public function listUsers() {
    return $this->userRepository->getAll();
}

public function deleteUser($id, $motif) {
    $user = $this->userRepository->getById($id);
    
    if($user && $this->userRepository->deactivate($id, $motif)){
        // Envoi du mail
        $sujet = "Suspension de votre compte Goorgoorlou";
        $corps = "Bonjour " . htmlspecialchars($user['prenom']) . ",<br><br>
                  Nous vous informons que votre compte a été suspendu par l'administration.<br>
                  <b>Motif de la décision :</b><br>
                  <blockquote style='color: #555;'>$motif</blockquote>
                  Si vous pensez qu'il s'agit d'une erreur, veuillez nous contacter.";
        
        MailService::sendNotification($user['email'], $sujet, $corps);

        $redirect = ($user['role'] === 'Etudiant') ? "ListeEtudiant" : "ListePrestataire";
        header("Location: $redirect?succes=1&message=Utilisateur notifié et suspendu&title=Suppression");
        exit;
    }
}

public function restoreUser($id) {
    $user = $this->userRepository->getById($id);
    if($user && $this->userRepository->activate($id)){
        $redirect = ($user['role'] === 'Etudiant') ? "CorbeilleEtudiant" : "CorbeillePrestataire";
        header("Location: $redirect?succes=1&message=Compte restauré&title=Succès");
        exit;
    }
}

public function permanentDelete($id) {
    $user = $this->userRepository->getById($id);
    if($user && $this->userRepository->deletePermanently($id)){
        $redirect = ($user['role'] === 'Etudiant') ? "CorbeilleEtudiant" : "CorbeillePrestataire";
        header("Location: $redirect?succes=1&message=Compte supprimé définitivement&title=Supprimé");
        exit;
    }
}

    public function listEtudiants() {
        return $this->userRepository->getByRole('Etudiant');
    }

    public function listPrestataires() {
        return $this->userRepository->getByRole('Prestataire');
    }

    // Modifier updateUser pour gérer la redirection dynamique
    public function updateUser() 
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id = $_POST['id'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $adresse = $_POST['adresse'];
            $role = $_POST['role'];
            $ninea = $_POST['ninea'];

            if($this->userRepository->update($id, $nom, $prenom, $email, $phone, $adresse, $role, $ninea)){
                // Redirection intelligente selon le rôle modifié
                $redirect = ($role === 'Etudiant') ? "ListeEtudiant" : "ListePrestataire";
                header("Location: $redirect?succes=1&message=Utilisateur mis à jour&title=Succès");
                exit;
            }
        }
    }



public function updateProfilePhoto() {
    if(isset($_FILES['photo_file']) && $_FILES['photo_file']['error'] == 0) {
        $userId = $_SESSION['id'];
        
        $result = UploadService::uploadUserPhoto($_FILES['photo_file'], $userId);
        
        if(isset($result['success'])) {
            $photoName = $result['success'];
            if($this->userRepository->updatePhoto($userId, $photoName)) {
                // On met à jour la session pour que l'image change partout tout de suite
                $_SESSION['photo'] = $photoName;
                
                // Redirection selon le rôle
                $url = ($_SESSION['role'] === 'Admin') ? "admin" : "DashboardPrestataire";
                header("Location: $url?succes=1&message=Photo mise à jour !");
                exit;
            }
        } else {
            $this->setErrorAndRedirect($result['error'], "Erreur Upload", "MonProfil");
        }
    }
}
public function updatePersonalInfo() {
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id = $_SESSION['id'];
        $phone = trim($_POST['phone']);
        $adresse = trim($_POST['adresse']);

        if($this->userRepository->updateContactInfo($id, $phone, $adresse)){
            // On met à jour la session pour l'affichage immédiat
            $_SESSION['phone'] = $phone;
            $_SESSION['adresse'] = $adresse;
            header("Location: MonProfil?succes=1&message=Informations mises à jour !");
            exit;
        }
    }
}


public function sendContactMessage() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = trim($_POST['contact_name']);
        $email = trim($_POST['contact_email']);
        $message = trim($_POST['contact_message']);

        if (empty($name) || empty($email) || empty($message)) {
            header("Location: home?error=1&message=Tous les champs sont requis&title=Erreur");
            exit;
        }

        // Préparation du mail pour l'administrateur
        $sujet = "Nouveau message de contact : " . $name;
        $corps = "Vous avez reçu un message depuis le formulaire de contact Gorgoorlu :<br><br>
                  <b>Nom :</b> $name<br>
                  <b>Email :</b> $email<br><br>
                  <b>Message :</b><br>
                  <blockquote style='background:#f9f9f9; padding:15px;'>".nl2br(htmlspecialchars($message))."</blockquote>";

        // Envoi à l'adresse de l'admin (ta boîte Mailtrap)
        $sent = MailService::sendNotification("admin@gorgoorlu.sn", $sujet, $corps);

        if ($sent) {
            header("Location: home?succes=1&message=Votre message a été envoyé avec succès !&title=Merci");
        } else {
            header("Location: home?error=1&message=Erreur lors de l'envoi du message&title=Erreur");
        }
        exit;
    }
}

// --- 1. MISE À JOUR DES INFORMATIONS ---
    public function updateFullProfile() {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id = $_SESSION['id'];
            $nom = trim($_POST['nom']);
            $prenom = trim($_POST['prenom']);
            $phone = trim($_POST['phone']);
            $adresse = trim($_POST['adresse']);
            $ninea = isset($_POST['ninea']) ? trim($_POST['ninea']) : null;

            if($this->userRepository->updateFullProfile($id, $nom, $prenom, $phone, $adresse, $ninea)){
                // ON MET À JOUR LA SESSION POUR L'AFFICHAGE IMMÉDIAT
                $_SESSION['nom'] = $nom;
                $_SESSION['prenom'] = $prenom;
                $_SESSION['phone'] = $phone;
                $_SESSION['adresse'] = $adresse;
                if($ninea) $_SESSION['ninea'] = $ninea;

                header("Location: MonProfil?succes=1&message=" . urlencode("Vos informations ont été mises à jour !"));
                exit;
            } else {
                $this->setErrorAndRedirect("Erreur lors de la mise à jour.", "Erreur", "MonProfil");
            }
        }
    }

    // --- 2. CHANGEMENT DU MOT DE PASSE ---
    public function changePassword() {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id = $_SESSION['id'];
            $newPass = $_POST['new_password'];
            $confirmPass = $_POST['confirm_password'];

            // Validation simple
            if(strlen($newPass) < 8) {
                $this->setErrorAndRedirect("Le mot de passe doit faire au moins 8 caractères.", "Sécurité", "MonProfil");
            }

            if($newPass !== $confirmPass) {
                $this->setErrorAndRedirect("Les deux mots de passe ne correspondent pas.", "Erreur", "MonProfil");
            }

            // Appel au repository (qui doit hasher le mot de passe)
            if($this->userRepository->updatePassword($id, $newPass)){
                header("Location: MonProfil?succes=1&message=" . urlencode("Votre mot de passe a été modifié."));
                exit;
            } else {
                $this->setErrorAndRedirect("Échec de la modification.", "Erreur", "MonProfil");
            }
        }
    }
}