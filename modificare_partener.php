<?php
// Connectare la baza de date
include("conectare.php");
require_once 'EventCRUD.php';
$error = '';

// Extrage lista de evenimente si pachete
$eventCRUD = new EventCRUD();
$evenimente = $eventCRUD->getAllEvents();
$pachete = $eventCRUD->getPachete();

if (isset($_GET['ID_Partener']) && is_numeric($_GET['ID_Partener'])) {
    $ID_Partener = $_GET['ID_Partener'];

    // Extrage informațiile partenerului curent
    $row = $eventCRUD->getPartenerById($ID_Partener)[0];

    // Procesarea formularului la trimitere
    if (isset($_POST['submit'])) {
        $Nume_Partener = htmlentities($_POST['Nume_Partener'], ENT_QUOTES);
        $Descriere = htmlentities($_POST['Descriere'], ENT_QUOTES);
        $Contact_Nume = htmlentities($_POST['Contact_Nume'], ENT_QUOTES);
        $Contact_Email = htmlentities($_POST['Contact_Email'], ENT_QUOTES);
        $Contact_Telefon = htmlentities($_POST['Contact_Telefon'], ENT_QUOTES);
        $ID_Eveniment = $_POST['ID_Eveniment'];
        $ID_Pachet = $_POST['ID_Pachet'];

        // Validare campuri
        if ($Nume_Partener == '' || $Descriere == '' || $Contact_Nume == '' || $Contact_Email == '' || $Contact_Telefon == '' || $ID_Eveniment == '' || $ID_Pachet == '') {
            $error = 'ERROR: Completati campurile obligatorii!';
        } else {
            // Executarea update-ului
            $result = $eventCRUD->updatePartener($ID_Partener, $Nume_Partener, $Descriere, $Contact_Nume, $Contact_Email, $Contact_Telefon, $ID_Eveniment, $ID_Pachet);
            if (!$result) {
                echo "ERROR: Nu se poate executa update.";
            } else {
                header("Location: vizualizare_partener.php"); // Redirect dupa update
                exit;
            }
        }
    }
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Modificare Inregistrare Partener</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
</head>
<body>
    <h1>Modificare Inregistrare Partener</h1>

    <?php if ($error != '') {
        echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error . "</div>";
    } ?>

    <form action="" method="post">
        <div>
            <?php if ($ID_Partener) { ?>
                <input type="hidden" name="ID_Partener" value="<?php echo $ID_Partener; ?>" />
                <p>ID: <?php echo $ID_Partener; ?></p>
                <strong>Nume Partener:</strong> <input type="text" name="Nume_Partener" value="<?php echo $row['Nume_Partener']; ?>" /><br />
                <strong>Descriere:</strong> <input type="text" name="Descriere" value="<?php echo $row['Descriere']; ?>" /><br />
                <strong>Contact Nume:</strong> <input type="text" name="Contact_Nume" value="<?php echo $row['Contact_Nume']; ?>" /><br />
                <strong>Contact Email:</strong> <input type="email" name="Contact_Email" value="<?php echo $row['Contact_Email']; ?>" /><br />
                <strong>Contact Telefon:</strong> <input type="text" name="Contact_Telefon" value="<?php echo $row['Contact_Telefon']; ?>" /><br />
                <strong>Eveniment:</strong>
                <select name="ID_Eveniment">
                    <?php foreach ($evenimente as $eveniment) {
                        $selected = ($eveniment['ID_Eveniment'] == $row['ID_Eveniment']) ? 'selected' : '';
                        echo "<option value='" . $eveniment['ID_Eveniment'] . "' $selected>" . $eveniment['Nume_Eveniment'] . "</option>";
                    } ?>
                </select><br />
                <strong>Pachet:</strong>
                <select name="ID_Pachet">
                    <?php foreach ($pachete as $pachet) {
                        $selected = ($pachet['ID_Pachet'] == $row['ID_Pachet']) ? 'selected' : '';
                        echo "<option value='" . $pachet['ID_Pachet'] . "' $selected>" . $pachet['Nume_Pachet'] . "</option>";
                    } ?>
                </select><br />
                <br />
                <input type="submit" name="submit" value="Submit" />
                <a href="vizualizare_partener.php">Index</a>
            <?php } ?>
        </div>
    </form>
</body>
</html>
