function editAvis(data) {
    document.getElementById('edit_id').value = data.id;
    document.getElementById('edit_note').value = data.note;
    document.getElementById('edit_commentaire').value = data.commentaire;
    document.getElementById('edit_annonce_id').value = data.annonce_id;
}

/*function confirmDeleteAvis(id) {
    Swal.fire({
        title: 'Désactiver cet avis ?',
        text: "L'avis sera masqué de la liste.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff5b57',
        background: '#2d353c',
        color: '#fff',
        confirmButtonText: 'Oui, désactiver'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "avisMainController?delete_id=" + id;
        }
    });
}
*/
function confirmDeleteAvis(id) {
    Swal.fire({
        title: 'Motif de suppression de l\'avis',
        input: 'textarea',
        inputPlaceholder: 'Indiquez la raison (ex: Propos inappropriés)...',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff5b57',
        confirmButtonText: 'Supprimer et notifier',
        background: '#2d353c',
        color: '#fff',
        preConfirm: (motif) => {
            if (!motif) { Swal.showValidationMessage('Motif obligatoire'); }
            return motif;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({ title: 'Suppression...', didOpen: () => { Swal.showLoading() } });
            const motif = encodeURIComponent(result.value);
            window.location.href = "avisMainController?delete_id=" + id + "&motif=" + motif;
        }
    });
}
document.addEventListener("DOMContentLoaded", function() {
    const formAdd = document.getElementById("addAvisForm");
    if(formAdd) {
        const comm = document.getElementById("commentaire");
        const btn = formAdd.querySelector("button[type='submit']");
        comm.addEventListener("input", () => {
            btn.disabled = comm.value.length < 5;
        });
    }
});