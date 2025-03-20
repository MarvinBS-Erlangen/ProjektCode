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
            message: "Bitte eine gültige Telefonnummer eingeben (mindestens 7 Ziffern)."
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

    Object.keys(fields).forEach(fieldId => {
        const field = document.getElementById(fieldId);
        let userInteracted = false;

        field.addEventListener("click", function () {
            userInteracted = true;
            console.log(`Feld ${fieldId} angeklickt`); // Log, wenn das Feld angeklickt wird
        });

        field.addEventListener("input", function () {
            userInteracted = true;
            console.log(`Eingabe im Feld ${fieldId}: ${field.value}`); // Log, wenn Eingabe erfolgt
            validateField(field, fields[fieldId]);
        });

        field.addEventListener("blur", function () {
            if (!userInteracted) return;
            console.log(`Feld ${fieldId} hat den Fokus verlassen`); // Log, wenn das Feld den Fokus verliert
            validateField(field, fields[fieldId]);
        });
    });

    function validateField(field, fieldConfig) {
        console.log(`Validierung für Feld ${field.id} gestartet`); // Log für die Validierung
        let errorSpan = field.nextElementSibling;
        if (!errorSpan || !errorSpan.classList.contains('error-message')) {
            errorSpan = document.createElement("span");
            errorSpan.className = "error-message inaktiv";
            field.parentNode.insertBefore(errorSpan, field.nextSibling);
            console.log(`Fehlermeldungs-Span für ${field.id} erstellt`); // Log, wenn der Fehler-Span erstellt wird
        }

        if (!field.value.trim()) {
            console.log(`Feld ${field.id} ist leer, keine Validierung nötig`); // Log, wenn das Feld leer ist
            errorSpan.classList.remove('aktiv');
            errorSpan.classList.add('inaktiv');
            errorSpan.textContent = "";
            return;
        }

        // Log für Regex-Validierung
        console.log(`Feld ${field.id} Regex: ${fieldConfig.regex}`);
        if (fieldConfig.regex && !fieldConfig.regex.test(field.value)) {
            console.log(`Feld ${field.id} hat die Regex-Prüfung nicht bestanden: ${field.value}`); // Log, wenn die Regex-Prüfung fehlschlägt
            errorSpan.classList.remove('inaktiv');
            errorSpan.classList.add('aktiv');
            errorSpan.textContent = fieldConfig.message;
        } else if (fieldConfig.matchField) {
            const matchField = document.getElementById(fieldConfig.matchField);
            console.log(`Feld ${field.id} und ${fieldConfig.matchField} vergleichen: ${field.value} === ${matchField.value}`);
            if (field.value !== matchField.value) {
                console.log(`Passwörter stimmen nicht überein: ${field.value} !== ${matchField.value}`); // Log, wenn Passwörter nicht übereinstimmen
                errorSpan.classList.remove('inaktiv');
                errorSpan.classList.add('aktiv');
                errorSpan.textContent = fieldConfig.message;
            } else {
                console.log(`Passwörter stimmen überein`); // Log, wenn Passwörter übereinstimmen
                errorSpan.classList.remove('aktiv');
                errorSpan.classList.add('inaktiv');
                errorSpan.textContent = "";
            }
        } else {
            console.log(`Feld ${field.id} ist gültig`); // Log, wenn das Feld gültig ist
            errorSpan.classList.remove('aktiv');
            errorSpan.classList.add('inaktiv');
            errorSpan.textContent = "";
        }
    }
});

