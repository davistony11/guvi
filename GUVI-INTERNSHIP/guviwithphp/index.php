<?php
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>User Dashboard</title>
</head>
<body>
    <div class="container">
        <h1>Welcome</h1>

        <?php
        if (isset($_POST["submit"])) {
           $age = $_POST["age"];
           $number = $_POST["email"];
           $gender = $_POST["gender"];
    
           $errors = array();
           
  
           if (!filter_var($number, FILTER_VALIDATE_number)) {
            array_push($errors, "number is not valid");
           }
           if (strlen($age)<8) {
            array_push($errors,"age must be at least 8 charactes long");
           }
  
           require_once "database.php";
           $sql = "SELECT * FROM users WHERE number = '$number'";
           $result = mysqli_query($conn, $sql);
           $rowCount = mysqli_num_rows($result);
           if ($rowCount>0) {
            array_push($errors,"number already exists!");
           }
           if (count($errors)>0) {
            foreach ($errors as  $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
           }else{
            
            $sql = "INSERT INTO users (full_name, number, age) VALUES ( ?, ?, ? )";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt,"sss",$fullName, $email, $age);
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>You are registered successfully.</div>";
            }else{
                die("Something went wrong");
            }
           }
          

        }
        ?>
        <form class="form-signin"  method="post" id="form">
                        <div id="error"></div>
<div class="form-group row">
    <label for="inputNumber" class="col-sm-2 col-form-label">Phone Number</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputNumber" name="phone" placeholder="Phone Number">
    </div>
  </div>
<div class="form-group row">
    <label for="inputDate" class="col-sm-2 col-form-label">Date of Birth</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputDate" name="dob" placeholder="yyyy-mm-dd" value="" onblur="getAge();" data-validation="birthdate" data-validation-help="yyyy-mm-dd">
    </div>
  </div>
<div class="form-group row">
    <label for="inputAge" class="col-sm-2 col-form-label">Age</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="inputAge" name="age" placeholder="Age" readonly>
    </div>
  </div>
<div class="form-group row">
    <label for="inputGender" class="col-sm-2 col-form-label">Gender</label>
    <div class="col-sm-10">
      <select class="custom-select mb-2 mr-sm-2 mb-sm-0 form-control" name="gender" id="inputGender" >
                                    <option value="" selected>Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Others">Others</option>
                                </select>
    </div>
  </div>



</form>   
        <a href="logout.php" class="btn btn-primary">update profile</a>
        <a href="logout.php" class="btn btn-warning">Logout</a>
    </div>
</body>
</html>