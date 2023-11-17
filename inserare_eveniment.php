<?php
include("conectare.php");
require ("checkLogin.php");
$error = '';
if (isset($_POST['submit'])) {
    $Nume_Eveniment = htmlentities($_POST['Nume_Eveniment'], ENT_QUOTES);
    $Descriere = htmlentities($_POST['Descriere'], ENT_QUOTES);
    $Data_Start = htmlentities($_POST['Data_Start'], ENT_QUOTES);
    $Data_Finish = htmlentities($_POST['Data_Finish'], ENT_QUOTES);
    $Locatie = htmlentities($_POST['Locatie'], ENT_QUOTES);
    $Numar_Participant_Maxim = htmlentities($_POST['Numar_Participant_Maxim'], ENT_QUOTES);
    $count_query = (int)"SELECT COUNT(*) FROM eveniment";
    echo $count_query;
    if ($Nume_Eveniment == '' || $Descriere == '' || $Data_Start == '' || $Data_Finish == '' || $Locatie == '' || $Numar_Participant_Maxim == '') {
        $error = 'ERROR: Campuri goale!';
    } else {
        if ($stmt = $mysqli->prepare("INSERT INTO eveniment(ID_Eveniment,Nume_Eveniment, Descriere, Data_Start, Data_Finish,Locatie,Numar_Participant_Maxim) VALUES (?,?,?,?,?,?, ?)")) {
//            $id = $count_query + 1;
            $stmt->bind_param("isssssi", $id, $Nume_Eveniment, $Descriere, $Data_Start, $Data_Finish, $Locatie, $Numar_Participant_Maxim);
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
            <strong> Nume Eveniment: </strong> <input type="text" name="Nume_Eveniment" value="" /> <br />
            <strong> Descriere: </strong> <input type="text" name="Descriere" value="" /> <br />
            <strong> Data Start: </strong> <input type="date" name="Data_Start" value="" /> <br />
            <strong> Data Finish: </strong> <input type="date" name="Data_Finish" value="" /> <br />
            <strong> Locatie: </strong> <input type="text" name="Locatie" value="" /> <br />
            <strong> Numar Participant Maxim: </strong> <input type="number" name="Numar_Participant_Maxim" value="" /> <br />
            <br />
            <input type="submit" name="submit" value="Submit" />
            <a href="vizualizare_eveniment.php">Index</a>
        </div>
    </form>
</body>

</html>