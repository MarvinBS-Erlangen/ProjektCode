<?php
// Funktion zum Hinzufügen eines Menüs zum Warenkorb
function addToCart($menueID)
{
    if (!isset($_SESSION['warenkorb_Menue'][$menueID])) {
        $_SESSION['warenkorb_Menue'][$menueID] = 0;
    }
    $_SESSION['warenkorb_Menue'][$menueID]++;
}

// Überprüfen, ob ein Menü zum Warenkorb hinzugefügt werden soll
if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
    addToCart($_GET['id']);
    header("Location: menu_details.php?id={$_GET['id']}");
    exit();
}
?>