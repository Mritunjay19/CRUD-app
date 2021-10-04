<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css" class="stylesheet">
    <title>CRUD App</title>
</head>

<body>

    <!-- NAVBAR + MySQL connection-->
    <?php include '_navbar.php';?>    

    <!-- Check if logged in -->
    <?php
        if(!isset($_SESSION['username']))
            header("location:login.php");
    ?>

    <!-- EDIT MODAL -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action='/crudapp/index.php?update=true' method='POST'>
                            <input type="hidden" name="idEdit" id="idEdit">
                            <div class="mb-3">
                            <h6><label for="headingEdit" class="form-label">Heading</label></h6>
                            <input type="text" class="form-control" id="headingEdit" name='headingEdit'>
                        </div>
                        <div class="mb-3">
                            <h6><label for="descriptionEdit" class="form-label">Description</label></h6>
                            <textarea class="form-control" id="descriptionEdit" rows="3" name='descriptionEdit'></textarea>
                        </div>
                        
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-secondary mx-2" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary mx-2">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- DELETE MODAL -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Do you want to Delete this record?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action='/crudapp/index.php?delete=true' method='POST'>
                        <input type="hidden" name="idDelete" id="idDelete">                        
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-secondary mx-2" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger mx-2">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- php-> mysql insert update delete -->
    <?php
        if($_SERVER['REQUEST_METHOD']=='POST'){
            if(isset($_GET['update'])){
                $hd=$_POST['headingEdit'];
                $desc=$_POST['descriptionEdit'];
                $id=$_POST['idEdit'];
                $query = "UPDATE `crudtable` SET `heading` = '$hd' , `description` = '$desc' WHERE `id` = $id";
                $res=mysqli_query($conn,$query);
                if($res)   echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    Record Updated
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                else echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Database Error
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
            }
            elseif(isset($_GET['delete'])){
                $id=$_POST['idDelete'];
                $query = "delete from crudtable where id= $id";
                $res=mysqli_query($conn,$query);
                if($res)   echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    Record Deleted
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                else echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Database Error
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
            }
            else
            {
                $hd=$_POST['heading'];
                $desc=$_POST['description'];
                $username=$_SESSION['username'];
                $query = "INSERT INTO `crudtable` (`heading`, `description` , `username`) VALUES ('$hd','$desc','$username');";

                $res=mysqli_query($conn,$query);
                if($res)   echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    Record Added
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                else echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Database Error
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
            }
        }       
    ?>


    <div class="container my-3">

        <!-- Record insert form -->
        <form action='/crudapp/index.php' method='POST'>
            <div class="mb-3">
                <h4><label for="heading" class="form-label">Heading</label></h4>
                <input type="text" class="form-control" id="heading" name='heading'>
            </div>
            <div class="mb-3">
                <h4><label for="description" class="form-label">Description</label></h4>
                <textarea class="form-control" id="description" rows="3" name='description'
                    placeholder="Type your text here .."></textarea>

            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <!-- All Records Data Table -->
        <div class='mt-3'>
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Heading</th>
                        <th scope="col">Description</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $username=$_SESSION['username'];
                        $query = "select * from crudtable where username='$username'";
                        $records=mysqli_query($conn,$query);
                        if(!$records)echo '<div class="alert alert-danger" role="alert">
                                                Database error
                                            </div>';
                        else {
                            $srno=0;
                            while($row = mysqli_fetch_assoc($records)){
                                $srno +=1;
                                echo '<tr>
                                        <th scope="row">'.$srno.'</th>
                                        <td>'.$row["heading"].'</td>
                                        <td>'.$row["description"].'</td>
                                        <td><button class="btn-primary btn edit" id='.$row["id"].'>Edit</button> / <button class="btn-primary btn delete" id='.$row["id"].'>Delete</button></td>
                                    </tr>';
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>

    <!-- jquery DataTable -->
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>

    <!-- Javascript to add modals to Edit and Delete buttons -->
    <script>

        // Edit button 
        edits = document.getElementsByClassName("edit");
        Array.from(edits).forEach((element)=>{
            element.addEventListener('click',(e)=>{
                // console.log("edit",e);
                row=e.target.parentNode.parentNode;
                heading=row.getElementsByTagName('td')[0].innerText;
                description=row.getElementsByTagName('td')[1].innerText;
                console.log(heading,description);
                headingEdit.value=heading;
                descriptionEdit.value=description;
                idEdit.value=e.target.id;
                // var myModal = new bootstrap.Modal(document.getElementById('editModal'));
                // myModal.toggle();
                $('#editModal').modal('toggle');
            });
        });

        // Delete button
        deletes = document.getElementsByClassName("delete");
        Array.from(deletes).forEach((element)=>{
            element.addEventListener('click',(e)=>{
                idDelete.value=e.target.id;
                $('#deleteModal').modal('toggle');
            });
        });

    </script>
</body>

</html>