<?php include 'includes/header.php';
$empno = $_SESSION['sessionUser'];?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<h2>Marks Entry</h2>

<?php
$result = mysqli_query($conn, "SELECT * FROM employee WHERE empno = $empno");
$row = mysqli_fetch_assoc($result);
$sem = $row['semester'];
$courses = [];
if ($row['courses_'.$sem] != NULL) {
    $courses = preg_split('/\,/', $row['courses_'.$sem]);
    $i = 1;
    while ($i < sizeof($courses)) {
        $id = intval($courses[$i - 1]);
        $x = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM courses WHERE id = $id"));
        $course = $x['course'];
        $branch = $x['branch'];
        $maxmid = $x['midsem'];
        $maxend = $x['endsem'];
        $maxta = $x['ta'];
        
        $type = $x['type'];
        echo "" .
            "<script>" .
            "document.getElementsByTagName('body')[0].innerHTML +=' " .
            "<fieldset id=\"$id\">" .
            "    <legend>".$course.": ".strtoupper($branch)."</legend>" .
            "     <h4>".strtoupper($type)."</h4>" .
            "</fieldset>'" .
            "</script>";
        $programs = ['btech', 'mtech', 'mca'];
        foreach($programs as $p){
            echo "<script>" .
                "document.getElementById('$id').innerHTML += ' " .
                "    <fieldset>" .
                "    <legend>" . strtoupper($p) . "</legend>" .
                "    <table id=\"" . $p . "_$id\">" .
                "        <tr>" .
                "            <td>Reg no</td>" .
                "            <td>Name</td>" .
                "            <td class=\"mid_$id\">Mid sem ($maxmid)</td>" .
                "            <td>End sem ($maxend)</td>" .
                "            <td>TA ($maxta)</td>" .
                "        </tr>" .
                "    </table>" .
                "    <button onclick=\"save_marks(\'" . $p . "_$id\')\">Save</button>" .
                "    </fieldset>' " .
                "</script>";

            $table1 = "academics_" . $p . "_2020";
            $table2 = "student_" . $p . "_2020";
            $query = "SELECT * FROM $table1 INNER JOIN $table2 ON $table1.regno = $table2.regno AND $table2.branch = '$branch'";
            $result = mysqli_query($conn, $query);
            
            while ($row = mysqli_fetch_assoc($result)) {
                $regno = $row['regno'];
                $name = $row['name'];
                $json = json_decode($row['marks_' . $sem], true);
                $arr = preg_split('/\,/', $json[strval($id)]);
                $mid = '';
                $end = '';
                $ta = '';
                if (sizeof($arr) == 3) {
                    $mid = $arr[0];
                    $end = $arr[1];
                    $ta = $arr[2];
                }
                echo "<script>" .
                    "document.getElementById('" . $p . "_$id').innerHTML += '<tr><td class=\"regno_".$p."_".$id."\">$regno</td>" .
                    "<td>$name</td>";
                if ($type != 'practical')
                    echo "<td><input type=\"number\" class=\"marks_" . $p . "_" . $id . "_mid\" value=\"$mid\"></td>";//marks_btech_physics_mid
                echo "<td><input type=\"number\" class=\"marks_".$p."_" . $id . "_end\" value=\"$end\"></td>" .
                    "<td><input type=\"number\" class=\"marks_".$p."_" . $id . "_ta\" value=\"$ta\"></td></tr>'" .
                    "</script>";
            }           

        }
        if($type == "practical"){
            echo "<script>" .
                "var x = document.getElementsByClassName('mid_$id');" .
                "Array.prototype.forEach.call(x, y => {" .
                "y.style.display= 'none';" .
                "}); </script>";
        }
        $i++;
    }
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
    input {
        text-align: center;
        width: 120px;
        border:0;
    }
    input:focus {
        outline: none;
    }
    button {
        padding: 5px;
        margin-top: 10px;
    }
</style>

<script>
    function save_marks(program_course){
        var midmarks = [], endmarks = [], tamarks = [], regno = [];
        var classname = "marks_" + program_course+"_mid";
        console.log(classname);
        var arr = document.getElementsByClassName(classname);
        console.log(arr);
        for(var i=0; i< arr.length; i++){
            midmarks.push(arr[i].value);
        }
        var classname = "marks_" + program_course+"_end";
        var arr = document.getElementsByClassName(classname);
        for(var i=0; i< arr.length; i++){
            endmarks.push(arr[i].value);
        }
        var classname = "marks_" + program_course+"_ta";
        var arr = document.getElementsByClassName(classname);
        for(var i=0; i< arr.length; i++){
            tamarks.push(arr[i].value);
        }
        var classname = "regno_" + program_course;
        var arr = document.getElementsByClassName(classname);
        for(var i=0; i< arr.length; i++){
            regno.push(arr[i].getInnerHTML());
        }

        $.ajax({
        type: "POST",
        url: "includes/add-grades-ajax.php",
        data: {
        midmarks: midmarks,
        endmarks: endmarks,
        tamarks: tamarks,
        regno: regno,
        program_course: program_course
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


<?php include 'includes/footer.php' ?>