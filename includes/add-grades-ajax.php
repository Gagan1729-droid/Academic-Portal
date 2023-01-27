<?php
include 'database.php';
session_start();

$course = $_POST['course'];
$midmarks = $_POST['midmarks'];
$endmarks = $_POST['endmarks'];
$tamarks = $_POST['tamarks'];

$table = "student_" . $course . "_2020";
$query = "SELECT * FROM $table";
$result = mysqli_query($conn, $query);

for ($i=0; $i<sizeof($endmarks); $i++){
    $row = mysqli_fetch_assoc($result);
    $x = floatval($midmarks[$i]);
    $m = floatval($midmarks[$i]) + floatval($endmarks[$i]) + floatval($tamarks[$i]);
    $marks = $midmarks[$i] . "," . $endmarks[$i] . "," . $tamarks[$i];
    if($m){
        $grade = getGrade($m);
        $regno = $row['regno'];
        $query = "UPDATE $table SET 1_1_marks = '$marks', 1_1_grades = '$grade' WHERE regno = $regno";
        mysqli_query($conn, $query);
    } else {
        $regno = $row['regno'];
        $query = "UPDATE $table SET 1_1_marks = NULL, 1_1_grades = NULL WHERE regno = $regno";
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