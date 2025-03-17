<?php
//Datenbank verbindung herstellen
include '../../database/connection.php';
//Start der Session
//Sessions initialisieren wenn noch nicht gemacht
include '../../comps/sessioncheck.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $benutzername = $_POST['benutzername'];
    $password = $_POST['password'];

    // SQL-Abfrage, um den Admin anhand des Benutzernamens zu finden
    $sql = "SELECT AdminID, Passwort_Hash FROM admin WHERE Benutzername = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $benutzername);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && password_verify($password, $admin['Passwort_Hash'])) {
        // Session-Variable setzen
        $_SESSION['AdminID'] = $admin['AdminID'];
        echo "Login erfolgreich. <a href='adminDashboard.php'>Weiter zum Admin-Dashboard</a>";
    } else {
        echo "Ungültiger Benutzername oder Passwort.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
</head>
<body>
    <h1>Admin Login</h1>
    <form method="POST" action="loginAdmin.php">
        <label for="benutzername">Benutzername:</label>
        <input type="text" id="benutzername" name="benutzername" required><br><br>
        
        <label for="password">Passwort:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <button type="submit" name="login">Login</button>
    </form>
</body>
</html>