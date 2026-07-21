<?php
require_once("../../../../model/UserRepository.php");
$repo = new UserRepository();
$trash = $repo->getTrashByRole('Prestataire');
?>
<!DOCTYPE html>
<html lang="fr">
<?php require_once("../../../sections/admin/head.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<body>
    <div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
        <?php require_once("../../../sections/admin/menuHaut.php"); ?>
        <?php require_once("../../../sections/admin/menuGauche.php"); ?>
        <div id="content" class="content">
            <ol class="breadcrumb float-xl-right">
                <li class="breadcrumb-item"><a href="ListePrestataire" class="btn btn-sm btn-success text-white"><i class="fa fa-arrow-left"></i> Retour</a></li>
            </ol>
            <h1 class="page-header"># Corbeille Prestataires</h1>
            <div class="panel panel-danger">
                <div class="panel-heading"><h4 class="panel-title">Comptes prestataires désactivés</h4></div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered">
                        <thead><tr><th>Nom</th><th>Prénom</th><th>Email</th><th>Actions</th></tr></thead>
                        <tbody>
                            <?php foreach($trash as $u): ?>
                            <tr>
                                <td><?= htmlspecialchars($u['nom']) ?></td>
                                <td><?= htmlspecialchars($u['prenom']) ?></td>
                                <td><?= htmlspecialchars($u['email']) ?></td>
                                <td class="text-nowrap">
                                    <a href="userMainController?restore_id=<?= $u['id'] ?>" class="btn btn-xs btn-primary">Restaurer</a>
                                    <a href="javascript:;" onclick="confirmDelete(<?= $u['id'] ?>)" class="btn btn-xs btn-danger">Supprimer</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Suppression définitive ?',
            text: "Cette action est irréversible !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff5b57',
            confirmButtonText: 'Oui, supprimer'
        }).then((result) => {
            if (result.isConfirmed) { window.location.href = "userMainController?permanent_delete_id=" + id; }
        });
    }
    </script>
    <?php require_once("../../../sections/admin/script.php"); ?>
</body>
</html>