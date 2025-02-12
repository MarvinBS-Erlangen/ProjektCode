<?php
// Session starten, falls noch nicht gestartet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verbindung zur Datenbank herstellen
include '../database/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailKunde = $_POST['EMail'];
    $passwordKunde = $_POST['Password'];

    // Benutzung von Prepared Statements um SQL Injections zu verhindern
    $prst = $conn->prepare("SELECT KundenID, Password_Hash FROM kunde WHERE EMail = ?");
    // Der Platzhalter ? wird durch den string Wert "s" im emailKunde ersetzt
    $prst->bind_param("s", $emailKunde);
    // Ausführen des Prepared Statements
    $prst->execute();
    // Ergebnis speichern
    $prst->store_result();

    if ($prst->num_rows > 0) {
        $prst->bind_result($kundeID, $hashedPassword);
        $prst->fetch();

        if (password_verify($passwordKunde, $hashedPassword)) {
            echo "<p class='success'>Login erfolgreich!</p>";
            $_SESSION['UserID'] = $kundeID;
        } else {
            echo "<p class='error'>Ungültiges Passwort. Bitte versuchen Sie es erneut.</p>";
        }
    } else {
        echo "<p class='error'>Kein Konto mit dieser E-Mail gefunden. Bitte registrieren Sie sich zuerst.</p>";
    }

    $prst->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/reset.css">
    <link rel="stylesheet" href="../public/styles/index.css">
    <link rel="stylesheet" href="../public/styles/login.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/header.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="../handlers/login-handler.js" defer></script>
    <title>Login</title>
</head>

<body>

    <?php include './partials/header.php'; ?>

    <main>
        <div class="form-container">
            <h2 class="login-title">Login</h2>
            <form action="login.php" method="post">
                <label for="email">Email:</label>
                <input type="email" id="email" name="EMail" required>

                <label for="password">Passwort:</label>
                <input type="password" id="password" name="Password" required>

                <input type="submit" id="btn-login" value="Login">
            </form>

            <p class="not-registered">Noch kein Konto? <a href="register.php">Registrieren</a></p>
        </div>
    </main>

    <?php include './partials/footer.php'; ?>

</body>

</html>
