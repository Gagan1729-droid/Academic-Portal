<?php 
include 'includes/header.php';
$empno = $_SESSION['sessionUser'];
$_SESSION['conn'] = $conn;
$table = "employee";
$query = "SELECT * FROM $table WHERE empno = " . $empno;
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<div id="lol">
<input id='course' type="text" name="course" placeholder="Enter the course for current semester">
<select id='type' onchange="changetype()">
    <option value="theory">Theory</option>   
    <option value="practical">Practical</option>
</select>
<input id='midsem' type='number' placeholder = "Max Mid Sem Marks">
<input id='endsem' type="number" placeholder = "Max End Sem Marks">
<input id='ta' type="number" placeholder = "Max TA marks">
<button onclick="addcourse()" style="text-align: center">Add</button>
</div>

    <legend>Current Courses</legend>
    <br>
    <table id="course_table">
    <tr>
        <td>Sr no</td>
        <td>Course</td>
        <td>Type</td>
        <td>Max Mid Sem Marks</td>
        <td>Max End Sem Marks</td>
        <td>Max TA Marks</td>
    </tr>
    </table>

<button id='submit' onclick="submit()">Submit</button>

<script>
    function changetype(){
        var type = document.getElementById('type');
        if(type.value == 'practical'){
            document.getElementById('midsem').style.display = 'none';
        } else {
            document.getElementById('midsem').style.display = 'inline';
        }
    }
    var courses='';
    var index = 0;
    function addcourse() {
        var course = document.getElementById('course').value;
        if(course==''){
            alert("Course name cannot be empty");
            return;
        }
        var mid,end,ta;
        if(type.value == 'theory'){
            mid = parseInt(document.getElementById('midsem').value);
            end = parseInt(document.getElementById('endsem').value);
            ta = parseInt(document.getElementById('ta').value);
            if(isNaN(mid)) mid=0;
            if(isNaN(end)) end=0;
            if(isNaN(ta)) ta=0;
            console.log(mid);
            if(mid+end+ta != 100){
                alert("Total should be 100");
                return;
            }
        }
        else {
            end = parseInt(document.getElementById('endsem').value);
            ta = parseInt(document.getElementById('ta').value);
            if(isNaN(end)) end=0;
            if(isNaN(ta)) ta=0;
            console.log(mid);
            if(end+ta != 100){
                alert("Total should be 100");
                return;
            }
        }
        document.getElementById('course_table').innerHTML += '<tr><td>' + ++index + '</td><td>'+course+'</td><td>'
            +type.value+"</td><td>"+mid+"</td><td>"+end+"</td><td>"+ta+"</td></tr>";
        document.getElementById('course').value = '';
        document.getElementById('endsem').value = '';
        document.getElementById('midsem').value = '';
        document.getElementById('ta').value = '';
        courses += course + ',';

        $.ajax({
        type: "POST",
        url: "includes/add-course-ajax.php",
        data: {
        courses: courses,
        course: course,
        type: type.value,
        mid: mid,
        end: end,
        ta: ta        
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


<style>
    #lol {
        display: block;
        list-style: none;
        padding: 10px;
        text-align: center;
        margin-bottom: 10px;
    }
    input,button {
        text-decoration: none;
        color: black;
        font-size: 18px;
        font-family: sans-serif;
        text-align: center;
        padding: 10px 10px 10px 10px;
    }
    input {
        width: 400px;
    }
    #submit {
        margin-top: 20px;
    }
    table, td {
        border: 1px solid black;
        border-collapse: collapse;
        text-align: center;
    }
    td {
        padding 1px 10px 1px 10px;
        text-align: center;
    }
</style>


<?php 

if ($row['courses'] != NULL) {
    $courses = $row['courses'];
    if($courses)
        echo "<script>var courses = '$courses'</script>";
    $courses = preg_split("/\,/", $row['courses']);
    $i = 1;
    while ($courses[$i-1] != NULL && $i != sizeof($courses)) {
        $temp = $courses[$i - 1];
        $result = mysqli_query($conn, "SELECT * FROM courses WHERE course = '" . $temp . "'");
        $row2 = mysqli_fetch_assoc($result);
        $type = $row2['type'];
        $mid = $row2['midsem'];
        $end = $row2['endsem'];
        $ta = $row2['ta'];
        echo "<script>" .
            "var index = $i; " .
            "document.getElementById('course_table').innerHTML += '<tr><td>$i</td><td>$temp</td><td>$type</td><td>$mid</td>" .
            "<td>$end</td><td>$ta</td></tr>';" .
            "</script>";
        $i++;
    }
}
include 'includes/footer.php' ?>