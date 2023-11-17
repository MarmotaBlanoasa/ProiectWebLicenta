<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <title>Vizualizare Inregistrari</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>

<body>
<h1>Inregistrarile din tabela eveniment</h1>
<p><b>Toate inregistrarile din eveniment</b></p>
<?php
include("conectare.php");
if ($result = $mysqli->query("SELECT * FROM eveniment ORDER BY ID_Eveniment")) {
    if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='10'>";

        echo "<tr><th>ID Eveniment</th><th>Nume Eveniment</th><th>Descriere</th><th>Data Start</th><th>Data Finish</th><th>Locatie</th><th>Numar Participanti Maxim</th><th></th><th></th></tr>";

        while ($row = $result->fetch_object()) {
            echo "<tr>";
            echo "<td>" . $row->ID_Eveniment . "</td>";
            echo "<td>" . $row->Nume_Eveniment . "</td>";
            echo "<td>" . $row->Descriere . "</td>";
            echo "<td>" . $row->Data_Start . "</td>";
            echo "<td>" . $row->Data_Finish . "</td>";
            echo "<td>" . $row->Locatie . "</td>";
            echo "<td>" . $row->Numar_Participant_Maxim . "</td>";
            echo "<td><a href='modificare_eveniment.php?ID_Eveniment=" . $row->ID_Eveniment . "'>Modificare</a></td>";
            echo "<td><a href='stergere_eveniment.php?ID_Eveniment=" . $row->ID_Eveniment . "'>Stergere</a></td>";
            echo "<td><a href='cumpara-bilet.php?ID_Eveniment=" . $row->ID_Eveniment . "'>Cumpara Bilet</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Nu sunt inregistrari in tabela!";
    }

} else {
    echo "Error: " . $mysqli->error();
}
$mysqli->close();
?>
<a href="inserare_eveniment.php">Adaugarea unei noi inregistrari</a>
</body>

</html>