<?php
include 'database.php';
session_start();
$table = 'employee';
$empno = $_SESSION['sessionUser'];
$courses = $_POST['courses'];
$course = $_POST['course'];
$type = $_POST['type'];
$mid = $_POST['mid'];
$end = $_POST['end'];
$ta = $_POST['ta'];

$query = "INSERT INTO courses(`course`,`type`,`midsem`, `endsem`,`ta`) VALUES('$course', '$type', '$mid','$end','$ta')";
$result = mysqli_query($conn, $query);

if($courses != NULL){
    $query = "UPDATE $table SET courses = '$courses' WHERE empno = '$empno'";
    $result = mysqli_query($conn, $query);
}
echo "Saved";
?>