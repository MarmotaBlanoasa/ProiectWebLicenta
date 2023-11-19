<?php
session_start();
require("checkLogin.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Vizualizare Agenda</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>
<body>
<h1>Inregistrările din tabela Agenda</h1>
<p><b>Toate înregistrările din agenda</b></p>
<?php
include("conectare.php");
$query = "SELECT agenda.*, eveniment.Nume_Eveniment FROM agenda 
              LEFT JOIN eveniment ON agenda.ID_Eveniment = eveniment.ID_Eveniment 
              ORDER BY ID_Agenda";

if ($result = $mysqli->query($query)) {
    if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='10'>";
        echo "<tr>
                    <th>ID Agenda</th>
                    <th>Eveniment</th>
                    <th>Nume Sesiune</th>
                    <th>Ora Început</th>
                    <th>Ora Sfârșit</th>
                    <th>Descriere</th>
                    <th></th>
                    <th></th>
                  </tr>";

        while ($row = $result->fetch_object()) {
            echo "<tr>";
            echo "<td>" . $row->ID_Agenda . "</td>";
            echo "<td>" . $row->Nume_Eveniment . "</td>";
            echo "<td>" . $row->Nume_Sesiune . "</td>";
            echo "<td>" . $row->Ora_Inceput . "</td>";
            echo "<td>" . $row->Ora_Sfarsit . "</td>";
            echo "<td>" . $row->Descriere . "</td>";
            echo "<td><a href='modificare_agenda.php?ID_Agenda=" . $row->ID_Agenda . "'>Modificare</a></td>";
            echo "<td><a href='stergere_agenda.php?ID_Agenda=" . $row->ID_Agenda . "'>Ștergere</a></td>";
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
<a href="inserare_agenda.php">Adăugarea unei noi agende</a>
</body>
</html>
