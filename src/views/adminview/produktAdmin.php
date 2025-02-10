<?php
// Admin check Script aufrufen
include '../../comps/admincheck.php';
// Verbindung zur Datenbank herstellen
include '../../database/connection.php';

// Verarbeitung des Post-Requests zum Hinzufügen oder Löschen eines Produkts
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_product'])) {
        $produktname = $_POST['produktname'] ?? '';
        $beschreibung = $_POST['beschreibung'] ?? '';
        $preis = $_POST['preis'] ?? 0.00;
        $energiewert = $_POST['energiewert'] ?? NULL;
        $bildurl = $_POST['bildurl'] ?? '';

        // Validierung
        if (empty($produktname) || empty($preis) || empty($bildurl)) {
            echo "<p style='color: red;'>Produktname, Preis und Bild URL sind Pflichtfelder.</p>";
        } else {
            // SQL-Befehl zum Einfügen eines Produkts
            $sql = "INSERT INTO produkt (Produktname, Beschreibung, Preis, Energiewert, BildURL) 
                    VALUES (?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdss", $produktname, $beschreibung, $preis, $energiewert, $bildurl);
            $stmt->execute();
            echo "<p style='color: green;'>Produkt erfolgreich hinzugefügt.</p>";
        }
    } elseif (isset($_POST['delete_product'])) {
        $produktID = $_POST['produkt_id'];

        // SQL-Befehl zum Löschen eines Produkts
        $sql = "DELETE FROM produkt WHERE ProduktID = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $produktID);
        $stmt->execute();
        echo "<p style='color: green;'>Produkt erfolgreich gelöscht.</p>";
    }
}

// Abrufen der existierenden Produkte
$sql = "SELECT ProduktID, Produktname, Beschreibung, Preis, Energiewert, BildURL FROM produkt";
$result = $conn->query($sql);
$produkte = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Produkt hinzufügen</title>
</head>
<body>
    <h1>Produkt hinzufügen</h1>
    <form method="POST" action="produktAdmin.php">
        <input type="hidden" name="add_product" value="1">
        <label for="produktname">Produktname:</label>
        <input type="text" id="produktname" name="produktname" required><br><br>
        
        <label for="beschreibung">Beschreibung:</label>
        <textarea id="beschreibung" name="beschreibung"></textarea><br><br>
        
        <label for="preis">Preis:</label>
        <input type="number" id="preis" name="preis" step="0.01" required><br><br>
        
        <label for="energiewert">Energiewert:</label>
        <input type="number" id="energiewert" name="energiewert"><br><br>
        
        <label for="bildurl">Bild URL:</label>
        <input type="text" id="bildurl" name="bildurl" required><br><br>
        
        <button type="submit">Produkt hinzufügen</button>
    </form>

    <h2>Existierende Produkte</h2>
    <table border="1">
        <tr>
            <th>ProduktID</th>
            <th>Produktname</th>
            <th>Beschreibung</th>
            <th>Preis</th>
            <th>Energiewert</th>
            <th>Bild</th>
            <th>Aktion</th>
        </tr>
        <?php foreach ($produkte as $produkt): ?>
        <tr>
            <td><?php echo htmlspecialchars($produkt['ProduktID']); ?></td>
            <td><?php echo htmlspecialchars($produkt['Produktname']); ?></td>
            <td><?php echo htmlspecialchars($produkt['Beschreibung']); ?></td>
            <td><?php echo htmlspecialchars($produkt['Preis']); ?></td>
            <td><?php echo htmlspecialchars($produkt['Energiewert']); ?></td>
            <td><img src="<?php echo htmlspecialchars($produkt['BildURL']); ?>" alt="<?php echo htmlspecialchars($produkt['Produktname']); ?>" width="100"></td>
            <td>
                <form method="POST" action="produktAdmin.php" style="display:inline;" onsubmit="return confirm('Sind Sie sicher, dass Sie dieses Produkt löschen möchten?');">
                    <input type="hidden" name="delete_product" value="1">
                    <input type="hidden" name="produkt_id" value="<?php echo htmlspecialchars($produkt['ProduktID']); ?>">
                    <button type="submit">Löschen</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>