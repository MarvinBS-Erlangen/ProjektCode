<?php
// Funktion zum Hinzufügen eines Produkts zum Warenkorb
function addToCart($produktID)
{
    if (!isset($_SESSION['warenkorb_Produkt'][$produktID])) {
        $_SESSION['warenkorb_Produkt'][$produktID] = 0;
    }
    $_SESSION['warenkorb_Produkt'][$produktID]++;
}

// Überprüfen, ob ein Produkt zum Warenkorb hinzugefügt werden soll
if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
    addToCart($_GET['id']);

    // Wenn Produkt hinzugefügt wird
    $_SESSION['success_message'] = "Produkt erfolgreich im Warenkorb hinzugefügt!";
    header("Location: products.php");
    exit();
}
