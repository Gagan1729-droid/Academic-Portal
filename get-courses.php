<?php include 'includes/header.php';
if(!isset($_SESSION['sessionUser'])){
    header('Location: index.php');
    exit();
}
if($_SESSION['category']!='Student'){
    header('Location: index.php');
    exit();
}
$regno = $_SESSION['sessionUser'];
if($_GET['regno']!=$regno){
    header('Location: get-courses.php?regno='.$regno);
}
?>

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
$table = "academics_".$program."_2020";
$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM $table WHERE regno=$regno"));
$semester = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM admin ORDER BY semester DESC LIMIT 1 "))['semester'];
$json = json_decode($row["marks_$semester"], true);
$i = 0;
foreach($json as $key=>$mark){
    $i++;
    $x = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM courses WHERE id = " . intval($key)));
    $course = $x['course'];
    $credits = $x['credits'];
    echo "<script>" .
            "document.getElementById('course_table').innerHTML += '<tr><td>$i)</td>" .
            "<td id=\"course\">$course</td>" .
            "<td>$credits</td>" .
            "<td>".$x['midsem']."</td><td>".$x['endsem']."</td><td>".$x['ta']."</td></tr>'" .
            "</script>";
}
// $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM admin ORDER BY semester DESC LIMIT 1 "));
// $courses = $arr = preg_split('/\,/', $row["courses_$branch"]);

// $i = 1;
// while($i < sizeof($courses)){
//     $id = $courses[$i-1];
//     $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM courses WHERE id = $id"));
//     $course = $row['course'];
//     $credits = $row['credits'];
//     echo "<script>" .
//             "document.getElementById('course_table').innerHTML += '<tr><td>$i)</td>" .
//             "<td id=\"course\">$course</td>" .
//             "<td>$credits</td>" .
//             "<td>".$row['midsem']."</td><td>".$row['endsem']."</td><td>".$row['ta']."</td></tr>'" .
//             "</script>";
//     $i++;
// }

include 'includes/footer.php' ?>