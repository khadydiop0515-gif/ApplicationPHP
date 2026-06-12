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
            $result = $statement->execute();
            return $result ?: null;
        } catch (PDOException $error) {
            error_log("Erreur lors de la récupération de l'annonce d'id $id : " . $error->getMessage());
            throw $error;
        }
    }

    // Permet d'ajouter une nouvelle annonce
    public function addAnnonce(string $titre, string $description, $salaire, string $statut) 
    {
        $sql = "INSERT INTO annonce (titre, description, salaire, statut, created_at)
                VALUES (:titre, :description, :salaire, :statut, NOW())";

        try {
            $statement = $this->db->prepare($sql);
            $statement->execute([
                'titre'       => $titre,
                'description' => $description, 
                'salaire'     => $salaire,
                'statut'      => $statut
            ]);
            $lastInsertId() = $this->db->lastInsertId();
            return $lastInsertId ?: null;
            
        } catch (PDOException $error) {
            error_log("Erreur lors de l'ajout de l'annonce $titre : " . $error->getMessage());
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

   // Permet de désactiver (annuler) une annonce
    public function desactiver(int $id)
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
    public function reactiver(int $id)
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
    public function supprimer(int $id)
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
}
?>
