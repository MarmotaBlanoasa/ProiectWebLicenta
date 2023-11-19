<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <title>Vizualizare Inregistrari</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>

<body>
    <h1>Inregistrarile din bilet </h1>
    <p><b>Toate inregistrarile din bilet</b></p>
    <?php
    include("conectare.php");

    // Interogarea SQL modificată
    $sql = "SELECT bilet.ID_Bilet, bilet.Tip_Bilet, bilet.Pret, eveniment.Nume_Eveniment, participant.Nume, participant.Prenume 
            FROM bilet 
            JOIN eveniment ON bilet.ID_Eveniment = eveniment.ID_Eveniment 
            JOIN participant ON bilet.ID_Participant = participant.ID_Participant 
            ORDER BY bilet.ID_Bilet";
    $result = $mysqli->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            echo "<table border='1' cellpadding='10'>";
            echo "<tr><th>ID Bilet</th><th>Tip Bilet</th><th>Pret</th><th>Eveniment</th><th>Participant</th><th></th><th></th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['ID_Bilet'] . "</td>";
                echo "<td>" . $row['Tip_Bilet'] . "</td>";
                echo "<td>" . $row['Pret'] . "</td>";
                echo "<td>" . $row['Nume_Eveniment'] . "</td>";
                echo "<td>" . $row['Nume'] . " " . $row['Prenume']. "</td>";
                echo "<td><a href='modificare_bilet.php?ID_Bilet=" . $row['ID_Bilet'] . "'>Modificare</a></td>";
                echo "<td><a href='stergere_bilet.php?ID_Bilet=" . $row['ID_Bilet'] . "'>Stergere</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Nu sunt inregistrari in tabela!";
        }
    } else {
        echo "Error: " . $mysqli->error;
    }
    $mysqli->close();
    ?>
    <a href="inserare_bilet.php">Adaugarea unei noi inregistrari</a>
</body>

</html>
