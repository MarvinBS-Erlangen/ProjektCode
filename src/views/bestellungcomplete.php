<?php
include '../comps/sessioncheck.php';
include '../comps/usercheck.php';
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/reset.css">
    <link rel="stylesheet" href="../public/styles/index.css">
    <link rel="stylesheet" href="../public/styles/complete.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/header.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Bestellung Abgeschlossen!</title>
</head>

<body>

    <?php include './partials/header.php'; ?>

    <main class="main">
        <div class="complete-container">
            <h1>Bestellung Abgeschlossen</h1>
            <p>Ihre Bestellung wurde erfolgreich abgeschlossen!</p>
        </div>
    </main>

    <?php include './partials/footer.php'; ?>

</body>

</html>
<style>
/* Container für die Bestellungsabschluss-Nachricht */
.complete-container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
}

/* Überschrift - Bestellung abgeschlossen */
h1 {
    font-size: 2.5rem;
    color: #28a745; /* Grüner Erfolgston */
    margin-bottom: 15px;
    font-weight: bold;
}

/* Beschreibungstext */
p {
    font-size: 1.2rem;
    color: #555555; /* Dunkleres Grau für den Text */
    line-height: 1.6;
    margin-top: 10px;
}

</style>
