// document.addEventListener('DOMContentLoaded', () => {
//     const cartIcon = document.querySelector('.product-cart-icon');

//     cartIcon.addEventListener('click', () => {
//         if (cartIcon.style.color === 'green') {
//             cartIcon.style.color = 'black'; // Change back to the original color
//         } else {
//             cartIcon.style.color = 'green'; // Change to green
//         }
//     });
// });


document.addEventListener('DOMContentLoaded', function () {
    const cartIcon = document.querySelector('.product-cart-icon');

    // Event listener für den Warenkorb-Button
    cartIcon.addEventListener('click', function () {
        const productId = window.location.search.split('=')[1]; // Holen der Produkt-ID aus der URL
        if (productId) {
            // Hier könnte die Logik zum Hinzufügen des Produkts zum Warenkorb implementiert werden
            console.log('Produkt hinzugefügt: ' + productId);
        }
    });
});
