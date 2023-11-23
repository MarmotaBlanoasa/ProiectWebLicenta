<?php
include("conectare.php");
include "checkLogin.php";
require_once "EventCRUD.php";
if (isset($_GET['ID_Sponsor']) && is_numeric($_GET['ID_Sponsor'])) {
    $eventCRUD = new EventCRUD();
    $delete = $eventCRUD->deleteSponsorByID($_GET['ID_Sponsor']);
    if (!$delete) {
        echo "error: nu se poate executa delete.";
        $mysqli->close();
    }
    header("Location: vizualizare_sponsor.php");
    echo "<p><a href=\"vizualizare_sponsor.php\">Index</a></p>";
}
?>