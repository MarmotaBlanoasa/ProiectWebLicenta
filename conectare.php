<?php
// Informatii conectare
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'eveniment';

// Încercați să vă conectați folosind informațiile de mai sus
$mysqli = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    // Dacă există o eroare la conexiune, opriți scriptul și afișați eroarea
    exit('Esec conectare MySQL: ' . mysqli_connect_error());
}