<?php include 'includes/header.php' ?>

<div>
<fieldset>
    <legend>Current Courses</legend>
    <table id="course_table">
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
$table = 'courses';
$query = "SELECT * FROM $table";
$result = mysqli_query($conn, $query);
$i = 1;
while($row = mysqli_fetch_assoc($result)){
    $course = $row['course'];
    echo "<script>" .
            "document.getElementById('course_table').innerHTML += '<tr><td>$i)</td>" .
            "<td>$course</td></tr>'" .
            "</script>";
    $i++;
}

include 'includes/footer.php' ?>