<?php include('../../templates/header.php');?>
<?php include '../../dbConnections/db.php'?> 
<?php include '../../dbConnections/dbUsers.php'?> 

<?php
$connect = new UsersCrud();


if(isset($_POST['btnRegister'])){
    if(!empty($_POST['txtPassword']) && !empty($_POST['txtName']) && !empty($_POST['txtEmail'])){
        
        $email = preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $_POST['txtEmail']) ? $_POST['txtEmail'] : false;

        $name = ctype_alpha(str_replace(' ', '', $_POST['txtName'])) ? $_POST['txtName'] : false;

        $password = preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,}$/', $_POST['txtPassword']) ?$_POST['txtPassword']  : false;

        if($email && $name && $password){
            $connect->createUser($name,$email,$password);
            if($connect){
                header('Location:index.php?message='.'User created successfully');
            }else{ echo 'something went wrong'; }
        }else{
            echo 'Ingresa datos validos';
        }
    }else{
        echo 'Rellena todos los datos';
    }
}
?>

<br>

<div class="card">
    <div class="card-header">
        User data
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="" class="form-label">Name:</label>
              <input type="text" 
                class="form-control" name="txtName" id="" aria-describedby="helpId" placeholder="Write name">
            </div>

            <div class="mb-3">
              <label for="" class="form-label">Password</label>
              <input type="text"
                class="form-control" name="txtPassword" id="" aria-describedby="helpId" placeholder="Write Password ">
            </div>

            <div class="mb-3">
              <label for="" class="form-label">Email</label>
              <input type="email"
                class="form-control" name="txtEmail" id="" aria-describedby="helpId" placeholder="abc@gmail.com">
            </div>

            <button name="btnRegister" type="submit" class="btn btn-success">Register</button>
            <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancel</a>
        </form>    
    </div>
    <div class="card-footer text-muted">
        footer  
    </div>
</div>

<?php include('../../templates/footer.php');?>