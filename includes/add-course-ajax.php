<?php
include 'database.php';
session_start();
$table = 'employee';
$empno = $_SESSION['sessionUser'];
$courses = $_POST['courses'];
$arr = preg_split("/\,/", $courses);
$i=0;
while ($arr[$i]) {
    $course = $arr[$i];
    $i++;
    $query = "INSERT INTO courses(`course`) VALUES('$course')";
    $result = mysqli_query($conn, $query);
}
if($courses != NULL){
    $query = "UPDATE $table SET courses = '$courses' WHERE empno = '$empno'";
    $result = mysqli_query($conn, $query);
}
echo "Saved";
?>