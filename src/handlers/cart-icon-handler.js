document.addEventListener("DOMContentLoaded", () => {
    const cartIcon = document.querySelector(".cart-icon");

    if (cartIcon) {
        cartIcon.addEventListener("click", () => {
            window.location.href = './warenkorb.php';
        });
    }
});
