<?php
// Hier werden die Datenbankverbindungsdetails definiert
$servername = "localhost"; // Der Servername
$username = "root"; // Standard-Benutzername für XAMPP
$password = ""; // Standard-Passwort, leer gelassen bei XAMPP
$dbname = "food_db_test"; // Aktuelle Test-Datenbank, nicht für Produktion geeignet

// Verbindung zur Datenbank wird erstellt
$conn = new mysqli($servername, $username, $password, $dbname);

// Überprüfung, ob die Verbindung erfolgreich war
if ($conn->connect_error) { // Wenn ein Fehler auftritt...
    die("Connection failed: " . $conn->connect_error); // ...Programm beenden und Fehlermeldung ausgeben
}
