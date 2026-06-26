<?php 
session_start();
require_once("../../model/UserRepository.php");

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
            $prenom = trim($_POST['prenom']);
            $nom = trim($_POST['nom']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $phone = trim($_POST['phone']);
            $adresse = trim($_POST['adresse']);
            $ninea = trim($_POST['ninea'] ?? '');
            
            $role = (isset($_POST['role']) && !empty($_POST['role'])) ? $_POST['role'] : 'etudiant';

            if($this->userRepository->findByEmail($email)){
                $this->setErrorAndRedirect("Cet email est déjà utilisé.", "Erreur", "inscription.php");
            }

            $resId = $this->userRepository->register($nom, $prenom, $email, $password, $phone, "default.png", $adresse, $role, $ninea, 1);

            if($resId){
                $_SESSION["id"] = $resId;
                $_SESSION["email"] = $email;
                $_SESSION["nom"] = $nom;
                $_SESSION["prenom"] = $prenom;
                $_SESSION["role"] = $role; 
                
                // Redirection selon le rôle après inscription
                $url = ($role === 'admin') ? "admin" : "home";

                header("Location: $url?succes=1&message=" . urlencode("Compte créé avec succès !") . "&title=" . urlencode("Succès"));
                exit;
            } else {
                $this->setErrorAndRedirect("Erreur lors de l'inscription.", "Erreur", "inscription.php");
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

public function updateUser() {
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
            header("Location: ListeUtilisateur?succes=1&message=Utilisateur mis à jour&title=Succès");
            exit;
        }
    }
}

public function deleteUser($id) {
    if($this->userRepository->deactivate($id)){
        header("Location: ListeUtilisateur?succes=1&message=Utilisateur supprimé&title=Suppression");
        exit;
    }
}
}