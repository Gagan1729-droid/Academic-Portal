<?php include 'database.php';
session_start();

$attribute = $_POST['attribute'];
$value = $_POST['value'];
$semester = $_POST['semester'];

$query = "UPDATE admin SET $attribute = $value WHERE semester = " . $semester;
$result = mysqli_query($conn, $query);

if ($attribute == "display_results")
    calcresults($conn,$semester);

echo "Done";

function calcresults($conn, $semester){
    //$programs = ['btech', 'mtech', 'mca', 'mba', 'phd'];
    foreach (['btech'] as $t) {
        $table = "student_" . $t . "_2020";
        // mysqli_query($conn, "ALTER TABLE $table ADD spi_$semester FLOAT");
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
            echo $credits . "  " . $gradecredits. '<br>';
            $spi = $gradecredits / $credits;
            mysqli_query($conn, "UPDATE $table SET spi_$semester = $spi WHERE regno = $regno");
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