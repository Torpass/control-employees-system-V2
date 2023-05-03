<?php
require_once('db.php');

class JobCrud extends ConexionSQL{

    public function __construct() {
      parent::__construct();
    }

    public function jobView(){
        $sql = "SELECT * FROM tbl_jobs";
        $query = $this->conexion->prepare($sql);
        $query->execute();
        if (!$query) {
            die('Error en la consulta: ' . $this->conexion->errorInfo());
        }
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function jobInsert($jobName) {
        $sql = "INSERT INTO tbl_jobs (jobName) VALUES (:jobName)";
        $query = $this->conexion->prepare($sql);    
        $query->bindParam(':jobName', $jobName);
        if ($query->execute()) {
          return true;
        } else {
          return false;
        }
    }

    public function jobEdit($editId, $jobNameEdit) {
        $sql = "UPDATE tbl_jobs SET jobName = :jobName WHERE id= '$editId'";
        $query = $this->conexion->prepare($sql);
        $query->bindParam(':jobName', $jobNameEdit);
        if ($query->execute()) {
            return true;
          } else {
            return false;
          }
    }

    public function jobDelete($deleteId){
        $sql = "DELETE FROM tbl_jobs WHERE id = $deleteId";
        $query = $this->conexion->prepare($sql);    
        if ($query->execute()) {
            return true;
          } else {
            return false;
          }
    }
    public function getJobById($idEdit) {
        $sql = "SELECT * FROM tbl_jobs WHERE id = :id";
        $query = $this->conexion->prepare($sql);
        $query->bindParam(":id", $idEdit);
        $query->execute();
        $job = $query->fetch(PDO::FETCH_ASSOC);
        return $job;
    }
}

?>