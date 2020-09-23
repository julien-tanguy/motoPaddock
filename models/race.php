<?php
//-------------------------------------------------------------RACE--------------------
class race
{
    public $id = 0;
    public $name = '';
    public $circuit = '';
    public $photo = '';
    public $id_ap29f_championship = 0;
    public $id_ap29f_dateRace = 0;
    private $db = NULL;
    public function __construct()
    {
        $this->db = dataBase::getInstance();
    }
    public function beginTransaction(){
        return $this->db->beginTransaction();
    }
    public function rollBack(){
        return $this->db->rollBack();
    }
    public function getLastInsertId(){
        return $this->db->lastInsertId();
    }
    public function commit(){
        return $this->db->commit();
    }
    public function addRace()
    {
        //$db devient une instance de l'objet PDO
        // on fait une requête préparée
        $addRaceQuery = $this->db->prepare(
            // Marqueur nominatif
            //bindValue: vérifie le type et que ça ne génère pas de faille de sécurité.
            //$this-> : permet d'acceder aux attributs de l'instance qui est en cours
            'INSERT INTO `ap29f_race` (`name`,`circuit`,`photo`,`id_ap29f_championship`,`id_ap29f_dateRace`)
    VALUES(:name,:circuit,:photo,:id_ap29f_championship,:id_ap29f_dateRace)'
        );
        $addRaceQuery->bindvalue(':name', $this->name, PDO::PARAM_STR);
        $addRaceQuery->bindvalue(':circuit', $this->circuit, PDO::PARAM_STR);
        $addRaceQuery->bindvalue(':photo', $this->photo, PDO::PARAM_STR);
        $addRaceQuery->bindvalue(':id_ap29f_championship', $this->id_ap29f_championship, PDO::PARAM_INT);
        $addRaceQuery->bindvalue(':id_ap29f_dateRace', $this->id_ap29f_dateRace, PDO::PARAM_INT);
        return $addRaceQuery->execute();
    }
    public function checkRacesExist()
    {
        $checkRacesExistQuery = $this->db->prepare(
            'SELECT COUNT(`id`) AS `isRaceExist`
            FROM `ap29f_race` 
            WHERE `name` = :name'
        );
        $checkRacesExistQuery->bindvalue(':name', $this->name, PDO::PARAM_STR);
        $checkRacesExistQuery->execute();
        //la méthode renvoie le COUNT(`id`) AS `isteamExist`donc 0 ou 1
        return $checkRacesExistQuery->fetch(PDO::FETCH_OBJ)->isRaceExist; 
    }
    function racesCards(){
        $raceQuery = $this->db->query(
            'SELECT 
                `ap29f_race`.`name` AS `raceName`
                ,`ap29f_race`.`id` AS `raceId`
                ,`ap29f_race`.`photo`
                ,`ap29f_race`.`circuit`
                ,DATE_FORMAT(`ap29f_dateRace`.`dateStart`, \'%d/%m/%Y\') AS `dateFrStart`
                ,DATE_FORMAT(`ap29f_dateRace`.`dateEnd`, \'%d/%m/%Y\') AS `dateFrEnd`
                ,`ap29f_championship`.`name`
            FROM 
                    `ap29f_race`
            INNER JOIN 
                    `ap29f_dateRace` ON `ap29f_race`.`id_ap29f_dateRace` = `ap29f_dateRace`.`id`
            INNER JOIN 
                    `ap29f_championship` ON `ap29f_race`.`id_ap29f_championship` = `ap29f_championship`.`id`
            ORDER BY 
                    `ap29f_dateRace`.`dateStart` ASC');
        //data retourne un tableau d'objet
        $data = $raceQuery->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }
    function displayListNameRaces(){
        $displayListNameRacesQuery = $this->db->query(
            'SELECT 
                `ap29f_race`.`name` as `raceName`
                ,`ap29f_race`.`id` as `raceId`
                ,DATE_FORMAT(`ap29f_dateRace`.`dateStart`, \'%d/%m/%Y\') as `dateFrStart`
                ,DATE_FORMAT(`ap29f_dateRace`.`dateEnd`, \'%d/%m/%Y\') as `dateFrEnd`
                ,`ap29f_championship`.`name` AS `champName`
                , `id_ap29f_dateRace` AS `raceDate`
            FROM 
                `ap29f_race`
            INNER JOIN 
                `ap29f_dateRace` ON `ap29f_race`.`id_ap29f_dateRace` = `ap29f_dateRace`.`id`
            INNER JOIN 
                `ap29f_championship` ON `ap29f_race`.`id_ap29f_championship` = `ap29f_championship`.`id`
            ORDER BY 
                `ap29f_championship`.`id` ASC, `ap29f_dateRace`.`dateStart` ASC');
        //data retourne un tableau d'objet
        return $displayListNameRacesQuery->fetchAll(PDO::FETCH_OBJ);
    }
    /**
     * méthode permettant d'afficher la course lié au resultat
     *
     * @return objet
     */
    function displayRaceNameById(){
        $displayRaceNameByIdQuery = $this->db->prepare(
        'SELECT 
            `ap29f_race`.`name` AS `raceName`
        FROM 
            `ap29f_race`
        WHERE 
            `ap29f_race`.`id` = :id ');
    $displayRaceNameByIdQuery->bindValue(':id', $this->id, PDO::PARAM_INT);
    $displayRaceNameByIdQuery->execute();
    return $displayRaceNameByIdQuery->fetch(PDO::FETCH_OBJ);
    }
    /**
     * méthode permettant d'afficher le nom de la liste des course dans l'ordre chronologique
     *
     * @return array
     */
    function displayListRace(){
        $displayListRaceQuery = $this->db->query(
            'SELECT 
                `ap29f_race`.`name` AS `raceName`
                ,`ap29f_race`.`id` AS `raceId`
            FROM 
                `ap29f_race`
            INNER JOIN 
                `ap29f_dateRace` ON `ap29f_race`.`id_ap29f_dateRace` = `ap29f_dateRace`.`id`
            ORDER BY 
                `ap29f_dateRace`.`dateStart` ASC');
        //data retourne un tableau d'objet
        return $displayListRaceQuery->fetchAll(PDO::FETCH_OBJ);
    }
//AFFICHER LES DATES DANS LE FORMULAIRE UPDATERACE VIA ID DATERACE
    function displayWeekEn(){
        $displayWeekEnQuery = $this->db->prepare(
            'SELECT 
                `dateStart`
                , `dateEnd`
                , `id_ap29f_dateRace` AS `raceId`
            FROM 
                `ap29f_race`
            INNER JOIN 
                `ap29f_dateRace` ON `ap29f_race`.`id_ap29f_dateRace` = `ap29f_dateRace`.`id`
            WHERE 
                `id_ap29f_dateRace` = :id'
            );
        //data retourne un tableau d'objet
        $displayWeekEnQuery->bindValue(':id', $this->id, PDO::PARAM_STR);
        $displayWeekEnQuery->execute();
        return $displayWeekEnQuery->fetch(PDO::FETCH_OBJ);
    }
}