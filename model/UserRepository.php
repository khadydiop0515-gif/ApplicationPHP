<?php 
require_once("DBRepository.php");

class UserRepository extends DBRepository
{
    public function __construct() {
        parent::__construct(); 
    }

    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        try {
            $statement = $this->db->prepare($sql);
            $statement->execute(['email' => $email]);
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function register($nom, $prenom, $email, $password, $phone, $photo, $adresse, $role, $ninea, $createdBy) {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (nom, prenom, email, password, phone, photo, adresse, role, ninea, etat, created_at, created_by) 
                    VALUES (:nom, :prenom, :email, :password, :phone, :photo, :adresse, :role, :ninea, 1, NOW(), :created_by)";

            $statement = $this->db->prepare($sql);
            $statement->execute([
                'nom'        => $nom,
                'prenom'     => $prenom, 
                'email'      => $email,
                'password'   => $hashedPassword, 
                'phone'      => $phone,
                'photo'      => $photo,
                'adresse'    => $adresse,
                'role'       => $role,
                'ninea'      => $ninea,
                'created_by' => $createdBy
            ]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Erreur lors de l'inscription : " . $e->getMessage());
            return false;
        }
    }

    public function login($email, $password)
    {
        $sql = "SELECT * FROM users WHERE email = :email AND etat = 1";
        try {
            $statement = $this->db->prepare($sql);
            $statement->execute(['email' => $email]);
            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if($user && password_verify($password, $user['password'])){
                return $user;
            } 
            return false;
        } catch (PDOException $error) {
            error_log("Erreur lors de la récupération : " . $error->getMessage());
            return false;
        }
    }

     // Récupérer tous les utilisateurs actifs
    public function getAll() {
        $sql = "SELECT * FROM users WHERE etat = 1 ORDER BY created_at DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un utilisateur par son ID
    public function getById($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mise à jour complète par l'admin
    public function update($id, $nom, $prenom, $email, $phone, $adresse, $role, $ninea) {
        $sql = "UPDATE users SET nom=:nom, prenom=:prenom, email=:email, phone=:phone, 
                adresse=:adresse, role=:role, ninea=:ninea, updated_at=NOW() 
                WHERE id=:id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'nom' => $nom, 'prenom' => $prenom, 'email' => $email,
            'phone' => $phone, 'adresse' => $adresse, 'role' => $role,
            'ninea' => $ninea, 'id' => $id
        ]);
    }

    // Désactivation (Soft Delete via la colonne etat)
    public function deactivate($id) {
        $sql = "UPDATE users SET etat = 0 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}