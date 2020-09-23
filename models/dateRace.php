<?php
//-------------------------------------------------------------DATERACE--------------------
class dateRace
{
    public $id = 0;
    public $dateStart = '0000-00-00';
    public $dateEnd = '0000-00-00';
    private $db = NULL;
    public function __construct()
    {
        $this->db = dataBase::getInstance();
    }
    public function addDateRace()
    {
        //$db devient une instance de l'objet PDO
        // on fait une requête préparée
        $addDateRaceQuery = $this->db->prepare(
            // Marqueur nominatif
            //bindValue: vérifie le type et que ça ne génère pas de faille de sécurité.
            //$this-> : permet d'acceder aux attributs de l'instance qui est en cours
            'INSERT INTO `ap29f_dateRace` (`dateStart`,`dateEnd`)
    VALUES(:dateStart,:dateEnd)'
        );
        $addDateRaceQuery->bindvalue(':dateStart', $this->dateStart, PDO::PARAM_STR);
        $addDateRaceQuery->bindvalue(':dateEnd', $this->dateEnd, PDO::PARAM_STR);
        return $addDateRaceQuery->execute();
    }
    function datesWeekEnd(){
        $dateQuery = $this->db->query(
            'SELECT 
                `id`
                , DATE_FORMAT(`dateStart`, \'%d/%m/%Y\') as `dateStartFr`
                , DATE_FORMAT(`dateEnd`, \'%d/%m/%Y\') as `dateEndFr`
            FROM 
                `ap29f_dateRace`');
        //data retourne un tableau d'objet
        $data = $dateQuery->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }
    public function updateDateRace()
    {
        //$db devient une instance de l'objet PDO
        // on fait une requête préparée
        $updateDateRaceQuery = $this->db->prepare(
            'UPDATE
                `ap29f_dateRace`
            SET
                `dateStart` = :dateStart
                , `dateEnd` = :dateEnd
            WHERE 
                `id` = :id'
        );
        $updateDateRaceQuery->bindValue(':id', $this->id, PDO::PARAM_INT);
        $updateDateRaceQuery->bindValue(':dateStart', $this->dateStart, PDO::PARAM_STR);
        $updateDateRaceQuery->bindValue(':dateEnd', $this->dateEnd, PDO::PARAM_STR);
        return $updateDateRaceQuery->execute();
    }
    /**
     * méthode permettant de supprimer une course par l'id de la dateRace
     *
     * @return boolean
     */
    public function deleteRaceByIdDateRace(){
        $deleteRaceByIdDateRaceQuery = $this->db->prepare(
            'DELETE FROM
                `ap29f_dateRace`
            WHERE 
                `id` = :id'
        );
            $deleteRaceByIdDateRaceQuery->bindValue(':id', $this->id, PDO::PARAM_INT);
            return $deleteRaceByIdDateRaceQuery->execute();
    }
}