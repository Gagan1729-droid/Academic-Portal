<?php include 'includes/header.php' ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<fieldset>
    <legend>B.Tech</legend>
    <table id="btech">
        <tr>
            <td>Reg. no</td>
            <td id="tdname">Name</td>
            <td>Mid sem Marks</td>
            <td>End sem Marks</td>
            <td>TA marks</td>
        </tr>
    </table>
    <button onclick="save_marks('btech')">Save</button>
</fieldset>

<fieldset>
    <legend>M.Tech</legend>
    <table id="mtech">
    <tr>
            <td>Reg. no</td>
            <td>Name</td>
            <td>Marks</td>
        </tr>
    </table>
</fieldset>

<fieldset>
    <legend>MCA</legend>
    <table id="mca">
    <tr>
            <td>Reg. no</td>
            <td>Name</td>
            <td>Marks</td>
        </tr>
    </table>
</fieldset>

<fieldset>
    <legend>MBA</legend>
    <table id="mba">
    <tr>
            <td>Reg. no</td>
            <td>Name</td>
            <td>Marks</td>
        </tr>
    </table>
</fieldset>

<fieldset>
    <legend>PhD</legend>
    <table id="phd">
    <tr>
            <td>Reg. no</td>
            <td>Name</td>
            <td>Marks</td>
        </tr>
    </table>
</fieldset>

<style>
    fieldset {
        margin: 20px;
        width: 500px;
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
    function save_marks(course){
        var midmarks = [], endmarks = [], tamarks = [];
        var classname = "marks_" + course+"_mid";
        var arr = document.getElementsByClassName(classname);
        for(var i=0; i< arr.length; i++){
            midmarks.push(arr[i].value);
        }
        var classname = "marks_" + course+"_end";
        var arr = document.getElementsByClassName(classname);
        for(var i=0; i< arr.length; i++){
            endmarks.push(arr[i].value);
        }
        var classname = "marks_" + course+"_ta";
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
        course: course
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
    $mark = $row['1_1_marks'];
    $arr = preg_split('/\,/', $mark);
    $mid = '';
    $end = '';
    $ta = '';
    if (sizeof($arr)==3) {
        $mid = $arr[0];
        $end = $arr[1];
        $ta = $arr[2];
    }

    echo "<script>" .
        "document.getElementById('btech').innerHTML += '<tr><td>$regno</td>" .
        "<td>$name</td>" .
        "<td><input type=\"number\" class=\"marks_btech_mid\" value=\"$mid\"></td>" .
        "<td><input type=\"number\" class=\"marks_btech_end\" value=\"$end\"></td>" .
        "<td><input type=\"number\" class=\"marks_btech_ta\" value=\"$ta\"></td></tr>'" .
        "</script>";
}

include 'includes/footer.php' ?>