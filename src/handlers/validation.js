document.addEventListener("DOMContentLoaded", function () {
    const fields = {
        firstname: {
            regex: /^[A-Za-zÄÖÜäöüß]+$/, 
            message: "Der Vorname darf keine Zahlen oder Sonderzeichen enthalten."
        },
        lastname: {
            regex: /^[A-Za-zÄÖÜäöüß]+$/, 
            message: "Der Nachname darf keine Zahlen oder Sonderzeichen enthalten."
        },
        email: {
            regex: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/, 
            message: "Bitte eine gültige E-Mail-Adresse eingeben."
        },
        address: {
            regex: /^[A-Za-zÄÖÜäöüß\s]+[0-9\s]*$/, 
            message: "Die Adresse darf keine Sonderzeichen enthalten und muss mindestens einen Buchstaben enthalten."
        },
        "house-number": {
            regex: /^[0-9]+[A-Za-z]?$/, 
            message: "Die Hausnummer darf nur Zahlen und optional einen Buchstaben am Ende enthalten."
        },
        zipcode: {
            regex: /^[0-9]{5}$/, 
            message: "Die Postleitzahl muss genau 5 Ziffern enthalten."
        },
        city: {
            regex: /^[A-Za-zÄÖÜäöüß\s]+$/, 
            message: "Die Stadt darf keine Zahlen oder Sonderzeichen enthalten."
        },
        phone: {
            regex: /^\+?[0-9\s-]{7,15}$/, 
            message: "Bitte eine gültige Telefonnummer eingeben (mindestens 7 Ziffern, maximal 15 Ziffern)."
        },
        password: {
            regex: /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,}$/, 
            message: "Das Passwort muss mindestens 8 Zeichen lang sein, einen Großbuchstaben, einen Kleinbuchstaben und eine Zahl enthalten."
        },
        "confirm-password": {
            matchField: "password", 
            message: "Die Passwörter stimmen nicht überein."
        }
    };

    const form = document.getElementById("register-form");

    Object.keys(fields).forEach(fieldId => {
        const field = document.getElementById(fieldId);
        let userInteracted = false;

        field.addEventListener("click", function () {
            userInteracted = true;
        });

        field.addEventListener("input", function () {
            userInteracted = true;
            validateField(field, fields[fieldId]);
        });

        field.addEventListener("blur", function () {
            if (!userInteracted) return;
            validateField(field, fields[fieldId]);
        });
    });

    form.addEventListener("submit", function (event) {
        let formIsValid = true;

        Object.keys(fields).forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (!validateField(field, fields[fieldId])) {
                formIsValid = false;
            }
        });

        if (!formIsValid) {
            event.preventDefault();
            alert("Bitte korrigieren Sie die Fehler in den Formularfeldern.");
        }
    });

    function validateField(field, fieldConfig) {
        let errorSpan = field.nextElementSibling;
        if (!errorSpan || !errorSpan.classList.contains('error-message')) {
            errorSpan = document.createElement("span");
            errorSpan.className = "error-message inaktiv";
            field.parentNode.insertBefore(errorSpan, field.nextSibling);
        }

        if (!field.value.trim()) {
            errorSpan.classList.remove('aktiv');
            errorSpan.classList.add('inaktiv');
            errorSpan.textContent = "";
            return false;
        }

        if (fieldConfig.regex && !fieldConfig.regex.test(field.value)) {
            errorSpan.classList.remove('inaktiv');
            errorSpan.classList.add('aktiv');
            errorSpan.textContent = fieldConfig.message;
            return false;
        } else if (fieldConfig.matchField) {
            const matchField = document.getElementById(fieldConfig.matchField);
            if (field.value !== matchField.value) {
                errorSpan.classList.remove('inaktiv');
                errorSpan.classList.add('aktiv');
                errorSpan.textContent = fieldConfig.message;
                return false;
            } else {
                errorSpan.classList.remove('aktiv');
                errorSpan.classList.add('inaktiv');
                errorSpan.textContent = "";
                return true;
            }
        } else {
            errorSpan.classList.remove('aktiv');
            errorSpan.classList.add('inaktiv');
            errorSpan.textContent = "";
            return true;
        }
    }
});

