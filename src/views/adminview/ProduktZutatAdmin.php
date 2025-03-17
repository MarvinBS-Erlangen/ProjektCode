<?php
//Datenbank verbindung herstellen
include '../../database/connection.php';
//Start der Session
//Sessions initialisieren wenn noch nicht gemacht
include '../../comps/sessioncheck.php';
// Admin check Script aufrufen
include '../../comps/admincheck.php';

// Verarbeitung des Formulars zum Zuweisen oder Löschen einer Zutat zu einem Produkt
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['assign_zutat'])) {
        $produktID = $_POST['produkt_id'] ?? '';
        $zutatID = $_POST['zutat_id'] ?? '';

        // Validierung
        if (empty($produktID) || empty($zutatID)) {
            echo "<p style='color: red;'>Produkt und Zutat sind Pflichtfelder.</p>";
        } else {
            // Überprüfen, ob die Zuweisung bereits existiert
            $sql = "SELECT * FROM Produkt_Zutat WHERE ProduktID = ? AND ZutatID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $produktID, $zutatID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<p style='color: red;'>Diese Zutat ist diesem Produkt bereits zugewiesen.</p>";
            } else {
                // SQL-Befehl zum Zuweisen einer Zutat zu einem Produkt
                $sql = "INSERT INTO Produkt_Zutat (ProduktID, ZutatID) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $produktID, $zutatID);
                $stmt->execute();
                echo "<p style='color: green;'>Zutat erfolgreich zugewiesen.</p>";
            }
        }
    } elseif (isset($_POST['delete_assignment'])) {
        $produktID = $_POST['produkt_id'];
        $zutatID = $_POST['zutat_id'];

        // SQL-Befehl zum Löschen einer Zuweisung
        $sql = "DELETE FROM Produkt_Zutat WHERE ProduktID = ? AND ZutatID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $produktID, $zutatID);
        $stmt->execute();
        echo "<p style='color: green;'>Zuweisung erfolgreich gelöscht.</p>";
    }
}

// Abrufen der existierenden Produkte
$sql = "SELECT ProduktID, Produktname FROM produkt";
$result = $conn->query($sql);
$produkte = $result->fetch_all(MYSQLI_ASSOC);

// Abrufen der existierenden Zutaten
$sql = "SELECT ZutatID, Zutatenname FROM Zutat";
$result = $conn->query($sql);
$zutaten = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Produkt-Zutat Zuweisung</title>
</head>
<body>
    <h1>Produkt-Zutat Zuweisung</h1>
    <form method="POST" action="ProduktZutatAdmin.php">
        <input type="hidden" name="assign_zutat" value="1">
        <label for="produkt_id">Produkt:</label>
        <select id="produkt_id" name="produkt_id" required>
            <option value="">Wählen Sie ein Produkt</option>
            <?php foreach ($produkte as $produkt): ?>
                <option value="<?php echo htmlspecialchars($produkt['ProduktID']); ?>">
                    <?php echo htmlspecialchars($produkt['Produktname']); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>
        
        <label for="zutat_id">Zutat:</label>
        <select id="zutat_id" name="zutat_id" required>
            <option value="">Wählen Sie eine Zutat</option>
            <?php foreach ($zutaten as $zutat): ?>
                <option value="<?php echo htmlspecialchars($zutat['ZutatID']); ?>">
                    <?php echo htmlspecialchars($zutat['Zutatenname']); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>
        
        <button type="submit">Zutat zuweisen</button>
    </form>

    <h2>Existierende Produkt-Zutat Zuweisungen</h2>
    <table border="1">
        <tr>
            <th>ProduktID</th>
            <th>Produktname</th>
            <th>Zutatenname</th>
            <th>Aktion</th>
        </tr>
        <?php
        // Abrufen der existierenden Produkt-Zutat Zuweisungen
        $sql = "SELECT p.ProduktID, p.Produktname, z.Zutatenname, pz.ZutatID 
                FROM Produkt_Zutat pz
                JOIN produkt p ON pz.ProduktID = p.ProduktID
                JOIN Zutat z ON pz.ZutatID = z.ZutatID
                ORDER BY p.ProduktID";
        $result = $conn->query($sql);
        $zuweisungen = $result->fetch_all(MYSQLI_ASSOC);

        foreach ($zuweisungen as $zuweisung): ?>
            <tr>
                <td><?php echo htmlspecialchars($zuweisung['ProduktID']); ?></td>
                <td><?php echo htmlspecialchars($zuweisung['Produktname']); ?></td>
                <td><?php echo htmlspecialchars($zuweisung['Zutatenname']); ?></td>
                <td>
                    <form method="POST" action="ProduktZutatAdmin.php" style="display:inline;" onsubmit="return confirm('Sind Sie sicher, dass Sie diese Zuweisung löschen möchten?');">
                        <input type="hidden" name="delete_assignment" value="1">
                        <input type="hidden" name="produkt_id" value="<?php echo htmlspecialchars($zuweisung['ProduktID']); ?>">
                        <input type="hidden" name="zutat_id" value="<?php echo htmlspecialchars($zuweisung['ZutatID']); ?>">
                        <button type="submit">Zuweisung löschen</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>