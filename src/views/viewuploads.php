<?php
// Verbindung zur Datenbank herstellen
include '../database/connection.php';

// Session starten, falls noch nicht gestartet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// BenutzerID aus der Session abrufen
$userID = $_SESSION['UserID'] ?? null;

if ($userID === null) {
    echo "<p style='color: red;'>Benutzer ist nicht eingeloggt.</p>";
    exit;
}

// Abrufen der Bilder des eingeloggten Benutzers
$sql = "SELECT Bilddatei, Titel, Hochladedatum, Freigabestatus FROM bild WHERE KundenID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$bilder = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Hochgeladene Bilder anzeigen</title>
</head>
<body>
    <h1>Hochgeladene Bilder</h1>
    <?php if (empty($bilder)): ?>
        <p>Keine Bilder gefunden.</p>
    <?php else: ?>
        <table border="1">
            <tr>
                <th>Bild</th>
                <th>Titel</th>
                <th>Hochladedatum</th>
                <th>Freigabestatus</th>
            </tr>
            <?php foreach ($bilder as $bild):
            // Freigabestatus des Bildes bestimmen
                if ($bild['Freigabestatus'] === 1) {
                    $Freigabestatus = "Freigegeben";
                } else {
                    $Freigabestatus = "Nicht freigegeben";  
                }?>
                <tr>
                    <td><img src="<?php echo htmlspecialchars($bild['Bilddatei']); ?>" alt="<?php echo htmlspecialchars($bild['Titel']); ?>" width="100"></td>
                    <td><?php echo htmlspecialchars($bild['Titel']); ?></td>
                    <td><?php echo htmlspecialchars($bild['Hochladedatum']); ?></td>
                    <td><?php echo htmlspecialchars($Freigabestatus); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>