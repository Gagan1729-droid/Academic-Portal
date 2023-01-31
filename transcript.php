<?php include 'includes/header.php';?>

<style>
    h1 {
        color: black;
        text-align:center;
        font-size: 25px;
    }
    fieldset {
        margin: 20px;
        width: auto;
        display: inline;
    }
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    td,th {
        padding: 3px 20px 3px 20px;
        text-align: center;
    }
    th {
        font-size: 20px;
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
} else if ($display_results == 0) {
    $semester--;
}

$program = $_SESSION['program'];
$regno = $_SESSION['sessionUser'];
$table1 = "academics_" . $program . "_2020";
$table2 = "student_" . $program . "_2020";
$query = "SELECT * FROM $table1 INNER JOIN $table2 ON $table1.regno = $table2.regno";
$details = mysqli_fetch_assoc(mysqli_query($conn, $query));
$branch = $details['branch'];

if($flag == 1){
    $cpi = $details['cpi_'.$semester];
    $status = ($cpi > 4) ? "Passed" : "Fail";
    echo "<script>" .
        "document.getElementsByTagName('body')[0].innerHTML += '<br><h1>CPI: $cpi (From 1 to $semester semester)</h1>" .
        "<h1>Status: $status till $semester semester</h1>'" .
        "</script>";
}

for ($i = 1; $i <= $semester && $flag==1; $i++){
    addTable($i,$conn, $row, $details, $branch);
}

function addTable($semester, $conn, $row, $details, $branch){
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

    $json = json_decode($details["marks_$semester"], true);
    foreach($json as $key=>$mark){
        $grade = getGrade($mark);
        $row2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM courses WHERE id = " . intval($key)));
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
    }
    $spi = $details['spi_'.$semester];
    echo "<script>" .
        "document.getElementById('sem_$semester').innerHTML += '" .
        "<tr>" .
        "<th colspan=\"3\">SPI: $spi</th>" .
        "</tr>'" .
        "</script>";
}

function getGrade($marks){
    $arr = preg_split('/\,/', $marks);
    $mid = intval($arr[0]);
    $end = intval($arr[1]);
    $ta = intval($arr[2]);
    $m = $mid + $end + $ta;
    if($m > 85) 
        return 'A+';
    else if($m>75) return 'A';
    else if($m>60) return 'B';
    else if($m>45) return 'C';
    else if($m>30) return 'D';
    else return 'E';
}

include 'includes/footer.php';

?>