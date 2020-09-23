<?php 
//--------------------------------PILOTS-----------------------------
class pilot
{
    public $id = 0;
    public $lastname = '';
    public $firstname = '';
    public $birthDate = '0000-00-00';
    public $number = 0;
    public $country = '';
    public $size = '';
    public $weight = '';
    public $description = '';
    public $id_ap29f_teams = 0;
    private $db = NULL;
    public function __construct()
    {
        $this->db = dataBase::getInstance();
    }
    /**
     * méthode permettant d'ajouter un pilote dans le base de données
     *
     * @return boolean
     */
    public function addPilot()
    {
        //$db devient une instance de l'objet PDO
        // on fait une requête préparée
        $addPilotQuery = $this->db->prepare(
            // Marqueur nominatif
            //bindValue: vérifie le type et que ça ne génère pas de faille de sécurité.
            //$this-> : permet d'acceder aux attributs de l'instance qui est en cours
            'INSERT INTO 
                `ap29f_pilots` (`photo`,`lastname`,`firstname`,`birthDate`,`number`,`country`,`size`,`weight`,`description`, `id_ap29f_teams`)
            VALUES
                (:photo,:lastname, :firstname, :birthDate, :number, :country, :size, :weight, :description, :id_ap29f_teams)'
        );
        $addPilotQuery->bindValue(':photo', $this->photo, PDO::PARAM_STR);
        $addPilotQuery->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $addPilotQuery->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $addPilotQuery->bindValue(':birthDate', $this->birthDate, PDO::PARAM_STR);
        $addPilotQuery->bindValue(':number', $this->number, PDO::PARAM_INT);
        $addPilotQuery->bindValue(':country', $this->country, PDO::PARAM_STR);
        $addPilotQuery->bindValue(':size', $this->size, PDO::PARAM_STR);
        $addPilotQuery->bindValue(':weight', $this->weight, PDO::PARAM_STR);
        $addPilotQuery->bindValue(':description', $this->description, PDO::PARAM_STR);
        $addPilotQuery->bindValue(':id_ap29f_teams', $this->id_ap29f_teams, PDO::PARAM_INT);
        return $addPilotQuery->execute();
    }
    /**
     * méthode permettant de verifie si un pilote existe deja.
     *
     * @return boolean
     */
    public function checkPilotsExist()
    {
        $checkPilotsExistQuery = $this->db->prepare(
            'SELECT COUNT(`id`) AS `isPilotExist`
            FROM `ap29f_pilots` 
            WHERE `lastname` = :lastname AND `firstname` = :firstname'
        );
        $checkPilotsExistQuery->bindvalue(':lastname', $this->lastname, PDO::PARAM_STR);
        $checkPilotsExistQuery->bindvalue(':firstname', $this->firstname, PDO::PARAM_STR);
        $checkPilotsExistQuery->execute();
        //la méthode renvoie le COUNT(`id`) AS `isteamExist`donc 0 ou 1
        return $checkPilotsExistQuery->fetch(PDO::FETCH_OBJ)->isPilotExist; 
    }
    public function checkPilotExistById()
    {
        $checkPilotExistByIdQuery = $this->db->prepare(
            'SELECT COUNT(`id`) AS `isPilotExist`
            FROM `ap29f_pilots` 
            WHERE `id` = :id'
        );
        $checkPilotExistByIdQuery->bindvalue(':id', $this->id, PDO::PARAM_STR);
        $checkPilotExistByIdQuery->execute();
        //la méthode renvoie le COUNT(`id`) AS `isteamExist`donc 0 ou 1
        return $checkPilotExistByIdQuery->fetch(PDO::FETCH_OBJ)->isPilotExist; 
    }
    
    //AFFICHER CARDS PILOTS
    function displayCardsPilots(){
        $pilotsCardQuery = $this->db->prepare(
            'SELECT 
                `firstname`
                , `lastname`
                , `photo`
                , `number`
                , `ap29f_pilots`.`id` AS `idPilot`
                , `ap29f_teams`.`id`
                , `ap29f_teams`.`id_ap29f_category`
                , `ap29f_category`.`id` 
            FROM 
                `ap29f_pilots`
            INNER JOIN 
                `ap29f_teams` ON `ap29f_pilots`.`id_ap29f_teams` = `ap29f_teams`.`id`
            INNER JOIN 
                `ap29f_category` ON `ap29f_teams`.`id_ap29f_category` = `ap29f_category`.`id`
            WHERE 
                `ap29f_category`.`id` = :id
            ORDER BY 
                `number` ASC ');
        $pilotsCardQuery->bindValue(':id', $this->id, PDO::PARAM_INT);
        $pilotsCardQuery->execute();
        //data retourne un tableau d'objet
        return $pilotsCardQuery->fetchAll(PDO::FETCH_OBJ);
    }
    function displayPilotsDetailTeam(){
        $displayPilotsDetailTeamQuery = $this->db->prepare(
            'SELECT 
                `firstname`
                , `lastname`
                , `number` 
            FROM 
                `ap29f_pilots`
            INNER JOIN 
                `ap29f_teams` ON `ap29f_pilots`.`id_ap29f_teams` = `ap29f_teams`.`id`
            WHERE 
                `ap29f_teams`.`id` = :id
            ORDER BY 
                `number` ASC ');
        $displayPilotsDetailTeamQuery->bindValue(':id', $this->id, PDO::PARAM_INT);
        $displayPilotsDetailTeamQuery->execute();
        //data retourne un tableau d'objet
        return $displayPilotsDetailTeamQuery->fetchAll(PDO::FETCH_OBJ);
    }
    function displayListNamePilots(){
        $displayListNamePilotsQuery = $this->db->query(
            'SELECT 
                `firstname`
                , `ap29f_pilots`.`id` AS `idPilot`
                , `lastname`
                , `ap29f_teams`.`name` AS `nameTeam`
                , `ap29f_category`.`name` AS `nameCategory`
            FROM 
                `ap29f_pilots`
            INNER JOIN 
                `ap29f_teams` ON `ap29f_pilots`.`id_ap29f_teams` = `ap29f_teams`.`id`
            INNER JOIN 
                `ap29f_category` ON `ap29f_teams`.`id_ap29f_category` = `ap29f_category`.`id`
            ORDER BY 
                 `ap29f_category`.`id` ASC, `lastname` ASC  ');
        //data retourne un tableau d'objet
        return $displayListNamePilotsQuery->fetchAll(PDO::FETCH_OBJ);
    }
    function displayListPilotsByCategory(){
        $displayListPilotsByNameQuery = $this->db->query(
            'SELECT 
                `firstname`
                , `lastname`
                , `ap29f_pilots`.`id` AS `idPilot`
            FROM 
                `ap29f_pilots`
            INNER JOIN 
                `ap29f_teams` ON `ap29f_pilots`.`id_ap29f_teams` = `ap29f_teams`.`id`
            INNER JOIN 
                `ap29f_category` ON `ap29f_teams`.`id_ap29f_category` = `ap29f_category`.`id`
            WHERE 
                `id_ap29f_category` = 1
            ORDER BY 
                `lastname` ASC ');
        //data retourne un tableau d'objet
        return $displayListPilotsByNameQuery->fetchAll(PDO::FETCH_OBJ);
    }
    function detailPilots(){
            $pilotDetailQuery = $this->db->prepare(
            'SELECT 
                `ap29f_pilots`.`id` 
                , `photo`
                , `lastname`
                , `firstname`
                , DATE_FORMAT(`birthDate`, \'%d-%m-%Y\') AS `birthDateFr`
                , DATE_FORMAT(`birthDate`, \'%Y-%m-%d\') AS `birthDateEn`
                , `number`
                , `country`
                , `size`
                , `weight`
                , `ap29f_pilots`.`description`
                , `id_ap29f_teams`
                ,`ap29f_teams`.`name` AS `teamName`
            FROM 
                `ap29f_pilots`
            INNER JOIN 
                `ap29f_teams` ON `ap29f_pilots`.`id_ap29f_teams` = `ap29f_teams`.`id`
            WHERE 
                `ap29f_pilots`.`id` = :id');
        //data retourne un tableau d'objet
        $pilotDetailQuery->bindValue(':id', $this->id, PDO::PARAM_INT);
        $pilotDetailQuery->execute();
        $data = $pilotDetailQuery->fetch(PDO::FETCH_OBJ);
        return $data;
    }
    public function updatePilot()
    {
        //$db devient une instance de l'objet PDO
        // on fait une requête préparée
        $modifyPilotQuery = $this->db->prepare(
            'UPDATE
                `ap29f_pilots`
            SET
                `photo` = :photo, `lastname` = :lastname, `firstname` = :firstname, `birthDate` = :birthDate, `number` = :number,`country` = :country,`size` = :size, `weight` = :weight, `description`= :description, `id_ap29f_teams` = :id_ap29f_teams
            WHERE 
                `id` = :id'
        );
        $modifyPilotQuery->bindValue(':id', $this->id, PDO::PARAM_INT);
        $modifyPilotQuery->bindValue(':photo', $this->photo, PDO::PARAM_STR);
        $modifyPilotQuery->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $modifyPilotQuery->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $modifyPilotQuery->bindValue(':birthDate', $this->birthDate, PDO::PARAM_STR);
        $modifyPilotQuery->bindValue(':number', $this->number, PDO::PARAM_INT);
        $modifyPilotQuery->bindValue(':country', $this->country, PDO::PARAM_STR);
        $modifyPilotQuery->bindValue(':size', $this->size, PDO::PARAM_STR);
        $modifyPilotQuery->bindValue(':weight', $this->weight, PDO::PARAM_STR);
        $modifyPilotQuery->bindValue(':description', $this->description, PDO::PARAM_STR);
        $modifyPilotQuery->bindValue(':id_ap29f_teams', $this->id_ap29f_teams, PDO::PARAM_INT);
        return $modifyPilotQuery->execute();
    }
    /**
     * méthode permettant de supprimer un pilotes par son id
     *
     * @return boolean
     */
    public function deletePilotById(){
        $deletePilotByIdQuery = $this->db->prepare(
            'DELETE FROM
                `ap29f_pilots`
            WHERE 
                `id` = :id'
        );
            $deletePilotByIdQuery->bindValue(':id', $this->id, PDO::PARAM_INT);
            return $deletePilotByIdQuery->execute();
    }
}


