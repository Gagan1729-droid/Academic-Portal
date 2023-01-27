<?php include 'includes/header.php';?>

<style>
    fieldset {
        margin: 20px;
        width: auto;
        display: inline;
    }
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    td {
        padding: 1px 10px 1px 10px;
        text-align: center;
    }
</style>


<?php

$query = "SELECT * FROM admin ORDER BY semester DESC LIMIT 1 ";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$semester = $row['semester'];
$display_results = $row['display_results'];
$flag = 1;

if($display_results == 0 && $semester == 1){
    echo "<script>" .
        "document.getElementsByTagName('body')[0].innerHTML += '<br>Results not yet declared';" .
        "</script>";
    $flag = 0;
} else if ($display_results == 0)
    $semester--;

for ($i = 1; $i <= $semester && $flag==1; $i++){
    addTable($i,$conn);
}

function addTable($semester, $conn){
    echo "<script>" .
    "document.getElementsByTagName('body')[0].innerHTML +='" .
    "<fieldset>" .
    "<legend>Semester-$semester</legend>".
    "<table id=\"sem_$semester\">" .
    "    <tr>" .
    "        <td>Course</td>" .
    "        <td>Credits</td>" .
    "        <td>Grade</td>" .
    "    </tr>" .
    "</table>" .
    "</fieldset>'" .
    "</script>";
    $course = $_SESSION['course'];
    $regno = $_SESSION['sessionUser'];
    $table = "student_" . $course . "_" . substr($regno, 0, 4);
    $query = "SELECT * FROM $table WHERE regno = " . $regno;
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $courses = preg_split('/\,/', $row['courses_' . $semester]);
    $i = 1;
    while ($i < sizeof($courses)) {
        $temp = $courses[$i - 1];
        $column = $semester . "_" . $temp . "_grades";
        $grade = $row[$column];
        $res = mysqli_query($conn, "SELECT * FROM courses WHERE id = " . $temp);
        $row2 = mysqli_fetch_assoc($res);
        $co = $row2['course'];
        $cr = $row2['credits'];
        echo "<script>" .
            "document.getElementById('sem_$semester').innerHTML += '" .
            "<tr>" .
            "<td>$co</td>" .
            "<td>$cr</td>" .
            "<td>$grade</td>" .
            "</tr>'" .
            "</script>";
        $i++;
    }
    

}

include 'includes/footer.php';

?>