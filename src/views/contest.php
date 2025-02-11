<?php
session_start();

// Datenbankverbindung herstellen
include '../database/connection.php';


// Bild hochladen und speichern
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload'])) {
    $titel = $_POST['titel'];
    $bildurl = $_POST['bildurl'];

    // Validierung der Bild-URL
    if (filter_var($bildurl, FILTER_VALIDATE_URL)) {
        $sql = "INSERT INTO Bild (Bilddatei, Titel) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $bildurl, $titel);
        $stmt->execute();

        echo "Bild erfolgreich hochgeladen.";
    } else {
        echo "Fehler: Bitte geben Sie eine gültige Bild-URL ein.";
    }
}

// Bewertung speichern
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bewerten'])) {
    $bildID = $_POST['bild_id'];
    $bewertungspunkte = (int)$_POST['bewertungspunkte'];

    $sql = "INSERT INTO Bewertung (BildID, Bewertungspunkte) VALUES (?, ?)";
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
    <title>Bild hochladen und bewerten</title>
</head>

<body>

    <?php include './partials/header.php'; ?>


    <main class="main">

        <div class="participate-container">
            <div class="description">Hi, 'username', participate in our Funny-Dinner-Contest.<br> Share your dinner pics with the community. There's a prize!!<br> Wink Wink</div>
            <div class="button-container">
                <div class="view-your-uploads-container">
                    <button type="button" id="btn-view-your-uploads">VIEW YOUR UPLOADS</button>
                </div>
                <div class="upload-picture-container">
                    <button type="button" id="btn-upload-picture">UPLOAD PICTURE</button>
                </div>
            </div>
        </div>

    </main>

    <?php include './partials/footer.php'; ?>

</body>

</html>
