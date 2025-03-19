<?php
// Datenbankverbindung herstellen
include '../database/connection.php';
// Start der Session
include '../comps/sessioncheck.php';
// Schaue ob der Benutzer eingeloggt ist
include '../comps/usercheck.php';
// Datenbank Logik einbinden -- POST Requests an die Datenbank + Backend Logik
include '../database/db_viewuploads.php';

?>

<!-- Frontend & Database Display -->
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Hochgeladene Bilder anzeigen</title>
    <link rel="stylesheet" href="../public/styles/reset.css">
    <link rel="stylesheet" href="../public/styles/index.css">
    <link rel="stylesheet" href="../public/styles/contest.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/header.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php include './partials/header.php'; ?>

    <main class="main">
        <h1>Hochgeladene Bilder</h1>

        <?php if (empty($bilder)): ?>
            <p>Keine Bilder gefunden.</p>
        <?php else: ?>
            <div class="uploads-container">
        <?php foreach ($bilder as $bild): ?>
            <div class="upload-item">
                <div class="image-container">
                    <img src="<?php echo htmlspecialchars($bild['Bilddatei']); ?>" alt="<?php echo htmlspecialchars($bild['Titel']); ?>" class="uploaded-image">
                </div>
                <div class="upload-details">
                    <h3 class="image-title"><?php echo htmlspecialchars($bild['Titel']); ?></h3>
                    <p class="upload-date"><?php echo htmlspecialchars($bild['Hochladedatum']); ?></p>
                    <p class="approval-status"><?php echo htmlspecialchars($bild['Freigabestatus'] == 1 ? 'Freigegeben' : 'Nicht freigegeben'); ?></p>
                    <a href="?delete_id=<?php echo $bild['BildID']; ?>" class="delete-btn" onclick="return confirm('Möchten Sie dieses Bild wirklich löschen?')">Löschen</a>
                </div>
            </div>
        <?php endforeach; ?>

            </div>
        <?php endif; ?>
    </main>

    <?php include './partials/footer.php'; ?>
</body>

</html>

<style>
/* Upload Container */
.uploads-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    margin-top: 20px;
}

.upload-item {
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    width: 250px;
    text-align: center;
    padding: 20px;
}

.upload-item .image-container {
    margin-bottom: 15px;
}

.upload-item .uploaded-image {
    width: 100%;
    height: auto;
    border-radius: 8px;
}

.upload-item .upload-details {
    font-size: 14px;
    color: #555;
}

.upload-item .image-title {
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}

.upload-item .upload-date,
.upload-item .approval-status {
    font-style: italic;
    color: #777;
}

.upload-item .delete-btn {
    display: inline-block;
    margin-top: 10px;
    padding: 5px 10px;
    background-color: #e74c3c;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
}

.upload-item .delete-btn:hover {
    background-color: #c0392b;
}

/* Erfolgsmeldung-Banner */
.success-banner {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    text-align: center;
    padding: 5px;
    font-size: 16px;
    font-weight: bold;
    position: relative;
    margin-top: 0px;
}

/* Fehlermeldung-Banner */
.error-banner {
    width: 100%;
    background-color: #FF5733;
    color: white;
    text-align: center;
    padding: 5px;
    font-size: 16px;
    font-weight: bold;
    position: relative;
    margin-top: 0px;
}

/* Close Button */
.close-btn {
    position: absolute;
    top: 50%;
    right: 5px;
    transform: translateY(-50%);
    text-decoration: none;
    color: white;
    font-size: 18px;
    font-weight: bold;
    padding: 5px;
    cursor: pointer;
}
</style>

