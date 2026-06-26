<?php
require_once("DBRepository.php");

class CandidatureRepository extends DBRepository {

    public function getAllWithDetails() {
        $sql = "SELECT c.*, u.prenom, u.nom, a.titre as annonce_titre 
                FROM candidature c
                LEFT JOIN users u ON c.user_id = u.id
                LEFT JOIN annonce a ON c.annonce_id = a.id
                WHERE c.deleted_at IS NULL
                ORDER BY c.date_postulation DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($message, $user_id, $annonce_id) {
        $sql = "INSERT INTO candidature (message_motivation, date_postulation, user_id, annonce_id, created_at) 
                VALUES (:msg, NOW(), :user, :annonce, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'msg' => $message,
            'user' => $user_id,
            'annonce' => $annonce_id
        ]);
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

    public function desactivate($id) {
        $sql = "UPDATE candidature SET deleted_at = NOW() WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}