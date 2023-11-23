<?php
session_start();
require 'checkLogin.php';
// Connect to the database
include("conectare.php");
require_once 'EventCRUD.php';
$error = '';

// Fetch the list of events
$eventCRUD = new EventCRUD();
$evenimente = $eventCRUD->getAllEvents();

if (isset($_GET['ID_Sponsor']) && is_numeric($_GET['ID_Sponsor'])) {
    $ID_Sponsor = $_GET['ID_Sponsor'];

    // Fetch the current sponsor's information
    $row = $eventCRUD->getSponsorById($ID_Sponsor)[0];

    // Process the form submission
    if (isset($_POST['submit'])) {
        $Nume_Sponsor = htmlentities($_POST['Nume_Sponsor'], ENT_QUOTES);
        $Descriere = htmlentities($_POST['Descriere'], ENT_QUOTES);
        $Contact_Nume = htmlentities($_POST['Contact_Nume'], ENT_QUOTES);
        $Contact_Email = htmlentities($_POST['Contact_Email'], ENT_QUOTES);
        $Contact_Telefon = htmlentities($_POST['Contact_Telefon'], ENT_QUOTES);
        $ID_Eveniment = $_POST['ID_Eveniment'];

        // Validate fields
        if ($Nume_Sponsor == '' || $Descriere == '' || $Contact_Nume == '' || $Contact_Email == '' || $Contact_Telefon == '' || $ID_Eveniment == '') {
            $error = 'ERROR: Please fill in all required fields!';
        } else {
            // Execute the update
            $result = $eventCRUD->updateSponsor($ID_Sponsor, $Nume_Sponsor, $Descriere, $Contact_Nume, $Contact_Email, $Contact_Telefon, $ID_Eveniment);
            if (!$result) {
                echo "ERROR: Could not execute update.";
            } else {
                header("Location: vizualizare_sponsor.php"); // Redirect after successful update
                exit;
            }
        }
    }
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Update Sponsor Record</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
</head>
<body>
    <h1>Update Sponsor Record</h1>

    <?php if ($error != '') {
        echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error . "</div>";
    } ?>

    <form action="" method="post">
        <div>
            <?php if ($ID_Sponsor) { ?>
                <input type="hidden" name="ID_Sponsor" value="<?php echo $ID_Sponsor; ?>" />
                <p>ID: <?php echo $ID_Sponsor; ?></p>
                <strong>Name:</strong> <input type="text" name="Nume_Sponsor" value="<?php echo $row['Nume_Sponsor']; ?>" /><br />
                <strong>Description:</strong> <input type="text" name="Descriere" value="<?php echo $row['Descriere']; ?>" /><br />
                <strong>Contact Name:</strong> <input type="text" name="Contact_Nume" value="<?php echo $row['Contact_Nume']; ?>" /><br />
                <strong>Contact Email:</strong> <input type="email" name="Contact_Email" value="<?php echo $row['Contact_Email']; ?>" /><br />
                <strong>Contact Phone:</strong> <input type="text" name="Contact_Telefon" value="<?php echo $row['Contact_Telefon']; ?>" /><br />
                <strong>Event:</strong>
                <select name="ID_Eveniment">
                    <?php foreach ($evenimente as $eveniment) {
                        $selected = ($eveniment['ID_Eveniment'] == $row['ID_Eveniment']) ? 'selected' : '';
                        echo "<option value='" . $eveniment['ID_Eveniment'] . "' $selected>" . $eveniment['Nume_Eveniment'] . "</option>";
                    } ?>
                </select><br />
                <br />
                <input type="submit" name="submit" value="Submit" />
                <a href="vizualizare_sponsor.php">Index</a>
            <?php } ?>
        </div>
    </form>
</body>
</html>
