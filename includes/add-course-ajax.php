<?php

include 'database.php';
session_start();
$table = 'employee';
$empno = $_SESSION['sessionUser'];
$course = $_POST['course'];
$type = $_POST['type'];
$branch = $_POST['branch'];
$program = $_POST['program'];
$mid = $_POST['mid'];
$end = $_POST['end'];
$ta = $_POST['ta'];
$credits = $_POST['credits'];
$semester = $_POST['semester'];

// Insert the new course in courses table
$query = "INSERT INTO courses(`course`,`branch`,`program`,`type`,`midsem`, `endsem`,`ta`, `credits`) VALUES('$course','$branch', '$program', '$type', '$mid','$end','$ta', '$credits')";
$result = mysqli_query($conn, $query);

// Get the id generated for the new course inserted 
$id = mysqli_insert_id($conn);

// Update the courses for the faculty
$courses = mysqli_fetch_assoc(mysqli_query($conn, "SELECT courses_".$semester." FROM employee WHERE empno = '$empno'"))["courses_$semester"];
$courses .= $id . ",";
mysqli_query($conn, "UPDATE $table SET courses_$semester = '$courses' WHERE empno = '$empno'");

// Add the columns for marks in students academics table
$table1 = "academics_".$program."_2020";
$table2 = "student_".$program."_2020";
$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM $table1 INNER JOIN $table2 ON $table1.regno = $table2.regno AND $table2.branch = '$branch'"));
if ($row) {
    $marks = json_decode($row['marks_' . $semester], true);
    $marks[$id] = null;
    $marks = json_encode($marks);
    $query = "UPDATE $table1 SET marks_$semester = '$marks' WHERE regno IN (SELECT t.regno FROM $table2 t WHERE t.branch = '$branch')";
    mysqli_query($conn, $query);
}


// Update the courses in respective branch in admin table
// $x = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM admin WHERE semester = $semester"));
// $courses = '';
// if (!array_key_exists("courses_" . $program . "_$branch", $x))
//     mysqli_query($conn, "ALTER TABLE admin ADD `courses_".$program."_$branch` VARCHAR(100)");
// else
//     $courses = $x["courses_" . $program . "_$branch"];
// $courses .= $id . ",";
// $query = "UPDATE admin SET courses_".$program."_$branch = '$courses' WHERE semester = $semester";
// mysqli_query($conn, $query);
    
echo "Saved";
?>