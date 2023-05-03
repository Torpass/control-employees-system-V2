<?php include('../../templates/header.php');?>
<?php include '../../dbConnections/db.php'?> 
<?php include '../../dbConnections/dbJobs.php'?> 


<?php
    $connect = new JobCrud();
    if(isset($_GET['txtID'])){
        $idEdit = $_GET['txtID'];
        $job = $connect->getJobById($idEdit);

        if(isset($_POST['btnUpdate'])){
            if($_POST['txtJobName'] != null){
                $jobNameEdit = $_POST['txtJobName'];
                if($connect->jobEdit($idEdit, $jobNameEdit)){
                    header('Location:index.php?message='.'Job updated successfully');
                }else{
                    echo 'You need to add a valid Job name';
                }
            }
        }
    }
?>

<br/>

<div class="card">
    <div class="card-header">
        Job data
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
              <label for="txtID" class="form-label">ID</label>
              <input type="text" value = "<?php echo $idEdit?>"
                class="form-control" readonly  name="" id="" aria-describedby="helpId" placeholder="ID">
            </div>

            <div class="mb-3">
              <label for="" class="form-label">Job name:</label>
              <input type="text"
                value = "<?php echo $job['jobName']?>"
                class="form-control" name="txtJobName" id="" aria-describedby="helpId" placeholder="Job name">
            </div>

           <button name='btnUpdate' type='submit' class='btn btn-success'>Update</button>

            <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancel</a>

        </form>
    </div>
    <div class="card-footer text-muted">
        Footer
    </div>
</div>
<?php include('../../templates/footer.php');?>