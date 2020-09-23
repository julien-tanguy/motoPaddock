<?php
class comment
{
    public $id = 0;
    public $content = '';
    public $date = '0000-00-00 00:00:00';
    public $id_ap29f_articles = 0;
    public $id_ap29f_users = 0;
    private $db = NULL;
    public function __construct()
    {
        $this->db = dataBase::getInstance();
    }
    public function addComment()
    {
        //$db devient une instance de l'objet PDO
        // on fait une requête préparée
        $addCommentQuery = $this->db->prepare(
            // Marqueur nominatif
            //bindValue: vérifie le type et que ça ne génère pas de faille de sécurité.
            //$this-> : permet d'acceder aux attributs de l'instance qui est en cours
            'INSERT INTO 
                `ap29f_comments` (`content`,`date`,`id_ap29f_articles`,`id_ap29f_users`)
            VALUES
                (:content, NOW(), :id_ap29f_articles, :id_ap29f_users)'
        );
        $addCommentQuery->bindvalue(':content', $this->content, PDO::PARAM_STR);
        $addCommentQuery->bindvalue(':id_ap29f_articles', $this->id_ap29f_articles, PDO::PARAM_INT);
        $addCommentQuery->bindvalue(':id_ap29f_users', $this->id_ap29f_users, PDO::PARAM_INT);
        return $addCommentQuery->execute();
    }
    public function displaycommentByIdArticle()
    {
        $displaycommentByIdArticleQuery = $this->db->prepare(
            'SELECT
                `ap29f_comments`.`content` AS `commentContent`
                ,`date`
                ,`ap29f_users`.`username` AS `authorComment`
            FROM
                `ap29f_comments`
            INNER JOIN `ap29f_users` ON `ap29f_comments`.`id_ap29f_users` = `ap29f_users`.`id`
            INNER JOIN `ap29f_articles` ON `ap29f_comments`.`id_ap29f_articles` = `ap29f_articles`.`id`
            WHERE 
                `ap29f_articles`.`id` = :id
            ORDER BY 
                `date` DESC '
        );
        $displaycommentByIdArticleQuery->bindvalue(':id', $this->id, PDO::PARAM_INT);
        //si il y a un prepare, il y a un execute
        $displaycommentByIdArticleQuery->execute();
        return $displaycommentByIdArticleQuery->fetchAll(PDO::FETCH_OBJ);
    }
}