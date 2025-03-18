document.addEventListener("DOMContentLoaded", function () {
    // Alle Menü-Items finden
    const menuItems = document.querySelectorAll(".menu");

    // Event Listener hinzufügen, der auf einen Klick reagiert
    menuItems.forEach(item => {
        item.addEventListener("click", function () {
            const menuID = this.getAttribute("data-id");

            // Umleitung zur Detailseite mit der spezifischen Menü-ID
            window.location.href = `menu_details.php?id=${menuID}`;
        });
    });
});
