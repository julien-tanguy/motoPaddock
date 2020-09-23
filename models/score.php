<?php
class score
{
    public $id = 0;
    public $value = 0;
    public $id_ap29f_pilots = 0;
    public $id_ap29f_race = 0;
    
    private $db = NULL;
    public function __construct()
    {
        $this->db = dataBase::getInstance();
    }
    /**
     * méthode permettant d'ajouter un score dans le base de données
     *
     * @return boolean
     */
    public function addScore()
    {
        $addScoreQuery = $this->db->prepare(
            // Marqueur nominatif
            //bindValue: vérifie le type et que ça ne génère pas de faille de sécurité.
            //$this-> : permet d'acceder aux attributs de l'instance qui est en cours
            'INSERT INTO 
                `ap29f_score` (`value`,`id_ap29f_pilots`,`id_ap29f_race`)
            VALUES
                (:value,:id_ap29f_pilots, :id_ap29f_race)'
        );
        $addScoreQuery->bindValue(':value', $this->value, PDO::PARAM_STR);
        $addScoreQuery->bindValue(':id_ap29f_pilots', $this->id_ap29f_pilots, PDO::PARAM_STR);
        $addScoreQuery->bindValue(':id_ap29f_race', $this->id_ap29f_race, PDO::PARAM_STR);
        return $addScoreQuery->execute();
    }
    /**
     * méthode permettant d'afficher le tableau des scores par l'id de la course
     *
     * @return array
     */
    function displayResultById(){
        $displayResultByIdQuery = $this->db->prepare(
        'SELECT 
            `value`
            ,`ap29f_teams`.`name` AS `teamName`
            ,`ap29f_pilots`.`lastname` AS `pilLast`
            ,`ap29f_pilots`.`firstname` AS `pilFirst`
            ,`ap29f_race`.`name` AS `raceName`
        FROM 
            `ap29f_score`
        INNER JOIN 
            `ap29f_pilots` ON `ap29f_score`.`id_ap29f_pilots` = `ap29f_pilots`.`id`
        INNER JOIN 
            `ap29f_race` ON `ap29f_score`.`id_ap29f_race` = `ap29f_race`.`id`
        INNER JOIN 
            `ap29f_teams` ON `ap29f_pilots`.`id_ap29f_teams` = `ap29f_teams`.`id`
        INNER JOIN 
            `ap29f_category` ON `ap29f_teams`.`id_ap29f_category` = `ap29f_category`.`id`
        WHERE 
            `ap29f_race`.`id` = :id AND `id_ap29f_category` = 1 AND `value` IS NOT NULL
        ORDER BY
            `value` DESC');
    //AND `value` IS NOT NULL = la requéte ne s'execute seulement si value n'est pas NULL
    $displayResultByIdQuery->bindValue(':id', $this->id, PDO::PARAM_INT);
    $displayResultByIdQuery->execute();
    return $displayResultByIdQuery->fetchAll(PDO::FETCH_OBJ);
    }
    /**
     * méthode permettant d'afficher le classement général 
     * grace a la somme (SUM()) des valeur de la table score
     *
     * @return array
     */
    function displayGeneralLadder(){
        $displayGeneralLadderQuery = $this->db->prepare(
            'SELECT SUM(`value`) AS `sumValues`
                    , `id_ap29f_pilots` 
                    ,`ap29f_teams`.`name` AS `teamName`
                    ,`ap29f_pilots`.`lastname` AS `pilLast`
                    ,`ap29f_pilots`.`firstname` AS `pilFirst`
            FROM 
                `ap29f_score`
            INNER JOIN 
                `ap29f_pilots` ON `ap29f_score`.`id_ap29f_pilots` = `ap29f_pilots`.`id` 
            INNER JOIN 
                `ap29f_teams` ON `ap29f_pilots`.`id_ap29f_teams` = `ap29f_teams`.`id`
            INNER JOIN 
                `ap29f_category` ON `ap29f_teams`.`id_ap29f_category` = `ap29f_category`.`id`
            WHERE 
                `id_ap29f_category` = :id 
            GROUP BY 
                `id_ap29f_pilots`
            ORDER BY 
                `sumValues` DESC ');
        $displayGeneralLadderQuery->bindValue(':id', $this->id, PDO::PARAM_INT);
        $displayGeneralLadderQuery->execute();
        return $displayGeneralLadderQuery->fetchAll(PDO::FETCH_OBJ);
    }
}


