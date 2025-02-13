<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Datenbankverbindung herstellen
include '../database/connection.php';

// BenutzerID aus der Session abrufen
$userID = $_SESSION['UserID'] ?? null;

if ($userID === null) {
    echo "<p style='color: red;'>Benutzer ist nicht eingeloggt.</p>";
    exit;
}

// Bewertung speichern oder deaktivieren
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bewerten'])) {
    $bildID = $_POST['bild_id'];

    // Überprüfen, ob der Benutzer bereits eine Bewertung für dieses Bild abgegeben hat
    $sql = "SELECT * FROM Bewertung WHERE BildID = ? AND KundenID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $bildID, $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Bewertung aktivieren oder deaktivieren
        $bewertung = $result->fetch_assoc();
        $istAktiv = $bewertung['IstAktiv'] ? 0 : 1;
        $sql = "UPDATE Bewertung SET IstAktiv = ? WHERE BildID = ? AND KundenID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $istAktiv, $bildID, $userID);
        $stmt->execute();

        echo json_encode(['status' => $istAktiv ? 'activated' : 'deactivated']);
    } else {
        // Neue Bewertung einfügen
        $sql = "INSERT INTO Bewertung (BildID, KundenID, IstAktiv) VALUES (?, ?, 1)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $bildID, $userID);
        $stmt->execute();

        echo json_encode(['status' => 'activated']);
    }
    exit;
}
?>

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
    <title>Bild hochladen und bewerten</title>
</head>

<body>

    <?php include './partials/header.php'; ?>


    <main class="main">

        <div class="participate-container">
            <div class="button-container">
                <div class="view-your-uploads-container">
                    <button type="button" id="btn-view-your-uploads">VIEW YOUR UPLOADS</button>
                </div>
                <div class="upload-picture-container">
                    <button type="button" id="btn-upload-picture">UPLOAD PICTURE</button>
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
