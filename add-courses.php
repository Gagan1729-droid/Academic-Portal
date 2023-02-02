<?php 
include 'includes/header.php';
$empno = $_SESSION['sessionUser'];
$_SESSION['conn'] = $conn;
$table = "employee";
$query = "SELECT * FROM $table WHERE empno = " . $empno;
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$semester = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM admin ORDER BY semester DESC LIMIT 1 "))['semester'];
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<div id="lol">
<input id='course' type="text" name="course" placeholder="Enter the course for current semester">
<select id='type' onchange="changetype()">
    <option value="theory">Theory</option>   
    <option value="practical">Practical</option>
</select>
<select id='branch'>
    <option value="cse">Computer Science and Engineering</option>
    <option value="ece">Electronic and Communication Engineering</option>
    <option value="ee">Electrical Engineering</option>
    <option value="me">Mechanical Engineering</option>
    <option value="ce">Civil Engineering</option>
    <option value="che">Chemical Engineering</option>
    <option value="be">Biotechonology Engineering</option>
    <option value="pie">Production and Industrial Engineering</option>
</select>
<select id='program'>
    <option value="btech">B.Tech</option>
    <option value="mtech">M.Tech</option>
    <option value="mca">MCA</option>
</select>
<!-- <label>Programs: </label>
<label><input style="width:auto;" type="checkbox" id='btech' value="btech"> B.Tech</label>
<label><input style="width:auto" type="checkbox" id='mtech' value="mtech"> M.Tech</label>
<label><input style="width:auto" type="checkbox" id='mca' value="mca"> MCA</label></br></br> -->

<input id='midsem' type='number' placeholder = "Max Mid Sem Marks">
<input id='endsem' type="number" placeholder = "Max End Sem Marks">
<input id='ta' type="number" placeholder = "Max TA marks">
<input id='credits' type="number" placeholder = "Credits">

<button onclick="addcourse()" style="text-align: center">Add</button>
</div>
<div id="summary">
    <legend style="text-align: center; font-weight: bold">Current Courses</legend>
    <br>
    <table id="course_table" style="margin-bottom:30px">
    <tr>
        <td>Sr no</td>
        <td>Course</td>
        <td>Branch</td>
        <td>Program</td>
        <td>Type</td>
        <td>Max Mid Sem Marks</td>
        <td>Max End Sem Marks</td>
        <td>Max TA Marks</td>
        <td>Credits</td>
    </tr>
    </table>
</div>

<script>
    function changetype(){
        var type = document.getElementById('type');
        if(type.value == 'practical'){
            document.getElementById('midsem').style.display = 'none';
        } else {
            document.getElementById('midsem').style.display = 'inline';
        }
    }
    var index = 0;
    function addcourse() {
        var course = document.getElementById('course').value;
        var credits = document.getElementById('credits').value;
        var branch = document.getElementById('branch').value;
        if(course==''){
            alert("Course name cannot be empty");
            return;
        }
        if(credits==''){
            alert("Enter credits too");
            return;
        }
        var program = document.getElementById('program').value;
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
            if(end+ta != 100){
                alert("Total should be 100");
                return;
            }
        }
        
        $.ajax({
        type: "POST",
        url: "includes/add-course-ajax.php",
        data: {
        course: course,
        type: type.value,
        branch: branch,
        program: program,
        mid: (mid) ? mid : 0,
        end: end,
        ta: ta,
        credits: credits,
        semester: <?php echo $semester?>
        },
        cache: false,
        success: function(data) {
        alert(data);
        },
        error: function(xhr, status, error) {
        console.error(xhr);
        }
        });
        document.getElementById('summary').style.display = 'block';

        document.getElementById('course_table').innerHTML += '<tr><td>' + ++index + '</td><td>'+course+'</td><td>'
            +branch+"</td><td>"+program+"</td><td>"+type.value+"</td><td>"+mid+"</td><td>"+end+"</td><td>"+ta+"</td><td>"+credits+"</td></tr>";
        document.getElementById('course').value = '';
        document.getElementById('endsem').value = '';
        document.getElementById('midsem').value = '';
        document.getElementById('ta').value = '';
        document.getElementById('credits').value = '';
    }
</script>


<style>
    #lol {
        display: block;
        list-style: none;
        padding: 10px;
        text-align: center;
        margin-bottom: 30px;
    }
    input,button,label {
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
    #midsem, #endsem, #ta, #credits {
        padding: 5px 5px 5px 5px;
        width: 200px;
    }
    table, td {
        border: 1px solid black;
        border-collapse: collapse;
        text-align: center;
        margin-left: auto;
        margin-right: auto;
    }
    td {
        padding 1px 10px 1px 10px;
        text-align: center;
    }
</style>


<?php 
if ($row['courses_'.$semester] != NULL) {
    $courses = preg_split("/\,/", $row['courses_'.$semester]);
    $i = 1;
    while ($courses[$i-1] != NULL && $i <= sizeof($courses)) {
        $temp = intval($courses[$i - 1]);
        $result = mysqli_query($conn, "SELECT * FROM courses WHERE id = $temp");
        $row2 = mysqli_fetch_assoc($result);
        $course = $row2['course'];
        $branch = $row2['branch'];
        $program = $row2['program'];
        $type = $row2['type'];
        $mid = $row2['midsem'];
        $end = $row2['endsem'];
        $ta = $row2['ta'];
        $credits = $row2['credits'];
        echo "<script>" .
            "var index = $i; " .
            "document.getElementById('course_table').innerHTML += '<tr><td>$i</td><td>$course</td><td>".strtoupper($branch)."</td>" .
            "<td>".ucfirst($program)."</td><td>".ucfirst($type)."</td><td>$mid</td>" .
            "<td>$end</td><td>$ta</td><td>$credits</td></tr>';" .
            "</script>";
        $i++;
    }
}
else {
    echo "<script>".
        "document.getElementById('summary').style.display='none';".
        "</script>";
}
include 'includes/footer.php' ?>