<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Vizualizare Înregistrări</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>       
</head>
<body>
    <h1>Înregistrările din tabela sesiune</h1>
    <p><b>Toate înregistrările din sesiune</b></p>
    <?php
        include("conectare.php");
        if ($result = $mysqli->query("SELECT sesiune.ID_Sesiune, sesiune.Nume_Sesiune, eveniment.Nume_Eveniment 
                                      FROM sesiune 
                                      JOIN eveniment ON sesiune.ID_Eveniment = eveniment.ID_Eveniment 
                                      ORDER BY sesiune.ID_Sesiune")) {
            if ($result->num_rows > 0) {
                echo "<table border='1' cellpadding='10'>";
                echo "<tr>
                        <th>ID Sesiune</th>
                        <th>Nume Eveniment</th>
                        <th>Nume Sesiune</th>  
                        <th>Modificare</th>
                        <th>Stergere</th>
                      </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['ID_Sesiune'] . "</td>";
                    echo "<td>" . $row['Nume_Eveniment'] . "</td>";
                    echo "<td>" . $row['Nume_Sesiune'] . "</td>";
                    echo "<td><a href='modificare_sesiune.php?ID_Sesiune=" . $row['ID_Sesiune'] . "'>Modificare</a></td>";
                    echo "<td><a href='stergere_sesiune.php?ID_Sesiune=" . $row['ID_Sesiune'] . "'>Stergere</a></td>";
                    echo "</tr>";                
                }
                echo "</table>";   
            } else {
                echo "Nu sunt înregistrări în tabelă!";
            }
        } else { 
            echo "Error: " . $mysqli->error; 
        }
        $mysqli->close();
    ?>
    <a href="inserare_sesiune.php">Adăugarea unei noi înregistrări</a>    
</body>
</html>
