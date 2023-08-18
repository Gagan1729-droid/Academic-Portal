<?php include 'includes/header.php';
if(!isset($_SESSION['sessionUser'])){
    header('Location: index.php');
    exit();
}
if($_SESSION['category']!='Employee'){
    header('Location: index.php');
    exit();
}

$empno = $_SESSION['sessionUser'];
if($_GET['empno']!=$empno){
    header('Location: courses.php?empno=' . $empno);
}

?>

<legend style="text-align: center; margin-top: 30px; font-weight: bold;">Current Courses</legend></br>
<table id="course_table">

</table>
<style>
    table{
        border: 1px solid black;
        border-collapse: collapse;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 40px;
    }
    td {
        padding: 2px 10px 2px 10px;
        text-align: center
    }
</style>

<?php
$empno = $_SESSION['sessionUser'];
$table = "employee";
$query = "SELECT * FROM $table WHERE empno = " . $empno;
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$semester = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM admin ORDER BY semester DESC LIMIT 1 "))['semester'];
if ($row['courses_'.$semester] != NULL) {
    echo "<script>" .
        "document.getElementById('course_table').innerHTML += '<tr><td>Sr no</td><td>Course Id</td><td>Course</td>" .
        "<td>Program</td><td>Branch</td><td>type</td><td>Mid Sem Marks</td><td>End Sem Marks</td><td>TA Marks</td><td>Credits</td>" .
        "</tr>'</script>";
    $courses = preg_split('/\,/', $row['courses_'.$semester]);
    $i = 1;
    while ($i < sizeof($courses)) {
        $id = $courses[$i - 1];
        $x = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM courses WHERE id = " . $id));
        $course = $x['course'];
        $program = $x['program'];
        $branch = $x['branch'];
        $midsem = $x['midsem'];
        $endsem = $x['endsem'];
        $ta = $x['ta'];
        $type = $x['type'];
        $credits = $x['credits'];
        echo "<script>" .
            "document.getElementById('course_table').innerHTML += '<tr><td>$i)</td><td>$id</td><td>$course</td>".
            "<td>".ucfirst($program)."</td><td>".strtoupper($branch)."</td><td>".ucfirst($type)."</td><td>$midsem</td>".
            "<td>$endsem</td><td>$ta</td><td>$credits</td></tr>'" .
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