<?php
include("conectare.php");

if (isset($_GET['ID_Agenda']) && is_numeric($_GET['ID_Agenda'])) {
    $ID_Agenda = $_GET['ID_Agenda'];

    
    if ($stmt = $mysqli->prepare("DELETE FROM agenda WHERE ID_Agenda=? LIMIT 1")) {
        $stmt->bind_param("i", $ID_Agenda);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "error: nu se poate executa delete.";
        $mysqli->close();
    echo "<div>Inregistrarea a fost stearsa</div>";
    }

    echo "<p><a href=\"vizualizare_agenda.php\">Index</a></p>";
}
?>