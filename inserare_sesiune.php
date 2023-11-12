<?php
    include("conectare.php");
    $error = '';
    if (isset($_POST['submit']))
    {
        $ID_Eveniment = htmlentities($_POST['ID_Eveniment'], ENT_QUOTES);
        $Nume_Sesiune = htmlentities($_POST['Nume_Sesiune'], ENT_QUOTES);
        if ($ID_Eveniment == ''|| $Nume_Sesiune=='')
        {
            $error = 'ERROR:Campuri goale!';
        }
        else
        {
            if ($stmt = $mysqli->prepare("INSERT into sesiune ( ID_Eveniment, Nume_Sesiune ) VALUES ( ?, ?)"))
            {
                $stmt->bind_param("ss", $ID_Eveniment,$Nume_Sesiune);
                $stmt->execute();
                $stmt->close();
            }
            else 
            {
                echo "ERROR:Nu se poate executa insert.";
            }
        }
    }
    $mysqli->close();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head> 
        <title><?php echo "Inserare inregistrare"; ?> </title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    </head> 
    <body>
        <h1><?php echo "Inserare inregistrare"; ?></h1>
        <?php if ($error != '') 
                {
                echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error."</div>";
                } 
        ?>
        <form action="" method="post">
            <div>
                <strong>ID Eveniment: </strong> <input type="text" name="ID_Eveniment" value=""/><br/>
                <strong>Nume Sesiune: </strong> <input type="text" name="Nume_Sesiune" value=""/><br/>
                <br/>
                <input type="submit" name="submit" value="Submit" />
                <a href="vizualizare_sesiune.php">Index</a>
            </div>
        </form>
    </body>
</html>