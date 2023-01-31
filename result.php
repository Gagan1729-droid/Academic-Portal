<?php include 'includes/header.php';

if(!isset($_SESSION['loggedIn'])){
    header("Location: index.php");
    exit();
} ?>


<h2>Result</h2>
<hr>

<div id="student-info">
    <div class = "panel">
        <span>
            <span id="topic">Registeration no: </span>
            <span id="regno"></span>
        </span>
        <span style="float:right">
            <span id="topic">Program: </span>
            <span id="program"></span>
        </span>
        </br>
        <span>
            <span id="topic">Name: </span>
            <span id="name"></span>
        </span>
        <span style="float:right">
            <span id="topic">Branch: </span>
            <span id="branch"></span>
        </span>
        </br>
        <span>
            <span id="topic">Semester: </span>
            <span id="semester"></span>
        </span>
        <span style="float: right; color: green">
            <span id="spi">SPI: </span>
            <span id="cpi">CPI: </span>
        </span>
    </div>

</div>


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
}

if($flag == 1){
    $program = $_SESSION['program'];
    $regno = $_SESSION['sessionUser'];
    $table1 = "academics_" . $program . "_2020";
    $table2 = "student_" . $program . "_2020";
    $query = "SELECT * FROM $table1 INNER JOIN $table2 ON $table1.regno = $table2.regno";
    $details = mysqli_fetch_assoc(mysqli_query($conn, $query));
    $branch = $details['branch'];
    $name = $details['name'];
    $spi = $details['spi_'.$semester];
    $cpi = $details['cpi_'.$semester];

    echo "<script>" .
    "document.getElementById('regno').innerHTML += '$regno';" .
    "document.getElementById('name').innerHTML += '$name';" .
    "document.getElementById('program').innerHTML += '".strtoupper($program)."';" .
    "document.getElementById('branch').innerHTML += '".strtoupper($branch)."';" .
    "document.getElementById('semester').innerHTML += '$semester';" .
    "document.getElementById('spi').innerHTML += '$spi';" .
    "document.getElementById('cpi').innerHTML += '$cpi';" .
    "document.getElementsByTagName('body')[0].innerHTML +='" .
    "<table id=\"sem_$semester\">" .
    "    <tr style=\"font-weight:bold;\">" .
    "        <td>Course code</td>" .
    "        <td>Course</td>" .
    "        <td>Credits</td>" .
    "        <td>Grade</td>" .
    "    </tr>" .
    "</table>'" .
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
            "<td>$key</td>" .
            "<td>$co</td>" .
            "<td>$cr</td>" .
            "<td>$grade</td>" .
            "</tr>'" .
            "</script>";
    }
    
    // echo "<script>" .
    //     "document.getElementById('sem_$semester').innerHTML += '" .
    //     "<tr>" .
    //     "<th colspan=\"4\">SPI: $spi</th>" .
    //     "</tr>'" .
    //     "</script>";
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

include 'includes/footer.php'?>

<style>
    #student-info {
        display: block;
        box-sizing: border-box;
        margin: 30px 30px 0 30px;
    }
    .panel {
        border: 1px solid transparent;
        border-radius: 4px;
        border-color: #ddd;
        box-shadow: 0 1px 1px rgb(0 0 0 / 5%);
        padding: 15px;
    }
    span {
        font-size: 14px;
        line-height: 1.42857143;
    }
    #topic {        
        font-weight: bold;
        color: #b22d00;
    }
    h1 {
        color: black;
        text-align:center;
    }
    hr{
        width: 4vw;
        margin-top: 1vw;
    }
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        margin-left: auto;
        margin-right: auto;
    }
    table {
        display: table;
        margin-top: 100px;
        margin-bottom: 100px;
        box-shadow: 10px 10px 5px #888888;
        transition: 0.5s;
    }
    table:hover {
        box-shadow: 0 0 0;
        transition: 0.5s;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    td,th {
        padding: 3px 20px 3px 20px;
        text-align: center;
    }
    th {
        font-size: 20px;
    }
</style>