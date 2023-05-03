<?php
class UsersCrud extends ConexionSQL{

    public function __construct() {
      parent::__construct();
    }

    public function getUsers(){
      $sql = "SELECT * FROM tbl_users";
      $query = $this->conexion->prepare($sql);
      if ($query->execute()){
        return $query->fetchAll(PDO::FETCH_ASSOC);
      } else {
        return false;
      }
    }

    public function getUserById($userId){
      $sql = "SELECT * FROM tbl_users WHERE id = :id";
        $query = $this->conexion->prepare($sql);
        $query->bindParam(":id", $userId);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);
        return $user;
    }


    public function createUser($userName,$userEmail,$userPassword){
      $sql = "INSERT INTO tbl_users (id, name, password, email) VALUES (NULL, :name, :password, :email)";
      $query = $this->conexion->prepare($sql);
      $query->bindParam(':name', $userName);
      $query->bindParam(':email', $userEmail);
      $query->bindParam(':password', $userPassword);
      if($query->execute()){
        return true;
      }else{
        return false;
      }
    }

    public function deleteUser($deleteId){
      $sql = "DELETE FROM tbl_users WHERE id = $deleteId";
        $query = $this->conexion->prepare($sql);    
        if ($query->execute()) {
            return true;
          } else {
            return false;
          }
    }

    public function updateUser($userId, $userName, $userEmail, $userPassword){
      $sql = "UPDATE tbl_users SET name = :name, email = :email, password = :password WHERE id = $userId";
      $query = $this->conexion->prepare($sql);
      $query->bindParam(':name', $userName);
      $query->bindParam(':email', $userEmail);
      $query->bindParam(':password', $userPassword);
      if($query->execute()){
        return true;
      }else{
        return false;
      }


    }
}

?>