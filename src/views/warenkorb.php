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
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/reset.css">
    <link rel="stylesheet" href="../public/styles/index.css">
    <link rel="stylesheet" href="../public/styles/warenkorb.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/header.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/footer.css">
    <title>Warenkorb</title>
</head>

<body>
    <?php include './partials/header.php'; ?>
    <main class="main">
        <div class="container">
            <div class="section">
                <h2>Bestellübersicht</h2>
                <div class="order-list">
                    <?php
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
                            echo "<div class='item'>
                                    <div class='item-details'>
                                        <p class='item-name'>{$produkt['Produktname']}</p>
                                        <p class='item-price'>{$produkt['Preis']} €</p>
                                        <p class='item-quantity'>Menge: {$menge}</p>
                                        <a href='warenkorb.php?action=remove&id={$produkt['ProduktID']}&type=produkt'>Entfernen</a>
                                    </div>
                                  </div>";
                        }
                    }

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
                            echo "<div class='item'>
                                    <div class='item-details'>
                                        <p class='item-name'>{$menue['Menuename']}</p>
                                        <p class='item-price'>{$menue['DiscountPreis']} €</p>
                                        <p class='item-quantity'>Menge: {$menge}</p>
                                        <a href='warenkorb.php?action=remove&id={$menue['MenueID']}&type=menue'>Entfernen</a>
                                    </div>
                                  </div>";
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="total">
                <span class="total-label">Gesamt:</span>
                <span class="total-price"><?php echo $gesamtpreis; ?> €</span>
            </div>
            <div class="section">
                <h2>Lieferadresse</h2>
                <input type="text" placeholder="Name">
                <div class="address-container">
                    <input type="text" name="strasse" placeholder="Straße">
                    <input type="text" name="hausnummer" placeholder="Hausnummer">
                </div>
                <input type="text" placeholder="PLZ">
                <input type="text" placeholder="Stadt">
            </div>
            <div class="section">
                <h2>Zahlungsmethode</h2>
                <select>
                    <option>Kreditkarte</option>
                    <option>PayPal</option>
                    <option>Rechnung</option>
                </select>
            </div>
            <a href='warenkorb.php?action=clear'><button>Warenkorb leeren</button></a>
            <button class="checkout-button">Bestellung abschließen</button>
        </div>
    </main>
    <?php include './partials/footer.php'; ?>
</body>

</html>
