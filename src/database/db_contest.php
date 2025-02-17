<?php
// BenutzerID aus der Session abrufen
$userID = $_SESSION['UserID'] ?? null;

// Bewertung speichern oder deaktivieren
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bewerten'])) {
    $bildID = $_POST['bild_id'];

    // Überprüfen, ob der Benutzer bereits eine Bewertung für dieses Bild abgegeben hat
    $sql = "SELECT * FROM Bewertung WHERE BildID = ? AND KundenID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $bildID, $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Bewertung aktivieren oder deaktivieren
        $bewertung = $result->fetch_assoc();
        $istAktiv = $bewertung['IstAktiv'] ? 0 : 1;
        $sql = "UPDATE Bewertung SET IstAktiv = ? WHERE BildID = ? AND KundenID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $istAktiv, $bildID, $userID);
        $stmt->execute();

        echo json_encode(['status' => $istAktiv ? 'activated' : 'deactivated']);
    } else {
        // Neue Bewertung einfügen
        $sql = "INSERT INTO Bewertung (BildID, KundenID, IstAktiv) VALUES (?, ?, 1)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $bildID, $userID);
        $stmt->execute();

        echo json_encode(['status' => 'activated']);
    }
    exit;
}
?>