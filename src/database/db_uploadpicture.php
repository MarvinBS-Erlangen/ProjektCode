<?php
// BenutzerID aus der Session abrufen
$userID = $_SESSION['UserID'] ?? null;

// Bild hochladen und speichern
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload'])) {
    $titel = $_POST['titel'];
    $bildurl = $_POST['bildurl'];

    // Validierung der Bild-URL
    if (filter_var($bildurl, FILTER_VALIDATE_URL)) {
        $sql = "INSERT INTO Bild (KundenID, Bilddatei, Titel) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $userID, $bildurl, $titel);
        $stmt->execute();

        echo "Bild erfolgreich hochgeladen.";
    } else {
        echo "Fehler: Bitte geben Sie eine gültige Bild-URL ein.";
    }
}
?>