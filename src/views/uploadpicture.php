<?php
//Datenbank verbindung herstellen
include '../database/connection.php';
//Start der Session
//Sessions initialisieren wenn noch nicht gemacht
include '../comps/sessioncheck.php';
//Schaue ob der Benuzter eingelogt ist
include '../comps/usercheck.php';
//Datenbank Logik einbinden -- POST Requests an die Datenbank + Backend Logik
include '../database/db_uploadpicture.php';
?>



<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/reset.css">
    <link rel="stylesheet" href="../public/styles/index.css">
    <link rel="stylesheet" href="../public/styles/uploadpicture.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/header.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Bild-Upload</title>
</head>

<body>
    <?php include './partials/header.php'; ?>

    <main class="main">
        <div class="upload-container">
            <h2>Bild hochladen</h2>

            <form id="upload-form" method="POST" action="uploadpicture.php">
                <input type="text" name="titel" id="description" placeholder="Beschreibung eingeben" required>
                <input type="text" name="bildurl" id="image-url" placeholder="Bild-URL eingeben" required>
                <div class="upload-buttons">
                    <button type="submit" name="upload" class="upload-button upload-submit">Upload</button>
                </div>
            </form>

            <!-- Error message display -->
            <p id="error-message" style="color: red;"></p>

            <div class="preview hidden" id="preview">
                <img id="preview-image" src="" alt="Vorschau">
                <h2 id="preview-title"></h2>
            </div>
        </div>
    </main>
    <?php include './partials/footer.php'; ?>
</body>

</html>
