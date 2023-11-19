<?php
include("conectare.php");
$error = '';

// Extrage lista de evenimente
$resultEveniment = $mysqli->query("SELECT ID_Eveniment, Nume_Eveniment FROM eveniment");
$evenimente = $resultEveniment->fetch_all(MYSQLI_ASSOC);

// Extrage lista de participanti
$resultParticipant = $mysqli->query("SELECT ID_Participant, Nume, Prenume FROM participant");
$participanti = $resultParticipant->fetch_all(MYSQLI_ASSOC);

if (isset($_POST['submit'])) {
    $Tip_Bilet = htmlentities($_POST['Tip_Bilet'], ENT_QUOTES);
    $Pret = htmlentities($_POST['Pret'], ENT_QUOTES);
    $ID_Eveniment = htmlentities($_POST['ID_Eveniment'], ENT_QUOTES);
    $ID_Participant = htmlentities($_POST['ID_Participant'], ENT_QUOTES);

    if ($Tip_Bilet == '' || $Pret == '' || $ID_Eveniment == '' || $ID_Participant == '') {
        $error = 'ERROR: Campuri goale!';
    } else {
        if ($stmt = $mysqli->prepare("INSERT INTO bilet (Tip_Bilet, Pret, ID_Eveniment, ID_Participant) VALUES (?, ?, ?, ?)")) {
            $stmt->bind_param("siii", $Tip_Bilet, $Pret, $ID_Eveniment, $ID_Participant);
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
            <strong>Tip bilet:</strong> <label>
                <select name="Tip_Bilet" id="Tip_Bilet">
                    <option value="Normal">Normal</option>
                    <option value="VIP">VIP</option>
                </select>
            </label><br />
            <strong>Pret:</strong> <label>
                <input type="text" name="Pret" id="Pret" readonly/>
            </label><br/>
            <strong> Eveniment: </strong>
            <select name="ID_Eveniment">
                <?php foreach ($evenimente as $eveniment) { ?>
                    <option value="<?php echo $eveniment['ID_Eveniment']; ?>">
                        <?php echo $eveniment['Nume_Eveniment']; ?>
                    </option>
                <?php } ?>
            </select> <br />
            <strong> Participant: </strong>
            <select name="ID_Participant">
                <?php foreach ($participanti as $participant) { ?>
                    <option value="<?php echo $participant['ID_Participant']; ?>">
                        <?php echo $participant['Nume'] . " " . $participant['Prenume']; ?>
                    </option>
                <?php } ?>
            </select> <br />
            <br />
            <input type="submit" name="submit" value="Submit" />
            <a href="vizualizare_bilet.php">Index</a>
        </div>
    </form>
    <script>
    function updatePrice() {
        var pretStandard = {
            'Normal': 200,
            'VIP': 300,
        };
        var tipBiletSelectat = document.getElementById('Tip_Bilet').value;
        document.getElementById('Pret').value = pretStandard[tipBiletSelectat];
    }

    // Actualizează prețul la încărcarea paginii
    window.onload = updatePrice;

    // Continuă să actualizezi prețul la schimbarea selecției
    document.getElementById('Tip_Bilet').addEventListener('change', updatePrice);
</script>
</body>

</html>