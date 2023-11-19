<?php
// connectare bazadedate 
include("conectare.php");

//Modificare datelor 
// se preia id din pagina vizualizare 
$error = '';

if (!empty($_POST['ID_Pachet'])) {
    if (isset($_POST['submit'])) {
        // verificam daca id-ul din URL este unul valid  
        if (is_numeric($_POST['ID_Pachet'])) {
            // preluam variabilele din URL/form  
            $ID_Pachet  = $_POST['ID_Pachet'];
            $Nume_Pachet = htmlentities($_POST['Nume_Pachet'], ENT_QUOTES);
            $Descriere = htmlentities($_POST['Descriere'], ENT_QUOTES);
            $Pret = htmlentities($_POST['Pret'], ENT_QUOTES);

            // verificam daca numele, prenumele, an si grupa nu sunt goale  
            if ($Nume_Pachet == '' || $Descriere == '' || $Pret == '' ) {
                // daca sunt goale afisam mesaj de eroare    
                echo "<div> ERROR: Completati campurile obligatorii!</div>";
            } else {
                // daca nu sunt erori se face update  name, code, image, price, descriere, categorie  
                if ($stmt = $mysqli->prepare("UPDATE pachet SET Nume_Pachet=?,Descriere=?,Pret=? WHERE ID_Pachet ='" . $ID_Pachet  . "'")) {
                    $stmt->bind_param("ssi", $Nume_Pachet, $Descriere, $Pret);
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
    <title> <?php if ($_GET['ID_Pachet'] != '') {
                echo "Modificare inregistrare";
            } ?> </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
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
            <?php if ($_GET['ID_Pachet'] != '') { ?>
                <input type="hidden" name="ID_Pachet" value="<?php echo $_GET['ID_Pachet']; ?>" />
                <p>ID: <?php echo $_GET['ID_Pachet'];
                        if ($result = $mysqli->query("SELECT * FROM pachet where ID_Pachet='" . $_GET['ID_Pachet'] . "'")) {
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_object(); ?></p>
               <strong> Nume Pachet: </strong>
            <label>
                <select name="Nume_Pachet" id="Nume_Pachet">
                    <option value="Silver">Silver</option>
                    <option value="Gold">Gold</option>
                    <option value="Platinum">Platinum</option>
                </select>
            </label><br/>
                <strong>Descriere: </strong> <input type="text" name="Descriere" value="<?php echo $row->Descriere; ?>" /><br />
                <strong>Pret: </strong> <input type="text" name="Pret" id="Pret" readonly value="<?php echo $row->Pret; ?>" /><br />
    <?php }
                        }
                    } ?>
    <br />
    <br />
    <input type="submit" name="submit" value="Submit" />
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