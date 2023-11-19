<?php
include("conectare.php");
$error = '';

// Extrage lista de evenimente
$resultEveniment = $mysqli->query("SELECT ID_Eveniment, Nume_Eveniment FROM eveniment");
$evenimente = $resultEveniment->fetch_all(MYSQLI_ASSOC);

if (isset($_POST['submit'])) {
    $Nume_Sponsor = htmlentities($_POST['Nume_Sponsor'], ENT_QUOTES);
    $Descriere = htmlentities($_POST['Descriere'], ENT_QUOTES);
    $Contact_Nume = htmlentities($_POST['Contact_Nume'], ENT_QUOTES);
    $Contact_Email = htmlentities($_POST['Contact_Email'], ENT_QUOTES);
    $Contact_Telefon = htmlentities($_POST['Contact_Telefon'], ENT_QUOTES);
    $ID_Eveniment = $_POST['ID_Eveniment'];

    if ($Nume_Sponsor == '' || $Descriere == '' || $Contact_Nume == '' || $Contact_Email == '' || $Contact_Telefon == '' || $ID_Eveniment == '') {
        $error = 'ERROR: Toate campurile sunt obligatorii!';
    } else {
        if ($stmt = $mysqli->prepare("INSERT INTO sponsor (Nume_Sponsor, Descriere, Contact_Nume, Contact_Email, Contact_Telefon, ID_Eveniment) VALUES (?, ?, ?, ?, ?, ?)")) {
            $stmt->bind_param("sssssi", $Nume_Sponsor, $Descriere, $Contact_Nume, $Contact_Email, $Contact_Telefon, $ID_Eveniment);
            if ($stmt->execute()) {
                echo "<div>Inregistrarea sponsorului a fost adaugata cu succes!</div>";
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
    <title>Inserare Sponsor</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
    <h1>Inserare Sponsor</h1>
    <?php if ($error != '') {
        echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error . "</div>";
    } ?>
    <form action="" method="post">
        <div>
            <strong>Nume Sponsor:</strong> <input type="text" name="Nume_Sponsor" value="" /><br />
            <strong>Descriere:</strong> <input type="text" name="Descriere" value="" /><br />
            <strong>Contact Nume:</strong> <input type="text" name="Contact_Nume" value="" /><br />
            <strong>Contact Email:</strong> <input type="email" name="Contact_Email" value="" /><br />
            <strong>Contact Telefon:</strong> <input type="text" name="Contact_Telefon" value="" /><br />
            <strong>Eveniment:</strong>
            <select name="ID_Eveniment">
                <?php foreach ($evenimente as $eveniment) {
                    echo "<option value='" . $eveniment['ID_Eveniment'] . "'>" . $eveniment['Nume_Eveniment'] . "</option>";
                } ?>
            </select><br />
            <br />
            <input type="submit" name="submit" value="Submit" />
            <a href="vizualizare_sponsor.php">Index</a>
        </div>
    </form>
</body>

</html>
