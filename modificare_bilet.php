<?php
// Conectare la baza de date
include("conectare.php");
$error = '';

// Verifică dacă ID-ul biletului este setat
if (isset($_GET['ID_Bilet']) && is_numeric($_GET['ID_Bilet'])) {
    $ID_Bilet = $_GET['ID_Bilet'];

    // Extrage informațiile pentru biletul curent
    $resultBilet = $mysqli->query("SELECT * FROM bilet WHERE ID_Bilet = $ID_Bilet");
    $bilet = $resultBilet->fetch_assoc();

    // Extrage lista de evenimente
    $resultEveniment = $mysqli->query("SELECT ID_Eveniment, Nume_Eveniment FROM eveniment");
    $evenimente = $resultEveniment->fetch_all(MYSQLI_ASSOC);

    // Extrage lista de participanți
    $resultParticipant = $mysqli->query("SELECT ID_Participant, Nume, Prenume FROM participant");
    $participanti = $resultParticipant->fetch_all(MYSQLI_ASSOC);

    // Procesează formularul la trimitere
    if (isset($_POST['submit'])) {
        $Tip_Bilet = htmlentities($_POST['Tip_Bilet'], ENT_QUOTES);
        $Pret = htmlentities($_POST['Pret'], ENT_QUOTES);
        $ID_Eveniment = htmlentities($_POST['ID_Eveniment'], ENT_QUOTES);
        $ID_Participant = htmlentities($_POST['ID_Participant'], ENT_QUOTES);

        if ($Tip_Bilet == '' || $Pret == '' || $ID_Eveniment == '' || $ID_Participant == '') {
            $error = 'ERROR: Completați toate câmpurile!';
        } else {
            if ($stmt = $mysqli->prepare("UPDATE bilet SET Tip_Bilet=?, Pret=?, ID_Eveniment=?, ID_Participant=? WHERE ID_Bilet=?")) {
                $stmt->bind_param("siiii", $Tip_Bilet, $Pret, $ID_Eveniment, $ID_Participant, $ID_Bilet);
                $stmt->execute();
                $stmt->close();
                header("Location: vizualizare_bilet.php");
                exit;
            } else {
                $error = "ERROR: nu se poate executa update.";
            }
        }
    }
} else {
    $error = "ID bilet invalid!";
}
$mysqli->close();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Modificare Inregistrare</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
</head>
<body>
    <h1>Modificare Inregistrare</h1>

    <?php if ($error != '') {
        echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error . "</div>";
    } ?>

    <form action="" method="post">
        <div>
            <input type="hidden" name="ID_Bilet" value="<?php echo $ID_Bilet; ?>" />
            <div>
            <strong>Tip bilet:</strong> <label>
                <select name="Tip_Bilet" id="Tip_Bilet">
                    <option value="Normal">Normal</option>
                    <option value="VIP">VIP</option>
                </select>
            </label><br />
            <strong>Pret:</strong> <label>
                <input type="text" name="Pret" id="Pret" readonly />
            </label><br/>
            <strong>Eveniment: </strong>
            <select name="ID_Eveniment">
                <?php foreach ($evenimente as $eveniment) {
                    echo "<option value='" . $eveniment['ID_Eveniment'] . "'" . ($eveniment['ID_Eveniment'] == $bilet['ID_Eveniment'] ? ' selected' : '') . ">" . $eveniment['Nume_Eveniment'] . "</option>";
                } ?>
            </select><br />
            <strong>Participant: </strong>
            <select name="ID_Participant">
                <?php foreach ($participanti as $participant) {
                    $numeComplet = $participant['Nume'] . " " . $participant['Prenume'];
                    echo "<option value='" . $participant['ID_Participant'] . "'" . ($participant['ID_Participant'] == $bilet['ID_Participant'] ? ' selected' : '') . ">" . $numeComplet . "</option>";
                } ?>
            </select><br />
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