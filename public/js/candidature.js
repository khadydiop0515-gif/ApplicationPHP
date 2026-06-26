function editCandidature(data) {
    document.getElementById('edit_id').value = data.id;
    document.getElementById('edit_annonce_id').value = data.annonce_id;
    document.getElementById('edit_message').value = data.message_motivation;
}

function confirmDeleteCandidature(id) {
    Swal.fire({
        title: 'Supprimer cette candidature ?',
        text: "Elle sera déplacée dans la corbeille.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff5b57',
        background: '#2d353c',
        color: '#fff',
        confirmButtonText: 'Oui, supprimer'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "candidatureMainController?delete_id=" + id;
        }
    });
}