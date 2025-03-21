<?php
// Datenbankverbindung herstellen
include '../../database/connection.php';
// Start der Session
// Sessions initialisieren, falls noch nicht gemacht
include '../../comps/sessioncheck.php';
// Admin check Script aufrufen
include '../../comps/admincheck.php';

// Verarbeitung des Post-Requests zum Ändern des Status einer Bestellung
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $bestellID = $_POST['bestell_id'];
    $status = $_POST['status'];

    // SQL-Befehl zum Aktualisieren des Status einer Bestellung
    $sql = "UPDATE bestellung SET Status = ? WHERE BestellID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $bestellID);
    $stmt->execute();
    echo "<p style='color: green;'>Status erfolgreich aktualisiert.</p>";

    // Wenn der Status auf "Abgeschlossen" geändert wurde, erstellen wir eine Rechnung
    if ($status === 'Abgeschlossen') {
        // Abrufen der Bestellinformationen (nur die notwendigen Spalten)
        $sql = "SELECT BestellID, Gesamtbetrag FROM bestellung WHERE BestellID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $bestellID);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $bestellung = $result->fetch_assoc();

            // Erstellen einer neuen Rechnung (nur die relevanten Spalten befüllen)
            $rechnung_sql = "INSERT INTO rechnung (BestellID, Rechnungsdatum, Betrag)
                             VALUES (?, NOW(), ?)";
            $rechnung_stmt = $conn->prepare($rechnung_sql);
            $rechnung_stmt->bind_param("is", $bestellung['BestellID'], $bestellung['Gesamtbetrag']);
            $rechnung_stmt->execute();
            echo "<p style='color: green;'>Rechnung erfolgreich erstellt.</p>";
        } else {
            echo "<p style='color: red;'>Fehler: Bestellung nicht gefunden.</p>";
        }
    }
}


// Abrufen der existierenden Bestellungen
$sql = "SELECT BestellID, KundenID, Bestelldatum, Gesamtbetrag, Zahlungsart, Status FROM bestellung";
$result = $conn->query($sql);
$bestellungen = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Bestellungen verwalten</title>
    <script>
        function filterByBestellID() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("bestellIDFilter");
            filter = input.value.toUpperCase();
            table = document.getElementById("bestellungenTable");
            tr = table.getElementsByTagName("tr");
            document.getElementById("kundenIDFilter").disabled = filter.length > 0;
            document.getElementById("statusFilter").disabled = filter.length > 0;
            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }       
            }
        }

        function filterByKundenID() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("kundenIDFilter");
            filter = input.value.toUpperCase();
            table = document.getElementById("bestellungenTable");
            tr = table.getElementsByTagName("tr");
            document.getElementById("bestellIDFilter").disabled = filter.length > 0;
            document.getElementById("statusFilter").disabled = filter.length > 0;
            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }       
            }
        }

        function filterByStatus() {
            var select, filter, table, tr, td, i, txtValue;
            select = document.getElementById("statusFilter");
            filter = select.value.toUpperCase();
            table = document.getElementById("bestellungenTable");
            tr = table.getElementsByTagName("tr");
            document.getElementById("bestellIDFilter").disabled = filter !== "";
            document.getElementById("kundenIDFilter").disabled = filter !== "";
            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[5];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (filter === "" || txtValue.toUpperCase() === filter) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }       
            }
        }
    </script>
</head>
<body>
    <h1>Bestellungen verwalten</h1>

    <label for="bestellIDFilter">BestellID filtern:</label>
    <input type="text" id="bestellIDFilter" onkeyup="filterByBestellID()" placeholder="BestellID eingeben...">

    <label for="kundenIDFilter">KundenID filtern:</label>
    <input type="text" id="kundenIDFilter" onkeyup="filterByKundenID()" placeholder="KundenID eingeben...">

    <label for="statusFilter">Status filtern:</label>
    <select id="statusFilter" onchange="filterByStatus()">
        <option value="">Alle</option>
        <option value="Bestellt">Bestellt</option>
        <option value="In Zubereitung">In Zubereitung</option>
        <option value="Abgeschlossen">Abgeschlossen</option>
    </select>

    <h2>Existierende Bestellungen</h2>
    <table id="bestellungenTable" border="1">
        <tr>
            <th>BestellID</th>
            <th>KundenID</th>
            <th>Bestelldatum</th>
            <th>Gesamtbetrag</th>
            <th>Zahlungsart</th>
            <th>Status</th>
            <th>Aktion</th>
        </tr>
        <?php foreach ($bestellungen as $bestellung): ?>
        <tr>
            <td><?php echo htmlspecialchars($bestellung['BestellID']); ?></td>
            <td><?php echo htmlspecialchars($bestellung['KundenID']); ?></td>
            <td><?php echo htmlspecialchars($bestellung['Bestelldatum']); ?></td>
            <td><?php echo htmlspecialchars($bestellung['Gesamtbetrag']); ?></td>
            <td><?php echo htmlspecialchars($bestellung['Zahlungsart']); ?></td>
            <td><?php echo htmlspecialchars($bestellung['Status']); ?></td>
            <td>
                <form method="POST" action="bestellungAdmin.php" style="display:inline;">
                    <input type="hidden" name="update_status" value="1">
                    <input type="hidden" name="bestell_id" value="<?php echo htmlspecialchars($bestellung['BestellID']); ?>">
                    <select name="status">
                        <option value="Bestellt" <?php if ($bestellung['Status'] == 'Bestellt') echo 'selected'; ?>>Bestellt</option>
                        <option value="In Zubereitung" <?php if ($bestellung['Status'] == 'In Zubereitung') echo 'selected'; ?>>In Zubereitung</option>
                        <option value="Abgeschlossen" <?php if ($bestellung['Status'] == 'Abgeschlossen') echo 'selected'; ?>>Abgeschlossen</option>
                    </select>
                    <button type="submit">Aktualisieren</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
