<?php
// Start the session to access session data
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Destroy all session data to log the user out
session_unset();  // Clear all session variables
session_destroy();  // Destroy the session

// Optionally, you can redirect the user to the homepage or login page after logout
header("Location: login.php");
exit();
?>
