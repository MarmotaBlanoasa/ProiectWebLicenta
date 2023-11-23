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
        $params = [['param_type' => 'i', 'param_value' => $id]];
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
    function addPachet(string $Nume_Pachet, string $Descriere, int $Pret): bool
    {
        $query = "INSERT INTO pachet(Nume_Pachet, Descriere, Pret) VALUES (?, ?, ?)";
        $params = [
            ['param_type' => 's', 'param_value' => $Nume_Pachet],
            ['param_type' => 's', 'param_value' => $Descriere],
            ['param_type' => 'i', 'param_value' => $Pret]
        ];
        return $this->updateDB($query, $params);
    }
    function getPachete()
    {
        $query = "SELECT * FROM pachet ORDER BY ID_Pachet";
        return $this->getDBResult($query);
    }
    function getPachetById(int $id): ?array
    {
        $query = "SELECT * FROM pachet WHERE ID_Pachet = ?";
        $params = [['param_type' => 'i', 'param_value' => $id]];
        return $this->getDBResult($query, $params);
    }

    function updatePachet(int $ID_Pachet, string $Nume_Pachet, string $Descriere, int $Pret): bool
    {
        $query = "UPDATE pachet SET Nume_Pachet=?, Descriere=?, Pret=? WHERE ID_Pachet = ?";
        $params = [
            ['param_type' => 's', 'param_value' => $Nume_Pachet],
            ['param_type' => 's', 'param_value' => $Descriere],
            ['param_type' => 'i', 'param_value' => $Pret],
            ['param_type' => 'i', 'param_value' => $ID_Pachet]
        ];
        return $this->updateDB($query, $params);
    }

    function addPartener(string $Nume_Partener, string $Descriere, string $Contact_Nume, string $Contact_Email, string $Contact_Telefon, int $ID_Eveniment, int $ID_Pachet): bool
    {
        $query = "INSERT INTO partener(Nume_Partener, Descriere, Contact_Nume, Contact_Email, Contact_Telefon, ID_Eveniment, ID_Pachet) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $params = [
            ['param_type' => 's', 'param_value' => $Nume_Partener],
            ['param_type' => 's', 'param_value' => $Descriere],
            ['param_type' => 's', 'param_value' => $Contact_Nume],
            ['param_type' => 's', 'param_value' => $Contact_Email],
            ['param_type' => 's', 'param_value' => $Contact_Telefon],
            ['param_type' => 'i', 'param_value' => $ID_Eveniment],
            ['param_type' => 'i', 'param_value' => $ID_Pachet]
        ];
        return $this->updateDB($query, $params);
    }

    function updatePartener(int $ID_Partener, string $Nume_Partener, string $Descriere, string $Contact_Nume, string $Contact_Email, string $Contact_Telefon, int $ID_Eveniment, int $ID_Pachet): bool
    {
        $query = "UPDATE partener SET Nume_Partener=?, Descriere=?, Contact_Nume=?, Contact_Email=?, Contact_Telefon=?, ID_Eveniment=?, ID_Pachet=? WHERE ID_Partener=?";
        $params = [
            ['param_type' => 's', 'param_value' => $Nume_Partener],
            ['param_type' => 's', 'param_value' => $Descriere],
            ['param_type' => 's', 'param_value' => $Contact_Nume],
            ['param_type' => 's', 'param_value' => $Contact_Email],
            ['param_type' => 's', 'param_value' => $Contact_Telefon],
            ['param_type' => 'i', 'param_value' => $ID_Eveniment],
            ['param_type' => 'i', 'param_value' => $ID_Pachet],
            ['param_type' => 'i', 'param_value' => $ID_Partener]
        ];
        return $this->updateDB($query, $params);
    }
    function getPartenerById(int $id): ?array
    {
        $query = "SELECT * FROM partener WHERE ID_Partener = ?";
        $params = [['param_type' => 'i', 'param_value' => $id]];
        return $this->getDBResult($query, $params);
    }

    function getPartners()
    {
        $query = "SELECT partener.*, eveniment.Nume_Eveniment, pachet.Nume_Pachet FROM partener 
              LEFT JOIN eveniment ON partener.ID_Eveniment = eveniment.ID_Eveniment 
              LEFT JOIN pachet ON partener.ID_Pachet = pachet.ID_Pachet 
              ORDER BY ID_Partener";
        return $this->getDBResult($query);
    }

    /**
     * @throws Exception
     */
//    TODO: fix this
//    function getParticipantByEventID(int $eventID)
//    {
//        $query = "SELECT * FROM participant WHERE ID_Eveniment = ?";
//        $params = [$eventID];
//        return $this->getDBResult($query, $params);
//    }
    function getSessionByEventID(int $eventID)
    {
        $query = "SELECT * FROM sesiune WHERE ID_Eveniment = ?";
        $params = [$eventID];
        return $this->getDBResult($query, $params);
    }
    function getAllSpeakers(){
        $query = "SELECT * FROM speaker ORDER BY ID_Speaker";
        return $this->getDBResult($query);
    }
    function addSpeaker(string $Nume, string $Prenume, string $Email, string $Telefon, string $Bio): bool
    {
        $query = "INSERT INTO speaker(Nume, Prenume, Email, Telefon, Bio) VALUES (?, ?, ?, ?, ?)";
        $params = [
            ['param_type' => 's', 'param_value' => $Nume],
            ['param_type' => 's', 'param_value' => $Prenume],
            ['param_type' => 's', 'param_value' => $Email],
            ['param_type' => 's', 'param_value' => $Telefon],
            ['param_type' => 's', 'param_value' => $Bio]
        ];
        return $this->updateDB($query, $params);
    }
    function getSpeakerById(int $id): ?array
    {
        $query = "SELECT * FROM speaker WHERE ID_Speaker = ?";
        $params = [['param_type' => 'i', 'param_value' => $id]];
        return $this->getDBResult($query, $params);
    }

    function updateSpeaker(int $ID_Speaker, string $Nume, string $Prenume, string $Email, string $Telefon, string $Bio): bool
    {
        $query = "UPDATE speaker SET Nume=?, Prenume=?, Email=?, Telefon=?, Bio=? WHERE ID_Speaker = ?";
        $params = [
            ['param_type' => 's', 'param_value' => $Nume],
            ['param_type' => 's', 'param_value' => $Prenume],
            ['param_type' => 's', 'param_value' => $Email],
            ['param_type' => 's', 'param_value' => $Telefon],
            ['param_type' => 's', 'param_value' => $Bio],
            ['param_type' => 'i', 'param_value' => $ID_Speaker]
        ];
        return $this->updateDB($query, $params);
    }
    function getSpeakerByEventID(int $eventID)
    {
        $query = "SELECT * FROM speaker JOIN speaker_sesiune ON speaker.ID_Speaker = speaker_sesiune.ID_Speaker WHERE speaker_sesiune.ID_Eveniment = ?";
        $params = [$eventID];
        return $this->getDBResult($query, $params);
    }
    function addSponsor(string $Nume_Sponsor, string $Descriere, string $Contact_Nume, string $Contact_Email, string $Contact_Telefon, int $ID_Eveniment): bool
    {
        $query = "INSERT INTO sponsor(Nume_Sponsor, Descriere, Contact_Nume, Contact_Email, Contact_Telefon, ID_Eveniment) VALUES (?, ?, ?, ?, ?, ?)";
        $params = [
            ['param_type' => 's', 'param_value' => $Nume_Sponsor],
            ['param_type' => 's', 'param_value' => $Descriere],
            ['param_type' => 's', 'param_value' => $Contact_Nume],
            ['param_type' => 's', 'param_value' => $Contact_Email],
            ['param_type' => 's', 'param_value' => $Contact_Telefon],
            ['param_type' => 'i', 'param_value' => $ID_Eveniment]
        ];
        return $this->updateDB($query, $params);
    }
    function getSponsorById(int $id): ?array
    {
        $query = "SELECT * FROM sponsor WHERE ID_Sponsor = ?";
        $params = [['param_type' => 'i', 'param_value' => $id]];
        return $this->getDBResult($query, $params);
    }

    function updateSponsor(int $ID_Sponsor, string $Nume_Sponsor, string $Descriere, string $Contact_Nume, string $Contact_Email, string $Contact_Telefon, int $ID_Eveniment): bool
    {
        $query = "UPDATE sponsor SET Nume_Sponsor=?, Descriere=?, Contact_Nume=?, Contact_Email=?, Contact_Telefon=?, ID_Eveniment=? WHERE ID_Sponsor = ?";
        $params = [
            ['param_type' => 's', 'param_value' => $Nume_Sponsor],
            ['param_type' => 's', 'param_value' => $Descriere],
            ['param_type' => 's', 'param_value' => $Contact_Nume],
            ['param_type' => 's', 'param_value' => $Contact_Email],
            ['param_type' => 's', 'param_value' => $Contact_Telefon],
            ['param_type' => 'i', 'param_value' => $ID_Eveniment],
            ['param_type' => 'i', 'param_value' => $ID_Sponsor]
        ];
        return $this->updateDB($query, $params);
    }
    function getAllSponsors(){
        $query = "SELECT * FROM sponsor ORDER BY ID_Sponsor";
        return $this->getDBResult($query);
    }
    function getSponsorByEventID(int $eventID)
    {
        $query = "SELECT * FROM sponsor WHERE ID_Eveniment = ?";
        $params = [['param_type' => 'i', 'param_value' => $eventID]];
        return $this->getDBResult($query, $params);
    }
    function deletPacketByID(int $id): bool
    {
        $query = "DELETE FROM pachet WHERE ID_Pachet = ?";
        $params = [['param_type' => 'i', 'param_value' => $id]];
        $result = $this->updateDB($query, $params);
        return $result !== false;
    }
    function deleteSpeakerByID(int $id): bool
    {
        $query = "DELETE FROM speaker WHERE ID_Speaker = ?";
        $params = [['param_type' => 'i', 'param_value' => $id]];
        $result = $this->updateDB($query, $params);
        return $result !== false;
    }
    function deletePartnerByID(int $id): bool
    {
        $query = "DELETE FROM partener WHERE ID_Partener = ?";
        $params = [['param_type' => 'i', 'param_value' => $id]];
        $result = $this->updateDB($query, $params);
        return $result !== false;
    }
    function deleteSponsorByID(int $id): bool
    {
        $query = "DELETE FROM sponsor WHERE ID_Sponsor = ?";
        $params = [['param_type' => 'i', 'param_value' => $id]];
        $result = $this->updateDB($query, $params);
        return $result !== false;
    }
    function deleteEventByID(int $id): bool
    {
        $query = "DELETE FROM eveniment WHERE ID_Eveniment = ?";
        $params = [['param_type' => 'i', 'param_value' => $id]];
        $result = $this->updateDB($query, $params);
        return $result !== false;
    }
    function addEvent(string $Nume_Eveniment, string $Descriere, string $Data_Start, string $Data_Finish, string $Locatie, int $Numar_Participant_Maxim): ?int
    {
        $query = "INSERT INTO eveniment(Nume_Eveniment, Descriere, Data_Start, Data_Finish, Locatie, Numar_Participant_Maxim) VALUES (?, ?, ?, ?, ?, ?)";
        $params = [
            ['param_type' => 's', 'param_value' => $Nume_Eveniment],
            ['param_type' => 's', 'param_value' => $Descriere],
            ['param_type' => 's', 'param_value' => $Data_Start],
            ['param_type' => 's', 'param_value' => $Data_Finish],
            ['param_type' => 's', 'param_value' => $Locatie],
            ['param_type' => 'i', 'param_value' => $Numar_Participant_Maxim]
        ];
        $result = $this->updateDB($query, $params);
        if ($result) {
            return $this->getLastInsertID();
        } else {
            return null;
        }
    }
    function updateEvent(int $ID_Eveniment, string $Nume_Eveniment, string $Descriere, string $Data_Start, string $Data_Finish, string $Locatie, int $Numar_Participant_Maxim): bool
    {
        $query = "UPDATE eveniment SET Nume_Eveniment=?,Descriere=?,Data_Start=?,Data_Finish=?,Locatie=?, Numar_Participant_Maxim=? WHERE ID_Eveniment = ?";
        $params = [
            ['param_type' => 's', 'param_value' => $Nume_Eveniment],
            ['param_type' => 's', 'param_value' => $Descriere],
            ['param_type' => 's', 'param_value' => $Data_Start],
            ['param_type' => 's', 'param_value' => $Data_Finish],
            ['param_type' => 's', 'param_value' => $Locatie],
            ['param_type' => 'i', 'param_value' => $Numar_Participant_Maxim],
            ['param_type' => 'i', 'param_value' => $ID_Eveniment]
        ];
        return $this->updateDB($query, $params);
    }
    function addAgenda(string $Nume_Sesiune, string $Ora_Inceput, string $Ora_Sfarsit, string $Descriere, int $ID_Eveniment, int $ID_Speaker): bool
    {
        $query = "INSERT INTO agenda(ID_Eveniment,Nume_Sesiune, Ora_Inceput, Ora_Sfarsit, Descriere, ID_Speaker) VALUES (?, ?, ?, ?, ?, ?)";
        $params = [
            ['param_type' => 'i', 'param_value' => $ID_Eveniment],
            ['param_type' => 's', 'param_value' => $Nume_Sesiune],
            ['param_type' => 's', 'param_value' => $Ora_Inceput],
            ['param_type' => 's', 'param_value' => $Ora_Sfarsit],
            ['param_type' => 's', 'param_value' => $Descriere],
            ['param_type' => 'i', 'param_value' => $ID_Speaker]
        ];
        return $this->updateDB($query, $params);
    }
    function getAgendasByEventId(int $eventID): ?array
    {
        $query = "SELECT * FROM agenda WHERE ID_Eveniment = ?";
        $params = [['param_type' => 'i', 'param_value' => $eventID]];
        return $this->getDBResult($query, $params);
    }

    function getSpeakerByAgendaId(int $agendaID): ?array
    {
        $query = "SELECT speaker.* FROM speaker JOIN agenda ON speaker.ID_Speaker = agenda.ID_Speaker WHERE agenda.ID_Agenda = ?";
        $params = [['param_type' => 'i', 'param_value' => $agendaID]];
        return $this->getDBResult($query, $params);
    }

    protected function getLastInsertID(): int
    {
        return $this->getConnection()->insert_id;
    }

}