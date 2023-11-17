<?php
    include("conectare.php");
    $error = '';

    // Extrage lista de evenimente
    $resultEveniment = $mysqli->query("SELECT ID_Eveniment, Nume_Eveniment FROM eveniment");
    $evenimente = $resultEveniment->fetch_all(MYSQLI_ASSOC);

    if (isset($_POST['submit']))
    {
        $ID_Eveniment = htmlentities($_POST['ID_Eveniment'], ENT_QUOTES);
        $Nume_Sesiune = htmlentities($_POST['Nume_Sesiune'], ENT_QUOTES);

        if ($ID_Eveniment == '' || $Nume_Sesiune == '')
        {
            $error = 'ERROR: Campuri goale!';
        }
        else
        {
            if ($stmt = $mysqli->prepare("INSERT INTO sesiune (ID_Eveniment, Nume_Sesiune) VALUES (?, ?)"))
            {
                $stmt->bind_param("is", $ID_Eveniment, $Nume_Sesiune);
                $stmt->execute();
                $stmt->close();
            }
            else 
            {
                echo "ERROR: Nu se poate executa insert.";
            }
        }
    }
    $mysqli->close();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head> 
        <title>Inserare Înregistrare</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    </head> 
    <body>
        <h1>Inserare Înregistrare</h1>
        <?php if ($error != '') 
            {
                echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error . "</div>";
            } 
        ?>
        <form action="" method="post">
            <div>
                <strong>Eveniment: </strong>
                <select name="ID_Eveniment">
                    <?php foreach ($evenimente as $eveniment) {
                        echo "<option value='" . $eveniment['ID_Eveniment'] . "'>" . $eveniment['Nume_Eveniment'] . "</option>";
                    } ?>
                </select><br/>
                <strong>Nume Sesiune: </strong> <input type="text" name="Nume_Sesiune" value=""/><br/>
                <br/>
                <input type="submit" name="submit" value="Submit" />
                <a href="vizualizare_sesiune.php">Index</a>
            </div>
        </form>
    </body>
</html>
