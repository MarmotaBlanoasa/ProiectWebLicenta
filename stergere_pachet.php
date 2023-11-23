<?php
include("conectare.php");
require_once "EventCRUD.php";
$eventCRUD = new EventCRUD();
if (isset($_GET['ID_Pachet']) && is_numeric($_GET['ID_Pachet'])) {
    $delete = $eventCRUD->deletPacketByID($_GET['ID_Pachet']);
    if ($delete) {
        header("Location: vizualizare_pachet.php");
    } else {
        echo "error: nu se poate executa delete.";
        $mysqli->close();
    echo "<div>Inregistrarea a fost stearsa</div>";
    }

    echo "<p><a href=\"vizualizare_pachet.php\">Index</a></p>";
}
?>