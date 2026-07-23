//  FONCTION POUR AFFICHER L'ERREUR 
function showError(input, message) {
    const baliseP = input.nextElementSibling; 
    if (message) {
        input.classList.add("is-invalid");
        if (baliseP && baliseP.classList.contains("error-message")) {
            baliseP.textContent = message;
            baliseP.style.color = "brown";
        }
    } else {
        input.classList.remove("is-invalid");
        if (baliseP && baliseP.classList.contains("error-message")) {
            baliseP.textContent = "";
        }
    }
}

// FONCTIONS GLOBALES 

// FONCTION GLOBALE POUR REMPLIR LA MODALE
function editAnnonce(data) {
    // Remplissage des champs par ID
    if(document.getElementById('edit_id')) document.getElementById('edit_id').value = data.id;
    if(document.getElementById('edit_titre')) document.getElementById('edit_titre').value = data.titre;
    if(document.getElementById('edit_description')) document.getElementById('edit_description').value = data.description;
    if(document.getElementById('edit_salaire')) document.getElementById('edit_salaire').value = data.salaire;
    if(document.getElementById('edit_categorie_id')) document.getElementById('edit_categorie_id').value = data.categorie_id;
    if(document.getElementById('edit_zone_id')) document.getElementById('edit_zone_id').value = data.zone_id;
    if(document.getElementById('edit_statut')) document.getElementById('edit_statut').value = data.statut;


    // réveille les écouteurs et dégrise le bouton "Enregistrer"
    setTimeout(() => {
        const event = new Event('input', { bubbles: true });
        document.getElementById('edit_titre').dispatchEvent(event);
    }, 200);
}

/*function confirmDelete(id) {
    Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: "Cette annonce sera déplacée dans la corbeille !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff5b57',
        cancelButtonColor: '#348fe2',
        confirmButtonText: '<i class="fa fa-trash"></i> Oui, Déplacer',
        cancelButtonText: 'Annuler',
        background: '#2d353c',
        color: '#fff'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Suppression...',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading() }
            });
            window.location.href = "annonceMainController?delete_id=" + id;
        }
    });
}*/
// On ajoute le paramètre 'role'
function confirmDelete(id, role) {
    if (role === 'Admin') {
        // CAS ADMIN : On demande le motif (ton code actuel)
        Swal.fire({
            title: 'Motif de suppression (Admin)',
            input: 'textarea',
            inputPlaceholder: 'Expliquez pourquoi vous supprimez cette annonce...',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff5b57',
            confirmButtonText: 'Supprimer et notifier',
            cancelButtonText: 'Annuler',
            preConfirm: (motif) => {
                if (!motif || motif.trim().length < 5) {
                    Swal.showValidationMessage('Veuillez saisir un motif (5 caract. min)');
                }
                return motif;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const motif = encodeURIComponent(result.value);
                window.location.href = "annonceMainController?delete_id=" + id + "&motif=" + motif;
            }
        });
    } else {
        // CAS PRESTATAIRE : Simple confirmation
        Swal.fire({
            title: 'Supprimer mon annonce ?',
            text: "Cette action placera votre annonce dans la corbeille.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ff5b57',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                // On envoie un motif par défaut pour le prestataire
                window.location.href = "annonceMainController?delete_id=" + id + "&motif=Supprimé par l'auteur";
            }
        });
    }
}
// LOGIQUE DE VALIDATION
document.addEventListener("DOMContentLoaded", function() {

    //  CONFIGURATION POUR L'AJOUT 
    const formAdd = document.getElementById("addAnnonceFrom");
    if (formAdd) {
        const inputsAdd = {
            titre: document.getElementById("titre"),
            desc: document.getElementById("description"),
            salaire: document.getElementById("salaire"),
            cat: document.getElementById("categorie_id"),
            zone: document.getElementById("zone_id"),
            btn: formAdd.querySelector("button[type='submit']")
        };

        function checkAddValidity() {
            const hasErrors = formAdd.querySelectorAll(".is-invalid").length > 0;
            const isEmpty = !inputsAdd.titre.value || !inputsAdd.desc.value || !inputsAdd.salaire.value || !inputsAdd.cat.value || !inputsAdd.zone.value;
            inputsAdd.btn.disabled = (hasErrors || isEmpty);
        }

        setupListeners(inputsAdd, checkAddValidity);
    }

    // configuration pour la modification 
    const formEdit = document.getElementById("editAnnonceForm");
    if (formEdit) {
        const inputsEdit = {
            titre: document.getElementById("edit_titre"),
            desc: document.getElementById("edit_description"),
            salaire: document.getElementById("edit_salaire"),
            cat: document.getElementById("edit_categorie_id"),
            zone: document.getElementById("edit_zone_id"),
            statut: document.getElementById("edit_statut"),
            btn: formEdit.querySelector("button[type='submit']")
        };

        function checkEditValidity() {
            const hasErrors = formEdit.querySelectorAll(".is-invalid").length > 0;
            const isEmpty = !inputsEdit.titre.value || !inputsEdit.desc.value || !inputsEdit.salaire.value || !inputsEdit.cat.value || !inputsEdit.zone.value || !inputsEdit.statut.value;
            inputsEdit.btn.disabled = (hasErrors || isEmpty);
        }

        setupListeners(inputsEdit, checkEditValidity);
    }

    //  Fonction pour attacher les 
    function setupListeners(fields, checkFn) {
        // Titre
        fields.titre.addEventListener("input", () => {
            const result = Validator.nameValidator("Le titre", 5, 40, fields.titre.value.trim());
            showError(fields.titre, result ? result.message : "");
            checkFn();
        });

        // Description
        fields.desc.addEventListener("input", () => {
            const result = Validator.adresseValidator("La description", 10, 500, fields.desc.value.trim());
            showError(fields.desc, result ? result.message : "");
            checkFn();
        });

        // Salaire
        fields.salaire.addEventListener("input", () => {
            showError(fields.salaire, fields.salaire.value <= 0 ? "Le salaire doit être positif." : "");
            checkFn();
        });

        // Selects 
        [fields.cat, fields.zone, fields.statut].forEach(select => {
            if (select) {
                select.addEventListener("change", () => {
                    showError(select, select.value === "" ? "Ce champ est obligatoire." : "");
                    checkFn();
                });
            }
        });
    }

    console.log("Scripts de validation (Ajout & Edition) initialisés !");
});