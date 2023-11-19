<?php
include("conectare.php");

if (isset($_GET['ID_Bilet']) && is_numeric($_GET['ID_Bilet'])) {
    $ID_Bilet = $_GET['ID_Bilet'];

    
    if ($stmt = $mysqli->prepare("DELETE FROM bilet WHERE ID_Bilet=? LIMIT 1")) {
        $stmt->bind_param("i", $ID_Bilet);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "error: nu se poate executa delete.";
        $mysqli->close();
    echo "<div>Inregistrarea a fost stearsa</div>";
    }

    echo "<p><a href=\"vizualizare_bilet.php\">Index</a></p>";
}
?>