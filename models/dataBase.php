<?php
class dataBase {
    public $db = null;
    private static $instance = null;
    public function __construct(){
        try {
            $this->db = new PDO('mysql:host=54.37.71.121;dbname=c72motopaddock;charset=utf8', 'c72julient', 'EyhJ#qL6', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } catch (Exception $error) {
            die($error->getMessage());
        }
    }
    /**
     * Singleton    
     * Static signifie que je ne peut pas y accèder via l'instance.    
     * on y accède de cette façon: nomClass::methode() ou nomClass::attribut
     *
     * @return instance 
     */
    public static function getInstance(){
        //On créer une instance PDO si et seulement si il en n'existe pas déjà une
        if(is_null(self::$instance)){
            self::$instance = new dataBase();
        }
        return self::$instance->db;
    }
}