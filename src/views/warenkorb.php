<?php
session_start();
include '../database/connection.php';

if (!isset($_SESSION['warenkorb_Produkt'])) {
    $_SESSION['warenkorb_Produkt'] = [];
}

// Produkt aus dem Warenkorb entfernen
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $produkt_id = $_GET['id'];
    if (isset($_SESSION['warenkorb_Produkt'][$produkt_id])) {
        $_SESSION['warenkorb_Produkt'][$produkt_id]--;
        if ($_SESSION['warenkorb_Produkt'][$produkt_id] <= 0) {
            unset($_SESSION['warenkorb_Produkt'][$produkt_id]);
        }
    }
    header("Location: warenkorb.php");
    exit();
}

// Warenkorb leeren
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'clear') {
    $_SESSION['warenkorb_Produkt'] = [];
    header("Location: warenkorb.php");
    exit();
}

// Warenkorb anzeigen
echo "<h1>Warenkorb</h1>";
if (!empty($_SESSION['warenkorb_Produkt'])) {
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
    foreach ($_SESSION['warenkorb_Produkt'] as $produkt_id => $menge) {
        $sql = "SELECT ProduktID, Produktname, Preis FROM produkt WHERE ProduktID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $produkt_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $produkt = $result->fetch_assoc();

        if ($produkt) {
            $gesamt = $produkt['Preis'] * $menge;
            $gesamtpreis += $gesamt;
            echo "<tr>
                    <td>{$produkt['ProduktID']}</td>
                    <td>{$produkt['Produktname']}</td>
                    <td>{$produkt['Preis']} €</td>
                    <td>{$menge}</td>
                    <td>{$gesamt} €</td>
                    <td><a href='warenkorb.php?action=remove&id={$produkt['ProduktID']}'>Entfernen</a></td>
                  </tr>";
        }
    }
    echo "<tr>
            <td colspan='4'>Gesamtpreis</td>
            <td>{$gesamtpreis} €</td>
            <td></td>
          </tr>";
    echo "</table>";
    echo "<br><a href='warenkorb.php?action=clear'><button>Warenkorb leeren</button></a>";
} else {
    echo "<p>Ihr Warenkorb ist leer.</p>";
}
?>