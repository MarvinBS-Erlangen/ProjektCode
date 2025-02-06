<?php
session_start();
//Verbindung zur Datenbank herstellen 
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailKunde = $_POST['EMail'];
    $passwordKunde = $_POST['Password'];

    // Benutzungung von prst -> Prepared statement um SQL Injections zu verhindern
    $prst = $conn->prepare("SELECT Password_Hash FROM kunde WHERE EMail = ?");
    // Der Platzhalter ? wird durch den string wert "s" im emailKunde ersetzt
    $prst->bind_param("s", $emailKunde);
    // ausfuehren des prst
    $prst->execute();
    // Ergebnis speichern
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="EMail" required><br><br>
        
        <label for="password">Passwort:</label>
        <input type="password" id="password" name="Password" required><br><br>
        
        <input type="submit" value="Login">
    </form>
</body>
</html>