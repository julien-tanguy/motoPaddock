<?php
class category
{
    public $id = 0;
    public $name = '';
    private $db = NULL;
    public function __construct()
    {
        $this->db = dataBase::getInstance();
    }
    function categoriesList(){
        $categoryQuery = $this->db->query(
            'SELECT 
                `id`
                , `name`
            FROM 
                `ap29f_category`');
        //data retourne un tableau d'objet
        $data = $categoryQuery->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }
    /**
     * méthode permettant de verifie si une catégorie existe deja par son id.
     *
     * @return boolean
     */
    public function checkcategoryExistById()
    {
        $checkcategoryExistByIdQuery = $this->db->prepare(
            'SELECT COUNT(`id`) AS `isCatExist`
            FROM `ap29f_category` 
            WHERE `id` = :id'
        );
        $checkcategoryExistByIdQuery->bindvalue(':id', $this->id, PDO::PARAM_STR);
        $checkcategoryExistByIdQuery->execute();
        //la méthode renvoie le COUNT(`id`) AS `isteamExist`donc 0 ou 1
        return $checkcategoryExistByIdQuery->fetch(PDO::FETCH_OBJ)->isCatExist; 
    }
}
