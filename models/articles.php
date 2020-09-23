<?php
class article
{
    public $id = 0;
    public $title = '';
    public $content = '';
    public $publicationDate = '0000-00-00';
    public $lastEditDate = '';
    public $id_ap29f_category = 0;
    public $id_ap29f_users = 0;
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
    public function addArticle()
    {
        //$db devient une instance de l'objet PDO
        // on fait une requête préparée
        $addArticleQuery = $this->db->prepare(
            // Marqueur nominatif
            //bindValue: vérifie le type et que ça ne génère pas de faille de sécurité.
            //$this-> : permet d'acceder aux attributs de l'instance qui est en cours
            'INSERT INTO 
                `ap29f_articles` (`title`,`content`,`publicationDate`,`lastEditDate`,`id_ap29f_category`,`id_ap29f_users`)
            VALUES
                (:title, :content, :publicationDate, :lastEditDate, :id_ap29f_category, :id_ap29f_users)'
        );
        $addArticleQuery->bindvalue(':title', $this->title, PDO::PARAM_STR);
        $addArticleQuery->bindvalue(':content', $this->content, PDO::PARAM_STR);
        $addArticleQuery->bindvalue(':publicationDate', $this->publicationDate, PDO::PARAM_STR);
        $addArticleQuery->bindvalue(':lastEditDate', $this->lastEditDate, PDO::PARAM_STR);
        $addArticleQuery->bindvalue(':id_ap29f_category', $this->id_ap29f_category, PDO::PARAM_INT);
        $addArticleQuery->bindvalue(':id_ap29f_users', $this->id_ap29f_users, PDO::PARAM_INT);
        return $addArticleQuery->execute();
    }
    public function checkArticlesExistByTitle()
    {
        $checkArticlesExistByTitleQuery = $this->db->prepare(
            'SELECT COUNT(`id`) AS `isArticleExist`
            FROM `ap29f_articles` 
            WHERE `title` = :title'
        );
        $checkArticlesExistByTitleQuery->bindvalue(':title', $this->title, PDO::PARAM_STR);
        $checkArticlesExistByTitleQuery->execute();
        //la méthode renvoie le COUNT(`id`) AS `isteamExist`donc 0 ou 1
        return $checkArticlesExistByTitleQuery->fetch(PDO::FETCH_OBJ)->isArticleExist; 
    }
    public function checkArticlesExistById()
    {
        $checkArticlesExistByIdQuery = $this->db->prepare(
            'SELECT COUNT(`id`) AS `isArticleExist`
            FROM `ap29f_articles` 
            WHERE `id` = :id'
        );
        $checkArticlesExistByIdQuery->bindvalue(':id', $this->id, PDO::PARAM_STR);
        $checkArticlesExistByIdQuery->execute();
        //la méthode renvoie le COUNT(`id`) AS `isteamExist`donc 0 ou 1
        return $checkArticlesExistByIdQuery->fetch(PDO::FETCH_OBJ)->isArticleExist; 
    }
    function articlesList(){
        $articlesListQuery = $this->db->query(
            'SELECT 
                `id`
                , `title`
            FROM 
                `ap29f_articles`');
        //data retourne un tableau d'objet
        $data = $articlesListQuery->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }
    function displayCardsArticle($limitArray = array(), $value = 0){
            if($value > 0){
                $where = 'WHERE id_ap29f_category = :id_ap29f_category';
            }
        $displayCardsArticleQuery = $this->db->prepare(
            'SELECT 
                `ap29f_articles`.`id` AS `idArticles`
                , `title`
                , `publicationDate`
                ,`ap29f_users`.`username`
                , `ap29f_photos`.`link`
            FROM 
                `ap29f_articles`
            INNER JOIN 
                `ap29f_users` ON `ap29f_articles`.`id_ap29f_users` = `ap29f_users`.`id`
            INNER JOIN 
                `ap29f_roles` ON `ap29f_users`.`id_ap29f_roles` = `ap29f_roles`.`id`
            INNER JOIN 
                `ap29f_idPhotos` ON `ap29f_idPhotos`.`id_ap29f_articles` = `ap29f_articles`.`id`
            INNER JOIN 
                `ap29f_photos` ON `ap29f_idPhotos`.`id_ap29f_photos` = `ap29f_photos`.`id` 
            ' . (isset($where) ? $where : '') . ' 
            ORDER BY 
                `publicationDate` DESC '
                . (count($limitArray) == 2 ? 'LIMIT :limit OFFSET :offset' : ''));
        if(isset($where)){
            $displayCardsArticleQuery->bindvalue(':id_ap29f_category', $value , PDO::PARAM_STR);
        }
        if (count($limitArray) == 2){
            $displayCardsArticleQuery->bindvalue(':limit', $limitArray['limit'], PDO::PARAM_INT);
            $displayCardsArticleQuery->bindvalue(':offset', $limitArray['offset'], PDO::PARAM_INT);
        }
        $displayCardsArticleQuery->execute();
        return $displayCardsArticleQuery->fetchAll(PDO::FETCH_OBJ);  
    }
    function displayCarouselArticle(){
        $displayCarouselArticleQuery = $this->db->query(
            'SELECT 
                `ap29f_articles`.`id` AS `idArticles`
                , `title`
                , `content`
                ,`lastEditDate`
                , `publicationDate`
                , `id_ap29f_users`
                ,`ap29f_users`.`username`
                , `ap29f_photos`.`link`
            FROM 
                `ap29f_articles`
            INNER JOIN 
                `ap29f_users` ON `ap29f_articles`.`id_ap29f_users` = `ap29f_users`.`id`
            INNER JOIN 
                `ap29f_roles` ON `ap29f_users`.`id_ap29f_roles` = `ap29f_roles`.`id`
            INNER JOIN 
                `ap29f_idPhotos` ON `ap29f_idPhotos`.`id_ap29f_articles` = `ap29f_articles`.`id`
            INNER JOIN 
                `ap29f_photos` ON `ap29f_idPhotos`.`id_ap29f_photos` = `ap29f_photos`.`id`
            ORDER BY 
                `lastEditDate` DESC 
            LIMIT 4 OFFSET 0');
        //data retourne un tableau d'objet
        $data = $displayCarouselArticleQuery->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }
    function displayArticle(){
        $displayArticleQuery = $this->db->prepare(
            'SELECT 
            `ap29f_articles`.`id` AS `idArticles`
            , `title`
            , `content`
            , `publicationDate`
            , DATE_FORMAT(`lastEditDate`, \'%d-%m-%Y %H:%i\') AS `editDateFr`
            , `id_ap29f_users`
            ,`ap29f_users`.`username` AS `authorName`
            , `ap29f_photos`.`link` 
            ,`ap29f_category`.`name` AS `categoryName`
        FROM 
            `ap29f_articles`
        INNER JOIN 
            `ap29f_users` ON `ap29f_articles`.`id_ap29f_users` = `ap29f_users`.`id`
        INNER JOIN 
            `ap29f_roles` ON `ap29f_users`.`id_ap29f_roles` = `ap29f_roles`.`id`
        INNER JOIN 
            `ap29f_idPhotos` ON `ap29f_idPhotos`.`id_ap29f_articles` = `ap29f_articles`.`id`
        INNER JOIN 
            `ap29f_photos` ON `ap29f_idPhotos`.`id_ap29f_photos` = `ap29f_photos`.`id`
        INNER JOIN 
            `ap29f_category` ON `ap29f_articles`.`id_ap29f_category` = `ap29f_category`.`id`
        WHERE 
            `ap29f_articles`.`id` = :id ');
    $displayArticleQuery->bindvalue(':id', $this->id, PDO::PARAM_INT);
    $displayArticleQuery->execute();
    //data retourne un tableau d'objet
    return $displayArticleQuery->fetch(PDO::FETCH_OBJ);
    }
    function displayListNameArticles(){
        $displayListNameArticlesQuery = $this->db->query(
            'SELECT
                `ap29f_articles`.`id` AS `articleId`    
                ,`title`
                ,`lastEditDate`
                ,`ap29f_users`.`username`
            FROM 
                `ap29f_articles`
            INNER JOIN 
                `ap29f_users` ON `ap29f_articles`.`id_ap29f_users` = `ap29f_users`.`id`
            ORDER BY 
                `lastEditDate` DESC ');
        //data retourne un tableau d'objet
        return $displayListNameArticlesQuery->fetchAll(PDO::FETCH_OBJ);
    }
    public function updateArticle()
    {
        $updateArticleQuery = $this->db->prepare(
            'UPDATE
                `ap29f_articles`
            SET
                `title` = :title
                , `content` = :content
                , `lastEditDate` = NOW()
            WHERE 
                `id` = :id'
        );
        $updateArticleQuery->bindvalue(':title', $this->title, PDO::PARAM_STR);
        $updateArticleQuery->bindvalue(':content', $this->content, PDO::PARAM_STR);
        $updateArticleQuery->bindvalue(':id', $this->id, PDO::PARAM_INT);
        return $updateArticleQuery->execute();
    }
    public function displayUpdateArticle()
    {
        $displayUpdateArticleQuery = $this->db->prepare(
            'SELECT
                `title` 
                , `content` 
            FROM
                `ap29f_articles`
            WHERE 
                `id` = :id'
        );
        $displayUpdateArticleQuery->bindvalue(':id', $this->id, PDO::PARAM_INT);
        //si il y a un prepare, il y a un execute
        $displayUpdateArticleQuery->execute();
        return $displayUpdateArticleQuery->fetch(PDO::FETCH_OBJ);
    }
    /**
     * méthode permettant de supprimer un article par son id
     *
     * @return boolean
     */
    public function deleteArticleById(){
        $deleteArticleByIdQuery = $this->db->prepare(
            'DELETE FROM
                `ap29f_articles`
            WHERE 
                `id` = :id'
        );
            $deleteArticleByIdQuery->bindValue(':id', $this->id, PDO::PARAM_INT);
            return $deleteArticleByIdQuery->execute();
    }
}