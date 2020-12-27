<?php
    session_start();
    include('dbcon.php');


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SBS</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">    
</head>
<body>
    <div class="head"></div>
    <div class="foot"></div>
    <section id="login" class="pb-5">
        <div class="container mt-5 mb-5 shadow">
            <h1 class="title text-center">Login</h1>
            <form action="login.php" method="post" class="was-validated">
            <div class="form-group">
                <label for="uname">Username:</label>
                <input type="text" class="form-control" id="uname" placeholder="Enter username" name="uname" required>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd" required>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <button type="submit" name="lbtn" class="btn btn-primary">Login</button>
            </form>
            <h5 class="mt-4"><a href="admin_login.php">Login As Admin</a></h5>
            <h5 class="mt-4"><a href="register.php">Don't Have an Account ?</a></h5>
        </div>
    </section>    
    <?php
        if(isset($_POST['lbtn'])){
            $user=mysqli_real_escape_string($con,$_POST['uname']);
            $pd=mysqli_real_escape_string($con,$_POST['pswd']);
            $lsql="SELECT * FROM `user` where (`username`='$user' AND `password`='$pd')";
            $lrun=mysqli_query($con,$lsql);
            if(mysqli_num_rows($lrun)==1){
                while($row = mysqli_fetch_assoc($lrun)){
                    $_SESSION['id']=$row['id'];
                    $_SESSION['username']=$row['username'];
                }
                header('location: index.php');
            }
            else{
                echo '<script type="text/javascript">alert("Incorrect Username Or Password !");</script>';
            }
        }
    ?>
</body>
</html>