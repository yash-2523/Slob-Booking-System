<?php
    session_start();
    include('dbcon.php');
    if(!isset($_SESSION['id'])){
        header("Location:login.php");
    }
    else{
        $id=$_SESSION['id'];
        $psql="SELECT * FROM `user` where `id`='$id'";
        $prun=mysqli_query($con,$psql);
        $pdata=mysqli_fetch_assoc($prun);
        if(isset($_POST['pbtn'])){
            if(isset($_POST['proimg'])){
                $imgname=$_FILES['proimg']['name'];
   		    	$tempname=$_FILES['proimg']['tmp_name'];
    			move_uploaded_file($tempname,"./images/$imgname");
                $sql ="UPDATE `user` SET `img` = '$imgname' WHERE `id` = '$id'";
                $run=mysqli_query($con,$sql);
            }
            if(isset($_POST['email'])){
                $pemail=$_POST['email'];
                $ps="UPDATE `user` set `email`='$pemail'where `id`='$id'";
                $pr=mysqli_query($con,$ps);
            }
            if(isset($_POST['bio'])){
                $pbio=$_POST['bio'];
                $ps="UPDATE `user` set `bio`='$pbio'where `id`='$id'";
                $pr=mysqli_query($con,$ps);
            }
            header("Location:profile.php");
        }
        if(isset($_POST['pbbtn'])){
            header("Location:index.php");
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
</head>
<body>
    <div class="head"></div>
    <div class="foot"></div>
    <section id="profile">
        <div class="container mt-5 mb-5 shadow">
            <h1 class="title text-center mt-3 mb-5" style="font-size: 2.9rem;">Profile</h1>
            <div class="row offset-1 mt-3">
                <div class="col-md-10">
                <form action="profile.php" id="pform" enctype="multipart/form-data" method="post">
                    <div class="pimg form-group">
                        
                        <img src="./images/<?php echo $pdata['img']; ?>" class="mb-4 text-center" alt="">
                        <div class="mt-3 mb-3 form-group">
                            <label for="pimg">Change profile image : </label>
                            <input type="file" name="proimg" id="pimg">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $pdata['username']; ?>" disabled id="email">
                    </div>
                    <div class="form-group">
                        <label for="enrollment">Enrollment No. :</label>
                        <input type="text-number" class="form-control" name="enrollment" value="<?php echo $pdata['enrollment']; ?>" disabled id="enrollment">
                    </div>
                    <div class="form-group">
                        <label for="email">Email-Id : <i class="fa fa-edit ml-3" style="cursor: pointer;color: black; font-size: 1rem;"></i></label>
                        <input type="email" class="form-control edit" name="email" value="<?php echo $pdata['email']; ?>" disabled id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="bio">Bio : <i class="fa fa-edit ml-3" style="cursor: pointer;color: black; font-size: 1rem;"></i></label>
                        <textarea type="text" class="form-control edit" name="bio" rows="10" disabled id="bio"><?php echo $pdata['bio']; ?></textarea>
                    </div>
                    <button type="submit" name="pbtn" class="btn btn-success">Save Changes</button>
                    <button type="submit" name="pbbtn" class="btn btn-primary">Back</button>
                </form>
                </div>
            </div>
        </div>
    </section>
    <script defer>
        let edit=document.querySelectorAll('.fa-edit');
        let input=document.querySelectorAll('.edit');
        for(let i=0;i<edit.length;i++){
            edit[i].addEventListener('click',()=>{
                input[i].disabled=false;
            })
        }
    </script>    
</body>
</html>