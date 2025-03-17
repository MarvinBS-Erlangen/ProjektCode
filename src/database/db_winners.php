<?php
// SQL-Abfrage: Ermittelt das Bild mit den meisten Likes
$sql = "
    SELECT b.Bilddatei, k.Vorname, COUNT(bw.BildID) AS likes
    FROM bewertung AS bw
    JOIN bild AS b ON bw.BildID = b.BildID
    JOIN kunde AS k ON bw.KundenID = k.KundenID
    WHERE bw.IstAktiv = 1
    GROUP BY bw.BildID, k.Vorname
    ORDER BY likes DESC
    LIMIT 1
";

$result = $conn->query($sql);
?>