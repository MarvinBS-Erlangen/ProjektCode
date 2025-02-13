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

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/reset.css">
    <link rel="stylesheet" href="../public/styles/index.css">
    <link rel="stylesheet" href="../public/styles/uploadpicture.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/header.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="../handlers/upload-picture-handler.js" defer></script>
    <title>Bild-Upload</title>
</head>

<body>

    <main class="main">
    <div class="upload-container">
        <h1>Bild hochladen</h1>

        <input type="text" id="title" placeholder="Titel eingeben">
        <input type="text" id="image-url" placeholder="Bild-URL eingeben">
        <div class="upload-buttons">
            <button class="upload-button preview-button">Vorschau</button>
            <button class="upload-button upload-submit">Upload</button>
        </div>

        <div class="preview hidden" id="preview">
            <img id="preview-image" src="" alt="Vorschau">
            <h2 id="preview-title"></h2>
        </div>
    </div>
    </main>
</body>

</html>
