<?php
    require_once("DBRepository.php");

class AnnonceRepository extends DBRepository
{
    //Recupérer la liste des annonces
    public function getAllAnnonces(string $statut) 
    {
        $sql = "SELECT * FROM annonce WHERE statut = :statut";

        try {
            $statement = $this->db->prepare($sql);
            $statement->execute(['statut' => $statut]);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result ?: null;
        } catch (PDOException $error) {
            $label = ($statut == 'Ouvert') ? "ouvertes" : (($statut == 'Pourvu') ? "pourvues" : "annulées");
            error_log("Erreur lors de la récupération des annonces $label : " . $error->getMessage());
            
            throw $error;
        }
    }

    // Récupérer une annonce par son ID
    public function getAnnonceById(int $id)
    {
        $sql = "SELECT * FROM annonce WHERE id = :id";

        try {
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC); 
            return $result ?: null;

        } catch (PDOException $error) {
            error_log("Erreur lors de la récupération de l'annonce d'id $id : " . $error->getMessage());
            throw $error;
        }
    }

    public function addAnnonce($titre, $description, $salaire, $categorie_id, $zone_id, $created_by) 
{
    
    $sql = "INSERT INTO annonce (titre, description, salaire, statut, created_at, created_by, categorie_id, zone_id)
            VALUES (:titre, :description, :salaire, 'Ouvert', NOW(), :user, :cat, :zone)";

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
        error_log("Erreur PDO : " . $error->getMessage());
        throw $error;
    }
}

    // Permet de modifier une  annonce
    public function updateAnnonce($id, string $titre, string $description, $salaire, string $statut) 
    {
        $sql = "UPDATE annonce
                SET titre = :titre,
                description = :description,
                salaire = :salaire,
                statut = :statut, 
                updated_at = NOW()
                WHERE id = :id"; 

        try {
            $statement = $this->db->prepare($sql);
            $statement->execute([
                'titre'       => $titre,
                'description' => $description, 
                'salaire'     => $salaire,
                'statut'      => $statut,
                'id'          => $id
            ]);
            return $statement->rowCount() >= 0; 
            
        } catch (PDOException $error) {
            $label = ($statut == 'Ouvert') ? "ouverte" : (($statut == 'Pourvu') ? "pourvue" : "annulée");
            error_log("Erreur lors de la modification de l'annonce $id (statut $label) : " . $error->getMessage());
            throw $error;
        }
    }

   // Permet de désactiver (annulé) une annonce
    public function desactivate(int $id)
    {
        $sql = "UPDATE annonce 
                SET statut = 'Annule', 
                    deleted_at = NOW() 
                WHERE id = :id";

        try {
            $statement = $this->db->prepare($sql);
            $statement->execute(['id' => $id]);
            $rowAffected = $statement->rowCount();
            return $rowAffected > 0;
        } catch (PDOException $error) {
            error_log("Erreur lors de l'annulation de l'annonce d'id $id : " . $error->getMessage());
            throw $error;
        }
    }

    // Permet de réactiver une annonce
    public function activate(int $id)
    {
        $sql = "UPDATE annonce 
            SET statut = 'Ouvert', 
                deleted_at = NULL 
            WHERE id = :id";

        try {
            $statement = $this->db->prepare($sql);
            $statement->execute(['id' => $id]);
            $rowAffected = $statement->rowCount();
            return $rowAffected > 0;
            } catch (PDOException $error) {
            error_log("Erreur lors de la réactivation de l'annonce d'id $id : " . $error->getMessage());
            throw $error;
        }
    }
    
    // supprimer
    public function delete(int $id)
    {
        $sql = "DELETE FROM annonce WHERE id = :id";

        try {
                $statement = $this->db->prepare($sql);
                $statement->execute(['id' => $id]);
                $rowAffected = $statement->rowCount();
                return $rowAffected > 0;
            } catch (PDOException $error) {
                error_log("Erreur lors de la suppression définitive de l'annonce d'id $id : " . $error->getMessage());
                throw $error;
            }
    }
    // Dans AnnonceRepository.php

    public function getAllAnnoncesWithDetails() 
    {
        // On fait une Joinnture pour avoir le nom de la catégorie et de la zone
        $sql = "SELECT a.*, c.nom as categorie_nom, z.nom_quartier 
                FROM annonce a
                LEFT JOIN categorie c ON a.categorie_id = c.id
                LEFT JOIN zone z ON a.zone_id = z.id
                WHERE a.deleted_at IS NULL 
                ORDER BY a.created_at DESC";

        try {
            return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            error_log("Erreur lors de la récupération des annonces : " . $error->getMessage());
            return [];
        }
    }

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
    }
}
?> 