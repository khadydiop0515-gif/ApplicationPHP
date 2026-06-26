function editZone(data) {
    document.getElementById('edit_zone_id').value = data.id;
    document.getElementById('edit_nom_quartier').value = data.nom_quartier;
}

function confirmDeleteZone(id) {
    Swal.fire({
        title: 'Supprimer cette zone ?',
        text: "Attention, cela peut impacter les annonces liées !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff5b57',
        cancelButtonColor: '#348fe2',
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler',
        background: '#2d353c',
        color: '#fff'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "zoneMainController?delete_id=" + id;
        }
    });
}