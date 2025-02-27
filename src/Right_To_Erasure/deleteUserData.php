<?php

include '../database/connection.php';

$userId = '';
// delete user from database on request of user
$query = "DELETE FROM kunde WHERE KundenID = ?"; // insert userid that should be deleted 
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->close();
