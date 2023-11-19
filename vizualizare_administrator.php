<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <title>Vizualizare Inregistrari</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>

<body>
    <h1>Inregistrarile din administrator </h1>
    <p><b>Toate inregistrarile din administrator</b></p>
    <?php
    include("conectare.php");
    if ($result = $mysqli->query("SELECT * FROM administrator ORDER BY ID_Administrator")) {
        if ($result->num_rows > 0) {
            echo "<table border='1' cellpadding='10'>";

            echo "<tr><th>ID Administrator</th><th>Nume</th><th>Prenume</th><th>Email</th><th>Parola</th><th></th><th></th></tr>";

            while ($row = $result->fetch_object()) {
                echo "<tr>";
                echo "<td>" . $row->ID_Administrator . "</td>";
                echo "<td>" . $row->Nume . "</td>";
                echo "<td>" . $row->Prenume . "</td>";
                echo "<td>" . $row->Email . "</td>";
                echo "<td>" . $row->Parola . "</td>";
                echo "<td><a href='modificare_administrator.php?ID_Administrator=" . $row->ID_Administrator . "'>Modificare</a></td>";
                echo "<td><a href='stergere_administrator.php?ID_Administrator=" . $row->ID_Administrator . "'>Stergere</a></td>";
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
    <a href="inserare_administrator.php">Adaugarea unei noi inregistrari</a>
</body>

</html>