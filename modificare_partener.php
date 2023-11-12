<?php
// connectare bazadedate 
include("conectare.php");

//Modificare datelor 
// se preia id din pagina vizualizare 
$error = '';

if (!empty($_POST['ID_Partener'])) {
    if (isset($_POST['submit'])) {
        // verificam daca id-ul din URL este unul valid  
        if (is_numeric($_POST['ID_Partener'])) {
            // preluam variabilele din URL/form  
            $ID_Partener  = $_POST['ID_Partener'];
            $Nume_Partener = htmlentities($_POST['Nume_Partener'], ENT_QUOTES);
            $Descriere = htmlentities($_POST['Descriere'], ENT_QUOTES);
            $Contact_Nume = htmlentities($_POST['Contact_Nume'], ENT_QUOTES);
            $Contact_Email = htmlentities($_POST['Contact_Email'], ENT_QUOTES);
            $Contact_Telefon = htmlentities($_POST['Contact_Telefon'], ENT_QUOTES);
            $ID_Eveniment = $_POST['ID_Eveniment'];
            $ID_Pachet = $_POST['ID_Pachet'];

            // verificam daca numele, prenumele, an si grupa nu sunt goale  
            if ($Nume_Partener == '' || $Descriere == '' || $Contact_Nume == '' || $Contact_Email == '' || $Contact_Telefon == '' || $ID_Eveniment == '' || $ID_Pachet == '') {
                // daca sunt goale afisam mesaj de eroare    
                echo "<div> ERROR: Completati campurile obligatorii!</div>";
            } else {
                // daca nu sunt erori se face update  name, code, image, price, descriere, categorie  
                if ($stmt = $mysqli->prepare("UPDATE partener SET Nume_Partener=?,Descriere=?,Contact_Nume=?, Contact_Email=?, Contact_Telefon=?, ID_Eveniment=?, ID_Pachet=? WHERE ID_Partener ='" . $ID_Partener  . "'")) {
                    $stmt->bind_param("sssssii", $Nume_Partener, $Descriere, $Contact_Nume, $Contact_Email, $Contact_Telefon, $ID_Eveniment, $ID_Pachet);
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
    <title> <?php if ($_GET['ID_Partener'] != '') {
                echo "Modificare inregistrare";
            } ?> </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
</head>

<body>
    <h1><?php if ($_GET['ID_Partener'] != '') {
            echo "Modificare Inregistrare";
        } ?></h1>

    <?php if ($error != '') {
        echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error . "</div>";
    } ?>

    <form action="" method="post">
        <div>
            <?php if ($_GET['ID_Partener'] != '') { ?>
                <input type="hidden" name="ID_Partener" value="<?php echo $_GET['ID_Partener']; ?>" />
                <p>ID: <?php echo $_GET['ID_Partener'];
                        if ($result = $mysqli->query("SELECT * FROM partener where ID_Partener='" . $_GET['ID_Partener'] . "'")) {
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_object(); ?></p>
                <strong>Nume Partener:</strong> <input type="text" name="Nume_Partener" value="<?php echo $row->Nume_Partener; ?>" /><br />
                <strong>Descriere:</strong> <input type="text" name="Descriere" value="<?php echo $row->Descriere; ?>" /><br />
                <strong>Contact Nume:</strong> <input type="text" name="Contact_Nume" value="<?php echo $row->Contact_Nume; ?>" /><br />
                <strong>Contact Email:</strong> <input type="email" name="Contact_Email" value="<?php echo $row->Contact_Email; ?>" /><br />
                <strong>Contact Telefon:</strong> <input type="text" name="Contact_Telefon" value="<?php echo $row->Contact_Telefon; ?>" /><br />
                <strong>ID Eveniment:</strong> <input type="number" name="ID_Eveniment" value="<?php echo $row->ID_Eveniment; ?>" /><br />
                <strong>ID Pachet:</strong> <input type="number" name="ID_Pachet" value="<?php echo $row->ID_Pachet; ?>" /><br />
    <?php }
                        }
                    } ?>
    <br />
    <br />
    <input type="submit" name="submit" value="Submit" />
    <a href="vizualizare_partener.php">Index</a>
        </div>
    </form>
</body>

</html>