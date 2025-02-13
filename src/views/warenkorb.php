<?php
session_start();
include '../database/connection.php';

if (!isset($_SESSION['warenkorb_Produkt'])) {
    $_SESSION['warenkorb_Produkt'] = [];
}

if (!isset($_SESSION['warenkorb_Menue'])) {
    $_SESSION['warenkorb_Menue'] = [];
}

if (!isset($_SESSION['UserID'])) {
    $_SESSION['UserID'] = [];
}

if (!isset($_SESSION['gesamtpreis'])) {
    $_SESSION['gesamtpreis'] = 0;
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

// BenutzerID aus der Session abrufen
$userID = $_SESSION['UserID'] ?? null;

if ($userID === null) {
    echo "<p style='color: red;'>Benutzer ist nicht eingeloggt.</p>";
    exit;
}

// Lieferadresse abrufen
$sql = "SELECT k.Nachname, a.Strasse, a.Hausnummer, a.Postleitzahl, a.Stadt, k.AdresseID FROM adresse a JOIN kunde k ON a.AdresseID = k.AdresseID WHERE k.KundenID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$adresse = $result->fetch_assoc();

// Zahlungsarten abrufen
$sql = "SHOW COLUMNS FROM bestellung LIKE 'Zahlungsart'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$type = $row['Type'];
preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
$zahlungsarten = explode("','", $matches[1]);

// Gesamtpreis berechnen und in der Session speichern
$gesamtpreis = 0;

foreach ($_SESSION['warenkorb_Produkt'] as $produkt_id => $menge) {
    $sql = "SELECT Preis FROM produkt WHERE ProduktID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $produkt_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $produkt = $result->fetch_assoc();

    if ($produkt) {
        $gesamt = $produkt['Preis'] * $menge;
        $gesamtpreis += $gesamt;
    }
}

foreach ($_SESSION['warenkorb_Menue'] as $menue_id => $menge) {
    $sql = "SELECT DiscountPreis FROM menue WHERE MenueID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $menue_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $menue = $result->fetch_assoc();

    if ($menue) {
        $gesamt = $menue['DiscountPreis'] * $menge;
        $gesamtpreis += $gesamt;
    }
}

$_SESSION['gesamtpreis'] = $gesamtpreis;

// Bestellung abschließen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    // Überprüfen, ob der Warenkorb leer ist
    if (empty($_SESSION['warenkorb_Produkt']) && empty($_SESSION['warenkorb_Menue'])) {
        echo "<p style='color: red;'>Ihr Warenkorb ist leer.</p>";
    } else {
        // Überprüfen, ob die Adresse angegeben wurde
        $name = $_POST['name'] ?? '';
        $strasse = $_POST['strasse'] ?? '';
        $hausnummer = $_POST['hausnummer'] ?? '';
        $plz = $_POST['plz'] ?? '';
        $stadt = $_POST['stadt'] ?? '';

        if (empty($name) || empty($strasse) || empty($hausnummer) || empty($plz) || empty($stadt)) {
            echo "<p style='color: red;'>Bitte geben Sie Ihre vollständige Adresse an.</p>";
        } else {
            // Adresse aktualisieren oder erstellen
            if ($adresse['AdresseID'] === null) {
                $sql = "INSERT INTO adresse (Strasse, Hausnummer, Postleitzahl, Stadt) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $strasse, $hausnummer, $plz, $stadt);
                $stmt->execute();
                $adresseID = $stmt->insert_id;

                $sql = "UPDATE kunde SET AdresseID = ? WHERE KundenID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $adresseID, $userID);
                $stmt->execute();
            } else {
                $sql = "UPDATE adresse SET Strasse = ?, Hausnummer = ?, Postleitzahl = ?, Stadt = ? WHERE AdresseID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssi", $strasse, $hausnummer, $plz, $stadt, $adresse['AdresseID']);
                $stmt->execute();
                $adresseID = $adresse['AdresseID'];
            }

            // Bestellung speichern und Bestellposten fuer Produkte und Menues speichern
            // Verknuepfen der Bestellpostenid mit der Bestellung
            $zahlungsart = $_POST['zahlungsart'] ?? '';
            $gesamtpreis = $_SESSION['gesamtpreis'];
            $sql = "INSERT INTO bestellung (KundenID, Zahlungsart, Gesamtbetrag) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isd", $userID, $zahlungsart, $gesamtpreis);
            $stmt->execute();
            $bestellungID = $stmt->insert_id;

            // Produkte in bestellposten_Produkt speichern
            foreach ($_SESSION['warenkorb_Produkt'] as $produkt_id => $menge) {
                $sql = "INSERT INTO bestellposten_Produkt (BestellID, ProduktID, Menge) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iii", $bestellungID, $produkt_id, $menge);
                $stmt->execute();
            }

            // Menues in bestellposten_Menue speichern
            foreach ($_SESSION['warenkorb_Menue'] as $menue_id => $menge) {
                $sql = "INSERT INTO bestellposten_Menue (BestellungID, MenueID, Menge) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iii", $bestellungID, $menue_id, $menge);
                $stmt->execute();
            }

            //change echo to a redirect on aktive bestellung page
            echo "<p style='color: green;'>Ihre Bestellung wurde erfolgreich abgeschlossen.</p>";

            // Warenkorb leeren
            $_SESSION['warenkorb_Produkt'] = [];
            $_SESSION['warenkorb_Menue'] = [];
            $_SESSION['gesamtpreis'] = 0;
        }
    }
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
                    foreach ($_SESSION['warenkorb_Produkt'] as $produkt_id => $menge) {
                        $sql = "SELECT ProduktID, Produktname, Preis FROM produkt WHERE ProduktID = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $produkt_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $produkt = $result->fetch_assoc();

                        if ($produkt) {
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
                <span class="total-label">GESAMT (inkl. MwSt):</span>
                <span class="total-price"><?php echo $_SESSION['gesamtpreis']; ?> €</span>
            </div>
            <div class="section">
                <h2>Lieferadresse</h2>
                <form method="POST" action="warenkorb.php">
                    <input type="text" name="name" placeholder="Name" value="<?php echo htmlspecialchars($adresse['Nachname'] ?? ''); ?>" required>
                    <div class="address-container">
                        <input type="text" name="strasse" placeholder="Straße" value="<?php echo htmlspecialchars($adresse['Strasse'] ?? ''); ?>" required>
                        <input type="text" name="hausnummer" placeholder="Hausnummer" value="<?php echo htmlspecialchars($adresse['Hausnummer'] ?? ''); ?>" required>
                    </div>
                    <input type="text" name="plz" placeholder="PLZ" value="<?php echo htmlspecialchars($adresse['Postleitzahl'] ?? ''); ?>" required>
                    <input type="text" name="stadt" placeholder="Stadt" value="<?php echo htmlspecialchars($adresse['Stadt'] ?? ''); ?>" required>
                    <div class="section">
                        <h2>Zahlungsmethode</h2>
                        <select name="zahlungsart">
                            <?php foreach ($zahlungsarten as $zahlungsart): ?>
                                <option value="<?php echo htmlspecialchars($zahlungsart); ?>"><?php echo htmlspecialchars($zahlungsart); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <a href='warenkorb.php?action=clear'><button type="button">Warenkorb leeren</button></a>
                    <button type="submit" name="checkout" class="checkout-button">Bestellung abschließen</button>
                </form>
            </div>
        </div>
    </main>
    <?php include './partials/footer.php'; ?>
</body>

</html>
