<?php
session_start();


// Verbindung zur Datenbank herstellen
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
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./styles/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <header style="height: clamp(3rem, 10vw, 5rem);" class="header">
        <div class="header-title">
            <span id="title" class="title"><a href="/">MACaPPLE</a></span>
        </div>
        <div class="nav-links">
            <ul class="nav-list">
                <li class="btn-menus"><a href="/menus">Menus</a></li>
                <li class="btn-products"><a href="/products">Products</a></li>
                <li class="btn-contest"><a href="/contest">Contest</a></li>
                <li class="btn-login"><a href="/login">Login</a></li>
                <li class="btn-signup"><a href="/signup">Sign Up</a></li>
            </ul>
        </div>
        <div class="cart-container">
            <i class="fa-solid fa-cart-shopping cart-icon"></i>
            <span class="items-in-cart">0</span>
        </div>
    </header>


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

    <footer>
        <ul class="footer-list">
            <li><a href="/impressum">Impressum</a></li>
            <li><a href="/agbs">AGBs</a></li>
            <li><a href="/datenschutzerklaerung">Datenschutzerklärung</a></li>
            <li><a href="/kontakt">Kontakt</a></li>
        </ul>
    </footer>
</body>

</html>
