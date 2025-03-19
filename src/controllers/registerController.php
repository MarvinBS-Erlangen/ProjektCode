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
            echo "<script>alert('Diese E-Mail-Adresse ist bereits registriert. Loggen Sie sich ein.');</script>";
            echo "<script>window.location.href = '../views/login.php';</script>";
        } else if ($stateResult['Status'] === 'gelöscht') {
            $state = 'aktiv';
            // Status wird in $updateReactivatedUserQuery aktualisiert, folgende zeilen also nicht mehr benötigt
            // $setStateAktivQuery = "UPDATE kunde SET Status = ? WHERE EMail = ?";
            // $stmt = $conn->prepare($setStateAktivQuery);
            // $stmt->bind_param("ss", $state, $email);
            // $stmt->execute();

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Adresse in der Datenbank aktualisieren
            $updateAddressQuery = "UPDATE adresse SET Strasse = ?, Hausnummer = ?, Postleitzahl = ?, Stadt = ?, Land = ? WHERE AdresseID IN (SELECT AdresseID FROM kunde WHERE EMail = ?)";
            $stmt = $conn->prepare($updateAddressQuery);
            $stmt->bind_param("ssssss", $address, $houseNumber, $zipcode, $city, $country, $email);
            $stmt->execute();

            // update exisiting, reactivated account with new form submitted data (vorname, nachname, ...)
            $updateReactivatedUserQuery = "UPDATE kunde SET Vorname = ?, Nachname = ?, Password_Hash = ?, Telefon = ?, Status = ? WHERE EMail = ?";
            $stmt = $conn->prepare($updateReactivatedUserQuery);
            $stmt->bind_param("ssssss", $firstName, $lastName, $hashedPassword, $phone, $state, $email);
            $stmt->execute();
            // Weiterleitung zur Login-Seite nach erfolgreicher Reaktivierung
            header("Location: ../views/login.php");
            exit();
        }
    } else {
        // folgender Code wird ausgeführt wenn der User noch gar kein Konto hat, sprich keine EMail von dem User in der Datenbank hinterlegt ist
        $state = 'aktiv';
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
            INSERT INTO kunde (Vorname, Nachname, EMail, Password_Hash, Telefon, AdresseID, Status)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ";
        $stmt = $conn->prepare($insertUserQuery);
        $stmt->bind_param("sssssis", $firstName, $lastName, $email, $hashedPassword, $phone, $addressId, $state);
        $stmt->execute();

        // Weiterleitung zur Login-Seite nach erfolgreicher Registrierung
        header("Location: ../views/login.php");
        exit();
    }
}
