<?php include 'includes/header.php' ?>

<fieldset>
    <legend>Current Courses</legend>
    <table id="course_table">
        <tr>
            <td></td>
            <td></td>
            <td>Credits</td>
            <td>Mid Sem</td>
            <td>End Sem</td>
            <td>TA</td>
        </tr>
    </table>
</fieldset>

<style>
    fieldset {
        margin-top: 50px;
        margin-bottom: 100px;
        margin-left: 30%;
        width: 600px;
        text-align: center;
    }
    td {
        padding: 2px 10px 2px 10px;
        text-align: center
    }
    #course {
        text-align: left;
    }
</style>

<?php
$regno = $_SESSION['sessionUser'];
$program = $_SESSION['program'];
$table = "student_".$program."_2020";
$branch = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM $table WHERE regno=$regno"))['branch'];

$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM admin ORDER BY semester DESC LIMIT 1 "));
$courses = $arr = preg_split('/\,/', $row["courses_$branch"]);

$i = 1;
while($i < sizeof($courses)){
    $id = $courses[$i-1];
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM courses WHERE id = $id"));
    $course = $row['course'];
    $credits = $row['credits'];
    echo "<script>" .
            "document.getElementById('course_table').innerHTML += '<tr><td>$i)</td>" .
            "<td id=\"course\">$course</td>" .
            "<td>$credits</td>" .
            "<td>".$row['midsem']."</td><td>".$row['endsem']."</td><td>".$row['ta']."</td></tr>'" .
            "</script>";
    $i++;
}

include 'includes/footer.php' ?>