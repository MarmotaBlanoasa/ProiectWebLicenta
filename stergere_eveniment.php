<?php
include("conectare.php");
require_once 'EventCRUD.php';
require "checkLogin.php";

if (isset($_GET['ID_Eveniment']) && is_numeric($_GET['ID_Eveniment'])) {
    $eventCRUD = new EventCRUD();
    $delete= $eventCRUD->deleteEventByID($_GET['ID_Eveniment']);
    if (!$delete) {
        echo "error: nu se poate executa delete.";
        $mysqli->close();
    }
    header("Location: home.php");
}
