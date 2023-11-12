<?php
    include("conectare.php");
    if (isset($_GET['ID_Speaker']) && is_numeric($_GET['ID_Speaker']))
    {
        $ID_Speaker = $_GET['ID_Speaker'];
        if ($stmt = $mysqli->prepare("DELETE FROM speaker WHERE ID_Speaker = ? LIMIT 1"))
        {
            $stmt->bind_param("i",$ID_Speaker);
            $stmt->execute();
            $stmt->close();
        }
        else
        {
            echo "ERROR: Nu se poate executa delete.";
        }
        $mysqli->close();
        echo "<div>Inregistrarea a fost stearsa!!!!</div>";
    }
    echo "<p><a href=\"vizualizare_speaker.php\">Index</a></p>";
?>