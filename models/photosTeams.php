<?php
class photosTeam
{
    public $id = 0;
    public $photoResume = '';
    public $photoCard = '';
    public $id_ap29f_teams = 0;
    private $db = NULL;
    public function __construct()
    {
        $this->db = dataBase::getInstance();
    }
    public function addPhotos()
    {
        $addPhotosQuery = $this->db->prepare(
            // Marqueur nominatif
            //bindValue: vérifie le type et que ça ne génère pas de faille de sécurité.
            //$this-> : permet d'acceder aux attributs de l'instance qui est en cours
            'INSERT INTO `ap29f_photosTeams` (`photoResume`,`photoCard`, `id_ap29f_teams`)
    VALUES(:photoResume, :photoCard, :id_ap29f_teams)'
        );
        $addPhotosQuery->bindvalue(':photoResume', $this->photoResume, PDO::PARAM_STR);
        $addPhotosQuery->bindvalue(':photoCard', $this->photoCard, PDO::PARAM_STR);
        $addPhotosQuery->bindvalue(':id_ap29f_teams', $this->id_ap29f_teams, PDO::PARAM_INT);
        return $addPhotosQuery->execute();
    }
}