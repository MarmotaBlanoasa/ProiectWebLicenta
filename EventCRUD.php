<?php
require_once "DBController.php";

class EventCRUD extends DBController
{
    /**
     * @throws Exception
     */
    function getAllEvents(): ?array
    {
        $query = "SELECT * FROM eveniment ORDER BY ID_Eveniment";
        return $this->getDBResult($query);
    }

    /**
     * @throws Exception
     */
    function getEventById(int $id): ?array
    {
        $query = "SELECT * FROM eveniment WHERE ID_Eveniment = ?";
        $params = [$id];
        return $this->getDBResult($query, $params);
    }

    /**
     * @throws Exception
     */
    function getAgendaForEvent(int $eventID): ?array
    {
        $query = "SELECT * FROM agenda WHERE ID_Eveniment = ?";
        $params = [$eventID];
        return $this->getDBResult($query, $params);
    }

    /**
     * @throws Exception
     */
    function getPachete()
    {
        $query = "SELECT * FROM pachet ORDER BY ID_Pachet";
        return $this->getDBResult($query);
    }

    function getPartners()
    {
        $query = "SELECT * FROM partener ORDER BY ID_Partener";
        return $this->getDBResult($query);
    }

    /**
     * @throws Exception
     */
    function getParticipantByEventID(int $eventID)
    {
        $query = "SELECT * FROM participant WHERE ID_Eveniment = ?";
        $params = [$eventID];
        return $this->getDBResult($query, $params);
    }
    function getSessionByEventID(int $eventID)
    {
        $query = "SELECT * FROM sesiune WHERE ID_Eveniment = ?";
        $params = [$eventID];
        return $this->getDBResult($query, $params);
    }
    function getSpeakerByEventID(int $eventID)
    {
        $query = "SELECT * FROM speaker WHERE speaker_sesiune.ID_Eveniment = ?";
        $params = [$eventID];
        return $this->getDBResult($query, $params);
    }
    function getAllSpeakers(){
        $query = "SELECT * FROM speaker ORDER BY ID_Speaker";
        return $this->getDBResult($query);
    }
    function getAllSponsors(){
        $query = "SELECT * FROM sponsor ORDER BY ID_Sponsor";
        return $this->getDBResult($query);
    }
    function getSponsorByEventID(int $eventID)
    {
        $query = "SELECT * FROM sponsor WHERE ID_Eveniment = ?";
        $params = [$eventID];
        return $this->getDBResult($query, $params);
    }

}