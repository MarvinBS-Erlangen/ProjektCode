<?php
// Benutzerinformationen aus der Datenbank abrufen
$userId = $_SESSION['UserID'];

// Debugging: Überprüfen der Benutzer-ID
if (!$userId) {
    die("Benutzer-ID nicht gefunden in der Session.");
}

$getUserOrdersQuery = "SELECT BestellID, Bestelldatum, Gesamtbetrag, Zahlungsart FROM Bestellung WHERE KundenID = ?";
$stmt = $conn->prepare($getUserOrdersQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Orders in einem Array speichern
$orders = [];
while ($row = $result->fetch_assoc()) {
    // Format the Bestelldatum
    $date = new DateTime($row['Bestelldatum']);
    $row['Bestelldatum'] = $date->format('d.m.Y, H:i');
    $price = $row['Gesamtbetrag'];
    $row['Gesamtbetrag'] =  number_format($price, 2, ',', '.');
    $orders[] = $row;
}

// Übergabe der Bestellungen an das Frontend
// Speichern der Bestellinformationen in Variablen
$bestellID = $orders[0]['BestellID'] ?? '';
$bestelldatum = $orders[0]['Bestelldatum'] ?? '';
$gesamtbetrag = $orders[0]['Gesamtbetrag'] ?? '';
$zahlungsart = $orders[0]['Zahlungsart'] ?? '';
