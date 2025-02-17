<?php
//Datenbank verbindung herstellen
include '../database/connection.php';
//Start der Session
//Sessions initialisieren wenn noch nicht gemacht
include '../comps/sessioncheck.php';
//Schaue ob der Benuzter eingelogt ist
include '../comps/usercheck.php';
//Datenbank Logik einbinden -- POST Requests an die Datenbank + Backend Logik
include '../database/db_viewuploads.php';
?>

<!-- Frontend & Database Display -->
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
