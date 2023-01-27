<?php include 'includes/header.php';?>

<div>
<fieldset>
    <legend>Current Courses</legend>
    <table id="course_table">
    <tr>
        <th colspan="3">Course List: </th>
    </tr>
    <!-- <tr>
        <td>1</td>
        <td>CS</td>
    </tr> -->
    </table>
</fieldset>
</div>
<style>
    div {
        width: 500px;
        text-align: center;
    }
</style>

<?php
$empno = $_SESSION['sessionUser'];
$table = "employee";
$query = "SELECT * FROM $table WHERE empno = " . $empno;
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$semester = $row['semester'];
if ($row['courses_'.$semester] != NULL) {
    $courses = preg_split('/\,/', $row['courses_'.$semester]);
    $i = 1;
    while ($i < sizeof($courses)) {
        $temp = $courses[$i - 1];
        echo "<script>" .
            "document.getElementById('course_table').innerHTML += '<tr><td>$i)</td><td>$temp</td></tr>'" .
            "</script>";
        $i++;
    }
}
else {
    echo "<script>" .
            "document.getElementById('course_table').innerHTML += '<tr><td>No courses added</td></tr>'" .
            "</script>";
}


include 'includes/footer.php' ;?>