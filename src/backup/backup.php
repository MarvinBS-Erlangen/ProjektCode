<?php

// 

// Datenbank-Verbindungsinformationen
$host = 'localhost';      // Host der Datenbank
$username = 'root';  // Datenbankbenutzername
$password = '';  // Datenbankpasswort
$dbname = 'food_db_test';  // Name der Datenbank

// Backup-Verzeichnis
$backupDir = 'C:\\xampp\\htdocs\\backups\\'; // Beispielpfad für Windows

// Aktuelles Datum für den Dateinamen
$date = date('Y-m-d_H-i-s');

// Dateiname des Backups
$backupFile = $backupDir . $dbname . '_' . $date . '.sql';

// MySQL-Dump-Befehl
$command = "C:\\xampp\\mysql\\bin\\mysqldump --user=$username --password=$password --host=$host $dbname > $backupFile";

// Ausführen des Befehls
system($command, $output);

// Überprüfen, ob das Backup erfolgreich war
if ($output === 0) {
    echo "Backup erfolgreich erstellt: " . $backupFile;
} else {
    echo "Fehler beim Erstellen des Backups.";
}
