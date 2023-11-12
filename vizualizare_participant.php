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
            if ($result = $mysqli->query("SELECT * FROM participant ORDER BY ID_Participant "))
            {
                if($result->num_rows>0)
                {
                    echo"<table border='1'cellpadding = '10'>";
                    echo "<tr>
                            <th>Id Participant</th>
                            <th>Nume</th>
                            <th>Prenume </th>
                            <th>Email</th>
                            <th>Telefon</th>    
                            <th></th>
                            <th></th>
                        </tr>";
                        while($row = $result -> fetch_object()) 
                        {
                            echo "<tr>";
                            echo "<td>" . $row->ID_Participant ."</td>";
                            echo "<td>" . $row->Nume . "</td>";
                            echo "<td>" . $row->Prenume . "</td>";
                            echo "<td>" . $row->Email . "</td>";
                            echo "<td>" . $row->Telefon . "</td>";
                            echo "<td><a href='modificare_participant.php?ID_Participant=" . $row->ID_Participant . "'>Modificare</a></td>";
                            echo "<td><a href='stergere_participant.php?ID_Participant=" .$row->ID_Participant . "'>Stergere</a></td>";
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
        <a href = "inserare_participant.php">Adaugarea unei noi inregistrari</a>    
    </body>
</html>