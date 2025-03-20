<?php
// Datenbankverbindung herstellen
include '../database/connection.php';

// SQL-Abfrage, um das Bild mit den meisten Likes zu erhalten
$sql = "
    SELECT b.Bilddatei, k.Vorname, COUNT(bw.BewertungsID) AS likes
    FROM bewertung AS bw
    JOIN bild AS b ON bw.BildID = b.BildID
    JOIN kunde AS k ON b.KundenID = k.KundenID
    WHERE bw.IstAktiv = 1
    GROUP BY b.BildID, k.Vorname
    ORDER BY likes DESC
    LIMIT 1
";

$result = $conn->query($sql);
