<?php
// Conectare la baza de date
include("conectare.php");
$error = '';

// Verifică dacă ID-ul speaker_sesiune este setat
if (isset($_GET['ID_Speaker_Sesiune']) && is_numeric($_GET['ID_Speaker_Sesiune'])) {
    $ID_Speaker_Sesiune = $_GET['ID_Speaker_Sesiune'];

    // Extrage informațiile pentru speaker_sesiune curent
    $resultSpeakerSesiune = $mysqli->query("SELECT * FROM speaker_sesiune WHERE ID_Speaker_Sesiune = $ID_Speaker_Sesiune");
    $speaker_sesiune = $resultSpeakerSesiune->fetch_assoc();

    // Extrage lista de speakeri
    $resultSpeaker = $mysqli->query("SELECT ID_Speaker, Nume, Prenume FROM speaker");
    $speakeri = $resultSpeaker->fetch_all(MYSQLI_ASSOC);

    // Extrage lista de sesiuni
    $resultSesiune = $mysqli->query("SELECT ID_Sesiune, Nume_Sesiune FROM sesiune");
    $sesiuni = $resultSesiune->fetch_all(MYSQLI_ASSOC);

    // Procesează formularul la trimitere
    if (isset($_POST['submit'])) {
        $ID_Speaker = htmlentities($_POST['ID_Speaker'], ENT_QUOTES);
        $ID_Sesiune = htmlentities($_POST['ID_Sesiune'], ENT_QUOTES);

        if ($ID_Speaker == '' || $ID_Sesiune == '') {
            $error = 'ERROR: Completați toate câmpurile!';
        } else {
            if ($stmt = $mysqli->prepare("UPDATE speaker_sesiune SET ID_Speaker=?, ID_Sesiune=? WHERE ID_Speaker_Sesiune=?")) {
                $stmt->bind_param("iii", $ID_Speaker, $ID_Sesiune, $ID_Speaker_Sesiune);
                $stmt->execute();
                $stmt->close();
                header("Location: vizualizare_speaker_sesiune.php");
                exit;
            } else {
                $error = "ERROR: nu se poate executa update.";
            }
        }
    }
} else {
    $error = "ID speaker_sesiune invalid!";
}
$mysqli->close();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Modificare Înregistrare Speaker Sesiune</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
    <h1>Modificare Înregistrare Speaker Sesiune</h1>

    <?php if ($error != '') {
        echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error . "</div>";
    } ?>

    <form action="" method="post">
        <div>
            <input type="hidden" name="ID_Speaker_Sesiune" value="<?php echo $ID_Speaker_Sesiune; ?>" />
            <strong>Speaker: </strong>
            <select name="ID_Speaker">
                <?php foreach ($speakeri as $speaker) {
                    echo "<option value='" . $speaker['ID_Speaker'] . "'" . ($speaker['ID_Speaker'] == $speaker_sesiune['ID_Speaker'] ? ' selected' : '') . ">" . $speaker['Nume'] . " " . $speaker['Prenume'] . "</option>";
                } ?>
            </select><br />
            <strong>Sesiune: </strong>
            <select name="ID_Sesiune">
                <?php foreach ($sesiuni as $sesiune) {
                    echo "<option value='" . $sesiune['ID_Sesiune'] . "'" . ($sesiune['ID_Sesiune'] == $speaker_sesiune['ID_Sesiune'] ? ' selected' : '') . ">" . $sesiune['Nume_Sesiune'] . "</option>";
                } ?>
            </select><br />
            <br />
            <input type="submit" name="submit" value="Submit" />
            <a href="vizualizare_speaker_sesiune.php">Index</a>
        </div>
    </form>
</body>
</html>
