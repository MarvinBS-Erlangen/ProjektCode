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

    $getStateQuery = "SELECT Status FROM kunde WHERE EMail = ?";
    $stmt = $conn->prepare($getStateQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stateResult = $result->fetch_assoc();

    if ($stateResult) {
        if ($stateResult['Status'] === 'aktiv') {
            // Ausgabe falls email schon existiert und status aktiv ist
            die("Diese E-Mail-Adresse ist bereits registriert.");
        } else if ($stateResult['Status'] === 'gelöscht') {
            $state = 'aktiv';
            $setStateAktivQuery = "UPDATE kunde SET Status = ? WHERE EMail = ?";
            $stmt = $conn->prepare($setStateAktivQuery);
            $stmt->bind_param("ss", $state, $email);
            $stmt->execute();

            // Weiterleitung zur Login-Seite nach erfolgreicher Reaktivierung
            header("Location: ../views/login.php");
            exit();
        }
    } else {
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
}
