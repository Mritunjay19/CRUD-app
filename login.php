
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
        if(isset($_SESSION['username']))
            header("location:index.php");
    ?>

    <?php
        if(isset($_GET['signup'])){
            echo '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Signup Success</strong> Please Login.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ';
        }
    ?>
    <?php
        if(isset($_GET['delete'])){
            echo '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success</strong> Account Successfully Deleted.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ';
        }
    ?>

    <?php
        $loginerror=false;
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $uname=$_POST['username'];
            $password=$_POST['password'];
            $q="select * from users where username='$uname' and password='$password'";
            $res = mysqli_query($conn,$q);
            if(mysqli_num_rows($res)>0){
                $_SESSION['username']=$uname;
                header("location:index.php");
            }
            else {
                $loginerror=true;
            }
        }
    ?>

    <div class="container mt-3">
        <?php
            if($loginerror)echo '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>ERROR</strong> Wrong Username or Password.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ';
        ?>
        
        <h3>Please Login</h3>
        <form action='/crudapp/login.php' method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name='username' maxlength="20"/>
                <div class="form-text">
                    <span id='emailMessage'></span>
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name='password' maxlength="20"/>
                <div class="form-text">
                    <span id='passwordMessage'></span>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
  </body>
</html>
