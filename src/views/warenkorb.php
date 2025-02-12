<?php
session_start();
include '../database/connection.php';

if (!isset($_SESSION['warenkorb_Produkt'])) {
    $_SESSION['warenkorb_Produkt'] = [];
}

if (!isset($_SESSION['warenkorb_Menue'])) {
    $_SESSION['warenkorb_Menue'] = [];
}

// Produkt aus dem Warenkorb entfernen
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id']) && isset($_GET['type'])) {
    $id = $_GET['id'];
    $type = $_GET['type'];
    if ($type == 'produkt' && isset($_SESSION['warenkorb_Produkt'][$id])) {
        $_SESSION['warenkorb_Produkt'][$id]--;
        if ($_SESSION['warenkorb_Produkt'][$id] <= 0) {
            unset($_SESSION['warenkorb_Produkt'][$id]);
        }
    } elseif ($type == 'menue' && isset($_SESSION['warenkorb_Menue'][$id])) {
        $_SESSION['warenkorb_Menue'][$id]--;
        if ($_SESSION['warenkorb_Menue'][$id] <= 0) {
            unset($_SESSION['warenkorb_Menue'][$id]);
        }
    }
    header("Location: warenkorb.php");
    exit();
}

// Warenkorb leeren
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'clear') {
    $_SESSION['warenkorb_Produkt'] = [];
    $_SESSION['warenkorb_Menue'] = [];
    header("Location: warenkorb.php");
    exit();
}

// Warenkorb anzeigen
echo "<h1>Warenkorb</h1>";
if (!empty($_SESSION['warenkorb_Produkt']) || !empty($_SESSION['warenkorb_Menue'])) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Preis</th>
                <th>Menge</th>
                <th>Gesamt</th>
                <th>Aktion</th>
            </tr>";
    $gesamtpreis = 0;

    // Produkte anzeigen
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
                    <td><a href='warenkorb.php?action=remove&id={$produkt['ProduktID']}&type=produkt'>Entfernen</a></td>
                  </tr>";
        }
    }

    // Menüs anzeigen
    foreach ($_SESSION['warenkorb_Menue'] as $menue_id => $menge) {
        $sql = "SELECT MenueID, Menuename, DiscountPreis FROM menue WHERE MenueID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $menue_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $menue = $result->fetch_assoc();

        if ($menue) {
            $gesamt = $menue['DiscountPreis'] * $menge;
            $gesamtpreis += $gesamt;
            echo "<tr>
                    <td>{$menue['MenueID']}</td>
                    <td>{$menue['Menuename']}</td>
                    <td>{$menue['DiscountPreis']} €</td>
                    <td>{$menge}</td>
                    <td>{$gesamt} €</td>
                    <td><a href='warenkorb.php?action=remove&id={$menue['MenueID']}&type=menue'>Entfernen</a></td>
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