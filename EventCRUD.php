<?php
require_once "DBController.php";
class EventCRUD extends DBController{
    /**
     * @throws Exception
     */
    function getAllEvents(): ?array
    {
        $query = "SELECT * FROM eveniment ORDER BY ID_Eveniment";
        return $this->getDBResult($query);
    }

}