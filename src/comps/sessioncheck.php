<?php
session_start();
// Das Script prueft ob die Globalen Sessions existieren, wenn nicht werden sie angelegt
// Die Sessions sind in docs SESSION_ID.txt aufgelisted
// User ID darf NICHT gesetzt werden !!! diese wird nur beim Login des Benutzers gesetzt und wird seperat je Seite ueberprueft
if (!isset($_SESSION['warenkorb_Produkt'])) {
    $_SESSION['warenkorb_Produkt'] = [];
}

if (!isset($_SESSION['warenkorb_Menue'])) {
    $_SESSION['warenkorb_Menue'] = [];
}


if (!isset($_SESSION['gesamtpreis'])) {
    $_SESSION['gesamtpreis'] = 0;
}


?>