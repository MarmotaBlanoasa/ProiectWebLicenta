<?php
session_start();
$loggedIn = isset($_SESSION["loggedin"]);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <title>Vizualizare evenimente</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>

<body>
    <h1>Lista evenimente</h1>
    <?php
    echo "<ul>";
    if (isset($_SESSION["loggedin"])) {
        echo "<li>
<a href='profil.php'>
Profil
</a>
</li>
<li>
<a href='vizualizare_pachet.php'>
Pachete
</a>
</li>";
    }
    echo "
<li>
<a href='vizualizare_eveniment.php'>
Evenimentele noastre
</a>
</li>
<li>
<a href='vizualizare_sesiune.php'>
Sesiunile Evenimentelor
</a>
</li>
<li>
<a href='vizualizare_partener.php'>
Parteneri
</a>
</li>
<li>
<a href='vizualizare_sponsor.php'>
Sponsori
</a>
</li>
<li>
<a href='vizualizare_speaker.php'>
Speakerii nostrii
</a>
</li>
<li>
<a href='vizualizare_bilet.php'>
Bilete
</a>
</li>
<li>
<a href='vizualizare_agenda.php'>
Agenda Evenimentului
</a>
</li>"
;
    echo "</ul>";
    ?>
    <?php
    include("conectare.php");
    if ($result = $mysqli->query("SELECT * FROM eveniment ORDER BY ID_Eveniment")) {
        if ($result->num_rows > 0) {
            echo "<table border='1' cellpadding='10'>";
            if ($loggedIn) {
                echo "<tr><th>ID Eveniment</th><th>Nume Eveniment</th><th>Descriere</th><th>Data Start</th><th>Data Finish</th><th>Locatie</th><th>Numar Participanti Maxim</th><th></th><th></th><th></th></tr>";
            } else {
                echo "<tr><th>ID Eveniment</th><th>Nume Eveniment</th><th>Descriere</th><th>Data Start</th><th>Data Finish</th><th>Locatie</th><th>Numar Participanti Maxim</th</tr>";
            }

            while ($row = $result->fetch_object()) {
                echo "<tr>";
                echo "<td>" . $row->ID_Eveniment . "</td>";
                echo "<td>" . $row->Nume_Eveniment . "</td>";
                echo "<td>" . $row->Descriere . "</td>";
                echo "<td>" . $row->Data_Start . "</td>";
                echo "<td>" . $row->Data_Finish . "</td>";
                echo "<td>" . $row->Locatie . "</td>";
                echo "<td>" . $row->Numar_Participant_Maxim . "</td>";
                if ($loggedIn) {
                    echo "<td><a href='modificare_eveniment.php?ID_Eveniment=" . $row->ID_Eveniment . "'>Modificare</a></td>";
                    echo "<td><a href='stergere_eveniment.php?ID_Eveniment=" . $row->ID_Eveniment . "'>Stergere</a></td>";
                    echo "<td><a href='cumpara-bilet.php?ID_Eveniment=" . $row->ID_Eveniment . "'>Cumpara Bilet</a></td>";
                }
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

    if ($loggedIn) echo '<a href="inserare_eveniment.php">Adaugarea unei noi inregistrari</a>';
    ?>

</body>

</html>