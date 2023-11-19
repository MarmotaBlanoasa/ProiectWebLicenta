<?php
include("conectare.php");
$error = '';

// Extrage lista de speakeri
$resultSpeaker = $mysqli->query("SELECT ID_Speaker, Nume, Prenume FROM speaker");
$speakeri = $resultSpeaker->fetch_all(MYSQLI_ASSOC);

// Extrage lista de sesiuni
$resultSesiune = $mysqli->query("SELECT ID_Sesiune, Nume_Sesiune FROM sesiune");
$sesiuni = $resultSesiune->fetch_all(MYSQLI_ASSOC);

if (isset($_POST['submit'])) {
    $ID_Speaker = htmlentities($_POST['ID_Speaker'], ENT_QUOTES);
    $ID_Sesiune = htmlentities($_POST['ID_Sesiune'], ENT_QUOTES);

    if ($ID_Speaker == '' || $ID_Sesiune == '') {
        $error = 'ERROR: Campuri goale!';
    } else {
        if ($stmt = $mysqli->prepare("INSERT INTO speaker_sesiune (ID_Speaker, ID_Sesiune) VALUES (?, ?)")) {
            $stmt->bind_param("ii", $ID_Speaker, $ID_Sesiune);
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
    <title><?php echo "Inserare Speaker in Sesiune"; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
    <h1><?php echo "Inserare Speaker in Sesiune"; ?></h1>
    <?php
    if ($error != '') {
        echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error . "</div>";
    }
    ?>
    <form action="" method="post">
        <div>
            <strong> Speaker: </strong>
            <select name="ID_Speaker">
                <?php foreach ($speakeri as $speaker) { ?>
                    <option value="<?php echo $speaker['ID_Speaker']; ?>">
                        <?php echo $speaker['Nume'] . " " . $speaker['Prenume']; ?>
                    </option>
                <?php } ?>
            </select> <br />
            <strong> Sesiune: </strong>
            <select name="ID_Sesiune">
                <?php foreach ($sesiuni as $sesiune) { ?>
                    <option value="<?php echo $sesiune['ID_Sesiune']; ?>">
                        <?php echo $sesiune['Nume_Sesiune']; ?>
                    </option>
                <?php } ?>
            </select> <br />
            <br />
            <input type="submit" name="submit" value="Submit" />
            <a href="vizualizare_speaker_sesiune.php">Index</a>
        </div>
    </form>
</body>

</html>
