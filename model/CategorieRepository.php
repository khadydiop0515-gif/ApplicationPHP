<?php
require_once("DBRepository.php");

class CategorieRepository extends DBRepository
{
    // Récupérer uniquement les catégories actives
    public function getAll()
    {
        $sql = "SELECT * FROM categorie WHERE etat = 1 ORDER BY nom ASC";
        try {
            return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur getAll Categorie : " . $e->getMessage());
            return [];
        }
    }

    // Récupérer les catégories dans la corbeille
    public function getTrash()
    {
        $sql = "SELECT * FROM categorie WHERE etat = 0 ORDER BY nom ASC";
        try {
            return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function add(string $nom)
    {
        // On force l'état à 1 à l'ajout
        $sql = "INSERT INTO categorie (nom, etat, created_at) VALUES (:nom, 1, NOW())";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['nom' => $nom]);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    // Envoyer en corbeille (Soft Delete)
    public function desactivate(int $id)
    {
        $sql = "UPDATE categorie SET etat = 0 WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    // Restaurer
    public function activate(int $id)
    {
        $sql = "UPDATE categorie SET etat = 1 WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    // Suppression définitive
    public function delete(int $id)
    {
        $sql = "DELETE FROM categorie WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function update(int $id, string $nom)
    {
        $sql = "UPDATE categorie SET nom = :nom, updated_at = NOW() WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['nom' => $nom, 'id' => $id]);
        } catch (PDOException $e) {
            throw $e;
        }
    }
}