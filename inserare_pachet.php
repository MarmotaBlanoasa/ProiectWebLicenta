<?php
include("conectare.php");
$error = '';
if (isset($_POST['submit'])) {
    $Nume_Pachet = htmlentities($_POST['Nume_Pachet'], ENT_QUOTES);
    $Descriere = htmlentities($_POST['Descriere'], ENT_QUOTES);
    $Pret = htmlentities($_POST['Pret'], ENT_QUOTES);

    if ($Nume_Pachet == '' || $Descriere == '' || $Pret == '') {
        $error = 'ERROR: Campuri goale!';
    } else {
        if ($stmt = $mysqli->prepare("INSERT INTO pachet(Nume_Pachet, Descriere, Pret) VALUES (?,?,?)")) {
            $stmt->bind_param("ssi", $Nume_Pachet, $Descriere, $Pret);
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
            <strong> Nume Pachet: </strong>
            <label>
                <select name="Nume_Pachet" id="Nume_Pachet">
                    <option value="Silver">Silver</option>
                    <option value="Gold">Gold</option>
                    <option value="Platinum">Platinum</option>
                </select>
            </label><br />
            <strong> Descriere: </strong> <input type="text" name="Descriere" value="" /> <br />
            <strong> Pret: </strong> <input type="text" name="Pret" id="Pret" value="" readonly /> <br />
            <br />
            <input type="submit" name="submit" value="Submit" />
            <a href="vizualizare_pachet.php">Index</a>
        </div>
    </form>
    <script>
        function updatePrice() {
            var pretStandard = {
                'Silver': 1000,
                'Gold': 1500,
                'Platinum': 2000
            };
            var tipPachetSelectat = document.getElementById('Nume_Pachet').value;
            document.getElementById('Pret').value = pretStandard[tipPachetSelectat];
        }
        // Actualizează prețul la încărcarea paginii
        window.onload = updatePrice;

        // Continuă să actualizezi prețul la schimbarea selecției
        document.getElementById('Nume_Pachet').addEventListener('change', updatePrice);
    </script>
</body>

</html>