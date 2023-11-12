<?php
include("conectare.php");

if (isset($_GET['ID_Eveniment']) && is_numeric($_GET['ID_Eveniment'])) {
    $ID_Eveniment = $_GET['ID_Eveniment'];

    
    if ($stmt = $mysqli->prepare("DELETE FROM eveniment WHERE ID_Eveniment=? LIMIT 1")) {
        $stmt->bind_param("i", $ID_Eveniment);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "error: nu se poate executa delete.";
        $mysqli->close();
    echo "<div>Inregistrarea a fost stearsa</div>";
    }

    echo "<p><a href=\"vizualizare_eveniment.php\">Index</a></p>";
}
?>