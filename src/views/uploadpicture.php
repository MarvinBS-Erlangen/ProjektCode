<?php
// Verbindung zur Datenbank herstellen
include '../database/connection.php';

// Session starten, falls noch nicht gestartet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// BenutzerID aus der Session abrufen
$userID = $_SESSION['UserID'] ?? null;

// if ($userID === null) {
//     echo "<p style='color: red;'>Benutzer ist nicht eingeloggt.</p>";
//     exit;
// }


// Bild hochladen und speichern
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload'])) {
    $titel = $_POST['titel'];
    $bildurl = $_POST['bildurl'];
    $userID = $_POST['user_id'];

    // Validierung der Bild-URL
    if (filter_var($bildurl, FILTER_VALIDATE_URL)) {
        $sql = "INSERT INTO Bild (KundenID, Bilddatei, Titel) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $KundenID, $bildurl, $titel);
        $stmt->execute();

        echo "Bild erfolgreich hochgeladen.";
    } else {
        echo "Fehler: Bitte geben Sie eine gültige Bild-URL ein.";
    }
}
?>

<h1>Bild hochladen</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="titel">Titel:</label>
            <input type="text" name="titel" id="titel" required><br>

            <label for="bildurl">Bild-URL:</label>
            <input type="url" name="bildurl" id="bildurl" required><br>

            <button type="submit" name="upload">Bild hochladen</button>
        </form>
