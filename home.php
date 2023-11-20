<?php
session_start();
$loggedIn = isset($_SESSION["loggedin"]);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
    <title>Vizualizare evenimente</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>

<body>
<h1>Lista evenimente</h1>
<?php
echo "<ul>";
if ($loggedIn) {
    echo "<li>
<a href='profil.php'>
Profil
</a>
</li>
<li>
<a href='vizualizare_pachet.php'>
Pachete
</a>
</li>";
}
echo "
<li>
<a href='vizualizare_eveniment.php'>
Evenimentele noastre
</a>
</li>
<li>
<a href='vizualizare_sesiune.php'>
Sesiunile Evenimentelor
</a>
</li>
<li>
<a href='vizualizare_partener.php'>
Parteneri
</a>
</li>
<li>
<a href='vizualizare_sponsor.php'>
Sponsori
</a>
</li>
<li>
<a href='vizualizare_speaker.php'>
Speakerii nostrii
</a>
</li>
<li>
<a href='vizualizare_speaker_sesiune.php'>
Speakerii care se regăsesc la sesiuni
</a>
</li>
<li>
<a href='cos-bilete.php'>
Bilete
</a>
</li>
<li>
<a href='vizualizare_agenda.php'>
Agenda Evenimentului
</a>
</li>";
echo "</ul>";
?>
<?php
include("conectare.php");
require_once "EventCRUD.php";
$loggedIn = isset($_SESSION["loggedin"]);
$eventCRUD = new EventCRUD();
try {
    $events = $eventCRUD->getAllEvents();
} catch (Exception $e) {
    echo "<p>Could not connect to the database to display events!</p>";
    exit();
}
if (!empty($events)) {
    echo "<table>";
    echo "<tr><th>ID Eveniment</th><th>Nume Eveniment</th><th>Descriere</th><th>Data Start</th><th>Data Finish</th><th>Locație</th><th>Număr Participanți Maxim</th><th>Modificare</th><th>Stergere</th><th>Cumpără Bilet</th></tr>";

    foreach ($events as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['ID_Eveniment']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Nume_Eveniment']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Descriere']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Data_Start']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Data_Finish']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Locatie']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Numar_Participant_Maxim']) . "</td>";
        echo "<td><a href='modificare_eveniment.php?ID_Eveniment=" . urlencode($row['ID_Eveniment']) . "'>Modificare</a></td>";
        echo "<td><a href='stergere_eveniment.php?ID_Eveniment=" . urlencode($row['ID_Eveniment']) . "'>Stergere</a></td>";
        echo "<td><a href='cumpara-bilet.php?ID_Eveniment=" . urlencode($row['ID_Eveniment']) . "'>Cumpără Bilet</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No events scheduled</p>";
}
$mysqli->close();
if ($loggedIn) {
    echo '<a href="inserare_eveniment.php">Adăugarea unei noi înregistrări</a>';
}
?>

</body>

</html>