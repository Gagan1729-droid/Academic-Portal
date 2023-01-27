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
    $programs = ['btech', 'mtech', 'mca'];
    foreach($programs as $p){
        $table = "student_" . $p . "_2020";
        mysqli_query($conn, "ALTER TABLE $table ADD `courses_" . $sem . "` VARCHAR(100) NOT NULL");
    }
}

// Calculate spi and cpi of each student
function calcresults($conn, $semester){
    $programs = ['btech', 'mtech', 'mca'];
    foreach ($programs as $t) {
        $table = "student_" . $t . "_2020";
        mysqli_query($conn, "ALTER TABLE $table ADD spi_$semester FLOAT");
        $query = "SELECT * FROM $table";
        $results = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($results)){
            $courses = preg_split('/\,/', $row['courses_' . $semester]);
            $regno = $row['regno'];
            $i = 1;
            $credits = 0;
            $gradecredits = 0;
            while ($i < sizeof($courses)) {
                $temp = $courses[$i - 1];
                $column = $semester . "_" . $temp . "_grades";
                $grade = $row[$column];
                $res = mysqli_query($conn, "SELECT * FROM courses WHERE id = " . $temp);
                $row2 = mysqli_fetch_assoc($res);
                $cr = $row2['credits'];
                $gradecredits += intval($cr) * getGradePoints($grade);
                $credits += intval($cr);
                $i++;
            }
            $spi = $gradecredits / $credits;
            $spi = number_format($spi, 2, '.', '');
            mysqli_query($conn, "UPDATE $table SET spi_$semester = $spi WHERE regno = $regno");

            // Calculate cpi
            $res1 = mysqli_query($conn, "SELECT credits FROM admin WHERE semester < $semester ORDER BY semester ASC");
            $i = 1;
            $gradecredits = $spi * $credits;
            $totcredits = $credits;
            while($i < $semester){
                $row2 = mysqli_fetch_assoc($res1);
                $c = $row2['credits'];
                $spi = $row['spi_' . $i];
                $totcredits += $c;
                $gradecredits += ($spi * $c);
            }
            $cpi = $gradecredits / $totcredits;
            $cpi = number_format($cpi, 2, '.', '');
            mysqli_query($conn, "UPDATE $table SET cpi = $cpi WHERE regno = $regno");
        }
    }
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