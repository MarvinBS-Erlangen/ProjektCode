// THIS IS ONLY A TEST FILE TO CREATE ADMIN ACCOUNTS
// NEEDS TO BE REMOVED BEFOR STAGGING OR PRODUCTION
<?php
session_start();

include '../../database/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $benutzername = $_POST['benutzername'];
    $password = $_POST['password'];
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Überprüfen, ob der Benutzername bereits existiert
    $sql = "SELECT AdminID FROM admin WHERE Benutzername = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $benutzername);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Benutzername existiert bereits. Bitte wählen Sie einen anderen.";
    } else {
        // SQL-Abfrage, um den neuen Admin zu registrieren
        $sql = "INSERT INTO admin (Benutzername, Passwort_Hash, created_on) VALUES (?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $benutzername, $passwordHash);
        if ($stmt->execute()) {
            echo "Registrierung erfolgreich. <a href='loginAdmin.php'>Zum Login</a>";
        } else {
            echo "Fehler bei der Registrierung. Bitte versuchen Sie es erneut.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Registrierung</title>
</head>
<body>
    <h1>Admin Registrierung</h1>
    <form method="POST" action="registerAdmin.php">
        <label for="benutzername">Benutzername:</label>
        <input type="text" id="benutzername" name="benutzername" required><br><br>
        
        <label for="password">Passwort:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <button type="submit" name="register">Registrieren</button>
    </form>
</body>
</html>