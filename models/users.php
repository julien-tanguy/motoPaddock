<?php
class user
{
    public $id = 0;
    public $username = '';
    public $password = '';
    public $mail = '';
    public $id_ap29f_roles = 0;
    private $db = NULL;
    public function __construct()
    {
        $this->db = dataBase::getInstance();
    }
    public function usersList(){
        $usersListQuery = $this->db->query(
            'SELECT 
                `id`
                , `username`
            FROM 
                `ap29f_users`
            WHERE `id` = 1 AND 2');
        //data retourne un tableau d'objet
        return $usersListQuery->fetchAll(PDO::FETCH_OBJ);
    }
    /**
 * Méthode permettant d'enregistrer un utilisateur
 * 
 * @return boolean
 */
    public function addUser(){
        $addUserQuery = $this->db->prepare(
            'INSERT INTO `ap29f_users`
            (`username`, `password`, `mail`, `id_ap29f_roles`)
            VALUES (:username, :password, :mail, 4)
        ');
        $addUserQuery->bindValue(':username',$this->username,PDO::PARAM_STR);
        $addUserQuery->bindValue(':mail',$this->mail,PDO::PARAM_STR);
        $addUserQuery->bindValue(':password',$this->password,PDO::PARAM_STR);
        return $addUserQuery->execute();
    }
    /**
     * Méthode permettant de savoir une valeur d'un champ est déjà prise    
     * Valeur de retour :
     *  - True : la valeur est déjà prise
     *  - False : la valeur est disponible
     * 
     * @param array $field
     * @return boolean
     */
    public function checkDispoByFieldName($field){
        $whereArray = [];
        foreach($field as $fieldName ){
            $whereArray[] = '`' . $fieldName . '` = :' . $fieldName;
        }
        //on stocke le where a l'exterieure de la requéte pour éviter les failles de sécurité (injection SQL)
        $where = ' WHERE ' . implode(' AND ', $whereArray);
        $checkDispoByFieldNameQuery = $this->db->prepare('
            SELECT COUNT(`id`) as `isUnavailable`
            FROM `ap29f_users`' 
            . $where
        ); 
        foreach($field as $fieldName ){
            $checkDispoByFieldNameQuery->bindValue(':'.$fieldName,$this->$fieldName,PDO::PARAM_STR);
        }
        $checkDispoByFieldNameQuery->execute();
        return $checkDispoByFieldNameQuery->fetch(PDO::FETCH_OBJ)->isUnavailable;
    }
    /**
     * Méthode permettant de récupérer le hash du mot de passe de l'utilisateur
     *
     * @return void
     */
    public function getUserPasswordHash(){
        $getUserPasswordHash = $this->db->prepare(
            'SELECT `password` 
            FROM `ap29f_users`
            WHERE `mail` = :mail'
        );
        $getUserPasswordHash->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $getUserPasswordHash->execute();
        $response = $getUserPasswordHash->fetch(PDO::FETCH_OBJ);
        //si $response est un objet, cela signifie que 
        //le mot de passe existe dans la base de données
        //sinon retourné une chaine vide pour eviter les erreurs
        if(is_object($response)){
            return $response->password;
        }else{
            return '';
        }
    }
    /**
     * Méthode permettant de récupérer les différentes infos d'un utilisateur
     * 
     * @return object
     */
    public function getUserProfile(){
        $getUserProfileQuery = $this->db->prepare(
            'SELECT `id`, `username`, `mail`, `id_ap29f_roles`
            FROM `ap29f_users`
            WHERE `mail` = :mail'
        );
        $getUserProfileQuery->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $getUserProfileQuery->execute();
        return $getUserProfileQuery->fetch(PDO::FETCH_OBJ);
    }
    /**
     * Méthode permettant de mettre à jour le pseudo d'un utilisateur
     * 
     * @return object
     */
    public function updateInfoUser(){
        $updateInfoUserQuery = $this->db->prepare(
            'UPDATE `ap29f_users`
            SET `username` = :username
            WHERE `id` = :id'
            );
        $updateInfoUserQuery->bindValue(':id', $this->id, PDO::PARAM_INT);
        $updateInfoUserQuery->bindValue(':username', $this->username, PDO::PARAM_STR);
        return $updateInfoUserQuery->execute();
    }
    /**
     * Méthode permettant de mettre à jour le mot de passe d'un utilisateur
     * 
     * @return object
     */
    public function updatepasswordUser(){
        $updatepasswordUserQuery = $this->db->prepare(
            'UPDATE `ap29f_users`
            SET `password` = :password
            WHERE `id` = :id'
            );
        $updatepasswordUserQuery->bindValue(':id', $this->id, PDO::PARAM_INT);
        $updatepasswordUserQuery->bindValue(':password', $this->password, PDO::PARAM_STR);
        return $updatepasswordUserQuery->execute();
    }
    /**
     * méthode permettant de supprimer un utilisateur par son id
     *
     * @return boolean
     */
    public function deleteUserById(){
        $deleteUserByIdQuery = $this->db->prepare(
            'DELETE FROM
                `ap29f_users`
            WHERE 
                `id` = :id'
        );
            $deleteUserByIdQuery->bindValue(':id', $this->id, PDO::PARAM_INT);
            return $deleteUserByIdQuery->execute();
    }
}