<?php
require_once("../../model/CandidatureRepository.php");

require_once("../../controller/MailService.php");
require_once("../../controller/MailService.php");
class CandidatureController
{
    private $candidatureRepository;

    public function __construct()
    {
        $this->candidatureRepository = new CandidatureRepository();
    }

    // Fonctions de redirection pour SweetAlert
    private function redirect($type, $message, $title, $url = "ListeCandidature")
    {
        $param = ($type == 'succes') ? 'succes=1' : 'error=1';
        header("Location: $url?$param&message=" . urlencode($message) . "&title=" . urlencode($title));
        exit;
    }

    public function addCandidature()
{
    if ($_SERVER["REQUEST_METHOD"] == 'POST') {
        $msg = trim($_POST['message_motivation'] ?? '');
        $user_id = $_POST['user_id'] ?? null;
        $annonce_id = $_POST['annonce_id'] ?? null;

        // 1. Déterminer l'URL de redirection (Admin ou Détails Annonce)
        // Si c'est un étudiant, on le renvoie sur la page de l'annonce
        $redirectUrl = (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin') 
                       ? "ListeCandidature" 
                       : "detailsAnnonce?id=" . $annonce_id;

        if (empty($msg) || !$user_id || !$annonce_id) {
            $this->redirect('error', "Tous les champs sont obligatoires.", "Champs vides", $redirectUrl);
        }

        // 2. VÉRIFICATION DES DOUBLONS
        if ($this->candidatureRepository->hasAlreadyApplied($user_id, $annonce_id)) {
            $this->redirect('error', "Vous avez déjà postulé à cette offre.", "Action impossible", $redirectUrl);
        }

        try {
            $res = $this->candidatureRepository->add($msg, $user_id, $annonce_id);
            if ($res) {
                $this->redirect('succes', "Votre candidature a été envoyée avec succès.", "Félicitations", $redirectUrl);
            }
        } catch (Exception $e) {
            $this->redirect('error', "Erreur : " . $e->getMessage(), "Erreur", $redirectUrl);
        }
    }
}

    public function updateCandidature()
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $id = $_POST['id'] ?? null;
            $msg = trim($_POST['message_motivation'] ?? '');
            $annonce_id = $_POST['annonce_id'] ?? null;

            try {
                $res = $this->candidatureRepository->update($id, $msg, $annonce_id);
                if ($res) {
                    $this->redirect('succes', "Modification effectuée.", "Succès");
                }
            } catch (Exception $e) {
                $this->redirect('error', "Erreur : " . $e->getMessage(), "Erreur");
            }
        }
    }

  
    

public function restoreCandidature($id)
{
    try {
        if ($this->candidatureRepository->activate($id)) {
            $this->redirect('succes', "Candidature restaurée avec succès.", "Restauration", "CorbeilleCandidature");
        }
    } catch (Exception $e) {
        $this->redirect('error', "Erreur : " . $e->getMessage(), "Erreur", "CorbeilleCandidature");
    }
}

public function permanentDelete($id)
{
    try {
        if ($this->candidatureRepository->delete($id)) {
            $this->redirect('succes', "Candidature supprimée définitivement.", "Supprimé", "CorbeilleCandidature");
        }
    } catch (Exception $e) {
        $this->redirect('error', "Erreur fatale lors de la suppression.", "Erreur", "CorbeilleCandidature");
    }
}


public function deleteCandidature($id, $motif)
{
    try {
        // 1. On récupère les infos pour le mail (Email étudiant + Titre annonce)
        $details = $this->candidatureRepository->getCandidatureDetails($id);

        // 2. Désactivation en base
        $res = $this->candidatureRepository->desactivate($id, $motif);

        if ($res && $details) {
            // 3. Envoi du mail
            $sujet = "Information sur votre candidature : " . $details['annonce_titre'];
            $corps = "Bonjour " . htmlspecialchars($details['prenom']) . ",<br><br>
                      Nous vous informons que votre candidature pour l'offre <b>'".$details['annonce_titre']."'</b> a été retirée par l'administration.<br><br>
                      <b>Motif :</b><br>
                      <blockquote style='color: #555;'>$motif</blockquote>";
            
            MailService::sendNotification($details['email'], $sujet, $corps);

            $this->redirect('succes', "Candidature supprimée et étudiant notifié.", "Succès");
        }
    } catch (Exception $e) {
        $this->redirect('error', "Erreur : " . $e->getMessage(), "Erreur");
    }
}


public function acceptCandidature($id) {
    $details = $this->candidatureRepository->getCandidatureDetails($id);
    if($this->candidatureRepository->accept($id)) {
        // Email de félicitations
        $sujet = "Bonne nouvelle ! Candidature acceptée : " . $details['annonce_titre'];
        $corps = "Bonjour " . htmlspecialchars($details['prenom']) . ",<br><br>
                  Le prestataire a <b>accepté</b> votre candidature pour l'offre : <b>".$details['annonce_titre']."</b>.<br>
                  Il prendra contact avec vous très prochainement via vos coordonnées.";
        
        MailService::sendNotification($details['email'], $sujet, $corps);
        $this->redirect('succes', "Candidat accepté et notifié.", "Succès", "CandidaturesRecues");
    }
}

public function rejectCandidature($id, $motif) {
    $details = $this->candidatureRepository->getCandidatureDetails($id);
    if($this->candidatureRepository->reject($id, $motif)) {
        // Email de refus
        $sujet = "Réponse à votre candidature : " . $details['annonce_titre'];
        $corps = "Bonjour " . htmlspecialchars($details['prenom']) . ",<br><br>
                  Nous avons le regret de vous informer que votre candidature pour l'offre <b>".$details['annonce_titre']."</b> n'a pas été retenue.<br>
                  <b>Motif :</b> $motif";
        
        MailService::sendNotification($details['email'], $sujet, $corps);
        $this->redirect('succes', "Candidature refusée.", "Terminé", "CandidaturesRecues");
    }
}
}