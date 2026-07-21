<?php
require_once("DBRepository.php");

class AvisRepository extends DBRepository {

    public function getAllWithDetails() {
        $sql = "SELECT av.*, CONCAT(u.prenom, ' ', u.nom) as auteur_nom, an.titre as annonce_titre 
                FROM avis av
                LEFT JOIN users u ON av.user_id = u.id
                LEFT JOIN annonce an ON av.annonce_id = an.id
                WHERE av.etat = 1
                ORDER BY av.created_at DESC";
        try {
            return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) { return []; }
    }

    // NOUVELLE MÉTHODE : Pour récupérer l'email de l'auteur d'un avis
    public function getAvisAuthorDetails($id) {
        $sql = "SELECT a.*, u.email, u.prenom FROM avis a JOIN users u ON a.user_id = u.id WHERE a.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add($note, $commentaire, $user_id, $annonce_id) {
        $sql = "INSERT INTO avis (note, commentaire, user_id, annonce_id, etat, created_at) 
                VALUES (:note, :comm, :user, :annonce, 1, NOW())";
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

    public function desactivate($id, $motif) {
        $sql = "UPDATE avis SET etat = 0, motif_suppression = :motif, deleted_at = NOW() WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id, 'motif' => $motif]);
    }

    public function activate($id) {
        $sql = "UPDATE avis SET etat = 1, deleted_at = NULL WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function delete($id) {
        $sql = "DELETE FROM avis WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}