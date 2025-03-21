

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

// Bestellungen vom User abrufen
include '../database/db_user_orders.php';
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
    <script src="../handlers/validation_user_profile.js" defer></script>
    <title>Benutzerprofil</title>
</head>

<body>

    <?php include './partials/header.php'; ?>

    <main class="main">
        <div class="profile-container">
            <!-- Linke Seite: Benutzerprofil -->
            <div class="profile-info">
                <h2>Profilinformationen</h2>
                <div class="profile-data">
                    <form method="POST" action="user_profile.php" id="profile-form">
                        <label for="Vorname">Vorname</label>
                        <input type="text" id="Vorname" name="Vorname" value="<?php echo htmlspecialchars($firstName); ?>" disabled>
                        <span class="error-message inaktiv"></span>

                        <label for="Nachname">Nachname</label>
                        <input type="text" id="Nachname" name="Nachname" value="<?php echo htmlspecialchars($lastName); ?>" disabled>
                        <span class="error-message inaktiv"></span>

                        <label for="Strasse">Straße</label>
                        <div class="address-container">
                            <input type="text" id="Strasse" name="Strasse" value="<?php echo htmlspecialchars($address); ?>" disabled>
                            <span class="error-message inaktiv"></span>
                            <label for="Hausnummer">Hausnummer</label>
                            <input type="text" id="Hausnummer" name="Hausnummer" value="<?php echo htmlspecialchars($houseNumber); ?>" disabled>
                            <span class="error-message inaktiv"></span>
                        </div>

                        <label for="Postleitzahl">PLZ</label>
                        <input type="text" id="Postleitzahl" name="Postleitzahl" value="<?php echo htmlspecialchars($zipcode); ?>" disabled>
                        <span class="error-message inaktiv"></span>

                        <label for="Stadt">Stadt</label>
                        <input type="text" id="Stadt" name="Stadt" value="<?php echo htmlspecialchars($city); ?>" disabled>
                        <span class="error-message inaktiv"></span>

                        <label for="Land">Land</label>
                        <select id="Land" name="Land" disabled>
                            <?php foreach ($countries as $countryOption): ?>
                                <option value="<?php echo htmlspecialchars($countryOption); ?>" <?php echo $countryOption === $country ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($countryOption); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="error-message inaktiv"></span>

                        <label for="Telefon">Telefonnummer</label>
                        <input type="text" id="Telefon" name="Telefon" value="<?php echo htmlspecialchars($phone); ?>" disabled>
                        <span class="error-message inaktiv"></span>
                        <br>

                        <button type="button" id="edit-btn">Bearbeiten</button>
                        <button type="submit" id="save-btn" class="hidden">Speichern</button>
                        <button type="button" id="cancel-btn" class="hidden">Abbrechen</button>
                    </form>
                </div>

                <div class="delete-account-container">
                    <!-- The form method is POST because HTML forms do not support the DELETE method directly -->
                    <form method="POST" action="user_profile.php" id="delete-form">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" id="delete-account-btn">Konto löschen</button>
                    </form>
                </div>

            </div>

            <!-- Rechte Seite: Bestellhistorie -->
            <div class="order-history">
                <h2>Vorherige Bestellungen</h2>
                <div id="orders-container">
                    <div id="orders">
                        <?php if (!empty($orders)): ?>
                            <?php foreach ($orders as $order): ?>
                                <div class="order-item">
                                    <div class="order-header">
                                        <p class="bestell-id">
                                            <strong>Bestell-ID:</strong> <?php echo htmlspecialchars($order['BestellID']); ?>
                                        </p>
                                        <p class="bestelldatum">
                                            <strong>Bestelldatum:</strong>
                                            <br> <?php echo htmlspecialchars($order['Bestelldatum']), ' Uhr';
                                                    ?>
                                        </p>
                                    </div>
                                    <div class="order-details">
                                        <p class="gesamtbetrag">
                                            <strong>Gesamtbetrag:</strong> <?php echo htmlspecialchars($order['Gesamtbetrag']); ?> €
                                        </p>
                                        <p class="zahlungsart">
                                            <strong>Zahlungsart:</strong> <?php echo htmlspecialchars($order['Zahlungsart']); ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Es wurden keine Bestellungen gefunden.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>




        </div>
    </main>



    <?php include './partials/footer.php'; ?>

    <script>
        document.getElementById('edit-btn').addEventListener('click', function() {
            document.querySelectorAll('.profile-info input, .profile-info select').forEach(function(input) {
                input.disabled = false;
            });
            document.getElementById('edit-btn').classList.add('hidden');
            document.getElementById('save-btn').classList.remove('hidden');
            document.getElementById('cancel-btn').classList.remove('hidden');
        });

        document.getElementById('cancel-btn').addEventListener('click', function() {
            document.querySelectorAll('.profile-info input, .profile-info select').forEach(function(input) {
                input.disabled = true;
            });
            document.getElementById('edit-btn').classList.remove('hidden');
            document.getElementById('save-btn').classList.add('hidden');
            document.getElementById('cancel-btn').classList.add('hidden');
        });

        // deaktivierte input felder aktivieren, wenn das Formular abgeschickt wird, damit daten aktualisiert werden können
        document.getElementById('profile-form').addEventListener('submit', function() {
            document.querySelectorAll('.profile-info input, .profile-info select').forEach(function(input) {
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