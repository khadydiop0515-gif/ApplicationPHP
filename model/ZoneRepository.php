<?php
require_once("DBRepository.php");

class ZoneRepository extends DBRepository
{
    // Récupérer toutes les zones
    public function getAll()
    {
        $sql = "SELECT * FROM zone ORDER BY nom_quartier ASC";
        try {
            return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur getAll Zone : " . $e->getMessage());
            return [];
        }
    }

    // Récupérer une zone par son ID
    public function getById(int $id)
    {
        $sql = "SELECT * FROM zone WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            error_log("Erreur getById Zone : " . $e->getMessage());
            return null;
        }
    }

    // Ajouter une zone
    public function add(string $nom_quartier)
    {
        $sql = "INSERT INTO zone (nom_quartier, created_at) VALUES (:nom, NOW())";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['nom' => $nom_quartier]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Erreur add Zone : " . $e->getMessage());
            throw $e;
        }
    }

    // Modifier une zone
    public function update(int $id, string $nom_quartier)
    {
        $sql = "UPDATE zone SET nom_quartier = :nom, updated_at = NOW() WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['nom' => $nom_quartier, 'id' => $id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Erreur update Zone : " . $e->getMessage());
            throw $e;
        }
    }

    // Supprimer une zone
    public function delete(int $id)
    {
        $sql = "DELETE FROM zone WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Erreur delete Zone : " . $e->getMessage());
            throw $e;
        }
    }
}