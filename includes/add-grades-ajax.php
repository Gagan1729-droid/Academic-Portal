<?php
include 'database.php';
session_start();

$program_course = $_POST['program_course'];
$endmarks = $_POST['endmarks'];
$tamarks = $_POST['tamarks'];
$regno = $_POST['regno'];
$arr = preg_split('/\_/', $program_course);
$program = $arr[0];
$course = $arr[1];

$result = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM courses WHERE id = $course"));
if ($result['type'] == 'theory')
    $midmarks = $_POST['midmarks'];

$sem = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM admin ORDER BY semester DESC LIMIT 1 "))['semester'];

$table = "academics_" . $program . "_2020";

for ($i=0; $i<sizeof($endmarks); $i++){
    if ($result['type'] == "theory")
        $mid = floatval($midmarks[$i]);
    else
        $mid = 0;
    $end = floatval($endmarks[$i]);
    $ta = floatval($tamarks[$i]);
    if($mid > $result['midsem'] || $end > $result['endsem'] || $ta > $result['ta']){
        echo "Marks entered are more than the maximum marks! Recheck please";
        exit();
    }
    $m = $mid + $end + $ta;
    $marks = ($result['type'] == "theory") ? $midmarks[$i] : ''; 
    $marks = "," . $endmarks[$i] . "," . $tamarks[$i];
    $reg = $regno[$i];
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM $table WHERE regno = $reg"));
    $json = json_decode($row["marks_$sem"], true);
    
    if($m){
        $json[strval($course)] = $marks;
    } else {
        $json[strval($course)] = NULL;;
    }
    $marks = json_encode($json);
    $query = "UPDATE $table SET marks_$sem = '$marks' WHERE regno = $reg";
    mysqli_query($conn, $query);
}

echo "Saved";

?>