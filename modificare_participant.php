<?php
// connectare bazadedate 
include("conectare.php");

//Modificare datelor 
// se preia id din pagina vizualizare 
$error = '';

if (!empty($_POST['ID_Participant'])) {
    if (isset($_POST['submit'])) {
        // verificam daca id-ul din URL este unul valid  
        if (is_numeric($_POST['ID_Participant'])) {
            // preluam variabilele din URL/form  
            $ID_Participant = $_POST['ID_Participant'];
            $Nume = htmlentities($_POST['Nume'], ENT_QUOTES);
            $Prenume = htmlentities($_POST['Prenume'], ENT_QUOTES);
            $Email = htmlentities($_POST['Email'], ENT_QUOTES);
            $Telefon = htmlentities($_POST['Telefon'], ENT_QUOTES);

            // verificam daca numele, prenumele, an si grupa nu sunt goale  
            if ($Nume == '' || $Prenume == '' || $Email == '' || $Telefon == '') {
                // daca sunt goale afisam mesaj de eroare    
                echo "<div> ERROR: Completati campurile obligatorii!</div>";
            } else {
                // daca nu sunt erori se face update  name, code, image, price, descriere, categorie  
                if ($stmt = $mysqli->prepare("UPDATE participant SET Nume=?,Prenume=?,Email=?,Telefon=? WHERE ID_Participant='" . $ID_Participant . "'")) {
                    $stmt->bind_param("ssss", $Nume, $Prenume, $Email, $Telefon);
                    $stmt->execute();
                    $stmt->close();
                } // mesaj de eroare in caz ca nu se poate face update    
                else {
                    echo "ERROR: nu se poate executa update.";
                }
            }
        }
        // daca variabila 'id' nu este valida, afisam mesaj de eroare 
        else {
            echo "id incorect!";
        }
    }
}
?>

<html>

<head>
    <title> <?php if ($_GET['ID_Participant'] != '') {
                echo "Modificare inregistrare";
            } ?> </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
</head>

<body>
    <h1><?php if ($_GET['ID_Participant'] != '') {
            echo "Modificare Inregistrare";
        } ?></h1>

    <?php if ($error != '') {
        echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error . "</div>";
    } ?>

    <form action="" method="post">
        <div>
            <?php if ($_GET['ID_Participant'] != '') { ?>
                <input type="hidden" name="ID_Participant" value="<?php echo $_GET['ID_Participant']; ?>" />
                <p>ID: <?php echo $_GET['ID_Participant'];
                        if ($result = $mysqli->query("SELECT * FROM participant where ID_Participant='" . $_GET['ID_Participant'] . "'")) {
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_object(); ?></p>
                                <strong>Nume: </strong> <input type="text" name="Nume" value="<?php echo $row->Nume; ?>" /><br />
                                <strong>Prenume: </strong> <input type="text" name="Prenume" value="<?php echo $row->Prenume; ?>" /><br />
                                <strong>Email: </strong> <input type="text" name="Email" value="<?php echo $row->Email; ?>" /><br />
                                <strong>Telefon: </strong> <input type="text" name="Telefon" value="<?php echo $row->Telefon; ?>" /><br />
            <?php }
                        }
                    } ?>
            <br />
            <br />
            <input type="submit" name="submit" value="Submit" />
            <a href="vizualizare_participant.php">Index</a>
        </div>
    </form>
</body>

</html>