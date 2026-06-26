<?php
require_once("DBRepository.php");

class CategorieRepository extends DBRepository
{
    // Récupérer toutes les catégories
    public function getAll()
    {
        $sql = "SELECT * FROM categorie ORDER BY nom ASC";
        try {
            return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur getAll Categorie : " . $e->getMessage());
            return [];
        }
    }

    // Récupérer une catégorie par son ID
    public function getById(int $id)
    {
        $sql = "SELECT * FROM categorie WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            error_log("Erreur getById Categorie : " . $e->getMessage());
            return null;
        }
    }

    // Ajouter une nouvelle catégorie
    public function add(string $nom)
    {
        $sql = "INSERT INTO categorie (nom, created_at) VALUES (:nom, NOW())";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['nom' => $nom]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Erreur add Categorie : " . $e->getMessage());
            throw $e;
        }
    }

    // Modifier une catégorie
    public function update(int $id, string $nom)
    {
        $sql = "UPDATE categorie SET nom = :nom, updated_at = NOW() WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['nom' => $nom, 'id' => $id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Erreur update Categorie : " . $e->getMessage());
            throw $e;
        }
    }

    // Supprimer une catégorie
    public function delete(int $id)
    {
        $sql = "DELETE FROM categorie WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Erreur delete Categorie : " . $e->getMessage());
            throw $e;
        }
    }
}