<?php

include('dbcon.php');


    $fid=$_POST['qid'];
    $title=$_POST['title'];
    $start_event=$_POST['start_event'];
    $end_event=$_POST['end_event'];
    $description=$_POST['description'];
    $venue=$_POST['room'];
    $start_date=$_POST['start_date'];
    $start_time=$_POST['start_time'];
    $end_time=$_POST['end_time'];
    $duration=$_POST['duration'];
    $organiser=$_POST['organiser'];
    $response_message=$_POST['response'];
    $role=$_POST['role'];
    $clash_sql="SELECT * FROM `schedule` where `room`=$venue";
    $run_clash_sql=mysqli_query($con,$clash_sql);
    $ok=false;

    while($row=mysqli_fetch_assoc($run_clash_sql)){
        if(($row['start_event']<=$start_event && $row['end_event']>=$start_event) || ($row['start_event']>=$start_event && $row['start_event']<=$end_event)){
            $ok=true;
            break;
        }
    }
    if($ok){
        if($response_message==null){
            $response_message="Clash Found";
        }
        $find_clash_sql='INSERT INTO `chat`(`id`, `title`, `start_event`, `end_event`, `description`, `room`, `date`, `start_time`, `end_time`, `duration`, `organiser`,`receiver`,`sql_query`,`response`,`status`) VALUES ("'.$fid.'","'.$title.'","'.date('Y-m-d H:i:s',strtotime($start_event)).'","'.date('Y-m-d H:i:s',strtotime($end_event)).'","'.$description.'","'.$venue.'","'.date('Y-m-d',strtotime($start_date)).'","'.date('H:i:s',strtotime($start_time)).'","'.date('H:i:s',strtotime($end_time)).'","'.date('H:i:s',strtotime($duration)).'","'.$organiser.'","'.$fid.'","0","'.$response_message.'","1")';
        
        $run_find_clash_sql=mysqli_query($con,$find_clash_sql);
        $delete_sql='DELETE FROM `chat` WHERE (`receiver`="admin" AND `start_event`="'.$start_event.'" AND `end_event`="'.$end_event.'" AND `room`="'.$venue.'" AND `title`="'.$title.'")';
        $run_delete_sql=mysqli_query($con,$delete_sql);
    }
    else{
        $insert_event_sql='INSERT INTO `schedule`(`id`, `title`, `start_event`, `end_event`, `description`, `room`, `date`, `start_time`, `end_time`, `duration`, `organiser`,`role`) VALUES ("'.$fid.'","'.$title.'","'.date('Y-m-d H:i:s',strtotime($start_event)).'","'.date('Y-m-d H:i:s',strtotime($end_event)).'","'.$description.'","'.$venue.'","'.date('Y-m-d',strtotime($start_date)).'","'.date('H:i:s',strtotime($start_time)).'","'.date('H:i:s',strtotime($end_time)).'","'.date('H:i:s',strtotime($duration)).'","'.$organiser.'","'.$role.'")';
    
        
        $run_insert_event_sql=mysqli_query($con,$insert_event_sql);
        if($response_message==null){
            $response_message="N/A";
        }
        $insert_chat_sql='INSERT INTO `chat`(`id`, `title`, `start_event`, `end_event`, `description`, `room`, `date`, `start_time`, `end_time`, `duration`, `organiser`,`receiver`,`sql_query`,`response`,`status`) VALUES ("'.$fid.'","'.$title.'","'.date('Y-m-d H:i:s',strtotime($start_event)).'","'.date('Y-m-d H:i:s',strtotime($end_event)).'","'.$description.'","'.$venue.'","'.date('Y-m-d',strtotime($start_date)).'","'.date('H:i:s',strtotime($start_time)).'","'.date('H:i:s',strtotime($end_time)).'","'.date('H:i:s',strtotime($duration)).'","'.$organiser.'","'.$fid.'","1","'.$response_message.'","1")';
        
        $run_insert_chat_sql=mysqli_query($con,$insert_chat_sql);
        $delete_sql='DELETE FROM `chat` WHERE (`receiver`="admin" AND `start_event`="'.$start_event.'" AND `end_event`="'.$end_event.'" AND `room`="'.$venue.'" AND `title`="'.$title.'")';
        $run_delete_sql=mysqli_query($con,$delete_sql);
    }

?>