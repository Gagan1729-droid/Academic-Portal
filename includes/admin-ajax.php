<?php include 'database.php';
session_start();

$attribute = $_POST['attribute'];
$value = $_POST['value'];
$semester = $_POST['semester'];

// If semester is changed, then required columns and courses need to be added
if($attribute == 'semester'){
    changeSemester($conn, $value);
} else {
    $query = "UPDATE admin SET $attribute = $value WHERE semester = " . $semester;
    $result = mysqli_query($conn, $query);
}

if ($attribute == "display_results" && $value  == '1')
    calcresults($conn,$semester);

echo "Done";

function changeSemester($conn, $sem){
    mysqli_query($conn, "INSERT INTO admin(`semester`) VALUES($sem)");
    mysqli_query($conn, "ALTER TABLE employee ADD `courses_" . $sem . "` VARCHAR(100) NOT NULL");
    $programs = ['btech', 'mtech', 'mca'];
    foreach($programs as $p){
        $table = "academics_" . $p . "_2020";
        mysqli_query($conn, "ALTER TABLE $table ADD `marks_" . $sem . "` VARCHAR(100) NOT NULL");
    }
}

// Calculate spi and cpi of each student
function calcresults($conn, $semester){
    $programs = ['btech', 'mtech', 'mca'];
    foreach ($programs as $p) {
        $table = "academics_" . $p . "_2020";
        mysqli_query($conn, "ALTER TABLE $table ADD spi_$semester FLOAT");
        mysqli_query($conn, "ALTER TABLE $table ADD cpi_$semester FLOAT");
        mysqli_query($conn, "ALTER TABLE $table ADD supplementary_$semester VARCHAR(50)");
        $query = "SELECT * FROM $table";
        $results = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($results)){
            $regno = $row['regno'];
            $json = json_decode($row["marks_$semester"], true);
            $credits = 0;
            $gradecredits = 0;
            $supply = '';
            if($json!=null)
            foreach($json as $key=>$mark){
                $grade = getGrade($mark);
                if ($grade == 'E')
                    $supply .= $key . ",";
                $cr = intval(mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM courses WHERE id = " . intval($key)))['credits']);
                $gradecredits += $cr * getGradePoints($grade);
                $credits += $cr;
            }

            // Update the supplementary subject 
            mysqli_query($conn, "UPDATE $table SET supplementary_$semester = '$supply' WHERE regno = $regno");
            $spi = ($credits!=0) ? $gradecredits / $credits : 0;
            $spi = number_format($spi, 2);
            mysqli_query($conn, "UPDATE $table SET spi_$semester = $spi WHERE regno = $regno");

            // Calculate cpi
            $totcredits = $credits;
            $gradecredits = $spi * $credits;
            // $res1 = mysqli_query($conn, "SELECT courses_".$p."_$branch FROM admin WHERE semester < $semester ORDER BY semester ASC");
            $i = 1;
            while ($i < $semester) {
                // $row2 = mysqli_fetch_assoc($res1);
                $json = json_decode($row["marks_$semester"], true);
                // $courses = preg_split('/\,/', $row2["courses_".$p."_$branch"]);
                $credits = 0;
                if($json!=null)
                foreach($json as $key=>$mark){
                    $cr = intval(mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM courses WHERE id = " . intval($key)))['credits']);
                    $credits += $cr;
                }
                // foreach ($courses as $cor) {
                //     $a = intval($cor);
                //     $c = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM courses WHERE id = $a"))['credits'];
                //     $credits += $c;
                // }
                $spi = $row["spi_$i"];
                $totcredits += $credits;
                $gradecredits += ($spi * $credits);
                $i++;
            }
            $cpi = ($totcredits!=0) ? $gradecredits / $totcredits : 0;
            $cpi = number_format($cpi, 2);
            // $table = "academics_" . $p . "_2020";
            mysqli_query($conn, "UPDATE $table SET cpi_$semester = $cpi WHERE regno = $regno");
        }
    }
}

function getGrade($marks){
    $arr = preg_split('/\,/', $marks);
    if (sizeof($arr) < 3)
        return 'E';
    $mid = intval($arr[0]);
    $end = intval($arr[1]);
    $ta = intval($arr[2]);
    $m = $mid + $end + $ta;
    if($m > 85) 
        return 'A+';
    else if($m>75) return 'A';
    else if($m>60) return 'B';
    else if($m>45) return 'C';
    else if($m>30) return 'D';
    else return 'E';
}

function getGradePoints($grade){
    switch ($grade) {
        case 'A+':
            return 10;
        case 'A':
            return 9;
        case 'B':
            return 8;
        case 'C':
            return 7;
        case 'D':
            return 4;    
        default:
            return 0;
    }
}

?>