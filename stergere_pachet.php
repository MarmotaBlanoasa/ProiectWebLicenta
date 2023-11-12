<?php
include("conectare.php");

if (isset($_GET['ID_Pachet']) && is_numeric($_GET['ID_Pachet'])) {
    $ID_Pachet = $_GET['ID_Pachet'];

    
    if ($stmt = $mysqli->prepare("DELETE FROM pachet WHERE ID_Pachet=? LIMIT 1")) {
        $stmt->bind_param("i", $ID_Pachet);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "error: nu se poate executa delete.";
        $mysqli->close();
    echo "<div>Inregistrarea a fost stearsa</div>";
    }

    echo "<p><a href=\"vizualizare_pachet.php\">Index</a></p>";
}
?>