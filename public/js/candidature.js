function editCandidature(data) {
    document.getElementById('edit_id').value = data.id;
    document.getElementById('edit_annonce_id').value = data.annonce_id;
    document.getElementById('edit_message').value = data.message_motivation;
}

function confirmDeleteCandidature(id) {
    Swal.fire({
        title: 'Motif de rejet/suppression',
        input: 'textarea',
        inputPlaceholder: 'Expliquez à l\'étudiant pourquoi sa candidature est retirée...',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff5b57',
        confirmButtonText: 'Supprimer et notifier',
        background: '#2d353c',
        color: '#fff',
        preConfirm: (motif) => {
            if (!motif || motif.trim().length < 5) {
                Swal.showValidationMessage('Veuillez saisir un motif (5 caract. min)');
            }
            return motif;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({ title: 'Traitement...', didOpen: () => { Swal.showLoading() } });
            const motif = encodeURIComponent(result.value);
            // Redirection vers le main controller
            window.location.href = "candidatureMainController?delete_id=" + id + "&motif=" + motif;
        }
    });
}