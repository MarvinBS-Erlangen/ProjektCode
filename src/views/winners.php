<?php
// Datenbank verbindung herstellen
include '../database/connection.php';
// Start der Session
include '../comps/sessioncheck.php';
// Schaue ob der Benutzer eingeloggt ist
include '../comps/usercheck.php';
//Datenbank Logik einbinden 
include '../database/db_winners.php';


// Berechnung der verbleibenden Zeit bis zum Monatsende
$lastDayOfMonth = date("Y-m-t 23:59:59"); // Letzter Tag des Monats, 23:59:59 Uhr
$timeRemaining = strtotime($lastDayOfMonth) - time();

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/reset.css">
    <link rel="stylesheet" href="../public/styles/index.css">
    <link rel="stylesheet" href="../public/styles/winners.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/header.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="../handlers/winner-time-counter-handler.js" defer></script>
    <title>Gewinner Bild</title>
</head>

<body>

    <?php include './partials/header.php'; ?>

    <main class="main">
        <h2>Countdown bis Monatsende:</h2>
        <p id="countdown"></p>

        <?php
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<div class='winner-container' style='border: 3px solid gold; padding: 15px; text-align: center;'>";
            echo "<h2>🏆 Gewinner Bild 🏆</h2>";
            echo "<p><strong>" . htmlspecialchars($row["Vorname"]) . "</strong></p>";
            echo "<img src='" . htmlspecialchars($row["Bilddatei"]) . "' alt='Image' style='width: 250px; height: auto;'>";
            echo "<p>Likes: " . $row["likes"] . "</p>";
            echo "</div>";
        } else {
            echo "<p>Keine Bilder haben aktuell genug Likes für den Gewinn.</p>";
        }

        $conn->close();
        ?>
    </main>

    <?php include './partials/footer.php'; ?>

    <script>
        // Countdown-Funktion
        function updateCountdown() {
            let timeRemaining = <?php echo $timeRemaining; ?>;
            let countdownElement = document.getElementById("countdown");

            function formatTime(seconds) {
                let days = Math.floor(seconds / (3600 * 24));
                let hours = Math.floor((seconds % (3600 * 24)) / 3600);
                let minutes = Math.floor((seconds % 3600) / 60);
                let secs = seconds % 60;
                return `${days} Tage, ${hours} Std, ${minutes} Min, ${secs} Sek`;
            }

            function tick() {
                if (timeRemaining > 0) {
                    countdownElement.innerHTML = formatTime(timeRemaining);
                    timeRemaining--;
                    setTimeout(tick, 1000);
                } else {
                    countdownElement.innerHTML = "Contest abgelaufen!";
                }
            }

            tick();
        }

        // Countdown starten
        updateCountdown();
    </script>

</body>

</html>