<?php include('../../templates/header.php');?>
<?php include '../../dbConnections/db.php'?> 
<?php include '../../dbConnections/dbJobs.php'?> 


<?php
    $conect = new JobCrud();
    if(isset($_POST['btnRegister'])){
        if($_POST['txtJobName'] != null){
            $jobName = $_POST['txtJobName'];
            if($conect->jobInsert($jobName)){
                header('Location:index.php?message=Job added successfully');
            }
        }else{
            echo 'You need to add a valid Job name';
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
              <label for="" class="form-label">Job name:</label>
              <input type="text"
                class="form-control" name="txtJobName" id="" aria-describedby="helpId" placeholder="Job name">
            </div>

            <button name="btnRegister" type="submit" class="btn btn-success">Register</button>

            <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancel</a>

        </form>
    </div>
    <div class="card-footer text-muted">
        Footer
    </div>
</div>

<?php include('../../templates/footer.php');?>