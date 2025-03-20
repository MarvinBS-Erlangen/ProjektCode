document.addEventListener('DOMContentLoaded', () => {
    const btnCurrentBestRatedFood = document.getElementById('btn-current-best-rated-food');

    btnCurrentBestRatedFood.addEventListener('click', () => {
        window.location.href = 'winners.php'; // Redirect to winners.php
    });
});