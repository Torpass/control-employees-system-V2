<?php

class EmployeeCrud extends ConexionSQL{

    public function __construct() {
        parent::__construct();
    }

    public function getEmployees(){
        $sql = "SELECT * ,(SELECT jobName from tbl_jobs WHERE tbl_jobs.id=tbl_employees.idJob limit 1) as job from tbl_employees";
        $query = $this->conexion->prepare($sql);
        if($query->execute()){
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }else {return false;}
    }

    public function getEmployeeById($employeeID){
        $sql = "SELECT * ,(SELECT jobName  from tbl_jobs WHERE tbl_jobs.id=tbl_employees.idJob limit 1) as job from tbl_employees WHERE id = $employeeID";
        $query = $this->conexion->prepare($sql);
        
        if($query->execute()){
            return $query->fetch(PDO::FETCH_LAZY);
        }else { return false; }

    }

    public function createEmployee($firstName, $lastName, $photo, $cv, $cvName,$roleID, $dateEntry){
        $sql = "INSERT INTO tbl_employees (id, firstName, lastName, photo, cv, cvName, idJob, startedAt) VALUES (NULL, :firstName, :lastName, :photo, :cv, :cvName, :idJob, :startedAt)";

        $query=$this->conexion->prepare($sql);
        $query->bindParam(':firstName', $firstName);
        $query->bindParam(':lastName', $lastName);
        $query->bindParam(':photo', $photo, PDO::PARAM_LOB);
        $query->bindParam(':cv', $cv, PDO::PARAM_LOB);
        $query->bindParam(':cvName', $cvName);
        $query->bindParam(':idJob', $roleID);
        $query->bindParam(':startedAt', $dateEntry);

        if($query->execute()){
            return true;
        }else {  
            return false;
        }
    }

    public function deleteEmployee($deleteID){
        $sql = "DELETE FROM tbl_employees WHERE id=$deleteID";
        $query = $this->conexion->prepare($sql);
        if($query->execute()){
            return true;
        }else {return false; }
    }

    public function updateEmployee($idEdit, $firstName, $lastName, $photo, $cv, $cvName,$roleID, $dateEntry ){
        $sql = "UPDATE tbl_employees SET firstName=:firstName, lastName =:lastName, photo=:photo, cv=:cv, cvName=:cvName, idJob=:idJob, startedAt=:startedAt WHERE id = $idEdit";

        $query=$this->conexion->prepare($sql);
        $query->bindParam(':firstName', $firstName);
        $query->bindParam(':lastName', $lastName);
        $query->bindParam(':photo', $photo, PDO::PARAM_LOB);
        $query->bindParam(':cv', $cv, PDO::PARAM_LOB);
        $query->bindParam(':cvName', $cvName);
        $query->bindParam(':idJob', $roleID);
        $query->bindParam(':startedAt', $dateEntry);

        if($query->execute()){
            return true;
        }else {  
            $error = $query->errorInfo();
            return $error[2];
        }
    }

}



?>