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

    public function getAvisByAnnonce(int $annonceId) {
    $sql = "SELECT av.*, CONCAT(u.prenom, ' ', u.nom) as auteur_nom, u.photo as auteur_photo 
            FROM avis av
            JOIN users u ON av.user_id = u.id
            WHERE av.annonce_id = :id AND av.etat = 1
            ORDER BY av.created_at DESC";
    try {
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $annonceId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    } catch (PDOException $e) {
        return [];
    }
}
/**
 * Récupérer tous les avis se trouvant dans la corbeille (etat = 0)
 */
public function getTrashWithDetails() {
    // On sélectionne les avis où etat = 0
    // On fait des jointures pour savoir qui a écrit l'avis et sur quelle annonce
    $sql = "SELECT av.*, 
                   CONCAT(u.prenom, ' ', u.nom) as auteur_nom, 
                   an.titre as annonce_titre 
            FROM avis av
            LEFT JOIN users u ON av.user_id = u.id
            LEFT JOIN annonce an ON av.annonce_id = an.id
            WHERE av.etat = 0
            ORDER BY av.deleted_at DESC";

    try {
        $query = $this->db->query($sql);
        if (!$query) {
            return [];
        }
        return $query->fetchAll(PDO::FETCH_ASSOC) ?: [];
    } catch (PDOException $e) {
        error_log("Erreur SQL getTrash Avis : " . $e->getMessage());
        return [];
    }
}
public function getGlobalRating(int $id) {
    $sql = "SELECT AVG(CAST(note AS DECIMAL(10,2))) 
            FROM avis av 
            JOIN annonce a ON av.annonce_id = a.id 
            WHERE a.created_by = :id AND av.etat = 1";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['id' => $id]);
    $moyenne = $stmt->fetchColumn();
    return $moyenne ? round(($moyenne / 5) * 100) : 0; // Retourne un pourcentage
}
public function getGlobalStats() {
    $sql = "SELECT COUNT(*) as total, AVG(CAST(note AS DECIMAL(10,2))) as moyenne FROM avis WHERE etat = 1";
    return $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
}
}