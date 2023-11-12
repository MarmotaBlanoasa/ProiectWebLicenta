<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title>Vizualizare Inregistrari</title>
        <meta http-equiv="Content-Type" content="text/html", charset="utf-8"/>       
    </head>
    <body>
        <h1>Inregistrarile din tabela participant</h1>
        <p><b>Toate inregistrarile din participant</b></p>
        <?php
            include("conectare.php");
            if ($result = $mysqli->query("SELECT * FROM sesiune ORDER BY ID_Sesiune "))
            {
                if($result->num_rows>0)
                {
                    echo"<table border='1'cellpadding = '10'>";
                    echo "<tr>
                            <th>Id Sesiune</th>
                            <th>ID Eveniment</th>
                            <th>Nume Sesiune </th>  
                            <th></th>
                            <th></th>
                        </tr>";
                        while($row = $result -> fetch_object()) 
                        {
                            echo "<tr>";
                            echo "<td>" . $row->ID_Sesiune ."</td>";
                            echo "<td>" . $row->ID_Eveniment . "</td>";
                            echo "<td>" . $row->Nume_Sesiune . "</td>";
                            echo "<td><a href='modificare_sesiune.php?ID_Sesiune=" . $row->ID_Sesiune . "'>Modificare</a></td>";
                            echo "<td><a href='stergere_sesiune.php?ID_Sesiune=" .$row->ID_Sesiune . "'>Stergere</a></td>";
                            echo "</tr>";                
                        }
                    echo"</table>";   
                }
                else
                {
                    echo "Nu sunt inregistrari in tabela! ";
                }
            }
            else
            { 
                echo "Error: " . $mysqli->close(); 
            }
        $mysqli->close();
        ?>
        <a href = "inserare_sesiune.php">Adaugarea unei noi inregistrari</a>    
    </body>
</html>