<?php
include("conectare.php");
include "checkLogin.php";
require_once "EventCRUD.php";
if (isset($_GET['ID_Speaker']) && is_numeric($_GET['ID_Speaker'])) {
    $eventCRUD = new EventCRUD();
    $delete = $eventCRUD->deleteSpeakerByID($_GET['ID_Speaker']);
    if (!$delete) {
        echo "error: nu se poate executa delete.";
        $mysqli->close();
    }
    header("Location: vizualizare_speaker.php");
    echo "<p><a href=\"vizualizare_speaker.php\">Index</a></p>";
}
?>