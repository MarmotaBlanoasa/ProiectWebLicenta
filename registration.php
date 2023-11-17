<?php
// Include database connection settings
global $mysqli;
require 'conectare.php';

// Check if all necessary POST data is set
if (!isset($_POST['email'], $_POST['password'], $_POST['email'], $_POST['name'], $_POST['surname'])) {
    exit('Completati formularul de inregistrare!');
}

// Validate input values
if (empty($_POST['email']) || empty($_POST['password']) || empty($_POST['name']) || empty($_POST['surname'])) {
    exit('Toate campurile sunt obligatorii!');
}
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    exit('Emailul introdus nu este valid!');
}
if (preg_match('/[A-Za-z0-9]+/', $_POST['email']) == 0) {
    exit('email-ul poate contine doar litere si cifre!');
}
if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
    exit('Parola trebuie sa aiba intre 5 si 20 de caractere!');
}

// Check if the email already exists
if ($stmt = $mysqli->prepare('SELECT ID_Administrator FROM administrator WHERE Email = ?')) {
    $stmt->bind_param('s', $_POST['email']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo 'Acest email este deja folosit, alegeti un altul!';
    } else {
        // email is available, proceed with registration
        if ($stmt = $mysqli->prepare('INSERT INTO administrator (nume, prenume, email, parola) VALUES (?, ?, ?, ?)')) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt->bind_param('ssss', $_POST["name"], $_POST['surname'], $_POST['email'], $password);
            $stmt->execute();
            echo 'Inregistrare reusita!';
            header('Location: login.html');
            exit();
        } else {
            echo 'Eroare la pregatirea statement-ului SQL!';
        }
    }
    $stmt->close();
} else {
    echo 'Eroare la pregatirea statement-ului SQL!';
}

$mysqli->close();
