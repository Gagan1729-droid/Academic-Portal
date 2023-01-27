<?php include 'includes/header.php';
$empno = $_SESSION['sessionUser']; ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<?php
$result = mysqli_query($conn, "SELECT * FROM employee WHERE empno = $empno");
$row = mysqli_fetch_assoc($result);
$sem = $row['semester'];
$courses = [];
if ($row['courses_'.$sem] != NULL) {
    $courses = preg_split('/\,/', $row['courses_'.$sem]);
    $i = 1;
    while ($i < sizeof($courses)) {
        $temp = $courses[$i - 1];
        $temp = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM courses WHERE course = '$temp'"))['id'];
        echo "" .
            "<script>" .
            "document.getElementsByTagName('body')[0].innerHTML +=' " .
            "<fieldset>" .
            "    <legend>".$courses[$i-1]."</legend>" .
            "    <fieldset>" .
            "    <legend>B.Tech</legend>" .
            "    <table id=\"btech_$temp\">" .
            "        <tr>" .
            "            <td>Reg. no</td>" .
            "            <td>Name</td>" .
            "            <td>Mid sem Marks</td>" .
            "            <td>End sem Marks</td>" .
            "            <td>TA marks</td>" .
            "        </tr>" .
            "    </table>" .
            "    <button onclick=\"save_marks(\'btech_$temp\')\">Save</button>" .
            "    </fieldset>" .
            "    <fieldset>" .
            "        <legend>M.Tech</legend>" .
            "        <table id=\"mtech_$temp\"> " .
            "            <tr> " .
            "                <td>Reg. no</td>" .
            "                <td>Name</td>" .
            "                <td>Mid sem Marks</td>" .
            "                <td>End sem Marks</td>" .
            "                <td>TA marks</td>" .
            "            </tr>" .
            "        </table>" .
            "    <button onclick=\"save_marks(\'mtech_$temp\')\">Save</button>" .
            "    </fieldset>" .
            "</fieldset>'" .
            "</script>";
        $i++;
    }
}
?>

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
    input {
        width: 50px;
    }
    button {
        padding: 5px;
        margin-top: 10px;
    }
</style>

<script>
    function save_marks(program_course){
        var midmarks = [], endmarks = [], tamarks = [];
        var classname = "marks_" + program_course+"_mid";
        console.log(classname);
        var arr = document.getElementsByClassName(classname);
        console.log(arr);
        for(var i=0; i< arr.length; i++){
            midmarks.push(arr[i].value);
        }
        var classname = "marks_" + program_course+"_end";
        var arr = document.getElementsByClassName(classname);
        for(var i=0; i< arr.length; i++){
            endmarks.push(arr[i].value);
        }
        var classname = "marks_" + program_course+"_ta";
        var arr = document.getElementsByClassName(classname);
        for(var i=0; i< arr.length; i++){
            tamarks.push(arr[i].value);
        }
        $.ajax({
        type: "POST",
        url: "includes/add-grades-ajax.php",
        data: {
        midmarks: midmarks,
        endmarks: endmarks,
        tamarks: tamarks,
        program_course: program_course
        },
        cache: false,
        success: function(data) {
        alert(data);
        },
        error: function(xhr, status, error) {
        console.error(xhr);
        }
        });
    }    
</script>


<?php

$query = "SELECT * FROM student_btech_2020";
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result)){
    $regno = $row['regno'];
    $name = $row['name'];
    $i = 1;
    while ($i < sizeof($courses)) {
        $temp = mysqli_fetch_assoc(mysqli_query($conn,"SELECT id FROM courses WHERE course = '" . $courses[$i-1]."'"))['id'];
        $col = $sem . "_" . $temp . "_marks";
        $arr = preg_split('/\,/', $row[$col]);
        $mid = '';
        $end = '';
        $ta = '';
        if (sizeof($arr)==3) {
            $mid = $arr[0];
            $end = $arr[1];
            $ta = $arr[2];
        }
        echo "<script>" .
        "document.getElementById('btech_$temp').innerHTML += '<tr><td>$regno</td>" .
        "<td>$name</td>" .
        "<td><input type=\"number\" class=\"marks_btech_".$temp."_mid\" value=\"$mid\"></td>" .
        "<td><input type=\"number\" class=\"marks_btech_".$temp."_end\" value=\"$end\"></td>" .
        "<td><input type=\"number\" class=\"marks_btech_".$temp."_ta\" value=\"$ta\"></td></tr>'" .
        "</script>";
        $i++;
    }       
}

include 'includes/footer.php' ?>