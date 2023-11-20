<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Vizualizare Înregistrări</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        a { color: blue; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .error { color: red; }
    </style>
</head>
<body>
<h1>Înregistrările din tabela eveniment</h1>
<p><b>Toate înregistrările din eveniment</b></p>
<?php
include("conectare.php");
require_once "EventCRUD.php";
$loggedIn = isset($_SESSION["loggedin"]);
$eventCRUD = new EventCRUD();
$events = $eventCRUD->getAllEvents();
if (!empty($events)) {
        echo "<table>";
        echo "<tr><th>ID Eveniment</th><th>Nume Eveniment</th><th>Descriere</th><th>Data Start</th><th>Data Finish</th><th>Locație</th><th>Număr Participanți Maxim</th><th>Modificare</th><th>Stergere</th><th>Cumpără Bilet</th></tr>";

        foreach ($events as $row) {
            echo "<tr>";
            echo "<td>{$row->ID_Eveniment}</td>";
            echo "<td>{$row->Nume_Eveniment}</td>";
            echo "<td>{$row->Descriere}</td>";
            echo "<td>{$row->Data_Start}</td>";
            echo "<td>{$row->Data_Finish}</td>";
            echo "<td>{$row->Locatie}</td>";
            echo "<td>{$row->Numar_Participant_Maxim}</td>";
            echo "<td><a href='modificare_eveniment.php?ID_Eveniment={$row->ID_Eveniment}'>Modificare</a></td>";
            echo "<td><a href='stergere_eveniment.php?ID_Eveniment={$row->ID_Eveniment}'>Stergere</a></td>";
            echo "<td><a href='cumpara-bilet.php?ID_Eveniment={$row->ID_Eveniment}'>Cumpără Bilet</a></td>";
            echo "</tr>";
        }
        echo "</table>";
} else {
    echo "<p>No events scheduled</p>";
}
$mysqli->close();
 if($loggedIn){
    echo '<a href="inserare_eveniment.php">Adăugarea unei noi înregistrări</a>';
 }
?>
</body>
</html>
