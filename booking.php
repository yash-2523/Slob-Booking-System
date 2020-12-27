<?php

session_start();
include('dbcon.php');
if(!isset($_SESSION['id']) && !isset($_SESSION['aid'])){
    header("Location:login.php");
}

if(isset($_POST['backbtn'])){
    header("location:index.php");
}
else if(isset($_POST['bookbtn'])){
    $start_date=$_POST['date'];
    $end_date=$_POST['edate'];
    $start_time=$_POST['time'];
    $end_time=$_POST['etime'];
    $start_eve=date('Y',strtotime($start_date)).'-'.date('m',strtotime($start_date)).'-'.date('j',strtotime($start_date)).' '.$start_time.':00';
    $end_eve=date('Y',strtotime($end_date)).'-'.date('m',strtotime($end_date)).'-'.date('j',strtotime($end_date)).' '.$end_time.':00';
    $venue=$_POST['venue'];
    $bsql="SELECT * FROM `schedule` where `room`=$venue";
    $rsql=mysqli_query($con,$bsql);
    $ok=false;
    while($row=mysqli_fetch_assoc($rsql)){
        if(($row['start_event']<=$start_eve && $row['end_event']>=$start_eve) || ($row['start_event']>=$start_eve && $row['start_event']<=$end_eve)){
            $ok=true;
            break;
        }
    }
    if($ok){
        echo '<script type="text/javascript">alert("It seems like the room is preoccupied with some other event !")</script>';
    }
    else{
        $title=$_POST['title'];
        $description=$_POST['description'];
        $fid=0;
        $organiser;
        if(isset($_SESSION['id'])){
            $fid=$_SESSION['id'];
            $ts="SELECT * FROM `user` where `id`=$fid";
            $rts=mysqli_query($con,$ts);
            while($row=mysqli_fetch_assoc($rts)){
                $organiser=$row['username'];
                break;
            }
        }
        else{
            $fid=$_SESSION['aid'];
            $organiser="Admin";
        }
        $duration=(date('H',strtotime($end_time))-date('H',strtotime($start_time))).':'.(date('i',strtotime($end_time))-date('i',strtotime($start_time))).':'.'00';
        $fsql='INSERT INTO `schedule`(`id`, `title`, `start_event`, `end_event`, `description`, `room`, `date`, `start_time`, `end_time`, `duration`, `organiser`) VALUES ("'.$fid.'","'.$title.'","'.date('Y-m-d',strtotime($start_date)).' '.date('H:i:s',strtotime($start_time)).'","'.date('Y-m-d',strtotime($end_date)).' '.date('H:i:s',strtotime($end_time)).'","'.$description.'","'.$venue.'","'.date('Y-m-d',strtotime($start_date)).'","'.date('H:i:s',strtotime($start_time)).'","'.date('H:i:s',strtotime($end_time)).'","'.date('H:i:s',strtotime($duration)).'","'.$organiser.'")';
        $frsql='INSERT INTO `chat`(`id`, `title`, `start_event`, `end_event`, `description`, `room`, `date`, `start_time`, `end_time`, `duration`, `organiser`,`receiver`,`status`) VALUES ("'.$fid.'","'.$title.'","'.date('Y-m-d',strtotime($start_date)).' '.date('H:i:s',strtotime($start_time)).'","'.date('Y-m-d',strtotime($end_date)).' '.date('H:i:s',strtotime($end_time)).'","'.$description.'","'.$venue.'","'.date('Y-m-d',strtotime($start_date)).'","'.date('H:i:s',strtotime($start_time)).'","'.date('H:i:s',strtotime($end_time)).'","'.date('H:i:s',strtotime($duration)).'","'.$organiser.'","0","1")';
        
        $rfs=mysqli_query($con,$frsql);
        if($rfs){
            echo '<script type="text/javascript">alert("Your Request has been sent to Admin !")</script>';
        }
        else{
            echo "error";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        #booking{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
        }
        #booking .container{
            background-color: whitesmoke !important;
            border-radius: 20px;
            padding: 1rem 0;
            margin: 1rem 0;
            margin-bottom: 8rem !important;
            z-index: 8;
        }
        .form-group label{
            font-size: 1.5rem !important;
        }
        .form-group{
            display: grid !important;
            grid-template-columns: repeat(2,50%) !important;
            row-gap: 1rem !important;
        }
        .form-group input,.form-group textarea{
            display: flex !important;
            justify-content: left !important;
            align-items: left !important;
        }
        .date::after{
            content: attr(data-before);
            color: red;
            font-size: 0.9rem;
        }
        .btn a{
            text-decoration: none;
            color: whitesmoke;
        }
        .btn{
            font-size: 1.4rem !important;
        }
    </style>
</head>
<body>
<div class="head"></div>
    <div class="foot"></div>
    <section id="booking">
        <div class="container mt-5 mb-5 shadow">
            <h1 class="title text-center mt-3 mb-5" style="font-size: 2.9rem;">Organise Event</h1>
            <div class="row offset-1 mt-3">
                <div class="col-md-10">
                <form action="booking.php" id="pform" class="mb-4" enctype="multipart/form-data" method="post">
                    <div class="form-group">
                        <label for="title">Event Title :</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Enter Title of the Event" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Event Description :</label>
                        <textarea type="text" class="form-control" name="description" rows="10" id="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="date">Start Date :</label>
                        <input type="date" class="form-control date" name="date" id="date" required>
                    </div>
                    <div class="form-group">
                        <label for="edate">End Date :</label>
                        <input type="date" class="form-control date" name="edate" id="edate" disabled required>
                    </div>
                    <div class="form-group">
                        <label for="time">Starts At :</label>
                        <input type="time" min="08:00" max="22:00" id="time" class="form-control time" name="time" disabled required>
                    </div>
                    <div class="form-group">
                        <label for="etime">Ends At :</label>
                        <input type="time" min="08:00" max="22:00" id="etime" class="form-control time" name="etime" disabled required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="venue">Venue :</label>
                        <input type="text" id="venue" class="form-control" name="venue" required>
                    </div>
                    <button type="submit" name="bookbtn" class="btn btn-primary mr-3">Book</button>
                    <button type="button" class="btn btn-success ml-3"><a href="index.php">Back</a></button>
                </form>
                
                </div>
            </div>
        </div>
    </section>

    <script defer>
        let time=document.querySelectorAll('.time');
        time[0].addEventListener('change',()=>{
            
            if(parseInt(time[0].value)<parseInt(time[0].min)){
                time[0].value=time[0].min;
            }
            else if(parseInt(time[0].value)>parseInt(time[0].max)){
                time[0].value=time[0].max;
            }
            time[1].min=time[0].value;
            time[1].disabled=false;
        })
        time[1].addEventListener('change',()=>{
            
            if(parseInt(time[1].value)<parseInt(time[1].min)){
                time[1].value=time[1].min;
            }
            else if(parseInt(time[1].value)>parseInt(time[1].max)){
                time[1].value=time[1].max;
            }
            if(time[0].value!=null){
                if(time[1].value<time[0].value){
                    time[1].value=time[0].value;
                }
            }
            else{
                if(time[1].value<time[0].min){
                    time[1].value=time[0].min;
                }
            }
        })
        let date=document.querySelectorAll('.date');
        let today=new Date();
        let year=today.getFullYear();
        let month=parseInt(today.getMonth()+1);
        if(month!=10 && month!=11 && month!=12){
            month=month.toString();
            month='0'+month;
        }
        month=month.toString();
        let curdate=parseInt(today.getDate());
        if(curdate/10==0){
            curdate=curdate.toString();
            curdate='0'+curdate;
        }
        curdate=curdate.toString();
        date[0].min=year + '-' + month + '-' + curdate;
        date[1].min=year + '-' + month + '-' + curdate;
        for(let i=0;i<2;i++){
            
            date[i].addEventListener('change',()=>{
                let nw_date=new Date(date[i].value);
                if(i==0){
                        let today=new Date(date[0].value);
                        let year=today.getFullYear();
                        let month=parseInt(today.getMonth()+1);
                        if(month!=10 && month!=11 && month!=12){
                            month=month.toString();
                            month='0'+month;
                        }
                        month=month.toString();
                        let curdate=parseInt(today.getDate());
                        if(parseInt(curdate/10)==0){
                            curdate=curdate.toString();
                            curdate='0'+curdate;
                        }
                        curdate=curdate.toString();
                        date[1].min=year + '-' + month + '-' + curdate;
                        console.log(date[1]);
                        date[1].disabled=false;
                }
                else{
                    time[0].disabled=false;
                    time[0].min="08:00";
                    time[1].min="08:00";
                }
            })

        }
    </script>
</body>
</html>