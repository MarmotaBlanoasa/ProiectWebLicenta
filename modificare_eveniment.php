<?php
session_start();
include("conectare.php");
include('checkLogin.php');
require_once "EventCRUD.php";
$error = '';
if (isset($_POST['submit'])) {
    $ID_Eveniment = $_POST['ID_Eveniment'];
    $Nume_Eveniment = htmlentities($_POST['Nume_Eveniment'], ENT_QUOTES);
    $Descriere = htmlentities($_POST['Descriere'], ENT_QUOTES);
    $Data_Start = htmlentities($_POST['Data_Start'], ENT_QUOTES);
    $Data_Finish = htmlentities($_POST['Data_Finish'], ENT_QUOTES);
    $Locatie = htmlentities($_POST['Locatie'], ENT_QUOTES);
    $Numar_Participant_Maxim = htmlentities($_POST['Numar_Participant_Maxim'], ENT_QUOTES);

    if ($Nume_Eveniment == '' || $Descriere == '' || $Data_Start == '' || $Data_Finish == '' || $Locatie == '' || $Numar_Participant_Maxim == '') {
        $error = 'ERROR: Campuri goale!';
    } else {
        $eventCRUD = new EventCRUD();
        $result = $eventCRUD->updateEvent($ID_Eveniment, $Nume_Eveniment, $Descriere, $Data_Start, $Data_Finish, $Locatie, $Numar_Participant_Maxim);
        if (!$result) {
            echo "ERROR: Nu se poate executa update.";
        }
    }
}
$mysqli->close();
?>

<html>

<head>
    <title> <?php if ($_GET['ID_Eveniment'] != '') {
            echo "Modificare inregistrare";
        } ?> </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8"/>
</head>

<body>
<h1><?php if ($_GET['ID_Eveniment'] != '') {
        echo "Modificare Inregistrare";
    } ?></h1>

<?php if ($error != '') {
    echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error . "</div>";
} ?>

<form action="" method="post">
    <div>
        <?php if ($_GET['ID_Eveniment'] != '') { ?>
            <input type="hidden" name="ID_Eveniment" value="<?php echo $_GET['ID_Eveniment']; ?>"/>
            <p>ID: <?php echo $_GET['ID_Eveniment'];
            $eventCRUD = new EventCRUD();
            $event = $eventCRUD->getEventById($_GET['ID_Eveniment']);
            if ($event) {
                $row = $event[0]; ?></p>
                <strong>Nume Eveniment: </strong> <input type="text" name="Nume_Eveniment"
                                                         value="<?php echo $row['Nume_Eveniment']; ?>"/><br/>
                <strong>Descriere: </strong> <input type="text" name="Descriere"
                                                    value="<?php echo $row['Descriere']; ?>"/><br/>
                <strong>Data Start: </strong> <input type="text" name="Data_Start"
                                                     value="<?php echo $row['Data_Start']; ?>"/><br/>
                <strong>Data Finish: </strong> <input type="text" name="Data_Finish"
                                                      value="<?php echo $row['Data_Finish']; ?>"/><br/>
                <strong>Locatie: </strong> <input type="text" name="Locatie" value="<?php echo $row['Locatie']; ?>"/>
                <br/>
                <strong>Numar Participant Maxim: </strong> <input type="number" name="Numar_Participant_Maxim"
                                                                  value="<?php echo $row['Numar_Participant_Maxim']; ?>"/>
                <br/>
            <?php }
        } ?>
        <br/>
        <br/>
        <input type="submit" name="submit" value="Submit"/>
        <a href="home.php">Index</a>
    </div>
</form>
</body>

</html>