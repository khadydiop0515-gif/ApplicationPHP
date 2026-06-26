<?php
require_once("../../model/CategorieRepository.php");

class CategorieController
{
    private $categorieRepository;

    public function __construct()
    {
        $this->categorieRepository = new CategorieRepository();
    }

    private function redirect($type, $message, $title, $url = "ListeCategorie")
    {
        $param = ($type == 'succes') ? 'succes=1' : 'error=1';
        header("Location: $url?$param&message=" . urlencode($message) . "&title=" . urlencode($title));
        exit;
    }

    public function addCategorie()
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $nom = trim($_POST['nom'] ?? '');

            if (empty($nom)) {
                $this->redirect('error', "Le nom de la catégorie est obligatoire.", "Champs vides");
            }

            try {
                $result = $this->categorieRepository->add($nom);
                if ($result) {
                    $this->redirect('succes', "La catégorie a été ajoutée.", "Succès");
                }
            } catch (Exception $e) {
                $this->redirect('error', "Erreur : " . $e->getMessage(), "Erreur système");
            }
        }
    }

    public function updateCategorie()
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $id = $_POST['id'] ?? null;
            $nom = trim($_POST['nom'] ?? '');

            if (!$id || empty($nom)) {
                $this->redirect('error', "Données incomplètes.", "Erreur");
            }

            try {
                $result = $this->categorieRepository->update($id, $nom);
                if ($result) {
                    $this->redirect('succes', "La catégorie a été mise à jour.", "Succès");
                } else {
                    $this->redirect('error', "Aucune modification effectuée.", "Info");
                }
            } catch (Exception $e) {
                $this->redirect('error', "Erreur : " . $e->getMessage(), "Erreur");
            }
        }
    }

    public function deleteCategorie($id)
    {
        try {
            $result = $this->categorieRepository->delete($id);
            if ($result) {
                $this->redirect('succes', "Catégorie supprimée définitivement.", "Suppression");
            }
        } catch (Exception $e) {
            // Souvent une erreur arrive ici si la catégorie est liée à une annonce (Clé étrangère)
            $this->redirect('error', "Impossible de supprimer cette catégorie car elle est utilisée dans des annonces.", "Erreur de liaison");
        }
    }
}