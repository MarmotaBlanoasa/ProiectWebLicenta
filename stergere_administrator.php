<?php
include("conectare.php");

if (isset($_GET['ID_Administrator']) && is_numeric($_GET['ID_Administrator'])) {
    $ID_Administrator = $_GET['ID_Administrator'];

    
    if ($stmt = $mysqli->prepare("DELETE FROM administrator WHERE ID_Administrator=? LIMIT 1")) {
        $stmt->bind_param("i", $ID_Administrator);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "error: nu se poate executa delete.";
        $mysqli->close();
    echo "<div>Inregistrarea a fost stearsa</div>";
    }

    echo "<p><a href=\"vizualizare_administrator.php\">Index</a></p>";
}
?>