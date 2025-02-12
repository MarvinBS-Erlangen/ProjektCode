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

// Bewertung speichern
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bewerten'])) {
    $bildID = $_POST['bild_id'];
    $bewertungspunkte = (int)$_POST['bewertungspunkte'];
    $userID = $_POST['user_id'];

    $sql = "INSERT INTO Bewertung (BildID, KundenID, Bewertungspunkte) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $bildID, $bewertungspunkte);
    $stmt->execute();

    echo "Bewertung erfolgreich gespeichert.";
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
    <script src="../handlers/star-rating-handler.js" defer></script>
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
                        <div class="rating-container">
                            <i class="fa fa-star" data-value="1"></i>
                            <i class="fa fa-star" data-value="2"></i>
                            <i class="fa fa-star" data-value="3"></i>
                            <i class="fa fa-star" data-value="4"></i>
                            <i class="fa fa-star" data-value="5"></i>
                        </div>
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

</body>

</html>
