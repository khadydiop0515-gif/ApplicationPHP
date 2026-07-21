<?php
require_once("DBRepository.php");

class CandidatureRepository extends DBRepository {

    public function getAllWithDetails() {
        // On filtre par etat = 1 (Liste active)
        $sql = "SELECT c.*, u.prenom, u.nom, a.titre as annonce_titre 
                FROM candidature c
                LEFT JOIN users u ON c.user_id = u.id
                LEFT JOIN annonce a ON c.annonce_id = a.id
                WHERE c.etat = 1
                ORDER BY c.date_postulation DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTrashWithDetails() {
        // On filtre par etat = 0 (Corbeille)
        $sql = "SELECT c.*, u.prenom, u.nom, a.titre as annonce_titre 
                FROM candidature c
                LEFT JOIN users u ON c.user_id = u.id
                LEFT JOIN annonce a ON c.annonce_id = a.id
                WHERE c.etat = 0
                ORDER BY c.deleted_at DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($message, $user_id, $annonce_id) {
        // On insère avec etat = 1 par défaut
        $sql = "INSERT INTO candidature (message_motivation, date_postulation, user_id, annonce_id, etat, created_at) 
                VALUES (:msg, NOW(), :user, :annonce, 1, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'msg' => $message,
            'user' => $user_id,
            'annonce' => $annonce_id
        ]);
    }

    // Soft Delete (Corbeille)
    public function desactivate($id, $motif) {
    $sql = "UPDATE candidature SET etat = 0, motif_suppression = :motif, deleted_at = NOW() WHERE id = :id";
    try {
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'motif' => $motif
        ]);
    } catch (PDOException $e) {
        return false;
    }
}

// Optionnel : ajouter une méthode pour récupérer les infos du candidat plus facilement
public function getCandidatureDetails($id) {
    $sql = "SELECT c.*, u.email, u.prenom, a.titre as annonce_titre 
            FROM candidature c 
            JOIN users u ON c.user_id = u.id 
            JOIN annonce a ON c.annonce_id = a.id 
            WHERE c.id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    // Restaurer
    public function activate($id) {
        $sql = "UPDATE candidature SET etat = 1, deleted_at = NULL WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    // Suppression réelle
    public function delete($id) {
        $sql = "DELETE FROM candidature WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function update($id, $message, $annonce_id) {
        $sql = "UPDATE candidature SET message_motivation = :msg, annonce_id = :annonce, updated_at = NOW() 
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'msg' => $message,
            'annonce' => $annonce_id,
            'id' => $id
        ]);
    }
}