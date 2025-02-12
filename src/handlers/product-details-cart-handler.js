document.addEventListener('DOMContentLoaded', () => {
    const cartIcon = document.querySelector('.product-cart-icon');

    cartIcon.addEventListener('click', () => {
        if (cartIcon.style.color === 'green') {
            cartIcon.style.color = 'black'; // Change back to the original color
        } else {
            cartIcon.style.color = 'green'; // Change to green
        }
    });
});
