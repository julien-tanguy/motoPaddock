<?php
class photoPresentation
{
    public $id = 0;
    public $link = '';
    private $db = NULL;
    public function __construct()
    {
        $this->db = dataBase::getInstance();
    }
    public function addPhotoPresentation()
    {
        //$db devient une instance de l'objet PDO
        // on fait une requête préparée
        $addPhotoQuery = $this->db->prepare(
            // Marqueur nominatif
            //bindValue: vérifie le type et que ça ne génère pas de faille de sécurité.
            //$this-> : permet d'acceder aux attributs de l'instance qui est en cours
            'INSERT INTO `ap29f_photos` (`link`)
            VALUES(:link)'
        );
        $addPhotoQuery->bindvalue(':link', $this->link, PDO::PARAM_STR);
        return $addPhotoQuery->execute();
    }
    /**
     * méthode permettant de supprimer une photos par son id
     *
     * @return boolean
     */
    
    //function array()
    //$toto = array_fill (0, count(array), '?')
    // . implode . (',' , $toto)
    public function deletePhotosById($array){
        //le tableau $countToDelete contiendra autant de ? (marqueurs interrogatifs)
        //qu'il y a de valeur dans le tableau passé en argument.
        $countToDelete = array_fill (0, count($array), '?');
        $deletePhotosByIdQuery = $this->db->prepare(
        'DELETE FROM
            `ap29f_photos`
            WHERE `id` IN ('. implode(',', $countToDelete) .')'
        );
        // Les marqueurs interrogatifs sont remplacé par les valeur du tableau 
        //passé en argument dans l'implode
        return $deletePhotosByIdQuery->execute($array);
    }
}