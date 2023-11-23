<?php
include("conectare.php");
include "checkLogin.php";
require_once "EventCRUD.php";
if (isset($_GET['ID_Partener']) && is_numeric($_GET['ID_Partener'])) {
    $eventCRUD = new EventCRUD();
    $delete = $eventCRUD->deletePartnerByID($_GET['ID_Partener']);
    if (!$delete) {
        echo "error: nu se poate executa delete.";
        $mysqli->close();
    }
    header("Location: vizualizare_partener.php");
    echo "<p><a href=\"vizualizare_partener.php\">Index</a></p>";
}
?>