<?php
    include("conectare.php");
    if (isset($_GET['ID_Participant']) && is_numeric($_GET['ID_Participant']))
    {
        $ID_Participant = $_GET['ID_Participant'];
        if ($stmt = $mysqli->prepare("DELETE FROM participant WHERE ID_Participant = ? LIMIT 1"))
        {
            $stmt->bind_param("i",$ID_Participant);
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
    echo "<p><a href=\"vizualizare_participant.php\">Index</a></p>";
?>