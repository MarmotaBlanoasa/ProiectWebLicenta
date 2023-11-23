<?php
session_start();
include("conectare.php");
require_once 'EventCRUD.php';
$loggedIn = isset($_SESSION["loggedin"]);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Vizualizare Parteneri</title>
    <meta http-equiv="Content-Type" content="text/html" , charset="utf-8"/>
</head>
<body>
<h1>Vizualizare speaker</h1>
<?php
$eventCRUD = new EventCRUD();
try {
    $speakeri = $eventCRUD->getAllSpeakers();
} catch (Exception $e) {
    echo "<p>Could not connect to the database to display events!</p>";
    exit();
}
if (!empty($speakeri)) {
    echo "<table border='1'cellpadding = '10'>";
    echo "<tr>          
                            <th>Nume</th>
                            <th>Prenume</th>
                            <th>Email</th> 
                            <th>Telefon</th> 
                            <th>Bio</th>   
                            <th></th>
                            <th></th>
                        </tr>";
    foreach ($speakeri as $row) {
        echo "<tr>";
        echo "<td>" . $row['Nume'] . "</td>";
        echo "<td>" . $row['Prenume'] . "</td>";
        echo "<td>" . $row['Email'] . "</td>";
        echo "<td>" . $row['Telefon'] . "</td>";
        echo "<td>" . $row['Bio'] . "</td>";
        if ($loggedIn) {
            echo "<td><a href='modificare_speaker.php?ID_Speaker=" . $row['ID_Speaker'] . "'>Modificare</a></td>";
            echo "<td><a href='stergere_speaker.php?ID_Speaker=" . $row['ID_Speaker'] . "'>Stergere</a></td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Nu sunt inregistrari in tabela! ";
}
$mysqli->close();
?>
<?php if ($loggedIn) echo '<a href = "inserare_speaker.php">Adaugarea unei noi inregistrari</a>' ?>
</body>
</html>