<?php
    session_start();
    include('dbcon.php');
    $ans="Login/register";
    $link1="Login";
    $link2="Register";
    $session=0;
    $session_val=-1;
    if(isset($_SESSION['id'])){
        if($_SESSION['id']){
        $session=1;
        $session_val=$_SESSION['id'];
        $id=$_SESSION['id'];
        $ans=$_SESSION['username'];
        $link1="Profile";
        $link2="Logout";
        
        }
    }
    else if(isset($_SESSION['aid'])){
        if($_SESSION['aid']==0){
            $aid=$_SESSION['aid'];
            $session=1;
            $session_val=0;
            $ausername=$_SESSION['ausername'];
            $ans="Admin";
            $link1="Schedule";
            $link2="Logout";
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
        .chat-show{
            position: fixed;
            top: 0%;
            right: 0;
            width: 30%;
            height: 100%;
            background-image: linear-gradient(to right,#a517ba,purple);
            overflow-y: scroll;
            padding: 2rem 0.3rem;
            animation-name: appear;
            animation-duration: 0.5s;
            
            display: none;
            z-index: 500;
        }
        ::-webkit-scrollbar{
            display: none;
        }
        @keyframes appear{
            0%{
                transform: translateX(100%);
            }
            100%{
                transform: translateX(0%);
            }
        }
        @keyframes disappear{
            0%{
                transform: translateX(0%);
            }
            100%{
                transform: translateX(100%);
            }
        }
        .container-fluid{
            position: relative;
            display: flex !important;
            justify-content: space-between;
            align-items: center;
            padding: 0.4rem auto;
        }
        .container-fluid:hover{
            background-color: rgba(0,0,0,0.3);
        }
        .container-fluid i{
            position: absolute;
            top: 0.5%;
            right: 1%;
            font-size: 1rem;
            color: white;
            cursor: pointer;
        }
        .event-info{
            width: 70%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .event-info h4{
            color: whitesmoke;
            cursor: pointer;
        }
        .event-info p
        {
            color: whitesmoke;
            overflow: hidden;
            cursor: pointer;
        }
        .event-info textarea{
            border-radius: 5px;
            padding: 0.3rem;
        }
        .response-btn{
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
        }
        .show_data{
            position: fixed; z-index: 18;width: 60%;top:15%;left:20%;border-radius: 20px;background-color: rgba(0,0,0,0.7);margin: auto;
            color: white;
            padding: 1rem 0;
            z-index: 600;
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
            .chat-show{
                width: 100%;
                height: 100%;
            }
            #nav-bar{
                padding: 0 0 !important;
            }  
        }
    </style>
</head>
<body>
<i class="fa fa-commenting text-success" id="chat" aria-hidden="true" style="font-size: 5rem !important; cursor:pointer; display:none; position:fixed; bottom:2%; right:2%; z-index:50;">
        <div class="total_msg" style="position: absolute; top:-15%; right:0%; width:60%; height:60%; border-radius:50%; background-color:greenyellow; color:white; font-size:1.5rem; font-weight:bold; display:flex; justify-content:center; align-items:center;">0</div>
</i>
    <div class="chat-show">
        <i class="fa fa-close" style="font-size: 1rem; position:absolute; cursor:pointer; top:1%; left: 1%"></i>
        <h1 class="text-center" style="color: whitesmoke;">Messages</h1>
    
    </div>
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
    <section id="nav-bar">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="#" style="font-family: Poppiens; text-decoration:white">Slot Booking System</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <i class="fa fa-bars"></i>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                  <a class="nav-link" href="#banner">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#services">Services</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#about">About Us</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $ans; ?></a>
                    <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?php echo strtolower($link1); ?>.php"><?php echo $link1; ?></a>
                    <a class="dropdown-item" href="<?php echo strtolower($link2); ?>.php"><?php echo $link2; ?></a>
                    </div>
                </li>
              </ul>
            </div>
          </nav>
    </section>
    <section id="banner">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="promo-title mb-5">Organise Your Event</h1>
                    <p class="mb-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <button class="bannerbtn mb-5" type="button"><a href="booking.php">Organise an Event</a></button>
                </div>
                <div class="col-md-6 text-center">
                    <img class="ml-5 mb-5" src="booking_slot_8.png" alt="">
                </div>
            </div>
        </div>
    </section>
    <section id="services">
        <div class="container text-center mt-5 mb-5">
            <h1 class="title mb-5">Our Services</h1>
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="card shadow mb-5">
                        <img src="booking_5.png" alt="">
                        <h4 class="card-title mb=3">Slot Booking</h4>
                        <p class="card-text mb-3" style="color: black; font-size: 1rem"> Book a slot for your event  </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow mb-3">
                        <img src="schedule.png" alt="">
                        <h4 class="card-title mb=3">View Schedule</h4>
                        <p class="card-text mb-3" style="color: black; font-size: 1rem"> View Your Scheduled Event from the calendar </p>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    <section id="about">
        <div class="container mt-5 mb-0">
            <h1 class="title text-center mb-5">About Us</h1>
            <div class="row mt-3 mb-0">
                <div class="col-md-6 text-left">
                    <ul>
                        <li>Beleive in doing bussiness with honesty</li>
                        <li>Beleive in doing bussiness with honesty</li>
                        <li>Beleive in doing bussiness with honesty</li>
                        <li>Beleive in doing bussiness with honesty</li>
                        <li>Beleive in doing bussiness with honesty</li>
                        <li>Beleive in doing bussiness with honesty</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <img src="booking_slot_8.png" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </section>
    <section id="social media">
        <div class="container mt-5 mb-5">
            <h1 class="title text-center mb-5">Find Us On Social Media</h1>
            <div class="social-icons mb-5">
                <i class="fa fa-facebook "></i>
                <i class="fa fa-twitter bg-primary"></i>
                <i class="fa fa-instagram"></i>
                <i class="fa fa-youtube bg-danger"></i>
                <i class="fa fa-google bg-danger"></i>
            </div>
        </div>
    </section>
    <section id="footer">
        <div class="container mt-5 mb-0">
            <div class="row mt-5 ml-0 mr-0">
                <div class="col-md-4 mt-5">
                    <h1>SBS</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>
                <div class="col-md-4 mt-5">
                    <h3><b>Contact Us</b></h3>
                    <p><i class="fa fa-map-marker" style="font-size: 1.5rem; margin-right: 0.8rem;"></i>Lovation</p>
                    <p><i class="fa fa-phone" style="font-size: 1.5rem; margin-right: 0.8rem;"></i>Phone Number</p>
                    <p><i class="fa fa-envelope-o" style="font-size: 1.5rem; margin-right: 0.8rem;"></i>Email-id</p>
                </div>
                <div class="col-md-4 mt-5 join">
                    <h3><b>Join Us</b></h3>
                    <form action="#">
                        <input type="email" placeholder="Your email">
                        <button type="submit">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script defer>
        let chat=document.getElementById('chat');
        if(<?php echo $session ?>){
            if(<?php echo $session_val ?>){
                let dropdown=document.querySelector('.dropdown-menu');
                let element=document.createElement('a');
                let dropdown_item=document.querySelectorAll('.dropdown-item');
                element.href="schedule.php";
                element.innerText="Schedule";
                element.classList.add('dropdown-item');
                console.log(element);
                dropdown.insertBefore(element,dropdown_item[1]);
                
                chat.style.display="block";
            }
            else{
                chat.style.display="block";
            }
        }
        let chat_show=document.querySelector('.chat-show');
        let msgclosebtn=document.querySelectorAll('.fa-close');
        for(let i=0;i<msgclosebtn.length;i++){
            msgclosebtn[i].addEventListener('click',()=>{
            event.target.parentElement.style.display="none";
            });
        }
        chat.addEventListener('click',()=>{
            chat_show.style.display="block";
            
        })
        function notification(title,descript,start_event,end_event,start_time,end_time,dates,room,duration,organiser,qid,sql_query,response,role){
                container_fluid=document.createElement('div');
                container_fluid.classList.add('container-fluid');
                container_fluid.classList.add('pt-3');
                container_fluid.classList.add('pb-3');
                event_info=document.createElement('div');
                event_info.classList.add('event-info');
                event_title=document.createElement('h4');
                event_title.innerText=title;
                event_response=document.createElement('h6');
                event_response.innerText="Response : "+response;
                event_response.style.color="whitesmoke";
                event_info.appendChild(event_title);
                event_info.appendChild(event_response);
                container_fluid.appendChild(event_info);
                response_btn=document.createElement('div');
                response_btn.classList.add('response-btn');
                let ans=document.createElement('h5');
                
                ans.innerText="Rejected"
                if(sql_query=='1'){
                    ans.classList.add('text-success');
                    ans.classList.add('bold');
                    ans.innerText="Accepted"
                }
                else{
                    ans.classList.add('text-danger');
                }
                response_btn.appendChild(ans);
                container_fluid.appendChild(response_btn);
                let delete_icon=document.createElement('i');
                delete_icon.classList.add('fa');
                delete_icon.classList.add('fa-trash');
                container_fluid.appendChild(delete_icon);
                chat_show.appendChild(container_fluid);
                document.querySelector('.total_msg').innerText=chat_show.childElementCount - 2;
                event_title.addEventListener('click',()=>{
                    document.getElementById('showdata').style.display="flex";
                    document.getElementById('title').innerText=title;
                    document.getElementById('descript').innerText=descript;
                    if(parseInt(role)){
                        document.getElementById('organiser').innerText="-By "+organiser+" (Faculty)";
                    }
                    else{
                        document.getElementById('organiser').innerText="-By "+organiser;
                    }
                    document.getElementById('date').innerText=dates;
                    document.getElementById('room').innerText=room;
                    document.getElementById('time').innerText=start_time;
                    document.getElementById('duration').innerText=duration;
                });
                delete_icon.addEventListener('click',()=>{
                    event.target.parentElement.style.animationName="disappear";
                    event.target.parentElement.style.animationDuration="0.5s";
                    setTimeout(chat_show.removeChild(event.target.parentElement),1000);
                    document.querySelector('.total_msg').innerText=chat_show.childElementCount - 2;
                    $.ajax({
                    type: 'post',
                    url: "remove_chat.php",
                    data: {'qid' : qid, 'title': title,'start_event': start_event,'end_event': end_event,'description': descript,'start_date': dates,'start_time': start_time,'end_time': end_time,'room': room,'duration': duration,'organiser': organiser}, 
                    success: function( data ) {
                    console.log(data);
                    }
                    });
                })
        }
        function notify(title,descript,start_event,end_event,start_time,end_time,dates,room,duration,organiser,qid,role){
                container_fluid=document.createElement('div');
                container_fluid.classList.add('container-fluid');
                container_fluid.classList.add('pt-3');
                container_fluid.classList.add('pb-3');
                event_info=document.createElement('div');
                event_info.classList.add('event-info');
                event_title=document.createElement('h4');
                event_title.innerText=title;
                event_description=document.createElement('p');
                event_description.innerText=descript;
                event_message=document.createElement('textarea');
                event_message.type="text";
                event_message.rows="2";
                event_message.placeholder="Message"
                event_info.appendChild(event_title);
                event_info.appendChild(event_description);
                event_info.appendChild(event_message);
                response_btn=document.createElement('div');
                response_btn.classList.add('response-btn');
                response_btn_1=document.createElement('button');
                response_btn_1.type="button";
                response_btn_1.classList.add('btn');
                response_btn_1.classList.add('btn-success');
                response_btn_1.classList.add('mb-2');
                response_btn_1.classList.add('accept');
                response_btn_1.innerText="Accept";
                response_btn_2=document.createElement('button');
                response_btn_2.type="button";
                response_btn_2.classList.add('btn');
                response_btn_2.classList.add('btn-danger');
                response_btn_2.classList.add('mt-1');
                response_btn_2.classList.add('reject');
                response_btn_2.innerText="Reject";
                response_btn.appendChild(response_btn_1);
                response_btn.appendChild(response_btn_2);
                container_fluid.appendChild(event_info);
                container_fluid.appendChild(response_btn);
                
                chat_show.appendChild(container_fluid);
                document.querySelector('.total_msg').innerText=chat_show.childElementCount - 2;
                event_title.addEventListener('click',()=>{
                    document.getElementById('showdata').style.display="flex";
                    document.getElementById('title').innerText=title;
                    document.getElementById('descript').innerText=descript;
                    if(parseInt(role)){
                        document.getElementById('organiser').innerText="-By "+organiser+" (Faculty)";
                    }
                    else{
                        document.getElementById('organiser').innerText="-By "+organiser;
                    }
                    document.getElementById('date').innerText=dates;
                    document.getElementById('room').innerText=room;
                    document.getElementById('time').innerText=start_time;
                    document.getElementById('duration').innerText=duration;
                });
                response_btn_1.addEventListener('click',()=>{
                    event.target.parentElement.parentElement.style.animationName="disappear";
                    event.target.parentElement.parentElement.style.animationDuration="1s";
                    setTimeout(chat_show.removeChild(event.target.parentElement.parentElement),1000);
                    document.querySelector('.total_msg').innerText=chat_show.childElementCount - 2;
                    $.ajax({
                    type: 'post',
                    url: "accept.php",
                    data: {'qid' : qid, 'title': title,'start_event': start_event,'end_event': end_event,'description': descript,'start_date': dates,'start_time': start_time,'end_time': end_time,'room': room,'duration': duration,'organiser': organiser,'response': event_message.value,'role':role
                    }, 
                    success: function( data ) {
                    console.log(data);
                    }
                    });
                })
                response_btn_2.addEventListener('click',()=>{
                    event.target.parentElement.parentElement.style.animationName="disappear";
                    event.target.parentElement.parentElement.style.animationDuration="1s";
                    setTimeout(chat_show.removeChild(event.target.parentElement.parentElement),1000);
                    document.querySelector('.total_msg').innerText=chat_show.childElementCount - 2;
                    $.ajax({
                    type: 'post',
                    url: "reject.php",
                    data: {'qid' : qid, 'title': title,'start_event': start_event,'end_event': end_event,'description': descript,'start_date': dates,'start_time': start_time,'end_time': end_time,'room': room,'duration': duration,'organiser': organiser,'response': event_message.value
                    }, 
                    success: function( data ) {
                    console.log(data);
                    }
                });
                })
            }
    </script>
</body>
</html>
<?php

function execute($session_val,$con){
if($session_val==0){
$csql='SELECT * FROM `chat` where (`receiver`="admin" AND `status`="1")';
$rcsql=mysqli_query($con,$csql);

while($row=mysqli_fetch_assoc($rcsql)){
    $title=$row['title'];
    $description=$row['description'];
    $start_event=$row['start_event'];
    $end_event=$row['end_event'];
    $start_time=$row['start_time'];
    $end_time=$row['end_time'];
    $date=$row['date'];
    $room=$row['room'];
    $duration=$row['duration'];
    $organiser=$row['organiser'];
    $qid=$row['id'];
    $new_sql="SELECT * FROM `user` where `id`=$qid";
    $run_new_sql=mysqli_query($con,$new_sql);
    $data=mysqli_fetch_assoc($run_new_sql);
    $role=$data['role'];
    echo '<script type="text/javascript" defer> notify("'.$title.'","'.$description.'","'.$start_event.'","'.$end_event.'","'.$start_time.'","'.$end_time.'","'.$date.'","'.$room.'","'.$duration.'","'.$organiser.'","'.$qid.'","'.$role.'"); </script>';
    
}
}
else{
    $csql='SELECT * FROM `chat` where (`receiver`="'.$session_val.'" AND `status`="1")';
$rcsql=mysqli_query($con,$csql);
while($row=mysqli_fetch_assoc($rcsql)){
    $title=$row['title'];
    $description=$row['description'];
    $start_event=$row['start_event'];
    $end_event=$row['end_event'];
    $start_time=$row['start_time'];
    $end_time=$row['end_time'];
    $date=$row['date'];
    $room=$row['room'];
    $duration=$row['duration'];
    $organiser=$row['organiser'];
    $qid=$row['id'];
    $sql_query=$row['sql_query'];
    $response=$row['response'];
    $sql="SELECT * FROM `user` where `id`=$qid";
        $run_sql=mysqli_query($con,$sql);
        $data=mysqli_fetch_assoc($run_sql);
        $role=$data['role'];
    echo '<script type="text/javascript" defer> notification("'.$title.'","'.$description.'","'.$start_event.'","'.$end_event.'","'.$start_time.'","'.$end_time.'","'.$date.'","'.$room.'","'.$duration.'","'.$organiser.'","'.$qid.'","'.$sql_query.'","'.$response.'","'.$role.'"); </script>';
    
}
}
}

while(true){
    execute($session_val,$con);
    
break;
}
?>