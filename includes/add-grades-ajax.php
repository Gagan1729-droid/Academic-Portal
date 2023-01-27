<?php
include 'database.php';
session_start();

$program_course = $_POST['program_course'];
$midmarks = $_POST['midmarks'];
$endmarks = $_POST['endmarks'];
$tamarks = $_POST['tamarks'];
$arr = preg_split('/\_/', $program_course);
$program = $arr[0];
$course = $arr[1];

$table = "student_" . $program . "_2020";
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
        $sem = $row['semester'];
        $query = "UPDATE $table SET $sem"."_".$course."_marks = '$marks', $sem"."_".$course."_grades = '$grade' WHERE regno = $regno";
        mysqli_query($conn, $query);
    } else {
        $regno = $row['regno'];
        $query = "UPDATE $table SET $sem"."_".$course."_marks = NULL, $sem"."_".$course."_grades = NULL WHERE regno = $regno";
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