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
$credits = $_POST['credits'];
$semester = $_POST['semester'];

$query = "INSERT INTO courses(`course`,`type`,`midsem`, `endsem`,`ta`, `credits`) VALUES('$course', '$type', '$mid','$end','$ta', '$credits')";
$result = mysqli_query($conn, $query);

if($courses != NULL){
    $query = "UPDATE $table SET courses_$semester = '$courses' WHERE empno = '$empno'";
    $result = mysqli_query($conn, $query);
}

$id = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id from courses WHERE course = '" . $course ."'"))['id'];

$programs = ['btech', 'mtech', 'mca'];
// Add the columns for marks and grades in students
foreach ($programs as $p) {
    $table = "student_".$p."_2020";
    $col = $semester . "_" . $id . "_marks";
    mysqli_query($conn, "ALTER TABLE $table ADD $col VARCHAR(15)");

    $col = $semester . "_" . $id . "_grades";
    mysqli_query($conn, "ALTER TABLE $table ADD $col VARCHAR(3)");

    // Update courses of all the students
    $result = mysqli_query($conn, "SELECT * FROM $table");
    if ($row = mysqli_fetch_assoc($result)) {
        $courses = $row['courses_' . $semester];
        $courses .= $id . ",";
        mysqli_query($conn, "UPDATE $table SET courses_$semester = '$courses' WHERE 1");
    }
}

echo "Saved";
?>