<?php
// Datenbank verbindung herstellen
include '../../database/connection.php';
// Start der Session
include '../../comps/sessioncheck.php';
// Admin check Script aufrufen
include '../../comps/admincheck.php';

// Verarbeitung des Post-Requests zum Herunterladen der CSV-Datei
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['download_csv'])) {
    // SQL-Abfrage zum Abrufen der Produktbestellungen aller Benutzer
    $sql = "
        SELECT k.KundenID, k.Vorname, k.Nachname, p.Produktname, SUM(bp.Menge) AS Anzahl
        FROM bestellposten_produkt AS bp
        JOIN produkt AS p ON bp.ProduktID = p.ProduktID
        JOIN bestellung AS b ON bp.BestellID = b.BestellID
        JOIN kunde AS k ON b.KundenID = k.KundenID
        GROUP BY k.KundenID, p.ProduktID
        UNION
        SELECT k.KundenID, k.Vorname, k.Nachname, m.MenueName AS Produktname, SUM(bm.Menge) AS Anzahl
        FROM bestellposten_menue AS bm
        JOIN menue AS m ON bm.MenueID = m.MenueID
        JOIN bestellung AS b ON bm.BestellID = b.BestellID
        JOIN kunde AS k ON b.KundenID = k.KundenID
        GROUP BY k.KundenID, m.MenueID
        ORDER BY KundenID, Produktname
    ";

    $result = $conn->query($sql);
    $bestellungen = $result->fetch_all(MYSQLI_ASSOC);

    // CSV-Datei erstellen
    $filename = "bestellungen_alle_kunden.csv";
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=' . $filename);

    $output = fopen('php://output', 'w');
    fputcsv($output, array('KundenID', 'Vorname', 'Nachname', 'Produktname', 'Anzahl'));

    foreach ($bestellungen as $bestellung) {
        fputcsv($output, $bestellung);
    }

    fclose($output);
    exit();
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/styles/reset.css">
    <link rel="stylesheet" href="../../public/styles/index.css">
    <link rel="stylesheet" href="../../public/styles/admin.css">
    <title>Bestellhaeufigkeiten CSV Download</title>
</head>
<body>
    <main class="main">
        <div class="admin-container">
            <form method="POST" action="csvDownload.php">
                <button type="submit" name="download_csv">CSV-Datei herunterladen</button>
            </form>
        </div>
    </main>
</body>
</html>