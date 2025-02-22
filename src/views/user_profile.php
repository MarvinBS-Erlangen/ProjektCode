<?php
// Datenbank verbindung herstellen
include '../database/connection.php';
// Start der Session
// Sessions initialisieren wenn noch nicht gemacht
include '../comps/sessioncheck.php';
// Schaue ob der Benutzer eingeloggt ist
include '../comps/usercheck.php';
// Datenbank Logik einbinden -- POST Requests an die Datenbank + Backend Logik
include '../database/db_user_profile.php';
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/reset.css">
    <link rel="stylesheet" href="../public/styles/index.css">
    <link rel="stylesheet" href="../public/styles/user_profile.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/header.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="../handlers/product-cart-icon-handler.js" defer></script>
    <script src="../handlers/user-profile-handlers.js" defer></script>
    <title>Benutzerprofil</title>
</head>

<body>

    <?php include './partials/header.php'; ?>

    <main class="main">
        <div class="profile-container">
            <!-- Linke Seite: Benutzerprofil -->
            <div class="profile-info">
                <h2>Profilinformationen</h2>
                <form method="POST" action="user_profile.php" id="profile-form">
                    <label for="firstname">Vorname</label>
                    <input type="text" id="firstname" name="Vorname" value="<?php echo htmlspecialchars($firstName); ?>" disabled>

                    <label for="lastname">Nachname</label>
                    <input type="text" id="lastname" name="Nachname" value="<?php echo htmlspecialchars($lastName); ?>" disabled>

                    <label for="address">Adresse</label>
                    <div class="address-container">
                        <input type="text" id="address" name="Strasse" value="<?php echo htmlspecialchars($address); ?>" disabled>
                        <input type="text" id="house-number" name="Hausnummer" value="<?php echo htmlspecialchars($houseNumber); ?>" disabled>
                    </div>

                    <label for="zipcode">PLZ</label>
                    <input type="text" id="zipcode" name="Postleitzahl" value="<?php echo htmlspecialchars($zipcode); ?>" disabled>

                    <label for="city">Stadt</label>
                    <input type="text" id="city" name="Stadt" value="<?php echo htmlspecialchars($city); ?>" disabled>

                    <label for="country">Land</label>
                    <input type="text" id="country" name="Land" value="<?php echo htmlspecialchars($country); ?>" disabled>

                    <label for="phone">Telefonnummer</label>
                    <input type="text" id="phone" name="Telefon" value="<?php echo htmlspecialchars($phone); ?>" disabled>

                    <button type="button" id="edit-btn">Bearbeiten</button>
                    <button type="submit" id="save-btn" class="hidden">Speichern</button>
                    <button type="button" id="cancel-btn" class="hidden">Abbrechen</button>
                </form>
            </div>

            <!-- Rechte Seite: Bestellhistorie -->
            <div class="order-history">
                <h2>Vorherige Bestellungen</h2>
                <div id="orders-container">
                    <div id="orders">
                        <!-- Bestellungen werden hier per JavaScript eingefügt -->
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="delete-account-container">
        <!-- The form method is POST because HTML forms do not support the DELETE method directly -->
        <form method="POST" action="user_profile.php" id="delete-form">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" id="delete-account-btn">Konto löschen</button>
        </form>
    </div>

    <?php include './partials/footer.php'; ?>

    <script>
        document.getElementById('edit-btn').addEventListener('click', function() {
            document.querySelectorAll('.profile-info input').forEach(function(input) {
                input.disabled = false;
            });
            document.getElementById('edit-btn').classList.add('hidden');
            document.getElementById('save-btn').classList.remove('hidden');
            document.getElementById('cancel-btn').classList.remove('hidden');
        });

        document.getElementById('cancel-btn').addEventListener('click', function() {
            document.querySelectorAll('.profile-info input').forEach(function(input) {
                input.disabled = true;
            });
            document.getElementById('edit-btn').classList.remove('hidden');
            document.getElementById('save-btn').classList.add('hidden');
            document.getElementById('cancel-btn').classList.add('hidden');
        });

        // deaktivierte input felder aktivieren, wenn das Formular abgeschickt wird, damit daten aktualisiert werden können
        document.getElementById('profile-form').addEventListener('submit', function() {
            document.querySelectorAll('.profile-info input').forEach(function(input) {
                input.disabled = false;
            });
        });

        // Bestätigungsmeldung anzeigen, bevor das Konto gelöscht wird
        document.getElementById('delete-form').addEventListener('submit', function(event) {
            var confirmation = confirm("Möchten Sie wirklich Ihr Konto löschen?");
            if (!confirmation) {
                event.preventDefault();
            }
        });
    </script>

</body>

</html>