function editCategorie(data) {
    document.getElementById('edit_cat_id').value = data.id;
    document.getElementById('edit_cat_nom').value = data.nom;
}

function confirmDeleteCategorie(id) {
    Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: "La catégorie sera désactivée et ne sera plus visible pour les utilisateurs !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff5b57',
        cancelButtonColor: '#348fe2',
        confirmButtonText: 'Oui, désactiver',
        cancelButtonText: 'Annuler',
        background: '#2d353c',
        color: '#fff'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "categorieMainController?delete_id=" + id;
        }
    });
}