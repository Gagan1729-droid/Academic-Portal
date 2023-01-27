<?php
include 'database.php';
session_start();

$course = $_POST['course'];
$marks = $_POST['marks'];

$table = "student_" . $course . "_2020";
$query = "SELECT * FROM $table";
$result = mysqli_query($conn, $query);

foreach($marks as $m){
    $row = mysqli_fetch_assoc($result);
    if($m){
        $grade = getGrade($m);
        $regno = $row['regno'];
        $query = "UPDATE $table SET 1_1_marks = $m, 1_1_grades = '$grade' WHERE regno = $regno";
        mysqli_query($conn, $query);
    }
}

function getGrade($m){
    if($m > 85) 
        return 'A+';
    else if($m>75) return 'A';
    else if($m>60) return 'B';
    else if($m>45) return 'C';
    else if($m>30) return 'D';
    else return 'E';
}

echo "Saved";

?>