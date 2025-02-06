<?php
session_start();
// Verbindung zur Datenbank herstellen
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailKunde = $_POST['EMail'];
    $passwordKunde = $_POST['Password'];

    // Prepared Statement zur Vermeidung von SQL Injections
    $prst = $conn->prepare("SELECT Password_Hash FROM kunde WHERE EMail = ?");
    $prst->bind_param("s", $emailKunde);
    $prst->execute();
    $prst->store_result();

    if ($prst->num_rows > 0) {
        $prst->bind_result($hashedPassword);
        $prst->fetch();

        if (password_verify($passwordKunde, $hashedPassword)) {
            echo "<p class='success'>Login successful!</p>";
        } else {
            echo "<p class='error'>Invalid password. Please try again.</p>";
        }
    } else {
        echo "<p class='error'>No account found with that email. Please register first.</p>";
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
    <title>Login</title>
    <link rel="stylesheet" href="./styles/login.css">
</head>
<body>
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
</body>
</html>
