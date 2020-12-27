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
    $delete_sql='DELETE FROM `chat` WHERE (`receiver`="'.$fid.'" AND `start_event`="'.$start_event.'" AND `end_event`="'.$end_event.'" AND `room`="'.$venue.'" AND `title`="'.$title.'")';
    $run_delete_sql=mysqli_query($con,$delete_sql);

?>