document.addEventListener('DOMContentLoaded', () => {
    const stars = document.querySelectorAll('.rating-container .fa-star');
    let lastClickedValue = 0;

    stars.forEach((star) => {
        star.addEventListener('click', (e) => {
            const value = parseInt(e.target.getAttribute('data-value'));

            if (value === lastClickedValue) {
                // If the same star is clicked again, remove all filled stars
                stars.forEach((s) => {
                    s.classList.remove('filled');
                });
                lastClickedValue = 0; // Reset the last clicked value
            } else {
                // Fill stars up to the clicked star
                stars.forEach((s, index) => {
                    if (index < value) {
                        s.classList.add('filled');
                    } else {
                        s.classList.remove('filled');
                    }
                });
                lastClickedValue = value; // Update the last clicked value
            }

            // Here you can add the AJAX call to save the rating to the database
        });
    });
});
