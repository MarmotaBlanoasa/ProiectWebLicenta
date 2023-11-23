<?php
session_start();
// connectare bazadedate
include("conectare.php");
require_once 'EventCRUD.php';
require 'checkLogin.php';
//Modificare datelor
// se preia id din pagina vizualizare
$error = '';

if (!empty($_POST['ID_Speaker'])) {
    if (isset($_POST['submit'])) {
        // verificam daca id-ul din URL este unul valid
        if (is_numeric($_POST['ID_Speaker'])) {
            // preluam variabilele din URL/form
            $ID_Speaker = $_POST['ID_Speaker'];
            $Nume = htmlentities($_POST['Nume'], ENT_QUOTES);
            $Prenume = htmlentities($_POST['Prenume'], ENT_QUOTES);
            $Email = htmlentities($_POST['Email'], ENT_QUOTES);
            $Telefon = htmlentities($_POST['Telefon'], ENT_QUOTES);
            $Bio = htmlentities($_POST['Bio'], ENT_QUOTES);

            // verificam daca numele, prenumele, an si grupa nu sunt goale
            if ($Nume == '' || $Prenume == '' || $Email == '' || $Telefon == '' || $Bio == '') {
                // daca sunt goale afisam mesaj de eroare
                echo "<div> ERROR: Completati campurile obligatorii!</div>";
            } else {
                // daca nu sunt erori se face update  name, code, image, price, descriere, categorie
                $eventCRUD = new EventCRUD();
                $result = $eventCRUD->updateSpeaker($ID_Speaker, $Nume, $Prenume, $Email, $Telefon, $Bio);
                if (!$result) {
                    echo "ERROR: nu se poate executa update.";
                }
            }
        } // daca variabila 'id' nu este valida, afisam mesaj de eroare
        else {
            echo "id incorect!";
        }
    }
}
?>

<html>

<head>
    <title> <?php if ($_GET['ID_Speaker'] != '') {
            echo "Modificare inregistrare";
        } ?> </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8"/>
</head>

<body>
<h1><?php if ($_GET['ID_Speaker'] != '') {
        echo "Modificare Inregistrare";
    } ?></h1>

<?php if ($error != '') {
    echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error . "</div>";
} ?>

<form action="" method="post">
    <div>
        <?php
        $eventCRUD = new EventCRUD();
        if ($_GET['ID_Speaker'] != '') {
            $speaker = $eventCRUD->getSpeakerById($_GET['ID_Speaker']);
            if ($speaker) {
                $row = $speaker[0]; ?>
                <input type="hidden" name="ID_Speaker" value="<?php echo $_GET['ID_Speaker']; ?>"/>
                <p>ID: <?php echo $_GET['ID_Speaker']; ?></p>
                <strong>Nume: </strong> <input type="text" name="Nume" value="<?php echo $row['Nume']; ?>"/><br/>
                <strong>Prenume: </strong> <input type="text" name="Prenume" value="<?php echo $row['Prenume']; ?>"/>
                <br/>
                <strong>Email: </strong> <input type="text" name="Email" value="<?php echo $row['Email']; ?>"/><br/>
                <strong>Telefon: </strong> <input type="text" name="Telefon" value="<?php echo $row['Telefon']; ?>"/>
                <br/>
                <strong>Bio: </strong> <input type="text" name="Bio" value="<?php echo $row['Bio']; ?>"/><br/>
            <?php }
        } ?>
        <br/>
        <br/>
        <input type="submit" name="submit" value="Submit"/>
        <a href="vizualizare_speaker.php">Index</a>
    </div>
</form>
</body>

</html>