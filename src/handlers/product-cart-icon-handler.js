document.addEventListener('DOMContentLoaded', () => {
    const cartIcons = document.querySelectorAll('.product .cart-icon');

    cartIcons.forEach((cartIcon) => {
        cartIcon.addEventListener('click', () => {
            if (cartIcon.style.color === '#4a7c59') {
                // Check for the color #4a7c59
                cartIcon.style.color = 'black'; // Change back to the original color
            } else {
                cartIcon.style.color = '#4a7c59'; // Change to #4a7c59
            }
        });
    });
});
