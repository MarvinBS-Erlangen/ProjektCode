<?php

// BenutzerID aus der Session abrufen
$userID = $_SESSION['UserID'] ?? null;


// Abrufen der Bilder des eingeloggten Benutzers
$sql = "SELECT Bilddatei, Titel, Hochladedatum, Freigabestatus FROM bild WHERE KundenID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$bilder = $result->fetch_all(MYSQLI_ASSOC);
?>