<?php
global $mysqli;
include("conectare.php");
$error = '';

// Fetch Eveniment options from the database
$evenimentOptions = $mysqli->query("SELECT ID_Eveniment, Nume_Eveniment FROM eveniment");

if (isset($_POST['submit'])) {
    $Nume_Sesiune = htmlentities($_POST['Nume_Sesiune'], ENT_QUOTES);
    $Ora_Inceput = htmlentities($_POST['Ora_Inceput'], ENT_QUOTES);
    $Ora_Sfarsit = htmlentities($_POST['Ora_Sfarsit'], ENT_QUOTES);
    $Descriere = htmlentities($_POST['Descriere'], ENT_QUOTES);
    $ID_Eveniment = $_POST['ID_Eveniment'];

    if ($Nume_Sesiune == '' || $Ora_Inceput == '' || $Ora_Sfarsit == '') {
        $error = 'ERROR: Toate campurile obligatorii trebuie completate!';
    } else {
        if ($stmt = $mysqli->prepare("INSERT INTO agenda (Nume_Sesiune, Ora_Inceput, Ora_Sfarsit, Descriere, ID_Eveniment) VALUES (?, ?, ?, ?, ?)")) {
            $stmt->bind_param("ssssi", $Nume_Sesiune, $Ora_Inceput, $Ora_Sfarsit, $Descriere, $ID_Eveniment);
            if ($stmt->execute()) {
                header("Location: vizualizare_agenda.php"); // Redirect la vizualizare agenda după insert
                exit();
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
    <title>Inserare Agenda</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
    <h1>Inserare Agenda</h1>
    <?php if ($error != '') {
        echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error . "</div>";
    } ?>
    <form action="" method="post">
        <div>
            <strong>Nume Sesiune:</strong> <input type="text" name="Nume_Sesiune" value="" /><br />
            <strong>Ora Început:</strong> <input type="time" name="Ora_Inceput" value="" /><br />
            <strong>Ora Sfârșit:</strong> <input type="time" name="Ora_Sfarsit" value="" /><br />
            <strong>Descriere:</strong> <textarea name="Descriere"></textarea><br />
            
            <strong>Eveniment:</strong> 
            <select name="ID_Eveniment">
                <?php while ($row = $evenimentOptions->fetch_assoc()): ?>
                    <option value="<?php echo $row['ID_Eveniment']; ?>"><?php echo $row['Nume_Eveniment']; ?></option>
                <?php endwhile; ?>
            </select><br />

            <br />
            <input type="submit" name="submit" value="Submit" />
            <a href="vizualizare_agenda.php">Index</a>
        </div>
    </form>
</body>
</html>
