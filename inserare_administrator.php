<?php
include("conectare.php");
$error = '';
if (isset($_POST['submit'])) {
    $Nume = htmlentities($_POST['Nume'], ENT_QUOTES);
    $Prenume = htmlentities($_POST['Prenume'], ENT_QUOTES);
    $Email = htmlentities($_POST['Email'], ENT_QUOTES);
    $Parola = htmlentities($_POST['Parola'], ENT_QUOTES);

    if ($Nume == '' || $Prenume == '' || $Email == '' || $Parola == '') {
        $error = 'ERROR: Campuri goale!';
    } else {
        if ($stmt = $mysqli->prepare("INSERT INTO administrator(Nume, Prenume, Email,Parola) VALUES (?,?,?,?)")) {
            $stmt->bind_param("ssss", $Nume, $Prenume, $Email,$Parola);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "ERROR: Nu se poate executa insert.";
        }
    }
}
$mysqli->close();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <title><?php echo "Inserare inregistrare"; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
    <h1><?php echo "Inserare inregistrare"; ?></h1>
    <?php
    if ($error != '') {
        echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error . "</div>";
    }
    ?>
    <form action="" method="post">
        <div>
            <strong> Nume: </strong> <input type="text" name="Nume" value="" /> <br />
            <strong> Prenume: </strong> <input type="text" name="Prenume" value="" /> <br />
            <strong> Email: </strong> <input type="text" name="Email" value="" /> <br />
            <strong> Parola: </strong> <input type="password" name="Parola" value="" /> <br />
            <br />
            <input type="submit" name="submit" value="Submit" />
            <a href="vizualizare_administrator.php">Index</a>
        </div>
    </form>
</body>

</html>