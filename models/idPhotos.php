<?php
class connexion
{
    public $id = 0;
    public $id_ap29f_photos = 0;
    public $id_ap29f_articles = 0;
    private $db = NULL;
    public function __construct()
    {
        $this->db = dataBase::getInstance();
    }
    public function addConnexion()
    {
        //$db devient une instance de l'objet PDO
        // on fait une requête préparée
        $addconnectionQuery = $this->db->prepare(
            // Marqueur nominatif
            //bindValue: vérifie le type et que ça ne génère pas de faille de sécurité.
            //$this-> : permet d'acceder aux attributs de l'instance qui est en cours
            'INSERT INTO `ap29f_idPhotos` (`id_ap29f_photos`, `id_ap29f_articles`)
    VALUES(:id_ap29f_photos, :id_ap29f_articles)'
        );
        $addconnectionQuery->bindvalue(':id_ap29f_photos', $this->id_ap29f_photos, PDO::PARAM_INT);
        $addconnectionQuery->bindvalue(':id_ap29f_articles', $this->id_ap29f_articles, PDO::PARAM_STR);
        return $addconnectionQuery->execute();
    }
    /**
     * méthode permettant de supprimer une connexion par son id
     *
     * @return boolean
     */
    public function deleteconnexionById(){
        $deleteconnexionByIdQuery = $this->db->prepare(
            'DELETE FROM
                `ap29f_idPhotos`
            WHERE 
                `id_ap29f_articles` = :id'
        );
            $deleteconnexionByIdQuery->bindValue(':id', $this->id, PDO::PARAM_INT);
            return $deleteconnexionByIdQuery->execute();
    }
    /**
     * méthode permettant de récuperer les id de photo dans un tableau.
     * 
     * @return array
     */
    public function getPhotosIdInIdPhotos(){
        $getPhotosIdInIdPhotosQuery = $this->db->prepare(
        'SELECT
            `id_ap29f_photos`
        FROM
            `ap29f_idPhotos`
        WHERE
            `id_ap29f_articles` = :id');
        $getPhotosIdInIdPhotosQuery->bindValue(':id', $this->id, PDO::PARAM_INT);
        $getPhotosIdInIdPhotosQuery->execute();
        // PDO::FETCH_COLUMN renvoie un tableau contenant les données de la colonne selectionné
        return $getPhotosIdInIdPhotosQuery->fetchAll(PDO::FETCH_COLUMN);;
    }
    

    

}