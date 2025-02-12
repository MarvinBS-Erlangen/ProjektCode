document.addEventListener('DOMContentLoaded', () => {
    const heartIcons = document.querySelectorAll('.rating-container .fa-heart');

    heartIcons.forEach(heartIcon => {
        heartIcon.addEventListener('click', (e) => {
            const targetIcon = e.target;
            if (targetIcon.classList.contains('fa-solid')) {
                targetIcon.classList.remove('fa-solid');
                targetIcon.classList.add('fa-regular');
            } else {
                targetIcon.classList.remove('fa-regular');
                targetIcon.classList.add('fa-solid');
            }
        });
    });
});
