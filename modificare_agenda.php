<?php
// Connect to the database
include("conectare.php");
$error = '';

if (isset($_GET['ID_Agenda']) && is_numeric($_GET['ID_Agenda'])) {
    $ID_Agenda = $_GET['ID_Agenda'];

    // Fetch the current agenda details
    if ($result = $mysqli->query("SELECT * FROM agenda WHERE ID_Agenda = $ID_Agenda")) {
        $row = $result->fetch_object();
    }

    // Fetch Eveniment options from the database
    $evenimentOptions = $mysqli->query("SELECT ID_Eveniment, Nume_Eveniment FROM eveniment");
    $evenimente = $evenimentOptions->fetch_all(MYSQLI_ASSOC);

    // Process the form when submitted
    if (isset($_POST['submit'])) {
        $Nume_Sesiune = htmlentities($_POST['Nume_Sesiune'], ENT_QUOTES);
        $Ora_Inceput = htmlentities($_POST['Ora_Inceput'], ENT_QUOTES);
        $Ora_Sfarsit = htmlentities($_POST['Ora_Sfarsit'], ENT_QUOTES);
        $Descriere = htmlentities($_POST['Descriere'], ENT_QUOTES);
        $ID_Eveniment = $_POST['ID_Eveniment'];

        // Validate fields
        if ($Nume_Sesiune == '' || $Ora_Inceput == '' || $Ora_Sfarsit == '') {
            $error = 'ERROR: Complete all mandatory fields!';
        } else {
            // Execute the update
            if ($stmt = $mysqli->prepare("UPDATE agenda SET Nume_Sesiune=?, Ora_Inceput=?, Ora_Sfarsit=?, Descriere=?, ID_Eveniment=? WHERE ID_Agenda=?")) {
                $stmt->bind_param("ssssii", $Nume_Sesiune, $Ora_Inceput, $Ora_Sfarsit, $Descriere, $ID_Eveniment, $ID_Agenda);
                $stmt->execute();
                $stmt->close();
                header("Location: vizualizare_agenda.php"); // Redirect after update
                exit;
            } else {
                $error = "ERROR: Cannot execute update. " . $mysqli->error;
            }
        }
    }
}
$mysqli->close();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Modificare Înregistrare Agenda</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
</head>
<body>
    <h1>Modificare Înregistrare Agenda</h1>

    <?php if ($error != '') {
        echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error . "</div>";
    } ?>

    <form action="" method="post">
        <div>
            <?php if ($ID_Agenda) { ?>
                <input type="hidden" name="ID_Agenda" value="<?php echo $ID_Agenda; ?>" />
                <p>ID: <?php echo $ID_Agenda; ?></p>
                <strong>Nume Sesiune:</strong> <input type="text" name="Nume_Sesiune" value="<?php echo $row->Nume_Sesiune; ?>" /><br />
                <strong>Ora Început:</strong> <input type="time" name="Ora_Inceput" value="<?php echo $row->Ora_Inceput; ?>" /><br />
                <strong>Ora Sfârșit:</strong> <input type="time" name="Ora_Sfarsit" value="<?php echo $row->Ora_Sfarsit; ?>" /><br />
                <strong>Descriere:</strong> <textarea name="Descriere"><?php echo $row->Descriere; ?></textarea><br />
                
                <strong>Eveniment:</strong>
                <select name="ID_Eveniment">
                    <?php foreach ($evenimente as $eveniment) {
                        $selected = ($eveniment['ID_Eveniment'] == $row->ID_Eveniment) ? 'selected' : '';
                        echo "<option value='" . $eveniment['ID_Eveniment'] . "' $selected>" . $eveniment['Nume_Eveniment'] . "</option>";
                    } ?>
                </select><br />
                
                <br />
                <input type="submit" name="submit" value="Submit" />
                <a href="vizualizare_agenda.php">Index</a>
            <?php } ?>
        </div>
    </form>
</body>
</html>
