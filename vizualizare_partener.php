<?php
session_start();
require("checkLogin.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Vizualizare Parteneri</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>
<body>
<h1>Inregistrările din tabela partener</h1>
<p><b>Toate înregistrările din partener</b></p>
<?php
include("conectare.php");
$query = "SELECT partener.*, eveniment.Nume_Eveniment, pachet.Nume_Pachet FROM partener 
              LEFT JOIN eveniment ON partener.ID_Eveniment = eveniment.ID_Eveniment 
              LEFT JOIN pachet ON partener.ID_Pachet = pachet.ID_Pachet 
              ORDER BY ID_Partener";

if ($result = $mysqli->query($query)) {
    if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='10'>";
        echo "<tr>
                    <th>ID Partener</th>
                    <th>Nume Partener</th>
                    <th>Descriere</th>
                    <th>Contact Nume</th>
                    <th>Contact Email</th>
                    <th>Contact Telefon</th>
                    <th>Eveniment</th>
                    <th>Pachet</th>
                    <th></th>
                    <th></th>
                  </tr>";

        while ($row = $result->fetch_object()) {
            echo "<tr>";
            echo "<td>" . $row->ID_Partener . "</td>";
            echo "<td>" . $row->Nume_Partener . "</td>";
            echo "<td>" . $row->Descriere . "</td>";
            echo "<td>" . $row->Contact_Nume . "</td>";
            echo "<td>" . $row->Contact_Email . "</td>";
            echo "<td>" . $row->Contact_Telefon . "</td>";
            echo "<td>" . $row->Nume_Eveniment . "</td>";
            echo "<td>" . $row->Nume_Pachet . "</td>";
            echo "<td><a href='modificare_partener.php?ID_Partener=" . $row->ID_Partener . "'>Modificare</a></td>";
            echo "<td><a href='stergere_partener.php?ID_Partener=" . $row->ID_Partener . "'>Ștergere</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Nu sunt înregistrări în tabelă!";
    }
} else {
    echo "Eroare: " . $mysqli->error;
}
$mysqli->close();
?>
<a href="inserare_partener.php">Adăugarea unui nou partener</a>
</body>
</html>
