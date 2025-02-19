<?php
include '../database/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['Vorname'];
    $lastName = $_POST['Nachname'];
    $email = $_POST['Email'];
    $password = $_POST['Passwort'];
    $confirmPassword = $_POST['Passwort_bestaetigen'];
    $address = $_POST['Strasse'];
    $houseNumber = $_POST['Hausnummer'];
    $zipcode = $_POST['Postleitzahl'];
    $city = $_POST['Stadt'];
    $country = $_POST['Land'];
    $phone = $_POST['Telefon'];

    if ($password !== $confirmPassword) {
        die("Passwörter stimmen nicht überein.");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Adresse in die Datenbank einfügen
    $insertAddressQuery = "
        INSERT INTO adresse (Strasse, Hausnummer, Postleitzahl, Stadt, Land)
        VALUES (?, ?, ?, ?, ?)
    ";
    $stmt = $conn->prepare($insertAddressQuery);
    $stmt->bind_param("sssss", $address, $houseNumber, $zipcode, $city, $country);
    $stmt->execute();

    $addressId = $stmt->insert_id;

    // Benutzer in die Datenbank einfügen
    $insertUserQuery = "
        INSERT INTO kunde (Vorname, Nachname, EMail, Password_Hash, Telefon, AdresseID)
        VALUES (?, ?, ?, ?, ?, ?)
    ";
    $stmt = $conn->prepare($insertUserQuery);
    $stmt->bind_param("sssssi", $firstName, $lastName, $email, $hashedPassword, $phone, $addressId);
    $stmt->execute();

    // Weiterleitung zur Login-Seite nach erfolgreicher Registrierung
    header("Location: ../views/login.php");
    exit();
}
