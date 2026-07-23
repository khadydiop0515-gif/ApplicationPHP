<?php
require_once("DBRepository.php");

class AnnonceRepository extends DBRepository
{
    // Récupérer une annonce par son ID
    public function getAnnonceById(int $id)
    {
        $sql = "SELECT * FROM annonce WHERE id = :id";
        try {
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $error) {
            error_log("Erreur getAnnonceById : " . $error->getMessage());
            throw $error;
        }
    }

    // Ajouter une annonce (etat = 1 par défaut)
    public function addAnnonce($titre, $description, $salaire, $categorie_id, $zone_id, $created_by) 
    {
        $sql = "INSERT INTO annonce (titre, description, salaire, statut, etat, created_at, created_by, categorie_id, zone_id)
                VALUES (:titre, :description, :salaire, 'Ouvert', 1, NOW(), :user, :cat, :zone)";

        try {
            $statement = $this->db->prepare($sql);
            $statement->execute([
                'titre'       => $titre,
                'description' => $description, 
                'salaire'     => (int)$salaire, 
                'user'        => $created_by,
                'cat'         => $categorie_id,
                'zone'        => $zone_id
            ]);
            return $this->db->lastInsertId();
        } catch (PDOException $error) {
            error_log("Erreur addAnnonce : " . $error->getMessage());
            throw $error;
        }
    }

    // Modifier une annonce
    public function updateAnnonceFull($id, $titre, $description, $salaire, $cat, $zone, $statut) {
        $sql = "UPDATE annonce SET 
                titre = :titre, 
                description = :desc, 
                salaire = :sal, 
                categorie_id = :cat, 
                zone_id = :zone, 
                statut = :statut,
                updated_at = NOW() 
                WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'titre' => $titre,
                'desc'  => $description,
                'sal'   => $salaire,
                'cat'   => $cat,
                'zone'  => $zone,
                'statut'=> $statut,
                'id'    => $id
            ]);
        } catch (PDOException $error) {
            error_log("Erreur updateAnnonceFull : " . $error->getMessage());
            return false;
        }
    }

    // Corbeille : Envoyer vers la corbeille (etat = 0)
    public function desactivate(int $id, string $motif)
    {
        // On met à jour l'état ET le motif
        $sql = "UPDATE annonce SET etat = 0, motif_suppression = :motif, deleted_at = NOW() WHERE id = :id";

        try {
            $statement = $this->db->prepare($sql);
            return $statement->execute([
                'id' => $id,
                'motif' => $motif
            ]);
        } catch (PDOException $error) {
            error_log("Erreur desactivate : " . $error->getMessage());
            throw $error;
        }
    }

    // Restaurer : Remettre en ligne (etat = 1)
    public function activate(int $id)
    {
        $sql = "UPDATE annonce SET etat = 1, deleted_at = NULL WHERE id = :id";
        try {
            $statement = $this->db->prepare($sql);
            $statement->execute(['id' => $id]);
            return $statement->rowCount() > 0;
        } catch (PDOException $error) {
            error_log("Erreur activate : " . $error->getMessage());
            throw $error;
        }
    }
    
    // Supprimer définitivement de la DB
    public function delete(int $id)
    {
        $sql = "DELETE FROM annonce WHERE id = :id";
        try {
            $statement = $this->db->prepare($sql);
            $statement->execute(['id' => $id]);
            return $statement->rowCount() > 0;
        } catch (PDOException $error) {
            error_log("Erreur delete : " . $error->getMessage());
            throw $error;
        }
    }

    // Liste principale (uniquement etat = 1)
    public function getAllAnnoncesWithDetails() 
    {
        $sql = "SELECT a.*, c.nom as categorie_nom, z.nom_quartier,
                (SELECT AVG(CAST(note AS DECIMAL(10,2))) FROM avis v WHERE v.annonce_id = a.id AND v.etat = 1) as note_moyenne,
                (SELECT COUNT(id) FROM avis v WHERE v.annonce_id = a.id AND v.etat = 1) as total_avis
                FROM annonce a
                LEFT JOIN categorie c ON a.categorie_id = c.id
                LEFT JOIN zone z ON a.zone_id = z.id
                WHERE a.etat = 1 
                ORDER BY a.created_at DESC";

        try {
            return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            error_log("Erreur getAllAnnoncesWithDetails : " . $error->getMessage());
            return [];
        }
    }

    // Liste corbeille (uniquement etat = 0)
    public function getTrashAnnoncesWithDetails() 
    {
        $sql = "SELECT a.*, c.nom as categorie_nom, z.nom_quartier
                FROM annonce a
                LEFT JOIN categorie c ON a.categorie_id = c.id
                LEFT JOIN zone z ON a.zone_id = z.id
                WHERE a.etat = 0
                ORDER BY a.deleted_at DESC";

        try {
            return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            error_log("Erreur getTrashAnnoncesWithDetails : " . $error->getMessage());
            return [];
        }
    }
    public function getPublicAnnonces(int $limit = 100, ?int $catId = null, ?int $zoneId = null) 
{
    $sql = "SELECT a.*, c.nom as categorie_nom, z.nom_quartier
            FROM annonce a
            LEFT JOIN categorie c ON a.categorie_id = c.id
            LEFT JOIN zone z ON a.zone_id = z.id
            WHERE a.etat = 1 AND a.statut = 'Ouvert'";

    // On ajoute dynamiquement les filtres s'ils sont présents
    if ($catId)  { $sql .= " AND a.categorie_id = :catId"; }
    if ($zoneId) { $sql .= " AND a.zone_id = :zoneId"; }

    $sql .= " ORDER BY a.created_at DESC LIMIT :limit";

    
    try {
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        
        // On ne bind que si la valeur n'est pas null
        if ($catId !== null)  { $statement->bindValue(':catId', $catId, PDO::PARAM_INT); }
        if ($zoneId !== null) { $statement->bindValue(':zoneId', $zoneId, PDO::PARAM_INT); }
        
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $error) {
        error_log("Erreur dans getPublicAnnonces : " . $error->getMessage()); // Très utile pour débugger
        return [];
    }
}

    // Dans AnnonceRepository.php

public function getAnnonceFullDetails(int $id)
{
    $sql = "SELECT a.*, c.nom as categorie_nom, z.nom_quartier,
            (SELECT AVG(CAST(note AS DECIMAL(10,2))) FROM avis v WHERE v.annonce_id = a.id AND v.etat = 1) as note_moyenne
            FROM annonce a
            LEFT JOIN categorie c ON a.categorie_id = c.id
            LEFT JOIN zone z ON a.zone_id = z.id
            WHERE a.id = :id AND a.etat = 1";

    try {
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC) ?: null;
    } catch (PDOException $error) {
        error_log("Erreur getAnnonceFullDetails : " . $error->getMessage());
        return null;
    }
}

// Dans model/AnnonceRepository.php

/**
 * Récupère les annonces actives d'un prestataire spécifique
 */
public function getAnnoncesByPrestataire(int $prestataireId) 
{
    $sql = "SELECT a.*, c.nom as categorie_nom, z.nom_quartier,
            (SELECT COUNT(id) FROM candidature WHERE annonce_id = a.id AND etat = 1) as nb_candidats
            FROM annonce a
            LEFT JOIN categorie c ON a.categorie_id = c.id
            LEFT JOIN zone z ON a.zone_id = z.id
            WHERE a.created_by = :user_id AND a.etat = 1
            ORDER BY a.created_at DESC";

    try {
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $prestataireId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * Récupère les annonces en corbeille d'un prestataire spécifique
 */
public function getTrashByPrestataire(int $prestataireId) 
{
    $sql = "SELECT a.* FROM annonce a WHERE a.created_by = :user_id AND a.etat = 0";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['user_id' => $prestataireId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function countAnnoncesByPrestataire(int $id) {
    $sql = "SELECT COUNT(*) FROM annonce WHERE created_by = :id AND etat = 1";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetchColumn();
}
public function countAllActive() {
    return $this->db->query("SELECT COUNT(*) FROM annonce WHERE etat = 1")->fetchColumn();
}

}