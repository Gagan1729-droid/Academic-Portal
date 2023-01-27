<?php
    include 'includes/header.php';
    if(!isset($_SESSION['sessionUser'])){
        header('Location: index.php');
        exit();
    }
    $regno = $_SESSION['sessionUser'];
    $course = $_SESSION['course'];
    $table = "student_" . $course . "_" . substr($regno, 0, 4);
    $query = "SELECT * FROM $table WHERE regno = " . $regno;
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
?>


<link rel = "stylesheet" type="text/css" href="student-style.css">
<div class="container">
<h2><?php echo strtoupper($course)?></h2>
<h2>Current Semester: <?php echo $row['semester'] ?></h2>
<h2>Status: <?php if ($row['cpi'] == '')
    echo "Result not declared"; 
    else if ($row['cpi'] > 4)
    echo "Pass";
else
    echo "Fail"; ?> </h2>
    <nav>
        <ul>
            <li id="headertabs"><a href="transcript.php">Get Transcript</a></li>
            <li id="headertabf"><a href="javascript:void(0)">Previous semester performance</a></li>
            <li id="headertaba"><a href="get-courses.php">See courses for current semester</a></li>
            
        </ul>
    </nav>
</div>


<?php
    include 'includes/footer.php'
?>