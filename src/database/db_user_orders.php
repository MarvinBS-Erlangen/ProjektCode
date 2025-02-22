<?php
// Benutzerinformationen aus der Datenbank abrufen
$userId = $_SESSION['UserID'];

// Debugging: Überprüfen der Benutzer-ID
if (!$userId) {
    die("Benutzer-ID nicht gefunden in der Session.");
}

$getUserOrdersQuery = "SELECT " 