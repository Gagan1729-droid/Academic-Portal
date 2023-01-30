<?php include 'includes/header.php';?>

<h2 style="color: black">Professors along with the students whose marks have yet not been entered</h2>

<?php
$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM admin ORDER BY semester DESC LIMIT 1"));
$semester = $row['semester'];

$result = mysqli_query($conn, "SELECT * FROM employee");
while($emp = mysqli_fetch_assoc($result)){
    $courses = $emp["courses_$semester"];
    $arr = preg_split('/\,/', $courses);
    $facflag = 0;
    foreach($arr as $c){
        if ($c == '')
            break;
        // echo "</br>$c ";
        $courseid = intval($c);
        $course_details = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM courses WHERE id = $courseid"));
        $branch = $course_details['branch'];
        $courseflag=0;
        $programs = ['btech', 'mtech', 'mca'];
        foreach($programs as $p){
            // echo "</br>$p";
            $table1 = "academics_" . $p . "_2020";
            $table2 = "student_" . $p . "_2020";
            $programflag=0;
            $students =  mysqli_query($conn, "SELECT * FROM $table1 INNER JOIN $table2 ON $table1.regno = $table2.regno AND $table2.branch = '$branch'");
            while($student = mysqli_fetch_assoc($students)){
                $regno = $student['regno'];
                // echo "</br>$regno ";
                $json = json_decode($student["marks_$semester"], true);
                foreach ($json as $key => $mark) {
                    if (intval($key) != $courseid)
                        continue;
                    $type = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM courses WHERE id = " . intval($key)));
                    $status = getStatus($mark, $type);
                    // echo "$status</br>";
                    if($status == 0){
                        if($facflag==0){
                            $facflag = 1;
                            addTableFaculty($emp['empno'], $emp['name']);
                        }
                        if($courseflag==0){
                            $courseflag = 1;
                            addTableCourse($emp['empno'],$courseid, $course_details['course'], $branch);
                        }
                        if($programflag ==0){
                            $programflag=1;
                            addTableProgram($emp['empno'], $courseid, $p);
                        }
                        addTablestudent($emp['empno'], $courseid,$p, $regno, $student['name']);
                    }
                }
            }
        }
    }
}

function addTableFaculty($id, $name){
    echo "<script>" .
        "document.getElementsByTagName('body')[0].innerHTML += '" .
        "<fieldset id = \"faculty_$id\">" .
        "<legend>$name</legend>" .
        "</fieldset>';" .
        "</script>";
}

function addTableCourse($empno, $courseid, $coursename, $branch){
    echo "<script>" . 
        "document.getElementById('faculty_$empno').innerHTML += '" .
        "<fieldset id = \"$empno"."_$courseid\">".
        "<legend>$coursename-".strtoupper($branch)."</legend>".
        "</fieldset>';".
        "</script>";
}

function addTableProgram($empno, $courseid, $p){
    echo "<script>".
        "document.getElementById('$empno"."_$courseid').innerHTML += '".
        "<table id=\"$empno"."_$courseid"."_$p\">".
        "<tr>" .
        "<td colspan=\"2\">".strtoupper($p)."</td>".
        "</tr>".
        "</table>';".
        "</script>";
}

function addTablestudent($empno, $courseid, $p, $regno, $stname){
    echo "<script>" .
        "document.getElementById('$empno" . "_$courseid" . "_$p').innerHTML += '" .
        "<tr class=\"name\">" .
        "<td>$regno</td>" .
        "<td>$stname</td>" .
        "</tr>';" .
        "</script>";
}




// $programs = ['btech', 'mtech', 'mca'];
// foreach(['btech'] as $p) {
//     $table = "academics_" . $p . "_2020";
//     $query = "SELECT * FROM $table";
//     $results = mysqli_query($conn, $query);
//     while ($row = mysqli_fetch_assoc($results)) {
//         $regno = $row['regno'];
//         $json = json_decode($row["marks_$semester"], true);
//         foreach ($json as $key => $mark) {
//             $type = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM courses WHERE id = " . intval($key)));
//             $status = getStatus($mark, $type);
//             if($status == 1){

//             }
//         }
//     }
// }

function getStatus($marks, $type){
    $arr = preg_split('/\,/', $marks);
    if (sizeof($arr) < 3)
        return 0;
    if ($arr[1] == '' || $arr[2] == '')
        return 0;
    if($type=="theory" && $arr[0]==''){
        return 0;
    }
    return 1;
}

?>

<style>
    fieldset {
        margin: 20px;
        width: auto;
        display: inline;
        vertical-align: top;
    }
    
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        margin:10px;
    }
    .name{
        background-color: rgb(245, 78, 78);
    }
    td,th {
        padding: 3px 20px 3px 20px;
        text-align: center;
    }
</style>


<?php include 'includes/footer.php'; ?>