<?php
    session_start();
    include('dbcon.php');
    if(isset($_POST['rbtn'])){
        $pswd=mysqli_real_escape_string($con,$_POST['pswd']);
        $cpswd=mysqli_real_escape_string($con,$_POST['cpswd']);
        if($pswd==$cpswd){
            $useranme=$_POST['uname'];
            $rsql="SELECT * FROM `user` where `username`='$useranme'";
            $rrun=mysqli_query($con,$rsql);
            if(mysqli_num_rows($rrun)==0){
                $email=$_POST['email'];
                $enrollment=$_POST['enrollment'];
                // $programme=$_POST['programme'];
                $gender=$_POST['gender'];
                $img="$gender.png";
                $role=$_POST['who'];
                $rs="INSERT INTO `user` (`id`, `username`, `email`, `enrollment`, `programme`, `password`, `gender`, `bio`, `img`,`role`) VALUES ('','$useranme','$email','$enrollment','','$pswd','$gender','','$img','$role') ";
                $rr=mysqli_query($con,$rs);
                if($rr){
                    header("Location:login.php");
                }
                else{
                    echo '<script type="text/javascript">alert("Oops ! Some error occured, Please Try Again");</script>';
                }
            }
            else{
                echo '<script type="text/javascript">alert("Username already exists ! Try with differnt Username");</script>';
            }
        }
        else{
            echo '<script type="text/javascript">alert("Password does not match with confirm password");</script>';
        }
    }
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
    <style>
        * form label::after{
            content: ' *';
            color: red;
            font-size: 1rem;
        }
        .container{
            width: 50%;
        }
        @media screen and (max-width: 1300px){
            #register .container{
                justify-content: left;
                width: 100%;
            }
        }
    </style>   
</head>
<body>
    <div class="head"></div>
    <div class="foot"></div>
    <section id="register" class="pb-5">
        <div class="container mt-5 mb-5 shadow">
            <h1 class="title text-center">Register</h1>
            <form action="register.php" method="post" class="form ml-0">
            <div class="form-group">
                <label for="uname">Username:</label>
                <input type="text" class="form-control" id="uname" placeholder="Enter username" name="uname" required>
            </div>
            <div class="form-group">
                <label for="email">Email-Id:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email-id" name="email" required>
            </div>
            <div class="form-group">
                <label for="enrollment">Enrollment No. :</label>
                <input type="text-number" class="form-control" id="enrollment" placeholder="Enter enrollment no." name="enrollment" required>
            </div>
            <div class="form-group" style="display: grid; grid-template-columns:repeat(2,auto); align-items:center; justify-content:space-between;">
            <label>Who you are ?</label>
            <div style="display: grid; grid-template-columns:repeat(2,1rem); align-items:center;">
                <input type="radio" name="who" class="m-0 p-0" value="1" required>Faculty
                <input type="radio" name="who" value="0">Other
            </div>
            </div>
            <div class="form-group" style="display: grid; grid-template-columns:repeat(2,auto); align-items:center;justify-content:space-between;">
            <label>Gender :  </label>
            <div style="display: grid; grid-template-columns:repeat(2,1rem); align-items:center;">
                <input type="radio" name="gender" class="m-0 p-0" value="male" required>Male
                <input type="radio" name="gender" value="female">Female
            </div>
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control pass" id="pwd" placeholder="Enter password" name="pswd" required>
                <div id="validation" style="color: red; font-size:1rem;"></div>
            </div>
            <div class="form-group">
                <label for="cpwd">Confirm Password:</label>
                <input type="password" class="form-control" id="cpwd" placeholder="Enter password" name="cpswd" required>
            </div>
            <button type="submit" name="rbtn" class="btn btn-primary">Register</button>
            </form>
            <h5 class="mt-4 mb-5"><a href="login.php">Already Have An Account ?</a></h5>
        </div>
    </section>
    <script>
        let pass=document.querySelector('.pass');
        pass.addEventListener('change',()=>{
            let str=pass.value;
            if(str.length<8){
                document.getElementById('validation').innerText="Atleast 8 characters required";
                pass.value=null;
            }
            else if(str.search(/[0-9]/)==-1){
                document.getElementById('validation').innerText="Numeric character required";
                pass.value=null;
            }
            else if(str.search(/[a-z]/)==-1){
                document.getElementById('validation').innerText="Lowercase character required";
                pass.value=null;
            }
            else if(str.search(/[A-Z]/)==-1){
                document.getElementById('validation').innerText="Uppercase character required";
                pass.value=null;
            }
            else if(str.search(/[!\@\#\$\%\^\&\*\-\+\_]/)==-1){
                document.getElementById('validation').innerText="Special character required";
                pass.value=null;
            }
            else{
                document.getElementById('validation').innerText="";
            }
        })
    </script>
</body>
</html>