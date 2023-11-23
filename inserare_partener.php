<?php
session_start();
include("conectare.php");
require_once 'EventCRUD.php';
require 'checkLogin.php';
$error = '';

// Fetch Eveniment and Pachet options from the database
$eventCRUD = new EventCRUD();
$evenimentOptions = $eventCRUD->getAllEvents();
$pachetOptions = $eventCRUD->getPachete();

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
        $result = $eventCRUD->addPartener($Nume_Partener, $Descriere, $Contact_Nume, $Contact_Email, $Contact_Telefon, $ID_Eveniment, $ID_Pachet);
        if (!$result) {
            echo "ERROR: Nu se poate executa insert.";
        }
    }
}
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

            <strong>ID Eveniment:</strong>
            <select name="ID_Eveniment">
                <?php foreach ($evenimentOptions as $row): ?>
                    <option value="<?php echo $row['ID_Eveniment']; ?>"><?php echo $row['Nume_Eveniment']; ?></option>
                <?php endforeach; ?>
            </select><br />

            <strong>ID Pachet:</strong>
            <select name="ID_Pachet">
                <?php foreach ($pachetOptions as $row): ?>
                    <option value="<?php echo $row['ID_Pachet']; ?>"><?php echo $row['Nume_Pachet']; ?></option>
                <?php endforeach; ?>
            </select><br />
            <br />
            <input type="submit" name="submit" value="Submit" />
            <a href="vizualizare_partener.php">Index</a>
        </div>
    </form>
</body>
</html>