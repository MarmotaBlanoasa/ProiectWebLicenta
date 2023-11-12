<?php
// connectare bazadedate 
include("conectare.php");

//Modificare datelor 
// se preia id din pagina vizualizare 
$error = '';

if (!empty($_POST['ID_Sesiune'])) {
    if (isset($_POST['submit'])) {
        // verificam daca id-ul din URL este unul valid  
        if (is_numeric($_POST['ID_Sesiune'])) {
            // preluam variabilele din URL/form  
            $ID_Sesiune = $_POST['ID_Sesiune'];
            $ID_Eveniment = htmlentities($_POST['ID_Eveniment'], ENT_QUOTES);
            $Nume_Sesiune = htmlentities($_POST['Nume_Sesiune'], ENT_QUOTES);

            // verificam daca numele, prenumele, an si grupa nu sunt goale  
            if ( $ID_Eveniment == '' || $Nume_Sesiune == '') {
                // daca sunt goale afisam mesaj de eroare    
                echo "<div> ERROR: Completati campurile obligatorii!</div>";
            } else {
                // daca nu sunt erori se face update  name, code, image, price, descriere, categorie  
                if ($stmt = $mysqli->prepare("UPDATE sesiune SET ID_Eveniment=?,Nume_Sesiune=? WHERE ID_Sesiune='" . $ID_Sesiune . "'")) {
                    $stmt->bind_param("ss",  $ID_Eveniment, $Nume_Sesiune);
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
    <title> <?php if ($_GET['ID_Sesiune'] != '') {
                echo "Modificare inregistrare";
            } ?> </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
</head>

<body>
    <h1><?php if ($_GET['ID_Sesiune'] != '') {
            echo "Modificare Inregistrare";
        } ?></h1>

    <?php if ($error != '') {
        echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error . "</div>";
    } ?>

    <form action="" method="post">
        <div>
            <?php if ($_GET['ID_Sesiune'] != '') { ?>
                <input type="hidden" name="ID_Sesiune" value="<?php echo $_GET['ID_Sesiune']; ?>" />
                <p>ID: <?php echo $_GET['ID_Sesiune'];
                        if ($result = $mysqli->query("SELECT * FROM sesiune where ID_Sesiune='" . $_GET['ID_Sesiune'] . "'")) {
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_object(); ?></p>
                                <strong>ID Eveniment: </strong> <input type="text" name="ID_Eveniment" value="<?php echo $row->ID_Eveniment; ?>" /><br />
                                <strong>Nume Sesiune: </strong> <input type="text" name="Nume_Sesiune" value="<?php echo $row->Nume_Sesiune; ?>" /><br />
            <?php }
                        }
                    } ?>
            <br />
            <br />
            <input type="submit" name="submit" value="Submit" />
            <a href="vizualizare_sesiune.php">Index</a>
        </div>
    </form>
</body>

</html>