<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Vizualizare Sponsor</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>
<body>
    <h1>Inregistrările din tabela sponsor</h1>
    <p><b>Toate înregistrările din sponsor</b></p>
    <?php
    include("conectare.php");
    if ($result = $mysqli->query("SELECT sponsor.*, eveniment.Nume_Eveniment FROM sponsor LEFT JOIN eveniment ON sponsor.ID_Eveniment = eveniment.ID_Eveniment ORDER BY ID_Sponsor")) {
        if ($result->num_rows > 0) {
            echo "<table border='1' cellpadding='10'>";
            echo "<tr>
                    <th>ID Sponsor</th>
                    <th>Nume Sponsor</th>
                    <th>Descriere</th>
                    <th>Contact Nume</th>
                    <th>Contact Email</th>
                    <th>Contact Telefon</th>
                    <th>Eveniment</th>
                    <th></th>
                    <th></th>
                </tr>";

            while ($row = $result->fetch_object()) {
                echo "<tr>";
                echo "<td>" . $row->ID_Sponsor . "</td>";
                echo "<td>" . $row->Nume_Sponsor . "</td>";
                echo "<td>" . $row->Descriere . "</td>";
                echo "<td>" . $row->Contact_Nume . "</td>";
                echo "<td>" . $row->Contact_Email . "</td>";
                echo "<td>" . $row->Contact_Telefon . "</td>";
                echo "<td>" . $row->Nume_Eveniment . "</td>";  
                echo "<td><a href='modificare_sponsor.php?ID_Sponsor=" . $row->ID_Sponsor . "'>Modificare</a></td>";
                echo "<td><a href='stergere_sponsor.php?ID_Sponsor=" . $row->ID_Sponsor . "'>Ștergere</a></td>";
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
    <a href="inserare_sponsor.php">Adăugarea unui nou sponsor</a>
</body>
</html>
