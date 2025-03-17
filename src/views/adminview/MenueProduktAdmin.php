<?php
//Datenbank verbindung herstellen
include '../../database/connection.php';
//Start der Session
//Sessions initialisieren wenn noch nicht gemacht
include '../../comps/sessioncheck.php';
// Admin check Script aufrufen
include '../../comps/admincheck.php';

// Funktion zum Aktualisieren des NormalPreises und DiscountPreises eines Menüs
function updateNormalPreis($conn, $menueID) {
    $sql = "SELECT SUM(p.Preis * mp.Menge) AS NormalPreis
            FROM Menue_Produkt mp
            JOIN produkt p ON mp.ProduktID = p.ProduktID
            WHERE mp.MenueID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $menueID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $normalPreis = $row['NormalPreis'] ?? 0;

    // DiscountPreis berechnen: -15% Endend auf eine xx.x9 Value fuer besser Darstellung
    $discountPreis = $normalPreis * 0.85;
    $discountPreis = floor($discountPreis * 10) / 10 + 0.09;

    $sql = "UPDATE menue SET NormalPreis = ?, DiscountPreis = ? WHERE MenueID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ddi", $normalPreis, $discountPreis, $menueID);
    $stmt->execute();
}

// Verarbeitung des Formulars zum Zuweisen oder Löschen eines Produkts zu einem Menü
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['assign_product'])) {
        $menueID = $_POST['menue_id'] ?? '';
        $produktID = $_POST['produkt_id'] ?? '';
        $menge = $_POST['menge'] ?? 1;

        // Validierung
        if (empty($menueID) || empty($produktID) || empty($menge)) {
            echo "<p style='color: red;'>Menü, Produkt und Menge sind Pflichtfelder.</p>";
        } else {
            // Überprüfen, ob die Zuweisung bereits existiert
            $sql = "SELECT * FROM Menue_Produkt WHERE MenueID = ? AND ProduktID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $menueID, $produktID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Wenn die Zuweisung bereits existiert, Anzahl erhöhen
                $sql = "UPDATE Menue_Produkt SET Menge = ? WHERE MenueID = ? AND ProduktID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iii", $menge, $menueID, $produktID);
                $stmt->execute();
                echo "<p style='color: green;'>Anzahl des Produkts im Menü erfolgreich gesetzt.</p>";
            } else {
                // SQL-Befehl zum Zuweisen eines Produkts zu einem Menü
                $sql = "INSERT INTO Menue_Produkt (MenueID, ProduktID, Menge) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iii", $menueID, $produktID, $menge);
                $stmt->execute();
                echo "<p style='color: green;'>Produkt erfolgreich zugewiesen.</p>";
            }

            // NormalPreis und DiscountPreis des Menüs aktualisieren
            updateNormalPreis($conn, $menueID);
        }
    } elseif (isset($_POST['delete_assignment'])) {
        $menueID = $_POST['menue_id'];
        $produktID = $_POST['produkt_id'];

        // SQL-Befehl zum Löschen einer Zuweisung
        $sql = "DELETE FROM Menue_Produkt WHERE MenueID = ? AND ProduktID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $menueID, $produktID);
        $stmt->execute();
        echo "<p style='color: green;'>Zuweisung erfolgreich gelöscht.</p>";

        // NormalPreis und DiscountPreis des Menüs aktualisieren
        updateNormalPreis($conn, $menueID);
    } elseif (isset($_POST['reset_quantity'])) {
        $menueID = $_POST['menue_id'];
        $produktID = $_POST['produkt_id'];

        // SQL-Befehl zum Zurücksetzen der Menge auf 1
        $sql = "UPDATE Menue_Produkt SET Menge = 1 WHERE MenueID = ? AND ProduktID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $menueID, $produktID);
        $stmt->execute();
        echo "<p style='color: green;'>Menge erfolgreich auf 1 gesetzt.</p>";

        // NormalPreis und DiscountPreis des Menüs aktualisieren
        updateNormalPreis($conn, $menueID);
    }
}

// Abrufen der existierenden Menüs
$sql = "SELECT MenueID, Menuename FROM menue";
$result = $conn->query($sql);
$menues = $result->fetch_all(MYSQLI_ASSOC);

// Abrufen der existierenden Produkte
$sql = "SELECT ProduktID, Produktname FROM produkt";
$result = $conn->query($sql);
$produkte = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Menü-Produkt Zuweisung</title>
</head>
<body>
    <h1>Menü-Produkt Zuweisung</h1>
    <form method="POST" action="MenueProduktAdmin.php">
        <input type="hidden" name="assign_product" value="1">
        <label for="menue_id">Menü:</label>
        <select id="menue_id" name="menue_id" required>
            <option value="">Wählen Sie ein Menü</option>
            <?php foreach ($menues as $menue): ?>
                <option value="<?php echo htmlspecialchars($menue['MenueID']); ?>">
                    <?php echo htmlspecialchars($menue['Menuename']); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>
        
        <label for="produkt_id">Produkt:</label>
        <select id="produkt_id" name="produkt_id" required>
            <option value="">Wählen Sie ein Produkt</option>
            <?php foreach ($produkte as $produkt): ?>
                <option value="<?php echo htmlspecialchars($produkt['ProduktID']); ?>">
                    <?php echo htmlspecialchars($produkt['Produktname']); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>
        
        <label for="menge">Menge:</label>
        <input type="number" id="menge" name="menge" value="1" min="1" required><br><br>
        
        <button type="submit">Produkt zuweisen</button>
    </form>

    <h2>Existierende Menü-Produkt Zuweisungen</h2>
    <table border="1">
        <tr>
            <th>MenueID</th>
            <th>Menuename</th>
            <th>Produktname</th>
            <th>Menge</th>
            <th>Aktion</th>
        </tr>
        <?php
        // Abrufen der existierenden Menü-Produkt Zuweisungen
        $sql = "SELECT m.MenueID, m.Menuename, p.Produktname, mp.ProduktID, mp.Menge
                FROM Menue_Produkt mp
                JOIN menue m ON mp.MenueID = m.MenueID
                JOIN produkt p ON mp.ProduktID = p.ProduktID
                ORDER BY m.MenueID";
        $result = $conn->query($sql);
        $zuweisungen = $result->fetch_all(MYSQLI_ASSOC);

        foreach ($zuweisungen as $zuweisung): ?>
            <tr>
                <td><?php echo htmlspecialchars($zuweisung['MenueID']); ?></td>
                <td><?php echo htmlspecialchars($zuweisung['Menuename']); ?></td>
                <td><?php echo htmlspecialchars($zuweisung['Produktname']); ?></td>
                <td><?php echo htmlspecialchars($zuweisung['Menge']); ?></td>
                <td>
                    <form method="POST" action="MenueProduktAdmin.php" style="display:inline;" onsubmit="return confirm('Sind Sie sicher, dass Sie diese Zuweisung löschen möchten?');">
                        <input type="hidden" name="delete_assignment" value="1">
                        <input type="hidden" name="menue_id" value="<?php echo htmlspecialchars($zuweisung['MenueID']); ?>">
                        <input type="hidden" name="produkt_id" value="<?php echo htmlspecialchars($zuweisung['ProduktID']); ?>">
                        <button type="submit">Zuweisung löschen</button>
                    </form>
                    <form method="POST" action="MenueProduktAdmin.php" style="display:inline;" onsubmit="return confirm('Sind Sie sicher, dass Sie die Menge auf 1 setzen möchten?');">
                        <input type="hidden" name="reset_quantity" value="1">
                        <input type="hidden" name="menue_id" value="<?php echo htmlspecialchars($zuweisung['MenueID']); ?>">
                        <input type="hidden" name="produkt_id" value="<?php echo htmlspecialchars($zuweisung['ProduktID']); ?>">
                        <button type="submit">Menge auf 1 setzen</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>