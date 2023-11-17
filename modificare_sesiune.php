<?php
include("conectare.php");
$error = '';

// Extrage lista de evenimente
$resultEveniment = $mysqli->query("SELECT ID_Eveniment, Nume_Eveniment FROM eveniment");
$evenimente = $resultEveniment->fetch_all(MYSQLI_ASSOC);

if (isset($_POST['submit']) && is_numeric($_POST['ID_Sesiune'])) {
    $ID_Sesiune = $_POST['ID_Sesiune'];
    $ID_Eveniment = htmlentities($_POST['ID_Eveniment'], ENT_QUOTES);
    $Nume_Sesiune = htmlentities($_POST['Nume_Sesiune'], ENT_QUOTES);

    if ($ID_Eveniment == '' || $Nume_Sesiune == '') {
        $error = 'ERROR: Campuri goale!';
    } else {
        if ($stmt = $mysqli->prepare("UPDATE sesiune SET ID_Eveniment=?, Nume_Sesiune=? WHERE ID_Sesiune=?")) {
            $stmt->bind_param("isi", $ID_Eveniment, $Nume_Sesiune, $ID_Sesiune);
            $stmt->execute();
            $stmt->close();
            header("Location: vizualizare_sesiune.php");
            exit;
        } else {
            $error = "ERROR: Nu se poate executa update.";
        }
    }
} elseif (isset($_GET['ID_Sesiune']) && is_numeric($_GET['ID_Sesiune'])) {
    $ID_Sesiune = $_GET['ID_Sesiune'];
    if ($result = $mysqli->query("SELECT * FROM sesiune WHERE ID_Sesiune = $ID_Sesiune")) {
        $sesiune = $result->fetch_assoc();
    } else {
        $error = "Nu s-au putut prelua datele.";
    }
}

$mysqli->close();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Modificare Înregistrare Sesiune</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
    <h1>Modificare Înregistrare Sesiune</h1>

    <?php if ($error != '') {
        echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error . "</div>";
    } ?>

    <form action="" method="post">
        <div>
            <input type="hidden" name="ID_Sesiune" value="<?php echo $sesiune['ID_Sesiune']; ?>" />
            <strong>Eveniment: </strong>
            <select name="ID_Eveniment">
                <?php foreach ($evenimente as $eveniment) {
                    $selected = $eveniment['ID_Eveniment'] == $sesiune['ID_Eveniment'] ? 'selected' : '';
                    echo "<option value='" . $eveniment['ID_Eveniment'] . "' $selected>" . $eveniment['Nume_Eveniment'] . "</option>";
                } ?>
            </select><br />
            <strong>Nume Sesiune: </strong> <input type="text" name="Nume_Sesiune" value="<?php echo $sesiune['Nume_Sesiune']; ?>" /><br />
            <br />
            <input type="submit" name="submit" value="Submit" />
            <a href="vizualizare_sesiune.php">Index</a>
        </div>
    </form>
</body>
</html>

