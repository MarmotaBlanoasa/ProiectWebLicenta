<?php
global $mysqli;
include("conectare.php");
$error = '';

if (isset($_POST['submit'])) {
    $tip_bilet = htmlentities($_POST['Tip_Bilet'], ENT_QUOTES);
    $pret_bilet = htmlentities($_POST['Pret'], ENT_QUOTES);
    $id_eveniment = htmlentities($_POST['id_eveniment'], ENT_QUOTES);
    $id_participant = htmlentities($_POST['id_participant'], ENT_QUOTES);

    if ($tip_bilet == '' || $pret_bilet == '' || $id_participant == '') {
        $error = 'ERROR: Toate campurile sunt obligatorii!';
    } else {
        if ($stmt = $mysqli->prepare("INSERT INTO bilet (Tip_Bilet, Pret,ID_Eveniment,ID_Participant) VALUES (?, ?, ?, ?)")) {
            $stmt->bind_param("siii", $tip_bilet, $pret_bilet, $id_participant, $id_participant);
            if ($stmt->execute()) {
                echo "<div>Bilet cumparat cu success</div>";
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
    <title>Cupara bilet</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<h1>Cumpara bilet</h1>
<?php if ($error != '') {
    echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error . "</div>";
} ?>
<form action="" method="post">
    <input type="hidden" name="id_eveniment" value="<?php echo $_GET['ID_Eveniment']; ?>" />
    <input type="hidden" name="id_participant" value="1" />
    <div>
        <strong>Tip bilet:</strong> <label>
            <select name="Tip_Bilet" id="Tip_Bilet">
                <option value="Normal">Normal</option>
                <option value="VIP">VIP</option>
            </select>
        </label><br />
        <strong>Pret:</strong> <label>
            <input type="text" name="Pret" id="Pret" readonly />
        </label><br />
        <br />
        <button type="submit" name="submit" value="Submit" >
            Cumpara bilet
        </button>
        <a href="home.php">Index</a>
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
