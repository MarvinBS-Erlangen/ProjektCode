<?php
session_start();

// Verbindung zur Datenbank herstellen
include 'connection.php';

if (!isset($_SESSION['warenkorb'])) {
    $_SESSION['warenkorb'] = [];
}

echo "<a href='warenkorb.php'>Warenkorb anzeigen</a><br><br>";

$sql = "SELECT ProduktID, Produktname, Beschreibung, Preis, Energiewert, BildURL FROM produkt";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ProduktID</th>
                <th>Produktname</th>
                <th>Beschreibung</th>
                <th>Preis</th>
                <th>Energiewert</th>
                <th>Bild</th>
                <th>Aktion</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['ProduktID']}</td>
                <td>{$row['Produktname']}</td>
                <td>{$row['Beschreibung']}</td>
                <td>{$row['Preis']}</td>
                <td>{$row['Energiewert']}</td>
                <td><img src='{$row['BildURL']}' alt='{$row['Produktname']}' width='100'></td>
                <td><button onclick='addToCart({$row['ProduktID']})'>In den Warenkorb</button></td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Keine Produkte gefunden.";
}
?>

<!-- Einbinden von Axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
function addToCart(produktID) {
    axios.post('warenkorb.php', {
        action: 'add',
        id: produktID
    })
    .then(function (response) {
        alert("Produkt wurde zum Warenkorb hinzugefügt");
    })
    .catch(function (error) {
        console.error("Es gab einen Fehler beim Hinzufügen des Produkts zum Warenkorb:", error);
    });
}
</script>