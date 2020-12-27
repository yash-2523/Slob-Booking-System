<?php 

include('dbcon.php');


    $fid=mysqli_real_escape_string($con,$_POST['qid']);
    $title=mysqli_real_escape_string($con,$_POST['title']);
    $start_event=mysqli_real_escape_string($con,$_POST['start_event']);
    $end_event=mysqli_real_escape_string($con,$_POST['end_event']);
    $description=mysqli_real_escape_string($con,$_POST['description']);
    $venue=mysqli_real_escape_string($con,$_POST['room']);
    $start_date=mysqli_real_escape_string($con,$_POST['start_date']);
    $start_time=mysqli_real_escape_string($con,$_POST['start_time']);
    $end_time=mysqli_real_escape_string($con,$_POST['end_time']);
    $duration=mysqli_real_escape_string($con,$_POST['duration']);
    $organiser=mysqli_real_escape_string($con,$_POST['organiser']);
    $response_message=mysqli_real_escape_string($con,$_POST['response']);
    if($response_message==null){
        $response_message="N/A";
    }
    $insert_chat_sql='INSERT INTO `chat`(`id`, `title`, `start_event`, `end_event`, `description`, `room`, `date`, `start_time`, `end_time`, `duration`, `organiser`,`receiver`,`sql_query`,`response`,`status`) VALUES ("'.$fid.'","'.$title.'","'.date('Y-m-d H:i:s',strtotime($start_event)).'","'.date('Y-m-d H:i:s',strtotime($end_event)).'","'.$description.'","'.$venue.'","'.date('Y-m-d',strtotime($start_date)).'","'.date('H:i:s',strtotime($start_time)).'","'.date('H:i:s',strtotime($end_time)).'","'.date('H:i:s',strtotime($duration)).'","'.$organiser.'","'.$fid.'","0","'.$response_message.'","1")';
    
    $run_insert_chat_sql=mysqli_query($con,$insert_chat_sql);
    $delete_sql='DELETE FROM `chat` WHERE (`receiver`="admin" AND `start_event`="'.$start_event.'" AND `end_event`="'.$end_event.'" AND `room`="'.$venue.'" AND `title`="'.$title.'")';
    $run_delete_sql=mysqli_query($con,$delete_sql);

?>