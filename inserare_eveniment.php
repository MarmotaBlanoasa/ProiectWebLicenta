<?php
session_start();
include("conectare.php");
include('checkLogin.php');
require_once "EventCRUD.php";
$error = '';
$eventCRUD = new EventCRUD();
if (isset($_POST['submit'])) {
    $Nume_Eveniment = htmlentities($_POST['Nume_Eveniment'], ENT_QUOTES);
    $Descriere = htmlentities($_POST['Descriere'], ENT_QUOTES);
    $Data_Start = htmlentities($_POST['Data_Start'], ENT_QUOTES);
    $Data_Finish = htmlentities($_POST['Data_Finish'], ENT_QUOTES);
    $Locatie = htmlentities($_POST['Locatie'], ENT_QUOTES);
    $Numar_Participant_Maxim = htmlentities($_POST['Numar_Participant_Maxim'], ENT_QUOTES);
    $result = null;
    if ($Nume_Eveniment == '' || $Descriere == '' || $Data_Start == '' || $Data_Finish == '' || $Locatie == '' || $Numar_Participant_Maxim == '') {
        $error = 'ERROR: Campuri goale!';
    } else {
        $result = $eventCRUD->addEvent($Nume_Eveniment, $Descriere, $Data_Start, $Data_Finish, $Locatie, $Numar_Participant_Maxim);
        if (!$result) {
            echo "ERROR: Nu se poate executa insert.";
        }
    }
    if ($result !== null) {
        $ID_Eveniment = intval($result);
        // If the event was successfully added, add the agendas
        foreach ($_POST['agenda'] as $agenda) {
            $Nume_Sesiune = htmlentities($agenda['Nume_Sesiune'], ENT_QUOTES);
            $Ora_Inceput = htmlentities($agenda['Ora_Inceput'], ENT_QUOTES);
            $Ora_Sfarsit = htmlentities($agenda['Ora_Sfarsit'], ENT_QUOTES);
            $Descriere = htmlentities($agenda['Descriere'], ENT_QUOTES);
            $ID_Speaker = (int)htmlentities($agenda['ID_Speaker'], ENT_QUOTES);
            $result = $eventCRUD->addAgenda($Nume_Sesiune, $Ora_Inceput, $Ora_Sfarsit, $Descriere, $ID_Eveniment, $ID_Speaker);
            if (!$result) {
                echo "ERROR: Nu se poate executa insert pentru agenda.";
            }
        }
    } else {
        echo "ERROR: Nu se poate executa insert pentru eveniment.";
    }
}
$mysqli->close();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <title><?php echo "Inserare inregistrare"; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
        <strong> Nume Eveniment: </strong> <input type="text" name="Nume_Eveniment" value=""/> <br/>
        <strong> Descriere: </strong> <input type="text" name="Descriere" value=""/> <br/>
        <strong> Data Start: </strong> <input type="date" name="Data_Start" value=""/> <br/>
        <strong> Data Finish: </strong> <input type="date" name="Data_Finish" value=""/> <br/>
        <strong> Locatie: </strong> <input type="text" name="Locatie" value=""/> <br/>
        <strong> Numar Participant Maxim: </strong> <input type="number" name="Numar_Participant_Maxim" value=""/> <br/>
        <br/>
        <?php $speakerOptions = $eventCRUD->getAllSpeakers(); ?>
        <?php for ($i = 0; $i < 3; $i++): ?>
            <h3>Agenda <?php echo $i + 1; ?></h3>
            <strong>Nume Sesiune:</strong> <input type="text" name="agenda[<?php echo $i; ?>][Nume_Sesiune]" /><br />
            <strong>Ora Început:</strong> <input type="time" name="agenda[<?php echo $i; ?>][Ora_Inceput]" /><br />
            <strong>Ora Sfârșit:</strong> <input type="time" name="agenda[<?php echo $i; ?>][Ora_Sfarsit]" /><br />
            <strong>Descriere:</strong> <textarea name="agenda[<?php echo $i; ?>][Descriere]"></textarea><br />
            <strong>Speaker:</strong>
            <select name="agenda[<?php echo $i; ?>][ID_Speaker]">
                <?php foreach ($speakerOptions as $speaker): ?>
                    <option value="<?php echo $speaker['ID_Speaker']; ?>"><?php echo $speaker['Nume']; ?></option>
                <?php endforeach; ?>
            </select><br />
        <?php endfor; ?>
        <br/>
        <input type="submit" name="submit" value="Submit"/>
        <a href="home.php">Index</a>
    </div>
</form>
</body>

</html>