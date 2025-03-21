<?php

// Benutzerinformationen aus der Datenbank abrufen
$userId = $_SESSION['UserID'];

// Debugging: Überprüfen der Benutzer-ID
if (!$userId) {
    die("Benutzer-ID nicht gefunden in der Session.");
}

$query = "
SELECT
k.Vorname,
k.Nachname,
a.Strasse,
a.Hausnummer,
a.Postleitzahl,
a.Stadt,
a.Land,
k.Telefon,
k.AdresseID,
k.Status
FROM
kunde k
JOIN
adresse a ON k.AdresseID = a.AdresseID
WHERE
k.KundenID = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId); // bind_param fügt die userId an der stelle vom ? in der query ein
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Debugging: Überprüfen der Abfrage und der Ergebnisse
if (!$user) {
    $firstName = '';
    $lastName = '';
    $address = '';
    $houseNumber = '';
    $zipcode = '';
    $city = '';
    $country = '';
    $phone = '';
    $addressId = null;
    $state = '';
} else {
    $firstName = $user['Vorname'];
    $lastName = $user['Nachname'];
    $address = $user['Strasse'];
    $houseNumber = $user['Hausnummer'];
    $zipcode = $user['Postleitzahl'];
    $city = $user['Stadt'];
    $country = $user['Land'];
    $phone = $user['Telefon'];
    $addressId = $user['AdresseID'];
    $state = $user['Status'];
}

// Länder aus der Datenbank abrufen
$countriesQuery = "SELECT DISTINCT Land FROM adresse ORDER BY Land";
$countriesResult = $conn->query($countriesQuery);
$countries = [];
while ($row = $countriesResult->fetch_assoc()) {
    $countries[] = $row['Land'];
}

// Verarbeiten der POST-Daten zum Aktualisieren der Benutzerinformationen
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Überprüfen, ob der Benutzer sein Konto löschen möchte;
    // Atttribut name im input feld ist _method und der Wert ist DELETE
    if (isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
        // Löschen des Benutzerkontos
        $deleteUserQuery = "
UPDATE kunde
SET Status = ?
WHERE KundenID = ?";

        $state = 'gelöscht';

        $stmt = $conn->prepare($deleteUserQuery);
        $stmt->bind_param("si", $state, $userId);
        $stmt->execute();
        $stmt->close();

        // Session-Varable UserID löschen
        unset($_SESSION['UserID']);

        header("Location: register.php");
        exit();
    } else {
        $newFirstName = $_POST['Vorname'];
        $newLastName = $_POST['Nachname'];
        $newAddress = $_POST['Strasse'];
        $newHouseNumber = $_POST['Hausnummer'];
        $newZipcode = $_POST['Postleitzahl'];
        $newCity = $_POST['Stadt'];
        $newCountry = $_POST['Land'];
        $newPhone = $_POST['Telefon'];

        // Update des Vor- und Nachnamens
        $updateFirstAndLastNameQuery = "
UPDATE kunde
SET Vorname = ?, Nachname = ?
WHERE KundenID = ?";

        $stmt = $conn->prepare($updateFirstAndLastNameQuery);
        $stmt->bind_param("ssi", $newFirstName, $newLastName, $userId);
        $stmt->execute();

        if ($addressId) {
            // Update der Adresse
            $updateAddressQuery = "
UPDATE adresse
SET Strasse = ?, Hausnummer = ?, Postleitzahl = ?, Stadt = ?, Land = ?
WHERE AdresseID = ?
";
            $stmt = $conn->prepare($updateAddressQuery);
            $stmt->bind_param("sssssi", $newAddress, $newHouseNumber, $newZipcode, $newCity, $newCountry, $addressId);
            $stmt->execute();
        }

        // Update der Telefonnummer
        $updatePhoneQuery = "
UPDATE kunde
SET Telefon = ?
WHERE KundenID = ?
";
        $stmt = $conn->prepare($updatePhoneQuery);
        $stmt->bind_param("si", $newPhone, $userId);
        $stmt->execute();

        // Seite neu laden, um die aktualisierten Daten anzuzeigen
        header("Location: user_profile.php");
        exit();
    }
}
?>