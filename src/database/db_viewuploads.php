<?php
// BenutzerID aus der Session abrufen
$userID = $_SESSION['UserID'] ?? null;

// Überprüfen, ob der Benutzer eine Löschanforderung gestellt hat
if (isset($_GET['delete_id'])) {
    $bildID = $_GET['delete_id'];

    // Bild löschen
    $sqlDelete = "DELETE FROM Bild WHERE BildID = ? AND KundenID = ?";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bind_param("ii", $bildID, $userID);
    $stmtDelete->execute();

    // Erfolgs- oder Fehlermeldung
    if ($stmtDelete->affected_rows > 0) {
        $_SESSION['success_message_pic'] = "Bild wurde erfolgreich gelöscht.";
    } else {
        $_SESSION['error_message_pic'] = "Fehler beim Löschen des Bildes.";
    }

    // Weiterleitung, um die URL zu bereinigen
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Abrufen der Bilder des eingeloggten Benutzers
$sql = "SELECT BildID, Bilddatei, Titel, Hochladedatum, Freigabestatus FROM Bild WHERE KundenID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$bilder = $result->fetch_all(MYSQLI_ASSOC);
?>

