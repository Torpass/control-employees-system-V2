<?php
class UsersConnection extends ConexionSQL{

    public function __construct() {
      parent::__construct();
    }

    public function get_user($userName,$userPassword){
        $sql = "SELECT *, count(*) as num_users 
                FROM tbl_users 
                WHERE name = :name AND password = :password";
   
        $query = $this->conexion->prepare($sql);
        $query->bindParam(':name', $userName);
        $query->bindParam(':password', $userPassword);
   
        if ($query->execute()){
            $user = $query->fetch(PDO::FETCH_LAZY);
            if($user['num_users'] == 1){
                return $user;
            } else {
                return false;
            }
        }else{
            return false;
        }
    } 
}   


?>