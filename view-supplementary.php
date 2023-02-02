<?php include 'includes/header.php'?>

<h2>Supplementary Students</h2>

<?php

$empno = $_SESSION['sessionUser'];
$table = "employee";
$query = "SELECT * FROM $table WHERE empno = " . $empno;
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$semester = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM admin ORDER BY semester DESC LIMIT 1 "))['semester'];
if ($row['courses_'.$semester] != NULL) {
    $courses = preg_split('/\,/', $row['courses_'.$semester]);
    $i = 1;
    while ($i < sizeof($courses)) {
        $id = intval($courses[$i - 1]);
        $x = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM courses WHERE id = $id"));
        $course = $x['course'];
        $branch = $x['branch'];

        $courseflag = 0;

        $programs = ['btech', 'mtech', 'mca'];
        foreach ($programs as $p) {
            $table1 = "academics_" . $p . "_2020";
            $table2 = "student_" . $p . "_2020";
            $query = "SELECT * FROM $table1 INNER JOIN $table2 ON $table1.regno = $table2.regno AND $table2.branch = '$branch'";
            $result = mysqli_query($conn, $query);
            $programflag = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $regno = $row['regno'];
                $name = $row['name'];
                $supply = $row['supplementary_' . $semester];
                // echo $regno . " " . $name . " " . $supply . "</br>";
                $arr = preg_split("/\,/", $supply);
                foreach ($arr as $a) {
                    if (intval($a) == $id) {
                        if($courseflag==0){
                            $courseflag = 1;
                            addCourseTable($course, $branch, $id);
                        }
                        if($programflag ==0){
                            $programflag = 1;
                            addProgramTable($p, $id);
                        }
                        addStudentTable($p, $id, $regno, $name);
                    }
                }
            }
        }
        $i++;
    }
}

function addCourseTable($course, $branch, $id){
    echo "" .
            "<script>" .
            "document.getElementsByTagName('body')[0].innerHTML +=' " .
            "<fieldset id=\"$id\">" .
            "    <legend>".$course.": ".strtoupper($branch)."</legend>" .
            "</fieldset>'" .
            "</script>";
}

function addProgramTable($p, $id){
    echo "<script>" .
                "document.getElementById('$id').innerHTML += ' " .
                "    <fieldset>" .
                "    <legend>" . strtoupper($p) . "</legend>" .
                "    <table id=\"" . $p . "_$id\">" .
                "        <tr>" .
                "            <td>Reg no</td>" .
                "            <td>Name</td>" .
                "        </tr>" .
                "    </table>" .
                "    </fieldset>' " .
                "</script>";
}

function addStudentTable($p, $id, $regno, $name){
    echo "<script>" .
            "document.getElementById('" . $p . "_$id').innerHTML += '<tr><td class=\"regno_" . $p . "_" . $id . "\">$regno</td>" .
            "<td>$name</td>" .
            "</tr>'</script>";
}

?>

<style>
    fieldset {
        margin: 20px;
        width: auto;
        display: inline;
        vertical-align: top;
    }
    h4 {
        text-align: center;
    }
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    td {
        padding: 1px 5px 1px 5px;
        text-align: center;
    }
</style>

<?php include 'includes/footer.php'?>