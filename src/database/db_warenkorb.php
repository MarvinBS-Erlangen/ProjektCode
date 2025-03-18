<?php
// BenutzerID aus der Session abrufen
$userID = $_SESSION['UserID'] ?? null;

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

// Produkt zum Warenkorb hinzufügen
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id']) && isset($_GET['type'])) {
    $id = $_GET['id'];
    $type = $_GET['type'];
    if ($type == 'produkt') {
        if (isset($_SESSION['warenkorb_Produkt'][$id])) {
            $_SESSION['warenkorb_Produkt'][$id]++;
        } else {
            $_SESSION['warenkorb_Produkt'][$id] = 1;
        }
    } elseif ($type == 'menue') {
        if (isset($_SESSION['warenkorb_Menue'][$id])) {
            $_SESSION['warenkorb_Menue'][$id]++;
        } else {
            $_SESSION['warenkorb_Menue'][$id] = 1;
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
                $sql = "INSERT INTO bestellposten_Menue (BestellID, MenueID, Menge) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iii", $bestellungID, $menue_id, $menge);
                $stmt->execute();
            }

            // Warenkorb leeren
            $_SESSION['warenkorb_Produkt'] = [];
            $_SESSION['warenkorb_Menue'] = [];
            $_SESSION['gesamtpreis'] = 0;
            header("Location: bestellungcomplete.php");
            exit();
        }
    }
}
