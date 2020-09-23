<?php
class championship
{
    public $id = 0;
    public $name = '';
    private $db = NULL;
    public function __construct()
    {
        $this->db = dataBase::getInstance();
    }
    function championships(){
        $championshipsQuery = $this->db->query(
            'SELECT 
                `id`
                , `name`
            FROM 
                `ap29f_championship`');
        //data retourne un tableau d'objet
        $data = $championshipsQuery->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }
}