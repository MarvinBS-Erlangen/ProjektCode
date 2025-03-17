<?php
//Datenbank verbindung herstellen
include '../../database/connection.php';
//Start der Session
//Sessions initialisieren wenn noch nicht gemacht
include '../../comps/sessioncheck.php';
// Admin check Script aufrufen
include '../../comps/admincheck.php';

// Verarbeitung des Post-Requests zum Hinzufügen oder Löschen eines Menüs
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_menu'])) {
        $menuename = $_POST['menuename'] ?? '';
        $beschreibung = $_POST['beschreibung'] ?? '';
        $bildurl = $_POST['bildurl'] ?? '';

        // Validierung
        if (empty($menuename) || empty($bildurl)) {
            echo "<p style='color: red;'>Menuename und Bild URL sind Pflichtfelder.</p>";
        } else {
            // SQL-Befehl zum Einfügen eines Menüs
            $sql = "INSERT INTO menue (Menuename, Beschreibung, BildURL) 
                    VALUES (?, ?, ?)";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $menuename, $beschreibung, $bildurl);
            $stmt->execute();
            echo "<p style='color: green;'>Menü erfolgreich hinzugefügt.</p>";
        }
    } elseif (isset($_POST['delete_menu'])) {
        $menueID = $_POST['menue_id'];

        // SQL-Befehl zum Löschen eines Menüs
        $sql = "DELETE FROM menue WHERE MenueID = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $menueID);
        $stmt->execute();
        echo "<p style='color: green;'>Menü erfolgreich gelöscht.</p>";
    }
}

// Abrufen der existierenden Menüs
$sql = "SELECT MenueID, Menuename, Beschreibung, BildURL FROM menue";
$result = $conn->query($sql);
$menues = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Menü hinzufügen</title>
</head>
<body>
    <h1>Menü hinzufügen</h1>
    <form method="POST" action="MenueAdmin.php">
        <input type="hidden" name="add_menu" value="1">
        <label for="menuename">Menuename:</label>
        <input type="text" id="menuename" name="menuename" required><br><br>
        
        <label for="beschreibung">Beschreibung:</label>
        <textarea id="beschreibung" name="beschreibung"></textarea><br><br>
        
        <label for="bildurl">Bild URL:</label>
        <input type="text" id="bildurl" name="bildurl" required><br><br>
        
        <button type="submit">Menü hinzufügen</button>
    </form>

    <h2>Existierende Menüs</h2>
    <table border="1">
        <tr>
            <th>MenueID</th>
            <th>Menuename</th>
            <th>Beschreibung</th>
            <th>Bild</th>
            <th>Aktion</th>
        </tr>
        <?php foreach ($menues as $menue): ?>
        <tr>
            <td><?php echo htmlspecialchars($menue['MenueID']); ?></td>
            <td><?php echo htmlspecialchars($menue['Menuename']); ?></td>
            <td><?php echo htmlspecialchars($menue['Beschreibung']); ?></td>
            <td><img src="<?php echo htmlspecialchars($menue['BildURL']); ?>" alt="<?php echo htmlspecialchars($menue['Menuename']); ?>" width="100"></td>
            <td>
                <form method="POST" action="MenueAdmin.php" style="display:inline;" onsubmit="return confirm('Sind Sie sicher, dass Sie dieses Menü löschen möchten?');">
                    <input type="hidden" name="delete_menu" value="1">
                    <input type="hidden" name="menue_id" value="<?php echo htmlspecialchars($menue['MenueID']); ?>">
                    <button type="submit">Löschen</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>