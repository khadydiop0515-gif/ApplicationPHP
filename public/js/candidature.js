function editCandidature(data) {
    document.getElementById('edit_id').value = data.id;
    document.getElementById('edit_annonce_id').value = data.annonce_id;
    document.getElementById('edit_message').value = data.message_motivation;
}

// === DOIVENT ÊTRE GLOBALES ===

function confirmAcceptCandidature(id) {
    Swal.fire({
        title: 'Accepter ce candidat ?',
        text: "Un email de confirmation lui sera envoyé.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#00acac',
        cancelButtonColor: '#707478',
        confirmButtonText: 'Oui, accepter !',
        cancelButtonText: 'Annuler',
        background: '#2d353c',
        color: '#fff'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "candidatureMainController?accept_id=" + id;
        }
    });
}

function confirmDeleteCandidature(id) {
    Swal.fire({
        title: 'Motif de rejet',
        input: 'textarea',
        inputPlaceholder: 'Expliquez pourquoi la candidature est refusée...',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff5b57',
        confirmButtonText: 'Refuser et notifier',
        background: '#2d353c',
        color: '#fff',
        preConfirm: (motif) => {
            if (!motif) { Swal.showValidationMessage('Motif obligatoire'); }
            return motif;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const motif = encodeURIComponent(result.value);
            window.location.href = "candidatureMainController?delete_id=" + id + "&motif=" + motif;
        }
    });
}
