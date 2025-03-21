document.addEventListener("DOMContentLoaded", function () {
    const fields = {
        name: {
            regex: /^[A-Za-zÄÖÜäöüß\s]+$/, 
            message: "Der Name darf keine Zahlen oder Sonderzeichen enthalten."
        },
        email: {
            regex: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/, 
            message: "Bitte eine gültige E-Mail-Adresse eingeben."
        },
        message: {
            regex: /.+/, 
            message: "Die Nachricht darf nicht leer sein."
        }
    };

    const form = document.querySelector(".contact-form form");

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
        } else {
            event.preventDefault();
            alert("Nachricht erfolgreich abgeschickt!");
            window.location.href = window.location.href; // Reload the page
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
        } else {
            errorSpan.classList.remove('aktiv');
            errorSpan.classList.add('inaktiv');
            errorSpan.textContent = "";
            return true;
        }
    }
});