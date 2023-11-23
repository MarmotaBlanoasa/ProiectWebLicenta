<?php
session_start();
require ("checkLogin.php");
include("conectare.php");
require_once "EventCRUD.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <title>Vizualizare pachete</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>

<body>
    <h1>Inregistrarile din pachet </h1>
    <p><b>Toate pachetele</b></p>
    <?php
    $eventCrud = new EventCRUD();
    $pachete = $eventCrud->getPachete();
        if (!empty($pachete)) {
            echo "<table border='1' cellpadding='10'>";

            echo "<tr><th>ID Pachet</th><th>Nume Pachet</th><th>Descriere</th><th>Pret</th><th></th><th></th></tr>";

            foreach ($pachete as $row) {
                echo "<tr>";
                echo "<td>" . $row['ID_Pachet'] . "</td>";
                echo "<td>" . $row['Nume_Pachet'] . "</td>";
                echo "<td>" . $row['Descriere'] . "</td>";
                echo "<td>" . $row['Pret'] . "</td>";
                if (isset($_SESSION['loggedin'])){
                    echo "<td><a href='modificare_pachet.php?ID_Pachet=" . $row['ID_Pachet'] . "'>Modificare</a></td>";
                    echo "<td><a href='stergere_pachet.php?ID_Pachet=" . $row['ID_Pachet'] . "'>Stergere</a></td>";
                }
                echo "</tr>";
            }
            echo "</table>";

        } else {
            echo "Nu sunt inregistrari in tabela!";
        }

    $mysqli->close();
    ?>
    <?= isset($_SESSION['loggedin']) ? '<a href="inserare_pachet.php">Adaugarea unei noi inregistrari</a>' : ''?>
</body>

</html>