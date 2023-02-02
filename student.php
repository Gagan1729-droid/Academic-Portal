<?php
    include 'includes/header.php';
    if(!isset($_SESSION['sessionUser'])){
        header('Location: index.php');
        exit();
    }
    $regno = $_SESSION['sessionUser'];
    $program = $_SESSION['program'];
    $res = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM admin ORDER BY semester DESC LIMIT 1 "));
    $semester = $res['semester'];
    $flag = 0;
    
    $table1 = "academics_" . $program . "_2020";
    $table2 = "student_" . $program . "_2020";
    $query = "SELECT * FROM $table1 INNER JOIN $table2 ON $table1.regno = $table2.regno AND $table1.regno = $regno";
    $result = mysqli_query($conn, $query);;
    $row = mysqli_fetch_assoc(mysqli_query($conn, $query));
    $name = $row['name'];
?>


<link rel = "stylesheet" type="text/css" href="student-style.css">
<div class="container">
<h2><?php echo strtoupper($program)?></h2>
<h2>Current Semester: <?php echo $semester ?></h2>
    <nav>
        <ul>
            <li id="headertabv"><a href="result.php">View Result</a></li>  
            <li id="headertabs"><a href="transcript.php">Get Transcript</a></li>
            <li id="headertabf"><a href="previous-semester.php">Previous semester performance</a></li>
            <li id="headertaba"><a href="get-courses.php">See courses for current semester</a></li>          
        </ul>
    </nav>
</div>


<?php
    if($res['display_results'] == 0){
        $flag = 1;
        echo "<script>" .
            "document.getElementById('headertabv').style.display = 'none';" .
            "</script>";
    }
    include 'includes/footer.php'
?>