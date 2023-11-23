<?php
session_start();
include("conectare.php");
require_once "EventCRUD.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Vizualizare Parteneri</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>
<body>
<h1>Inregistrările din tabela partener</h1>
<p><b>Parteneri</b></p>
<?php
$eventCRUD = new EventCRUD();
$parteneri = $eventCRUD->getPartners();
    if (!empty($parteneri)) {
        echo "<table border='1' cellpadding='10'>";
        echo "<tr>
                    <th>ID Partener</th>
                    <th>Nume Partener</th>
                    <th>Descriere</th>
                    <th>Contact Nume</th>
                    <th>Contact Email</th>
                    <th>Contact Telefon</th>
                    <th>Pachet</th>
                    <th></th>
                    <th></th>
                  </tr>";

        foreach ($parteneri as $row) {
            echo "<tr>";
            echo "<td>" . $row['ID_Partener'] . "</td>";
            echo "<td>" . $row['Nume_Partener'] . "</td>";
            echo "<td>" . $row['Descriere'] . "</td>";
            echo "<td>" . $row['Contact_Nume'] . "</td>";
            echo "<td>" . $row['Contact_Email'] . "</td>";
            echo "<td>" . $row['Contact_Telefon'] . "</td>";
            echo "<td>" . $row['Nume_Pachet'] . "</td>";
            if (isset($_SESSION['loggedin'])){
                echo "<td><a href='modificare_partener.php?ID_Partener=" . $row['ID_Partener'] . "'>Modificare</a></td>";
                echo "<td><a href='stergere_partener.php?ID_Partener=" . $row['ID_Partener'] . "'>Ștergere</a></td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Nu sunt înregistrări în tabelă!";
    }
$mysqli->close();
?>
<?= isset($_SESSION['loggedin']) ? '<a href="inserare_partener.php">Adăugarea unui nou partener</a>' : ''?>
</body>
</html>
