// Sélection des éléments HTML par leur ID
const prenomInput = document.getElementById("prenom");
const nomInput = document.getElementById("nom");
const emailInput = document.getElementById("email");
const phoneInput = document.getElementById("phone");
const roleSelect = document.getElementById("role");
const adresseInput = document.getElementById("adresse");
const passwordInput = document.getElementById("password");
const btnSubmit = document.getElementById("btnRegister");

// On désactive le bouton par défaut
btnSubmit.disabled = true;

// Affiche le message d'erreur sous l'input

function showError(input, message) {
    const errorDisplay = input.nextElementSibling; // Récupère la balise <p> après l'input
    if (message) {
        input.classList.add("is-invalid");
        if (errorDisplay) errorDisplay.textContent = message;
    } else {
        input.classList.remove("is-invalid");
        if (errorDisplay) errorDisplay.textContent = "";
    }
}

// Vérifie la validité globale de tout le formulaire
 
function checkFormValidity() {
    const prenomErr = Validator.nameValidator("Le prénom", 2, 30, prenomInput.value);
    const nomErr    = Validator.nameValidator("Le nom", 2, 30, nomInput.value);
    
    // emailValidator
    const emailErr  = Validator.emailValidator("L'email", emailInput.value);
    
    // phoneValidator
    const phoneErr  = Validator.phoneValidator("Le téléphone", 9, 15, phoneInput.value);
    
    // adresseValidator(controlName, minLength, maxLength, value)
    const adresseErr = Validator.adresseValidator("L'adresse", 5, 100, adresseInput.value);
    
    // passwordValidator
    const passwordErr = Validator.passwordValidator("Le mot de passe", passwordInput.value, 8);
    
    // Rôle
    const roleValid = roleSelect.value !== "";
 
    // Le bouton est actif seulement si les erreurs sont null et le rôle est choisi
    const isFormValid = !prenomErr && !nomErr && !emailErr && !phoneErr && !adresseErr && !passwordErr && roleValid;

    btnSubmit.disabled = !isFormValid;
}

//  AJOUT DES ÉCOUTEURS 

prenomInput.addEventListener("input", () => {
    const err = Validator.nameValidator("Le prénom", 2, 30, prenomInput.value);
    showError(prenomInput, err ? err.message : "");
    checkFormValidity();
});

nomInput.addEventListener("input", () => {
    const err = Validator.nameValidator("Le nom", 2, 30, nomInput.value);
    showError(nomInput, err ? err.message : "");
    checkFormValidity();
});

emailInput.addEventListener("input", () => {
    const err = Validator.emailValidator("L'email", emailInput.value);
    showError(emailInput, err ? err.message : "");
    checkFormValidity();
});

phoneInput.addEventListener("input", () => {
    // On autorise entre 9 et 15 chiffres
    const err = Validator.phoneValidator("Le téléphone", 9, 15, phoneInput.value);
    showError(phoneInput, err ? err.message : "");
    checkFormValidity();
});

adresseInput.addEventListener("input", () => {
    const err = Validator.adresseValidator("L'adresse", 5, 100, adresseInput.value);
    showError(adresseInput, err ? err.message : "");
    checkFormValidity();
});

passwordInput.addEventListener("input", () => {
    const err = Validator.passwordValidator("Le mot de passe", passwordInput.value, 8);
    showError(passwordInput, err ? err.message : "");
    checkFormValidity();
});

// Pour le rôle, on verifie lors du changement
roleSelect.addEventListener("change", () => {
    checkFormValidity();
});