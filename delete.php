
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <title>Login</title>
  </head>
  <body>

    <?php include '_navbar.php';?>
    
    <?php
        if(!isset($_SESSION['username']))
            header("location:login.php");
    ?>

    <?php
        $deleteerror=false;
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $username=$_SESSION['username'];
            $password=$_POST['password'];
            $q="select * from users where username='$username' and password='$password'";
            $res = mysqli_query($conn,$q);
            if(mysqli_num_rows($res)>0){
                mysqli_query($conn,"delete from users where username='$username'");
                mysqli_query($conn,"delete from crudtable where username='$username'");
                session_unset();
                session_destroy();
                header("location:login.php?delete=true");
            }
            else {
                $deleteerror=true;
            }
        }
    ?>

    <div class="container mt-3">
        <?php
            if($deleteerror)echo '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>ERROR</strong> Wrong Password.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ';
        ?>
        
        <h3>Please Enter Password to confirm Accout Deletion</h3>
        <form action='/crudapp/delete.php' method="POST">
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name='password'/>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
  </body>
</html>
