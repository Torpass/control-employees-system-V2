<?php include('../../templates/header.php');?>
<?php include '../../dbConnections/db.php'?> 
<?php include '../../dbConnections/dbEmployees.php'?> 
<?php include '../../dbConnections/dbJobs.php'?> 



<?php
$jobs= new JobCrud();
$tbl_jobs= $jobs->jobView(); 

$connect = new EmployeeCrud();
    if(isset($_GET['txtID'])){
        $idEdit = $_GET['txtID'];
        $register = $connect->getEmployeeById($_GET['txtID']);
        $fecha = date("Y-m-d", strtotime($register['startedAt']));

        if(isset($_POST['btnUpdate'])){
          if(!empty($_POST['txtFirstname']) && !empty($_POST['txtLastname']) && !empty($_POST['txtRole']) && !empty($_POST['TxtDateEntry'])){
            //recopilacion de los datos enviados
            $firstName = ctype_alpha(str_replace(' ', '', $_POST['txtFirstname'])) ? $_POST['txtFirstname'] : false;  
            $lastName = ctype_alpha(str_replace(' ', '', $_POST['txtLastname'])) ? $_POST['txtLastname'] : false;  
            $roleID = $_POST['txtRole'];
            $dateEntry =$_POST['TxtDateEntry'];

            if(!empty($_FILES['photo']['name'])) {
              $photo = file_get_contents($_FILES['photo']['tmp_name']);
            } else {
              $photo = $register['photo'];
            }
            if(!empty($_FILES['cv']['name'])) {
              $cv = file_get_contents($_FILES['cv']['tmp_name']);
              $cvName = $_FILES['cv']['name'];
            } else {
              $cv = $register['cv'];
              $cvName = $register['cvName'];
            }

            $connect->updateEmployee($idEdit, $firstName, $lastName, $photo, $cv, $cvName, $roleID, $dateEntry);
            if($connect){
              header('Location:index.php?message='.'Employee updated successfully');
              exit();
            }else {echo 'something went wrong';}
          }else{ echo 'Rellene todos los datos';}
        }
    }

?>

<br>

<div class="card">
    <div class="card-header">
        Employee data
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="" class="form-label">First name:</label>
              <input type="text" value="<?php echo $register['firstName']?>"
                class="form-control" name="txtFirstname" id="" aria-describedby="helpId" placeholder="First name">
            </div>


            <div class="mb-3">
              <label for="" class="form-label">Last name:</label>
              <input type="text" value="<?php echo $register['lastName']?>"
                class="form-control" name="txtLastname" id="" aria-describedby="helpId" placeholder="Last name">
            </div>


            <div class="mb-3">
              <label for="" class="form-label">Photo:</label> <br>
              <img width="300px" height="200px" src="data:image/png;base64,<?php echo base64_encode($register['photo']); ?>" alt="Imagen">
              <input type="file"
                class="form-control" name="photo" id="inputFile" aria-describedby="helpId" placeholder="Photo">
               
            </div>


            <div class="mb-3">
              <label for="" class="form-label">CV(PDF):</label>
              <input type="file" class="form-control" name="cv" id="" placeholder="CV" aria-describedby="fileHelpId" value="<?php echo $register['cvName']?>">
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Role</label>
                <select value="<?php echo $register['idJob']?>" class="form-select form-select-sm" name="txtRole" id="">
                <option value="<?php echo $register['idJob']?>" selected><?php echo $register['job'];?></option>
                    <?php foreach ($tbl_jobs as $jobsRegisters){?>
                      <option value="<?php echo $jobsRegisters['id']?>"><?php echo $jobsRegisters['jobName']?></option>
                    <?php }?>
                </select>
            </div>


            <div class="mb-3">
              <label for="" class="form-label">Date of entry</label>
              <input type="date" class="form-control" name="TxtDateEntry" id="" aria-describedby="emailHelpId" placeholder="date of entry" 
              value="<?php echo $fecha?>"
              format="yyyy/mm/dd">
              
              
            </div>

            <button type="submit" name="btnUpdate" class="btn btn-success">Update</button>
            <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancel</a>
        </form>
    </div>
    <div class="card-footer text-muted">

    </div>
</div>

<?php include('../../templates/footer.php');?>