<?php
session_start();
// connectare bazadedate
include("conectare.php");
include "checkLogin.php";
require_once 'EventCRUD.php';
//Modificare datelor
// se preia id din pagina vizualizare
$error = '';

if (!empty($_POST['ID_Pachet'])) {
    if (isset($_POST['submit'])) {
        // verificam daca id-ul din URL este unul valid
        if (is_numeric($_POST['ID_Pachet'])) {
            // preluam variabilele din URL/form
            $ID_Pachet = $_POST['ID_Pachet'];
            $Nume_Pachet = htmlentities($_POST['Nume_Pachet'], ENT_QUOTES);
            $Descriere = htmlentities($_POST['Descriere'], ENT_QUOTES);
            $Pret = htmlentities($_POST['Pret'], ENT_QUOTES);

            // verificam daca numele, prenumele, an si grupa nu sunt goale
            if ($Nume_Pachet == '' || $Descriere == '' || $Pret == '') {
                // daca sunt goale afisam mesaj de eroare
                echo "<div> ERROR: Completati campurile obligatorii!</div>";
            } else {
                // daca nu sunt erori se face update  name, code, image, price, descriere, categorie
                $eventCRUD = new EventCRUD();
                $result = $eventCRUD->updatePachet($ID_Pachet, $Nume_Pachet, $Descriere, $Pret);
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
    <title> <?php if ($_GET['ID_Pachet'] != '') {
            echo "Modificare inregistrare";
        } ?> </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8"/>
</head>

<body>
<h1><?php if ($_GET['ID_Pachet'] != '') {
        echo "Modificare Inregistrare";
    } ?></h1>

<?php if ($error != '') {
    echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error . "</div>";
} ?>

<form action="" method="post">
    <div>
        <?php
        $eventCRUD = new EventCRUD();
        if ($_GET['ID_Pachet'] != '') {
            $pachet = $eventCRUD->getPachetById($_GET['ID_Pachet']);
            if ($pachet) {
                $row = $pachet[0]; ?>
                <input type="hidden" name="ID_Pachet" value="<?php echo $_GET['ID_Pachet']; ?>"/>
                <p>ID: <?php echo $_GET['ID_Pachet']; ?></p>
                <strong>Nume Pachet: </strong>
                <label>
                    <select name="Nume_Pachet" id="Nume_Pachet">
                        <option value="Silver">Silver</option>
                        <option value="Gold">Gold</option>
                        <option value="Platinum">Platinum</option>
                    </select>
                </label><br/>
                <strong>Descriere: </strong> <input type="text" name="Descriere"
                                                    value="<?php echo $row['Descriere']; ?>"/><br/>
                <strong>Pret: </strong> <input type="text" name="Pret" id="Pret" readonly
                                               value="<?php echo $row['Pret']; ?>"/><br/>
            <?php }
        } ?>
        <br/>
        <br/>
        <input type="submit" name="submit" value="Submit"/>
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