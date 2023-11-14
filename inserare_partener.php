<?php
global $mysqli;
include("conectare.php");
$error = '';

if (isset($_POST['submit'])) {
    $Nume_Partener = htmlentities($_POST['Nume_Partener'], ENT_QUOTES);
    $Descriere = htmlentities($_POST['Descriere'], ENT_QUOTES);
    $Contact_Nume = htmlentities($_POST['Contact_Nume'], ENT_QUOTES);
    $Contact_Email = htmlentities($_POST['Contact_Email'], ENT_QUOTES);
    $Contact_Telefon = htmlentities($_POST['Contact_Telefon'], ENT_QUOTES);
    $ID_Eveniment = $_POST['ID_Eveniment'];
    $ID_Pachet = $_POST['ID_Pachet'];

    if ($Nume_Partener == '' || $Contact_Nume == '' || $Contact_Email == '' || $Contact_Telefon == '') {
        $error = 'ERROR: Toate campurile sunt obligatorii!';
    } else {
        if ($stmt = $mysqli->prepare("INSERT INTO partener (Nume_Partener, Descriere, Contact_Nume, Contact_Email, Contact_Telefon, ID_Eveniment, ID_Pachet) VALUES (?, ?, ?, ?, ?, ?, ?)")) {
            $stmt->bind_param("sssssii", $Nume_Partener, $Descriere, $Contact_Nume, $Contact_Email, $Contact_Telefon, $ID_Eveniment, $ID_Pachet);
            if ($stmt->execute()) {
                echo "<div>Inregistrarea partenerului a fost adaugata cu succes!</div>";
            } else {
                $error = "ERROR: Nu se poate executa insert. " . $mysqli->error;
            }
            $stmt->close();
        } else {
            $error = "ERROR: Nu se poate pregati insert. " . $mysqli->error;
        }
    }
}
$mysqli->close();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <title>Inserare Partener</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
    <h1>Inserare Partener</h1>
    <?php if ($error != '') {
        echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error . "</div>";
    } ?>
    <form action="" method="post">
        <div>
            <strong>Nume Partener:</strong> <input type="text" name="Nume_Partener" value="" /><br />
            <strong>Descriere:</strong> <input type="text" name="Descriere" value="" /><br />
            <strong>Contact Nume:</strong> <input type="text" name="Contact_Nume" value="" /><br />
            <strong>Contact Email:</strong> <input type="email" name="Contact_Email" value="" /><br />
            <strong>Contact Telefon:</strong> <input type="text" name="Contact_Telefon" value="" /><br />
            <strong>ID Eveniment:</strong> <input type="number" name="ID_Eveniment" value="" /><br />
            <strong>ID Pachet:</strong> <input type="number" name="ID_Pachet" value="" /><br />
            <br />
            <input type="submit" name="submit" value="Submit" />
            <a href="vizualizare_partener.php">Index</a>
        </div>
    </form>
</body>

</html>
