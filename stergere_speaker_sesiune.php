<?php
    include("conectare.php");
    if (isset($_GET['ID_Speaker_Sesiune']) && is_numeric($_GET['ID_Speaker_Sesiune']))
    {
        $ID_Speaker_Sesiune= $_GET['ID_Speaker_Sesiune'];
        if ($stmt = $mysqli->prepare("DELETE FROM speaker_sesiune WHERE ID_Speaker_Sesiune = ? LIMIT 1"))
        {
            $stmt->bind_param("i",$ID_Speaker_Sesiune);
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
    echo "<p><a href=\"vizualizare_speaker_sesiune.php\">Index</a></p>";
?>