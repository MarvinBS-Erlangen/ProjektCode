document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    const errorBox = document.createElement('div');
    errorBox.classList.add('error-box');
    errorBox.style.display = 'none';
    document.body.appendChild(errorBox);

    form.addEventListener('submit', (e) => {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        // Simulate an AJAX request to check the login
        fetch('login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `EMail=${encodeURIComponent(
                email,
            )}&Password=${encodeURIComponent(password)}`,
        })
            .then((response) => response.text())
            .then((data) => {
                if (data.includes('No account found with that email')) {
                    e.preventDefault();
                    errorBox.textContent =
                        'No account found with that email. Please register first.';
                    errorBox.style.display = 'block';
                }
            })
            .catch((error) => console.error('Error:', error));
    });
});
