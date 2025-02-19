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

// Benutzerinformationen aus der Datenbank abrufen
$userId = $_SESSION['UserID'];
$query = "
    SELECT
        k.Vorname AS firstName,
        k.Nachname AS lastName,
        a.Strasse AS address,
        a.Hausnummer AS houseNumber,
        a.Postleitzahl AS zipcode,
        a.Stadt AS city,
        a.Land AS country,
        k.Telefon AS phone
    FROM
        kunde k
    JOIN
        adresse a ON k.AdresseID = a.AdresseID
    WHERE
        k.KundenID = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$firstName = $user['firstName'];
$lastName = $user['lastName'];
$address = $user['address'];
$houseNumber = $user['houseNumber'];
$zipcode = $user['zipcode'];
$city = $user['city'];
$country = $user['country'];
$phone = $user['phone'];
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
                <label for="firstname">Vorname</label>
                <input type="text" id="firstname" value="<?php echo htmlspecialchars($firstName); ?>" disabled>

                <label for="lastname">Nachname</label>
                <input type="text" id="lastname" value="<?php echo htmlspecialchars($lastName); ?>" disabled>

                <label for="address">Adresse</label>
                <div class="address-container">
                    <input type="text" id="address" value="<?php echo htmlspecialchars($address); ?>" disabled>
                    <input type="text" id="house-number" value="<?php echo htmlspecialchars($houseNumber); ?>" disabled>
                </div>

                <label for="zipcode">PLZ</label>
                <input type="text" id="zipcode" value="<?php echo htmlspecialchars($zipcode); ?>" disabled>

                <label for="city">Stadt</label>
                <input type="text" id="city" value="<?php echo htmlspecialchars($city); ?>" disabled>

                <label for="country">Land</label>
                <input type="text" id="country" value="<?php echo htmlspecialchars($country); ?>" disabled>

                <label for="phone">Telefonnummer</label>
                <input type="text" id="phone" value="<?php echo htmlspecialchars($phone); ?>" disabled>

                <button id="edit-btn">Bearbeiten</button>
                <button id="save-btn" class="hidden">Speichern</button>
                <button id="cancel-btn" class="hidden">Abbrechen</button>
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

    <?php include './partials/footer.php'; ?>

</body>

</html>
