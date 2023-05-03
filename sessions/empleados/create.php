<?php include('../../templates/header.php');?>
<?php include '../../dbConnections/db.php'?> 
<?php include '../../dbConnections/dbEmployees.php'?> 
<?php include '../../dbConnections/dbJobs.php'?> 


<?php
$jobs= new JobCrud();
$tbl_jobs= $jobs->jobView(); 
$connect = new EmployeeCrud();

if(isset($_POST['btnRegister'])){
  if(!empty($_POST['txtFirstname']) && !empty($_POST['txtLastname']) && !empty($_POST['txtRole']) && !empty($_POST['TxtDateEntry'])){
    if(!empty($_FILES['photo']['name']) && !empty($_FILES['cv']['name'])){

      //recepción de datos con validaciones numericas y en español
      $firstName = preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/', $_POST['txtFirstname']) ? $_POST['txtFirstname'] : false;

      $lastName = preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/', $_POST['txtLastname']) ? $_POST['txtLastname'] : false;

      $roleID = $_POST['txtRole'];
      $dateEntry =$_POST['TxtDateEntry'];
      $photo = file_get_contents($_FILES['photo']['tmp_name']);
      $cv = file_get_contents($_FILES['cv']['tmp_name']);
      $cvName = $_FILES['cv']['name'];


      //Preparando query para inserción de datos
      if($firstName && $lastName){
        $connect->createEmployee($firstName, $lastName,$photo, $cv, $cvName, $roleID, $dateEntry);
          if($connect){
            header('Location:index.php?message='.'Employee added successfully');
          }else{
              echo 'something went wrong with connection';
          }
      }else{
        echo 'Something went wrong with the data';
      }
    }else{
      echo 'Te faltan los archivos';
    }
  }else{
    echo 'Te faltan datos';
  }
}
?>

  <br>

<div class="card">
    <div class="card-header">
        Employee data
    </div>
    <div class="card-body">
        <form action="create.php" method="post" enctype="multipart/form-data">

            <div class="mb-3">
              <label for="" class="form-label">First name:</label>
              <input type="text" 
                class="form-control" name="txtFirstname" id="" aria-describedby="helpId" placeholder="First name">
            </div>


            <div class="mb-3">
              <label for="" class="form-label">Last name:</label>
              <input type="text"
                class="form-control" name="txtLastname" id="" aria-describedby="helpId" placeholder="Last name">
            </div>


            <div class="mb-3">
              <label for="" class="form-label">Photo:</label>
              <input type="file"
                class="form-control" name="photo" id="" aria-describedby="helpId" placeholder="Photo">
            </div>


            <div class="mb-3">
              <label for="" class="form-label">CV(PDF):</label>
              <input type="file" class="form-control" name="cv" id="" placeholder="CV" aria-describedby="fileHelpId">
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Role</label>
                <select class="form-select form-select-sm" name="txtRole" id="">
                    <option disabled selected>Select a job</option>
                    <?php foreach ($tbl_jobs as $register){?>
                      <option placeholder="Enter job" value="<?php echo $register['id']?>"><?php echo $register['jobName']?></option>
                    <?php }?>
                </select>
            </div>


            <div class="mb-3">
              <label for="" class="form-label">Date of entry</label>
              <input type="date" class="form-control" name="TxtDateEntry" id="" aria-describedby="emailHelpId" placeholder="date of entry">
            </div>

            <button type="submit" name="btnRegister" class="btn btn-success">Register</button>
            <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancel</a>
        </form>
    </div>
    <div class="card-footer text-muted">

    </div>
</div>

<?php include('../../templates/footer.php');?>