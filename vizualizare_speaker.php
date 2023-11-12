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
            if ($result = $mysqli->query("SELECT * FROM speaker ORDER BY ID_Speaker "))
            {
                if($result->num_rows>0)
                {
                    echo"<table border='1'cellpadding = '10'>";
                    echo "<tr>
                            <th>ID Speaker</th>
                            <th>Nume</th>
                            <th>Prenume</th>
                            <th>Email</th> 
                            <th>Telefon</th> 
                            <th>Bio</th>   
                            <th></th>
                            <th></th>
                        </tr>";
                        while($row = $result -> fetch_object()) 
                        {
                            echo "<tr>";
                            echo "<td>" . $row->ID_Speaker ."</td>";
                            echo "<td>" . $row->Nume . "</td>";
                            echo "<td>" . $row->Prenume . "</td>";
                            echo "<td>" . $row->Email . "</td>";
                            echo "<td>" . $row->Telefon . "</td>";
                            echo "<td>" . $row->Bio . "</td>";
                        
                            echo "<td><a href='modificare_speaker.php?ID_Speaker=" . $row->ID_Speaker . "'>Modificare</a></td>";
                            echo "<td><a href='stergere_speaker.php?ID_Speaker=" .$row->ID_Speaker . "'>Stergere</a></td>";
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
        <a href = "inserare_speaker.php">Adaugarea unei noi inregistrari</a>    
    </body>
</html>