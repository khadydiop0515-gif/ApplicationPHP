function editUser(data) {
    document.getElementById('edit_id').value = data.id;
    document.getElementById('edit_nom').value = data.nom;
    document.getElementById('edit_prenom').value = data.prenom;
    document.getElementById('edit_email').value = data.email;
    document.getElementById('edit_phone').value = data.phone;
    document.getElementById('edit_adresse').value = data.adresse;
    document.getElementById('edit_role').value = data.role;
    document.getElementById('edit_ninea').value = data.ninea;
}

function confirmDeleteUser(id) {
    Swal.fire({
        title: 'Supprimer cet utilisateur ?',
        text: "Il ne pourra plus se connecter à l'application.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff5b57',
        background: '#2d353c',
        color: '#fff',
        confirmButtonText: 'Oui, supprimer'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "userMainController?delete_id=" + id;
        }
    });
}