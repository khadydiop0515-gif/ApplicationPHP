<?php
require_once("DBRepository.php");

class ZoneRepository extends DBRepository
{
    // Récupérer uniquement les zones actives
    public function getAll()
    {
        $sql = "SELECT * FROM zone WHERE etat = 1 ORDER BY nom_quartier ASC";
        try {
            return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur getAll Zone : " . $e->getMessage());
            return [];
        }
    }

    // Récupérer les zones dans la corbeille
    public function getTrash()
    {
        $sql = "SELECT * FROM zone WHERE etat = 0 ORDER BY nom_quartier ASC";
        try {
            return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function add(string $nom_quartier)
    {
        // On force l'état à 1 à l'ajout
        $sql = "INSERT INTO zone (nom_quartier, etat, created_at) VALUES (:nom, 1, NOW())";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['nom' => $nom_quartier]);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    // Envoyer en corbeille (Soft Delete)
    public function desactivate(int $id)
    {
        $sql = "UPDATE zone SET etat = 0, updated_at = NOW() WHERE id = :id";
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
        $sql = "UPDATE zone SET etat = 1, updated_at = NOW() WHERE id = :id";
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
        $sql = "DELETE FROM zone WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function update(int $id, string $nom_quartier)
    {
        $sql = "UPDATE zone SET nom_quartier = :nom, updated_at = NOW() WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['nom' => $nom_quartier, 'id' => $id]);
        } catch (PDOException $e) {
            throw $e;
        }
    }
}