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

    // // Regex-Patterns zur Validierung
    // $regexPatterns = [
    //     'Vorname' => '/^[A-Za-zÄÖÜäöüß\-]+$/u',
    //     'Nachname' => '/^[A-Za-zÄÖÜäöüß\-]+$/u',
    //     'Email' => '/^[a-zA-Z0-9._%+-]+@(gmail\.com|gmx\.de|gmx\.net|web\.de|yahoo\.com|hotmail\.com)$/',
    //     'Hausnummer' => '/^[0-9]+[a-zA-Z]?$/',
    //     'Postleitzahl' => '/^\d{5}$/',
    //     'Stadt' => '/^[A-Za-zÄÖÜäöüß\- ]+$/u',
    //     'Telefon' => '/^(?:\+49\s?|0)(?:\d{3,4}\s?\d{3,5}\s?\d{4})$/',
    //     'Passwort' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
    // ];

    // // Validierung durchführen
    // foreach ($regexPatterns as $field => $pattern) {
    //     if (!preg_match($pattern, $_POST[$field])) {
    //         die("Ungültiges Format für $field.");
    //     }
    // }

    // Überprüfung des Passworts
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
            echo "<script>alert('Diese E-Mail-Adresse ist bereits registriert. Loggen Sie sich ein.');</script>";
            echo "<script>window.location.href = '../views/login.php';</script>";
        } else if ($stateResult['Status'] === 'gelöscht') {
            $state = 'aktiv';
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $updateAddressQuery = "UPDATE adresse SET Strasse = ?, Hausnummer = ?, Postleitzahl = ?, Stadt = ?, Land = ? WHERE AdresseID IN (SELECT AdresseID FROM kunde WHERE EMail = ?)";
            $stmt = $conn->prepare($updateAddressQuery);
            $stmt->bind_param("ssssss", $address, $houseNumber, $zipcode, $city, $country, $email);
            $stmt->execute();

            $updateReactivatedUserQuery = "UPDATE kunde SET Vorname = ?, Nachname = ?, Password_Hash = ?, Telefon = ?, Status = ? WHERE EMail = ?";
            $stmt = $conn->prepare($updateReactivatedUserQuery);
            $stmt->bind_param("ssssss", $firstName, $lastName, $hashedPassword, $phone, $state, $email);
            $stmt->execute();
            header("Location: ../views/login.php");
            exit();
        }
    } else {
        $state = 'aktiv';
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $insertAddressQuery = "INSERT INTO adresse (Strasse, Hausnummer, Postleitzahl, Stadt, Land) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertAddressQuery);
        $stmt->bind_param("sssss", $address, $houseNumber, $zipcode, $city, $country);
        $stmt->execute();

        $addressId = $stmt->insert_id;

        $insertUserQuery = "INSERT INTO kunde (Vorname, Nachname, EMail, Password_Hash, Telefon, AdresseID, Status) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertUserQuery);
        $stmt->bind_param("sssssis", $firstName, $lastName, $email, $hashedPassword, $phone, $addressId, $state);
        $stmt->execute();

        header("Location: ../views/login.php");
        exit();
    }
}
