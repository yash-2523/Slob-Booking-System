<?php

session_start();
include('dbcon.php');
if(!isset($_SESSION['id']) && !isset($_SESSION['aid'])){
    header("Location:login.php");
}
else{
    if(isset($_SESSION['id'])){
        $sid=$_SESSION['id'];
        $sql="SELECT * FROM `user` where `id`=$sid";
        $run_sql=mysqli_query($con,$sql);
        $data=mysqli_fetch_assoc($run_sql);
    }
    else{
        $sid=$_SESSION['aid'];
    }
}


?>
<!DOCTYPE html>
<html>
 <head>
  <title>SBS</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .show_data{
            position: fixed; z-index: 18;width: 60%;top:15%;left:20%;border-radius: 20px;background-color: rgba(0,0,0,0.7);margin: auto;
            color: white;
            padding: 1rem 0;
            display: none;
        }
        #show-info{
            display: grid;
            grid-template-columns: repeat(2,auto);
            column-gap: 0.5rem;
            row-gap: 0.5rem;
        }
        #show-info label{
            font-size: 1.5rem;
            font-weight: bold;
        }
        #show-info p{
            font-size: 1.3rem;
        }
        @media screen and (max-width: 900px){
            .show_data{
                width: 100%;
                height: 100%;
                top: 0%;
                left: 0%;
                overflow-y: scroll;
                
            }
            ::-webkit-scrollbar {
                display: none;
            }
            #show-info{
                grid-template-columns: repeat(1,auto);
            }  
        }
    </style>
 </head>
 <body>
 <div class="head"></div>
    <div class="foot"></div>
  <section id="schedule">
    <div class="container m-auto" style="background-color: whitesmoke;border-radius: 20px;padding: 1rem 1rem !important;margin-top: 2rem !important;margin-bottom: 8rem !important;z-index: 8">
    <h1 class="title text-center mb-5">Schedule</h1>
    <button type="button" style="position: absolute; top:3%; right: 5%; cursor:pointer;" onclick="window.location='index.php'" class="btn btn-success">Back</button>
    <div id="calendar"></div>
    </div>
  </section>
  <div class="show_data mb-3" id="showdata">
    <i class="fa fa-close" style="font-size: 1.4rem; position:absolute;top:1%;right:2%; cursor:pointer;"></i>
    <div class="conatiner mt-5 ml-3 mr-3">
        <h1 style="font-size: 3.2rem;" id="title">Event-Title</h1>
        <h4 class="ml-4 mb-5" id="organiser" style="font-size: 1.7rem; opacity: 0.6">- By Organiser</h4>
        <div class="container" id="show-info">
            <label>Description : </label>
            <p style="overflow-wrap: normal;" id="descript">jsodxnmslmcpsa,zpx,spoew po ofomeo fmorem ,roemfo meromfoiermiocmem do ,pe,p ,epowfoerm gi ntgntigm0oe,fopem oifjrei ferinfierj fio erjo ifjeroijg iej goij goijregoejrofwpfkwpop</p>
            <label>Date : </label>
            <p id="date">18/06/2020</p>
            <label>Venue : </label>
            <p id="room">205</p>
            <label>Starts At : </label>
            <p id="time">09:40:00 am</p>
            <label>Duration : </label>
            <p id="duration">3 hours</p>
        </div>

    </div>
  </div>
  <script>
   document.querySelector('.fa').addEventListener('click',()=>{
              document.querySelector('.show_data').style.display="none";
   });
   $(document).ready(function() {
    var calendar = $('#calendar').fullCalendar({
     editable:true,
     header:{
      left:'prev,next today',
      center:'title',
      right:'month,agendaWeek,agendaDay'
     },
     events: 'Load.php',
     selectable:true,
     selectHelper:true,
     eventClick:function(event)
     {
        if(<?php echo $sid ?>){
            if(event.id==<?php echo $sid ?>){
                $('#showdata').css('display','block');        
            }
        }
        else{
        $('#showdata').css('display','block');
        }
        $('#title').text(event.title);
        if(parseInt(event.role)==1){
            $('#organiser').text('-By '+event.organiser+' (Faculty)');
        }
        else{
            $('#organiser').text('-By '+event.organiser);
        }
        $('#descript').text(event.description);
        $('#room').text(event.room);
        $('#date').text(event.date);
        $('#time').text(event.start_time);
        $('#duration').text(event.duration + " hour");
     },
 
 
    });
   });
    
   </script>
 </body>

</html>