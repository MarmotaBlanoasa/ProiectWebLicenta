<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Vizualizare Sponsor</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>
<body>
<h1>Inregistrările din tabela sponsor</h1>
<p><b>Toate înregistrările din sponsor</b></p>
<?php
session_start();
include("conectare.php");
require_once "EventCRUD.php";
$loggedIn = isset($_SESSION["loggedin"]);
$eventCRUD = new EventCRUD();
try {
    $sponsor = $eventCRUD->getAllSponsors();
} catch (Exception $e) {
    echo "<p>Could not connect to the database to display events!</p>";
    exit();
}

if (!empty($sponsor)) {
    echo "<table border='1' cellpadding='10'>";
    echo "<tr>
                    <th>ID Sponsor</th>
                    <th>Nume Sponsor</th>
                    <th>Descriere</th>
                    <th>Contact Nume</th>
                    <th>Contact Email</th>
                    <th>Contact Telefon</th>
                    <th></th>
                    <th></th>
                </tr>";

    foreach ($sponsor as $row) {
        echo "<tr>";
        echo "<td>" . $row['ID_Sponsor'] . "</td>";
        echo "<td>" . $row['Nume_Sponsor'] . "</td>";
        echo "<td>" . $row['Descriere'] . "</td>";
        echo "<td>" . $row['Contact_Nume'] . "</td>";
        echo "<td>" . $row['Contact_Email'] . "</td>";
        echo "<td>" . $row['Contact_Telefon'] . "</td>";
        if ($loggedIn){
            echo "<td><a href='modificare_sponsor.php?ID_Sponsor=" . $row['ID_Sponsor'] . "'>Modificare</a></td>";
            echo "<td><a href='stergere_sponsor.php?ID_Sponsor=" . $row['ID_Sponsor'] . "'>Ștergere</a></td>";
        }
        echo "</tr>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Nu sunt înregistrări în tabelă!";
}
$mysqli->close();
?>
<?= $loggedIn ?  '<a href="inserare_sponsor.php">Adăugarea unui nou sponsor</a>': '' ?>
</body>
</html>
