<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['warenkorb'])) {
    $_SESSION['warenkorb'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'] ?? '';
    $produkt_id = $data['id'] ?? '';

    if ($action === 'add' && $produkt_id) {
        $sql = "SELECT ProduktID, Produktname, Preis FROM produkt WHERE ProduktID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $produkt_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $produkt = $result->fetch_assoc();

        if ($produkt) {
            if (isset($_SESSION['warenkorb'][$produkt_id])) {
                $_SESSION['warenkorb'][$produkt_id]['menge']++;
            } else {
                $_SESSION['warenkorb'][$produkt_id] = [
                    'ProduktID' => $produkt['ProduktID'],
                    'Produktname' => $produkt['Produktname'],
                    'Preis' => $produkt['Preis'],
                    'menge' => 1
                ];
            }
        }
        echo json_encode(['status' => 'success']);
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $produkt_id = $_GET['id'];
    if (isset($_SESSION['warenkorb'][$produkt_id])) {
        unset($_SESSION['warenkorb'][$produkt_id]);
    }
    header("Location: warenkorb.php");
    exit();
}

// Warenkorb anzeigen
echo "<h1>Warenkorb</h1>";
if (!empty($_SESSION['warenkorb'])) {
    echo "<table border='1'>
            <tr>
                <th>ProduktID</th>
                <th>Produktname</th>
                <th>Preis</th>
                <th>Menge</th>
                <th>Gesamt</th>
                <th>Aktion</th>
            </tr>";
    $gesamtpreis = 0;
    foreach ($_SESSION['warenkorb'] as $item) {
        $gesamt = $item['Preis'] * $item['menge'];
        $gesamtpreis += $gesamt;
        echo "<tr>
                <td>{$item['ProduktID']}</td>
                <td>{$item['Produktname']}</td>
                <td>{$item['Preis']}</td>
                <td>{$item['menge']}</td>
                <td>{$gesamt}</td>
                <td><a href='warenkorb.php?action=remove&id={$item['ProduktID']}'>Entfernen</a></td>
              </tr>";
    }
    echo "<tr>
            <td colspan='4'>Gesamtpreis</td>
            <td>{$gesamtpreis}</td>
            <td></td>
          </tr>";
    echo "</table>";
} else {
    echo "<p>Ihr Warenkorb ist leer.</p>";
}
?>