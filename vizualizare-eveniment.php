<?php
include("conectare.php");
require_once "EventCRUD.php";

$eventCRUD = new EventCRUD();

if (isset($_GET['ID_Eveniment']) && is_numeric($_GET['ID_Eveniment'])) {
    $event = $eventCRUD->getEventById($_GET['ID_Eveniment']);
    if ($event) {
        $event = $event[0];
        // Display event details
        echo "Event Name: " . $event['Nume_Eveniment'] . "<br>";
        echo "Description: " . $event['Descriere'] . "<br>";
        echo "Start Date: " . $event['Data_Start'] . "<br>";
        echo "End Date: " . $event['Data_Finish'] . "<br>";
        echo "Location: " . $event['Locatie'] . "<br>";
        echo "Max Participants: " . $event['Numar_Participant_Maxim'] . "<br>";
        $agendas = $eventCRUD->getAgendasByEventId($_GET['ID_Eveniment']);

        echo "<h2>Agendas</h2>";
        if (empty($agendas)) {
            echo "Nu exista o agenda pentru acest eveniment.";
        }else{
            foreach ($agendas as $agenda) {
                echo "Session Name: " . $agenda['Nume_Sesiune'] . "<br>";
                echo "Start Time: " . $agenda['Ora_Inceput'] . "<br>";
                echo "End Time: " . $agenda['Ora_Sfarsit'] . "<br>";
                echo "Description: " . $agenda['Descriere'] . "<br>";

                // Display speaker for each agenda
                $speaker = $eventCRUD->getSpeakerByAgendaId($agenda['ID_Agenda']);
                if ($speaker) {
                    $speaker = $speaker[0];
                    echo "Speaker: " . $speaker['Nume'] . " " . $speaker['Prenume'] . "<br>";
                } else {
                    echo "No speaker assigned.<br>";
                }
                echo "<hr>";
            }
        }
        echo "<a href='home.php'>Inapoi</a>";
    } else {
        echo "Event not found.";
    }
} else {
    echo "Invalid event ID.";
}