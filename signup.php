
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <title>Signup</title>
  </head>
  <body>

    <?php include '_navbar.php';?>
    
    <?php
        $signuperror=false;
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $uname=$_POST['username'];
            $password=$_POST['password'];
            $q="select * from users where username='$uname'";
            $res = mysqli_query($conn,$q);
            if(mysqli_num_rows($res)>0){
                $signuperror=true;
            }
            else {
                $username=$_POST['username'];
                $password=$_POST['password'];
                $q="insert into users (`username`,`password`) values('$username','$password')";
                $res = mysqli_query($conn,$q);
                header("location:login.php?signup=true");    
            }
        }
    ?>

    <div class="container mt-3">
        <?php
            if($signuperror)echo '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>ERROR</strong> Username already in use.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ';
        ?>
        
        <h3>Please Signup</h3>
        <form action='/crudapp/signup.php' method="POST">
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
