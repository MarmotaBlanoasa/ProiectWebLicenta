<?php
// connectare bazadedate 
include("conectare.php");

//Modificare datelor 
// se preia id din pagina vizualizare 
$error = '';

if (!empty($_POST['ID_Administrator'])) {
    if (isset($_POST['submit'])) {
        // verificam daca id-ul din URL este unul valid  
        if (is_numeric($_POST['ID_Administrator'])) {
            // preluam variabilele din URL/form  
            $ID_Administrator = $_POST['ID_Administrator'];
            $Nume = htmlentities($_POST['Nume'], ENT_QUOTES);
            $Prenume = htmlentities($_POST['Prenume'], ENT_QUOTES);
            $Email= htmlentities($_POST['Email'], ENT_QUOTES);
            $Parola= htmlentities($_POST['Parola'], ENT_QUOTES);

            // verificam daca numele, prenumele, an si grupa nu sunt goale  
            if ($Nume == '' || $Prenume == '' || $Email == '' || $Parola == '' ) {
                // daca sunt goale afisam mesaj de eroare    
                echo "<div> ERROR: Completati campurile obligatorii!</div>";
            } else {
                // daca nu sunt erori se face update  name, code, image, price, descriere, categorie  
                if ($stmt = $mysqli->prepare("UPDATE administrator SET Nume=?,Prenume=?,Email=?, Parola=? WHERE ID_Administrator ='" . $ID_Administrator  . "'")) {
                    $stmt->bind_param("ssss", $Nume, $Prenume, $Email,$Parola);
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
    <title> <?php if ($_GET['ID_Administrator'] != '') {
                echo "Modificare inregistrare";
            } ?> </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
</head>

<body>
    <h1><?php if ($_GET['ID_Administrator'] != '') {
            echo "Modificare Inregistrare";
        } ?></h1>

    <?php if ($error != '') {
        echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error . "</div>";
    } ?>

    <form action="" method="post">
        <div>
            <?php if ($_GET['ID_Administrator'] != '') { ?>
                <input type="hidden" name="ID_Administrator" value="<?php echo $_GET['ID_Administrator']; ?>" />
                <p>ID: <?php echo $_GET['ID_Administrator'];
                        if ($result = $mysqli->query("SELECT * FROM administrator where ID_Administrator='" . $_GET['ID_Administrator'] . "'")) {
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_object(); ?></p>
                <strong>Nume: </strong> <input type="text" name="Nume" value="<?php echo $row->Nume; ?>" /><br />
                <strong>Prenume: </strong> <input type="text" name="Prenume" value="<?php echo $row->Prenume; ?>" /><br />
                <strong>Email: </strong> <input type="text" name="Email" value="<?php echo $row->Email; ?>" /><br />
                <strong>Parola: </strong> <input type="password" name="Parola" value="<?php echo $row->Parola; ?>" /><br />
    <?php }
                        }
                    } ?>
    <br />
    <br />
    <input type="submit" name="submit" value="Submit" />
    <a href="vizualizare_administrator.php">Index</a>
        </div>
    </form>
</body>

</html>