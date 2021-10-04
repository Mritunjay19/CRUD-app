<?php
session_start();
echo '
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/crudapp/index.php">
            <img src="./php.png" alt="" width="50" height="24" class="d-inline-block align-text-top">
            CRUD App
        </a>
        <div class="d-flex">';
if(isset($_SESSION['username']))
            echo '<a href="/crudapp/logout.php"><button class="btn btn-outline-success" >Logout</button></a><a href="/crudapp/delete.php"> <button class="btn btn-outline-danger mx-1" >Delete</button></a>';
elseif(basename($_SERVER['PHP_SELF'])=='signup.php')
            echo '<a href="/crudapp/login.php"><button class="btn btn-outline-success" >login</button></a>';
else        echo '<a href="/crudapp/signup.php"><button class="btn btn-outline-success" >Signup</button></a>';
echo   '</div>
    </div>
</nav>
';


$conn=mysqli_connect('localhost',"root","","crudapp"); 
if(!$conn){
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Database Connection Error
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    exit();
}

?>