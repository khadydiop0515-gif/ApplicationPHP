<?php
require_once("DBRepository.php");

class AvisRepository extends DBRepository {

        public function getAllWithDetails() {
            $sql = "SELECT av.*, CONCAT(u.prenom, ' ', u.nom) as auteur_nom, an.titre as annonce_titre 
                    FROM avis av
                    LEFT JOIN users u ON av.user_id = u.id
                    LEFT JOIN annonce an ON av.annonce_id = an.id
                    WHERE av.deleted_at IS NULL
                    ORDER BY av.created_at DESC";

        try {
            return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur SQL Avis : " . $e->getMessage());
            return [];
        }
    }

    public function add($note, $commentaire, $user_id, $annonce_id) {
        $sql = "INSERT INTO avis (note, commentaire, user_id, annonce_id, created_at) 
                VALUES (:note, :comm, :user, :annonce, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'note' => $note,
            'comm' => $commentaire,
            'user' => $user_id,
            'annonce' => $annonce_id
        ]);
    }

    public function update($id, $note, $commentaire, $annonce_id) {
        $sql = "UPDATE avis SET note = :note, commentaire = :comm, annonce_id = :annonce, updated_at = NOW() 
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'note' => $note,
            'comm' => $commentaire,
            'annonce' => $annonce_id,
            'id' => $id
        ]);
    }

    public function desactivate($id) {
        $sql = "UPDATE avis SET deleted_at = NOW() WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}