<?php

session_start();
if(!isset($_SESSION['id']) && !isset($_SESSION['aid'])){
    header("Location:login.php");
}
else{
    if(isset($_SESSION['id'])){
        $lid=$_SESSION['id'];
    }
    else{
        $lid=$_SESSION['aid'];
    }
}
$connect = new PDO('mysql:host=localhost;dbname=Slot_booking', 'root', '');

$data = array();


$query = "SELECT * FROM schedule ORDER BY start_event";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

foreach($result as $row)
{
 $data[] = array(
  'id'   => $row["id"],
  'title'   => $row["title"],
  'start'   => $row["start_event"],
  'end'   => $row["end_event"],
  'room' => $row["room"],
  'description' => $row["description"],
  'date' => $row["date"],
  'start_time' => $row["start_time"],
  'end_time' => $row["end_time"],
  'duration' => $row["duration"],
  'organiser' => $row["organiser"],
  'role' => $row["role"]
 );
}

echo json_encode($data);

?>