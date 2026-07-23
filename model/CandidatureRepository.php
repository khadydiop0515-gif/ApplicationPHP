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

    /**
 * Vérifie si l'utilisateur a déjà postulé à cette annonce (et que la candidature est active)
 */
public function hasAlreadyApplied($userId, $annonceId) {
    $sql = "SELECT COUNT(*) FROM candidature WHERE user_id = :user AND annonce_id = :annonce AND etat = 1";
    try {
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user' => $userId, 'annonce' => $annonceId]);
        return $stmt->fetchColumn() > 0;
    } catch (PDOException $e) {
        return false;
    }
}


public function getCandidaturesForPrestataire(int $prestataireId) {
    $sql = "SELECT c.*, u.prenom as cand_prenom, u.nom as cand_nom, u.email as cand_email, u.phone as cand_phone, a.titre as annonce_titre
            FROM candidature c
            JOIN users u ON c.user_id = u.id
            JOIN annonce a ON c.annonce_id = a.id
            WHERE a.created_by = :pres_id AND c.etat = 1
            ORDER BY c.date_postulation DESC";
    
    try {
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['pres_id' => $prestataireId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    } catch (PDOException $e) {
        return [];
    }
}



/**
 * Accepter une candidature (statut -> Acceptée)
 */
public function accept($id) {
    $sql = "UPDATE candidature SET statut = 'Acceptée', updated_at = NOW() WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute(['id' => $id]);
}

/**
 * Refuser une candidature (statut -> Refusée, etat -> 0)
 */
public function reject($id, $motif) {
    $sql = "UPDATE candidature SET statut = 'Refusée', etat = 0, motif_suppression = :motif, deleted_at = NOW() WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute(['id' => $id, 'motif' => $motif]);
}

public function countPendingCandidatures(int $id) {
    // On compte les candidatures 'En attente' liées aux annonces de ce prestataire
    $sql = "SELECT COUNT(c.id) 
            FROM candidature c 
            JOIN annonce a ON c.annonce_id = a.id 
            WHERE a.created_by = :id AND c.statut = 'En attente' AND c.etat = 1";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetchColumn();
}
/**
 * Récupère toutes les candidatures d'un étudiant spécifique
 */
public function getCandidaturesByUser(int $userId) {
    $sql = "SELECT c.*, a.titre as annonce_titre, cat.nom as categorie_nom, z.nom_quartier
            FROM candidature c
            JOIN annonce a ON c.annonce_id = a.id
            LEFT JOIN categorie cat ON a.categorie_id = cat.id
            LEFT JOIN zone z ON a.zone_id = z.id
            WHERE c.user_id = :user_id AND c.etat = 1
            ORDER BY c.date_postulation DESC";
    try {
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    } catch (PDOException $e) {
        return [];
    }
}
public function countAll() {
    return $this->db->query("SELECT COUNT(*) FROM candidature WHERE etat = 1")->fetchColumn();
}
/**
 * Récupère les statistiques des 7 derniers jours
 */
public function getStatsLast7Days() {
    $sql = "SELECT DATE(created_at) as date, COUNT(*) as total 
            FROM candidature 
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
            GROUP BY DATE(created_at) 
            ORDER BY date ASC";
    return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}




}