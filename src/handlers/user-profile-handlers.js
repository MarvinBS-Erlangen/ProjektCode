const editButton = document.getElementById("edit-btn");
const saveButton = document.getElementById("save-btn");
const inputs = document.querySelectorAll(".profile-info input");

function toggleEditSaveButtons(enableEditing) {
    inputs.forEach(input => input.disabled = !enableEditing);
    editButton.classList.toggle("hidden", enableEditing);
    saveButton.classList.toggle("hidden", !enableEditing);
}

editButton.addEventListener("click", () => toggleEditSaveButtons(true));

saveButton.addEventListener("click", () => {
    let allFieldsFilled = true;

    inputs.forEach(input => {
        if (input.value.trim() === "") {
            allFieldsFilled = false;
            input.style.border = "2px solid red";
        } else {
            input.style.border = "1px solid #ccc";
        }
    });
function isValidPhoneNumber(phoneNumber) {
    const phoneRegex = /^\+?(\d{1,3})?[-.\s]?\(?(\d{1,4})\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,4}$/;
    return phoneRegex.test(phoneNumber);
}

// Beispielaufruf:
const phone = document.getElementById("phone").value;
if (!isValidPhoneNumber(phone)) {
    alert("Die Telefonnummer ist ungültig.");
} else {
    if (!allFieldsFilled) {
        alert("Bitte fülle alle Felder aus, bevor du speicherst!");
    } else {
        toggleEditSaveButtons(false);
         alert("Änderungen wurden erfolgreich gespeichert!");
    }
}
});
 