<?php
include("conectare.php");

if (isset($_GET['ID_Partener']) && is_numeric($_GET['ID_Partener'])) {
    $ID_Partener = $_GET['ID_Partener'];

    
    if ($stmt = $mysqli->prepare("DELETE FROM partener WHERE ID_Partener=? LIMIT 1")) {
        $stmt->bind_param("i", $ID_Partener);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "error: nu se poate executa delete.";
        $mysqli->close();
    echo "<div>Inregistrarea a fost stearsa</div>";
    }

    echo "<p><a href=\"vizualizare_partener.php\">Index</a></p>";
}
?>