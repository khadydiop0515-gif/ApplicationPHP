<?php 
session_start();
require_once("../../model/UserRepository.php");
require_once("../../controller/MailService.php");
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

            // Cas de l'admin super-admin 
            if ($email === "admin@gmail.com" && $password === "passer123"){
                $_SESSION["id"] = 1; 
                $_SESSION["nom"] = "Mbaye";
                $_SESSION["prenom"] = "Andalla";
                $_SESSION["role"] = "admin";
                
                //redirection
                $url = "admin"; 
                header("Location: $url?succes=1&message=".urlencode("Bienvenue Admin")."&title=".urlencode("Succès"));
                exit;
            }

            // Cas des utilisateurs de la base de données
            $user = $this->userRepository->login($email, $password);
            if($user){
                $_SESSION["id"] = $user['id']; 
                $_SESSION["nom"] = $user['nom'];
                $_SESSION["prenom"] = $user['prenom'];
                $_SESSION["role"] = $user['role'];
                
                // Redirection
                $url = ($user['role'] === 'admin') ? "admin" : "home";

                header("Location: $url?succes=1&message=".urlencode("Heureux de vous revoir")."&title=".urlencode("Connexion"));
                exit;
            } else {
                $this->setErrorAndRedirect("Identifiants incorrects", "Erreur de connexion", "login");
            }
        }
    }

    public function register() {
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['frmRegister'])){
        // 1. Récupération avec les bons noms de champs (POST)
        $prenom = trim($_POST['prenom'] ?? '');
        $nom = trim($_POST['nom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        
        // CORRECTION : Le name dans le HTML est 'telephone'
        $phone = trim($_POST['telephone'] ?? ''); 
        
        $adresse = trim($_POST['adresse'] ?? '');
        $ninea = trim($_POST['ninea'] ?? '');
        
        // CORRECTION : Matcher l'ENUM de la DB ('Etudiant')
        $role = (isset($_POST['role']) && !empty($_POST['role'])) ? $_POST['role'] : 'Etudiant';

        // 2. Vérification si l'email existe déjà
        if($this->userRepository->findByEmail($email)){
            $this->setErrorAndRedirect("Cet email est déjà utilisé.", "Erreur", "inscription");
        }

        // 3. Appel au repository
        // Note : On passe '1' pour created_by si c'est une auto-inscription (ID de l'admin système)
        $resId = $this->userRepository->register($nom, $prenom, $email, $password, $phone, "default.png", $adresse, $role, $ninea, 1);

        if($resId){
            // Initialisation de la session après succès
            $_SESSION["id"] = $resId;
            $_SESSION["email"] = $email;
            $_SESSION["nom"] = $nom;
            $_SESSION["prenom"] = $prenom;
            $_SESSION["role"] = $role; 
            
            $url = ($role === 'Admin') ? "admin" : "home";

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

// Dans controller/user/UserController.php

// Remplacer listUsers par ces deux méthodes
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
}