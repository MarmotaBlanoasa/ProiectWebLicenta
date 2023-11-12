<?php
    include("conectare.php");
    if (isset($_GET['ID_Sesiune']) && is_numeric($_GET['ID_Sesiune']))
    {
        $ID_Sesiune = $_GET['ID_Sesiune'];
        if ($stmt = $mysqli->prepare("DELETE FROM sesiune WHERE ID_Sesiune = ? LIMIT 1"))
        {
            $stmt->bind_param("i",$ID_Sesiune);
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
    echo "<p><a href=\"vizualizare_sesiune.php\">Index</a></p>";
?>