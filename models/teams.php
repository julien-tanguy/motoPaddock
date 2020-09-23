<?php
//déclaration de ma class team
class team
{
//declaration des attributs de la class team avec une valeur par défaut
    public $id = 0;
    public $name = '';
    public $description = '';
    public $logoTeam = '';
    public $id_ap29f_category = 0;
    private $db = NULL;
//declaration du la méthode magique __construct qui va créer l'instance 
//via la méthode getInstance déclaré dans le model dataBase
    public function __construct()
    {
        $this->db = dataBase::getInstance();
    }
//méthodes liées aux transactions
    /*beginTransaction() : Démarre une transaction, désactive le mode autocommit. 
    Lorsque l'autocommit est désactivé, les modifications faites sur la base de données via les instances des objets PDO
     ne sont pas appliquées tant que vous ne mettez pas fin à la transaction en appelant la fonction PDO::commit().  */
    public function beginTransaction(){
        return $this->db->beginTransaction();
    }
    /* rollBack() : Annule une transaction, Si la base de données est en mode autocommit,
     cette fonction restaurera le mode autocommit après l'annulation de la transaction. */
    public function rollBack(){
        return $this->db->rollBack();
    }
    /*getLastInsertId() : Retourne l'identifiant auto-généré utilisé dans la dernière requête. */
    public function getLastInsertId(){
        return $this->db->lastInsertId();
    }
    /*commit() : applique les modifications sur la base de données. */
    public function commit(){
        return $this->db->commit();
    }
//declaration de la méthode addTeam pour inserer une nouvelle équipe dans la base de données
    public function addTeam()
    {
        //$db devient une instance de l'objet PDO
        // j'utilise une requête préparée car je ne connais pas encore les valeurs a inserer
        $addTeamQuery = $this->db->prepare(
        //$this-> : permet d'acceder aux attributs de l'instance qui est en cours
        //INSERT INTO permet d'inserer dans la table ap29f_teams pour les champs indiqué entres parenthéses
        //les valeurs contenu entres parenthése aprés VALUES
            'INSERT INTO `ap29f_teams` (`name`,`description`,`logoTeam`,`id_ap29f_category`)
            VALUES(:name,:description, :logoTeam, :id_ap29f_category)'
        );
        // j'utilise des marqueurs nominatifs pour sécuriser la requéte en évitant d'y inserer
        //directement les valeurs postés par l'utilisateur ce qui la rendrait vulnérable à une injection SQL 
        //le bindValue sert à vérifier le type et que ça ne génère pas de faille de sécurité (injection SQL)
        $addTeamQuery->bindvalue(':name', $this->name, PDO::PARAM_STR);
        $addTeamQuery->bindvalue(':description', $this->description, PDO::PARAM_STR);
        $addTeamQuery->bindvalue(':logoTeam', $this->logoTeam, PDO::PARAM_STR);
        $addTeamQuery->bindvalue(':id_ap29f_category', $this->id_ap29f_category, PDO::PARAM_INT);
        return $addTeamQuery->execute();
    }
    public function teamsList(){
        $teamsQuery = $this->db->query(
            'SELECT 
                `id`
                , `name`
            FROM 
                `ap29f_teams`');
        //data retourne un tableau d'objet
        $data = $teamsQuery->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }
    /**
     * méthode permettant d'afficher la liste des équipe sous 
     * forme de cards
     *
     * @return boolean
     */
    public function teamsCard(){
        /*j'utilise une requéte préparé pour afficher
        les équipes selon l'id de leurs catégory.
        J'effectue des jointure entres les tables teams, photosTeam et catégory
        pour pouvoir afficher des elément des ces 3 tables */
        $CardTeamQuery = $this->db->prepare(
            'SELECT 
                `ap29f_teams`.`id` AS `idTeam`
                , `ap29f_teams`.`name`
                , `ap29f_photosTeams`.`photoCard`
            FROM 
                `ap29f_teams`
            INNER JOIN 
                `ap29f_category` ON `ap29f_teams`.`id_ap29f_category` = `ap29f_category`.`id`
            INNER JOIN 
                `ap29f_photosTeams` ON `ap29f_photosTeams`.`id_ap29f_teams` = `ap29f_teams`.`id`
            WHERE 
                `ap29f_category`.`id` = :id');
        /*fetchall retourne un tableau d'objet
        contenant touts les résultats.*/
        $CardTeamQuery->bindvalue(':id', $this->id, PDO::PARAM_STR);
        $CardTeamQuery->execute();
        return $CardTeamQuery->fetchAll(PDO::FETCH_OBJ);
    }
    public function displayListTeamPilots(){
        $displayListTeamPilotsQuery = $this->db->query(
            'SELECT 
                `ap29f_teams`.`id` AS `idTeam`
                , `ap29f_teams`.`name` AS `nameTeam`
                , `ap29f_category`.`name` AS `nameCategory`
            FROM 
                `ap29f_teams`
            INNER JOIN 
                `ap29f_category` ON `ap29f_teams`.`id_ap29f_category` = `ap29f_category`.`id`
            ORDER BY 
                `ap29f_category`.`id` ASC, `nameTeam` ASC ');
        //data retourne un tableau d'objet
        return $displayListTeamPilotsQuery->fetchAll(PDO::FETCH_OBJ);
    }
    public function detailTeams(){
            $detailTeamQuery = $this->db->prepare(
            'SELECT 
                `ap29f_teams`.`name` AS `teamName`
                , `ap29f_teams`.`description` AS `teamDescription`
                , `logoTeam`
                , `photoResume`
                , `photoCard`
            FROM 
                `ap29f_teams`
            INNER JOIN 
                `ap29f_photosTeams` ON `ap29f_photosTeams`.`id_ap29f_teams` = `ap29f_teams`.`id`
            INNER JOIN 
                `ap29f_category` ON `ap29f_teams`.`id_ap29f_category` = `ap29f_category`.`id`
            WHERE 
                `ap29f_teams`.`id` = :id ');
        $detailTeamQuery->bindvalue(':id', $this->id, PDO::PARAM_STR);
        //maintenant que toute les valeurs sont définis, executer la méthode
        $detailTeamQuery->execute();
        return $detailTeamQuery->fetch(PDO::FETCH_OBJ);
    }
    /**
     * méthode permettant de verifie si une equipe existe deja par son nom.
     *
     * @return boolean
     */
    public function checkTeamsExist()
    {
        /*COUNT(id) compteras le nombre d'id correspondand dans la table indiqué aprés FROM (ici ap29f_teams) 
        par le WHERE (ici le champ name)  */
        $checkTeamsExistQuery = $this->db->prepare(
            'SELECT COUNT(`id`) AS `isteamExist`
            FROM `ap29f_teams` 
            WHERE `name` = :name'
        );
        $checkTeamsExistQuery->bindvalue(':name', $this->name, PDO::PARAM_STR);
        $checkTeamsExistQuery->execute();
        /*la méthode retourne le COUNT(`id`) AS `isteamExist`donc 0 ou 1.
        Si 0 : l'équipe n'existe pas, je peux l'ajouter.
        Si 1 : l'équipe existe déjà.*/
        return $checkTeamsExistQuery->fetch(PDO::FETCH_OBJ)->isteamExist; 
    }
    /**
     * méthode permettant de verifie si une equipe existe deja par son id.
     *
     * @return boolean
     */
    public function checkTeamsExistById()
    {
        $checkTeamsExistByIdQuery = $this->db->prepare(
            'SELECT COUNT(`id`) AS `isteamExist`
            FROM `ap29f_teams` 
            WHERE `id` = :id'
        );
        $checkTeamsExistByIdQuery->bindvalue(':id', $this->id, PDO::PARAM_STR);
        $checkTeamsExistByIdQuery->execute();
        //la méthode renvoie le COUNT(`id`) AS `isteamExist`donc 0 ou 1
        return $checkTeamsExistByIdQuery->fetch(PDO::FETCH_OBJ)->isteamExist; 
    }
    /**
     * méthode permettant de mettre une equipe a jour
     *
     * @return boolean
     */
    public function updateTeam()
    {
        /* Je fait une requête préparée.
        J'utilise la commande SQL UPDATE pour indiquer la table a mettre à jour.
        La commande SET pour données au champs souhaitais une nouvelle valeurs,
        et la commande WHERE pour ciblé la ligne à mettre à jour.*/
        $updateTeamQuery = $this->db->prepare(
            'UPDATE
                `ap29f_teams`
            SET
                `name` = :name, `description` = :description
            WHERE 
                `id` = :id'
        );
        $updateTeamQuery->bindValue(':id', $this->id, PDO::PARAM_INT);
        $updateTeamQuery->bindvalue(':name', $this->name, PDO::PARAM_STR);
        $updateTeamQuery->bindvalue(':description', $this->description, PDO::PARAM_STR);
        return $updateTeamQuery->execute();
    }
    /**
     * méthode permettant de supprimer une team par son id
     *
     * @return boolean
     */
    public function deleteTeamById()
    {
        /* Je fait une requête préparée.
        J'utilise la commande SQL DELETE FROM pour indiquer la table dans laquel supprimer
        et la commande WHERE pour ciblé la ligne à supprimer.*/
        $deleteTeamByIdQuery = $this->db->prepare(
            'DELETE FROM
                `ap29f_teams`
            WHERE 
                `id` = :id'
        );
            $deleteTeamByIdQuery->bindValue(':id', $this->id, PDO::PARAM_INT);
            return $deleteTeamByIdQuery->execute();
    }
}