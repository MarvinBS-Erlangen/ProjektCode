<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakt – MACaPPLE</title>
    <link rel="stylesheet" href="../public/styles/contact.css">
</head>

<body>
    <header>
        <h1>Kontakt</h1>
        <p>Wir freuen uns auf deine Nachricht!</p>
    </header>

    <main class="main">
        <div class="contact-container">
            <section class="contact-info">
                <h2>Unsere Kontaktinformationen</h2>
                <p><strong>Email:</strong> support@macapple.de</p>
                <p><strong>Telefon:</strong> +49 123 456 789</p>
                <p><strong>Adresse:</strong> Musterstraße 12, 90402 Nürnberg</p>
            </section>

            <section class="contact-form">
                <h2>Schreib uns eine Nachricht</h2>
                <form action="kontakt.php" method="POST">
                    <label for="name">Dein Name</label>
                    <input type="text" id="name" name="name" required>

                    <label for="email">Deine E-Mail</label>
                    <input type="email" id="email" name="email" required>

                    <label for="message">Deine Nachricht</label>
                    <textarea id="message" name="message" rows="5" required></textarea>

                    <button type="submit">Absenden</button>
                </form>
            </section>
        </div>
    </main>
</body>

</html>
