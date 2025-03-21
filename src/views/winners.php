<?php
// Datenbankverbindung herstellen
include '../database/connection.php'; 
//Start der Session
//Sessions initialisieren wenn noch nicht gemacht
include '../comps/sessioncheck.php'; // checkt ob ne session läuft
// Schaue ob der benutzer eingeloggt ist
include '../comps/usercheck.php';
// Datenbank logik einbinden 
include '../database/db_winners.php';

// berechnung der verbleibenden zeit bis zum monatsende
$lastDayOfMonth = date("Y-m-t 23:59:59"); // letzter tag vom monat, 23:59:59 uhr
$timeRemaining = strtotime($lastDayOfMonth) - time(); // zeit bis dahin in sekunden berechnen

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS Dateien einbinden -->
    <link rel="stylesheet" href="../public/styles/reset.css">
    <link rel="stylesheet" href="../public/styles/index.css">
    <link rel="stylesheet" href="../public/styles/winners.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/header.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/footer.css">
    <!-- Font Awesome für Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="../handlers/winner-time-counter-handler.js" defer></script>
    <title>Gewinner Bild</title>
</head>

<body>

    <?php include './partials/header.php'; // header einfügen ?>

    <main class="main">
        <h2>Countdown bis Monatsende:</h2>
        <p id="countdown"></p>

        <?php
        // checkt ob es gewinner gibt
        if ($result->num_rows > 0) { // wenn es ergebnisse gibt
            $row = $result->fetch_assoc(); // holt die daten von der datenbank
            echo "<div class='winner-container' style='border: 3px solid gold; padding: 15px; text-align: center;'>";
            echo "<h2>🏆 Gewinner Bild 🏆</h2>";
            echo "<p><strong>" . htmlspecialchars($row["Vorname"]) . "</strong></p>"; // zeigt den vornamen
            echo "<img src='" . htmlspecialchars($row["Bilddatei"]) . "' alt='Image' style='width: 250px; height: auto;'>"; // zeigt das bild
            echo "<p>Likes: " . $row["likes"] . "</p>"; // zeigt die likes
            echo "</div>";
        } else { // wenn keine ergebnisse da sind
            echo "<p>Keine Bilder haben aktuell genug Likes für den Gewinn.</p>"; // meldung wenn nix da is
        }

        $conn->close(); // datenbank verbindung schließen
        ?>
    </main>

    <?php include './partials/footer.php'; // footer einfügen ?>

    <script>
        // countdown-funktion
        function updateCountdown() {
            let timeRemaining = <?php echo $timeRemaining; ?>; // zeit vom php holen
            let countdownElement = document.getElementById("countdown");

            function formatTime(seconds) {
                let days = Math.floor(seconds / (3600 * 24)); // tage berechnen
                let hours = Math.floor((seconds % (3600 * 24)) / 3600); // stunden berechnen
                let minutes = Math.floor((seconds % 3600) / 60); // minuten berechnen
                let secs = seconds % 60; // sekunden berechnen
                return `${days} Tage, ${hours} Std, ${minutes} Min, ${secs} Sek`; // formatierte zeit zurückgeben
            }

            function tick() {
                if (timeRemaining > 0) { // wenn noch zeit übrig is
                    countdownElement.innerHTML = formatTime(timeRemaining); // countdown anzeigen
                    timeRemaining--; // zeit runterzählen
                    setTimeout(tick, 1000); // jede sekunde aktualisieren
                } else { // wenn zeit abgelaufen ist --- Dies muss aber noch besprochen werden da die Contest Hauefigkeit Unbekannt ist
                    countdownElement.innerHTML = "Contest abgelaufen!"; // meldung anzeigen
                }
            }

            tick(); // countdown starten
        }

        // countdown starten
        updateCountdown();
    </script>

</body>

</html>