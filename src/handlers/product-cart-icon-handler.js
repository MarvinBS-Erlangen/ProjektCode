document.addEventListener('DOMContentLoaded', () => {
    const cartIcons = document.querySelectorAll('.cart-icon');

            cartIcons.forEach(icon => {
                icon.addEventListener('click', function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                    window.location.href = this.href;
                });
            });
});
