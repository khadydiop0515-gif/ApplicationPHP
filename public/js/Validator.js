class Validator {
    
    //Permet de valider un mot de passe
    static passwordValidator(controlName, value, lengthWord) {
        return !value || value.length === 0
            ? { error: true, message: `${controlName} est obligatoire.` }
            : value.length < lengthWord
            ? { error: true, message: `${controlName} doit contenir au moins ${lengthWord} caractères.` }
            : (value.startsWith(' ') || value.endsWith(' '))
            ? { error: true, message: `Les espaces de début et de fin ne sont pas autorisés.` }
            : null; 
    }

    //Permet de valider une adresse email
    static emailValidator(controlName, value) {
   
    const pattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

    return !value || value.length === 0
        ? { error: true, message: `${controlName} est obligatoire.` }
        : (value.startsWith(' ') || value.endsWith(' '))
        ? { error: true, message: `Les espaces de début et de fin ne sont pas autorisés.` }
        : !pattern.test(value)
        ? { error: true, message: `${controlName} doit respecter le format exemple@gmail.com.` }
        : null;
    }

    // Permet de valider un numéro de téléphone
    static phoneValidator(controlName, minLength, maxLength, value) {

    const phoneRegex = /^\+?[0-9]+$/;

    return !value || value.length === 0
        ? { error: true, message: `${controlName} est obligatoire.` }
        : (value.startsWith(' ') || value.endsWith(' '))
        ? { error: true, message: `Les espaces de début et de fin ne sont pas autorisés.` }
        : !phoneRegex.test(value) 
        ? { error: true, message: `${controlName} ne doit contenir que des chiffres (le "+" est autorisé au début).` }
        : value.length < minLength
        ? { error: true, message: `${controlName} doit contenir au moins ${minLength} caractères.` }
        : value.length > maxLength
        ? { error: true, message: `${controlName} doit contenir au plus ${maxLength} caractères.` }
        : null; 
    }

    // Permet de valider un nom ou un prénom
    static nameValidator(controlName, minLength, maxLength, value) {
    
    const pattern = /^[a-zA-ZÀ-ÿ\s'-]+$/;

    if (!value || value.length === 0) {
        return { error: true, message: `${controlName} est obligatoire.` };
    }
    if (value.startsWith(' ') || value.endsWith(' ')) {
        return { error: true, message: `Les espaces de début et de fin ne sont pas autorisés.` };
    }
    if (!pattern.test(value)) {
        return { error: true, message: `${controlName} ne doit contenir que des lettres.` };
    }
    if (value.length < minLength) {
        return { error: true, message: `${controlName} doit contenir au moins ${minLength} lettres.` };
    }
    if (value.length > maxLength) {
        return { error: true, message: `${controlName} doit contenir au plus ${maxLength} lettres.` };
    }
    return null;
    }

   // Permet de valider une adresse 
    static adresseValidator(controlName, minLength, maxLength, value) {
    
    const isContainsNumber = /[0-9]/;
    const isContainsUpperCase = /[A-Z]/;
    const isContainsLowerCase = /[a-z]/;
    const isContainsSymbol = /[^a-zA-Z0-9\sà-ÿÀ-ß]/;

    if (!value || value.length === 0) {
        return { error: true, message: `${controlName} est obligatoire.` };
    }

    if (value.startsWith(' ') || value.endsWith(' ')) {
        return { error: true, message: `Les espaces de début et de fin ne sont pas autorisés.` };
    }

    if (isContainsSymbol.test(value) 
        && !isContainsNumber.test(value) 
        && !isContainsUpperCase.test(value)
        && !isContainsLowerCase.test(value)) {
        return { error: true, message: `${controlName} ne doit pas contenir que des caractères spéciaux.` };
    }

    if (isContainsNumber.test(value)
        && !isContainsSymbol.test(value)
        && !isContainsUpperCase.test(value)
        && !isContainsLowerCase.test(value)) {
        return { error: true, message: `${controlName} ne doit pas contenir que des chiffres.` };
    }

    if (value.length < minLength) {
        return { error: true, message: `${controlName} est trop courte (min ${minLength} caractères).` };
    }

    if (value.length > maxLength) {
        return { error: true, message: `${controlName} est trop longue (max ${maxLength} caractères).` };
    }

    return null;
    }
    
    static textValidator(label, value, min = 2) {
    if (value.length === 0) {
        return { message: `${label} est obligatoire` };
    }
    if (value.length < min) {
        return { message: `${label} doit contenir au moins ${min} caractères` };
    }
    return null;
}

}