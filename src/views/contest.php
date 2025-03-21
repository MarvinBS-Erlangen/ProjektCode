<?php
//Datenbank verbindung herstellen
include '../database/connection.php';
//Start der Session
//Sessions initialisieren wenn noch nicht gemacht
include '../comps/sessioncheck.php';
//Schaue ob der Benuzter eingelogt ist
include '../comps/usercheck.php';
//Datenbank Logik einbinden -- POST Requests an die Datenbank + Backend Logik
include '../database/db_contest.php';
?>

<!-- Frontend & Database Display -->
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../public/styles/reset.css">
    <link rel="stylesheet" href="../public/styles/index.css">
    <link rel="stylesheet" href="../public/styles/contest.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/header.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="../handlers/rating-handler.js" defer></script>
    <script src="../handlers/btns-view-upload-handlers.js" defer></script>
    <script src="../handlers/btn-best-rated-food.js" defer></script>
    <title>Bild hochladen und bewerten</title>
</head>

<body>

    <?php include './partials/header.php'; ?>
    <?php if (isset($_SESSION['success_message_pic'])): ?>
        <div class="success-banner">
            <?php echo $_SESSION['success_message_pic'];
            unset($_SESSION['success_message_pic']); ?>
        </div>

    <?php endif; ?>

    <?php if (isset($_SESSION['error_message_pic'])): ?>
        <div class="error-banner">
            <?php echo $_SESSION['error_message_pic'];
            unset($_SESSION['error_message_pic']); ?>
        </div>
    <?php endif; ?>

    <main class="main">


        <div class="participate-container">
            <div class="description">Mach mit bei unserem <span id="funny-dinner-contest">Funny-Dinner-Contest</span>.<br>
                Teile deine Essens-Fotos mit der Community. <br> Es gibt einen Preis!! <br>
                Zwinker Zwinker 😉</div>
            <div class="button-container">
                <div class="view-your-uploads-container">
                    <button type="button" id="btn-view-your-uploads">UPLOADS ANZEIGEN</button>
                </div>
                <div class="upload-picture-container">
                    <button type="button" id="btn-upload-picture">BILD
                        <br> HOCHLADEN</button>
                </div>
                <div class="current-best-rated-food-container">
                    <button type="button" id="btn-current-best-rated-food">AKTUELL BESTER</button>
                </div>
            </div>
        </div>

        <?php
        // Bilder anzeigen und Bewertungsformular bereitstellen
        $sql = "SELECT b.BildID, b.Titel, b.Bilddatei, k.EMail
                FROM Bild b
                JOIN Kunde k ON b.KundenID = k.KundenID
                WHERE b.Freigabestatus = 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $emailParts = explode('@', $row['EMail']);
                $username = $emailParts[0];

                // Überprüfen, ob der Benutzer bereits eine Bewertung für dieses Bild abgegeben hat
                $sqlBewertung = "SELECT * FROM Bewertung WHERE BildID = ? AND KundenID = ? AND IstAktiv = 1";
                $stmtBewertung = $conn->prepare($sqlBewertung);
                $stmtBewertung->bind_param("ii", $row['BildID'], $userID);
                $stmtBewertung->execute();
                $resultBewertung = $stmtBewertung->get_result();
                $bereitsBewertet = $resultBewertung->num_rows > 0;

                echo '<div class="uploads-container">
                    <div class="username-title">
                        <h3 class="username">' . htmlspecialchars($username) . '</h3>
                    </div>
                    <div class="upload">
                        <div class="image-container">
                            <img src="' . htmlspecialchars($row['Bilddatei']) . '" alt="' . htmlspecialchars($row['Titel']) . '">
                        </div>
                    </div>
                    <div class="upload-info-container">
                        <div class="image-description-container">
                            <span class="image-description">' . htmlspecialchars($row['Titel']) . '</span>
                        </div>
                        <div class="rating-container">';
                echo '<form method="POST" action="contest.php" class="rating-form">
                                <input type="hidden" name="bild_id" value="' . htmlspecialchars($row['BildID']) . '">
                                <input type="hidden" name="bewerten" value="1">';
                if ($bereitsBewertet) {
                    echo '<button type="submit"><i class="fa-solid fa-heart"></i></button>';
                } else {
                    echo '<button type="submit"><i class="fa-regular fa-heart"></i></button>';
                }
                echo '</form>';
                echo '</div>
                    </div>
                </div>';
            }
        } else {
            echo "Keine Bilder vorhanden.";
        }

        $conn->close();
        ?>

    </main>

    <?php include './partials/footer.php'; ?>

    <script>
        document.querySelectorAll('.rating-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const action = this.getAttribute('action');

                fetch(action, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Handle the response data
                        console.log(data);

                        // Update the button icon based on the response
                        const button = this.querySelector('button');
                        const icon = button.querySelector('i');
                        if (data.status === 'activated') {
                            icon.classList.remove('fa-regular');
                            icon.classList.add('fa-solid');
                        } else {
                            icon.classList.remove('fa-solid');
                            icon.classList.add('fa-regular');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>

</body>

</html>

<style>
    /* Erfolgsmeldung-Banner */
    .success-banner {
        width: 100%;
        background-color: #4CAF50;
        /* Grüner Hintergrund für Erfolg */
        color: white;
        text-align: center;
        padding: 5px;
        font-size: 16px;
        font-weight: bold;
        position: relative;
        margin-top: 0px;
        animation: fadeOut 3s forwards;
    }

    /* Fehlermeldung-Banner */
    .error-banner {
        width: 100%;
        background-color: #FF5733;
        /* Roter Hintergrund für Fehler */
        color: white;
        text-align: center;
        padding: 5px;
        font-size: 16px;
        font-weight: bold;
        position: relative;
        margin-top: 0px;
        animation: fadeOut 3s forwards;
        /* Fade-out animation */
    }

    @keyframes fadeOut {
        0% {
            opacity: 1;
        }

        99% {
            opacity: 1;
        }

        100% {
            opacity: 0;
        }
    }
</style>