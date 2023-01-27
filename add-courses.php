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
<button onclick="addcourse()">Add</button>
</div>

<fieldset>
    <legend>Current Courses</legend>
    <table id="course_table">
    <tr>
        <th colspan="3">Course List: </th>
    </tr>
    </table>
</fieldset>

<button id='submit' onclick="submit()">Submit</button>

<script>
    var courses='';
    var index = 0;
    function addcourse() {
        var course = document.getElementById('course').value;
        document.getElementById('course_table').innerHTML += '<tr><td>' + ++index + '</td><td>'+course+'</td></tr>';
        document.getElementById('course').value = '';
        courses += course + ',';
    }

    function submit(){
        $.ajax({
        type: "POST",
        url: "includes/add-course-ajax.php",
        data: {
        courses: courses
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
        echo "<script>" .
            "var index = $i; " .
            "document.getElementById('course_table').innerHTML += '<tr><td>$i</td><td>$temp</td></tr>';" .
            "</script>";
        $i++;
    }
}
include 'includes/footer.php' ?>