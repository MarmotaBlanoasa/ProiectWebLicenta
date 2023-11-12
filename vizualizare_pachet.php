<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <title>Vizualizare Inregistrari</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>

<body>
    <h1>Inregistrarile din pachet </h1>
    <p><b>Toate inregistrarile din pachet</b></p>
    <?php
    include("conectare.php");
    if ($result = $mysqli->query("SELECT * FROM pachet ORDER BY ID_Pachet")) {
        if ($result->num_rows > 0) {
            echo "<table border='1' cellpadding='10'>";

            echo "<tr><th>ID Pachet</th><th>Nume Pachet</th><th>Descriere</th><th>Pret</th><th></th><th></th></tr>";

            while ($row = $result->fetch_object()) {
                echo "<tr>";
                echo "<td>" . $row->ID_Pachet . "</td>";
                echo "<td>" . $row->Nume_Pachet . "</td>";
                echo "<td>" . $row->Descriere . "</td>";
                echo "<td>" . $row->Pret . "</td>";
                echo "<td><a href='modificare_pachet.php?ID_Pachet=" . $row->ID_Pachet . "'>Modificare</a></td>";
                echo "<td><a href='stergere_pachet.php?ID_Pachet=" . $row->ID_Pachet . "'>Stergere</a></td>";
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
    <a href="inserare_pachet.php">Adaugarea unei noi inregistrari</a>
</body>

</html>