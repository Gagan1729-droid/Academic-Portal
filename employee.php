<?php
    include 'includes/header.php';
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
        header('Location: employee.php?empno=' . $empno);
    }
    $table = "employee";
    $query = "SELECT * FROM $table WHERE empno = " . $empno;
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $query = "SELECT * FROM admin ORDER BY semester DESC LIMIT 1 ";
    $result = mysqli_query($conn, $query);
    $row2 = mysqli_fetch_assoc($result);
    $name = $row['name'];
?>

<link rel = "stylesheet" type="text/css" href="student-style.css">
<div class="container">
<h2>Current Semester: <?php echo $row2['semester'] ?></h2>
    <nav>
        <ul>
            <li id="headertabc"><a href="add-courses.php">Enter courses for current semester</a></li>
            <li id="headertabm"><a href="enter-grades.php">Enter marks</a></li>
            <li id="headertabs"><a href="courses.php">See your courses for current semester</a></li>
            <li id="headertabv"><a href="view-supplementary.php">View Supplementary examinations</a></li>            
        </ul>
    </nav>
</div>

<script>
    if(<?php echo $row2['course_entry'] ?> == 0){
        document.getElementById("headertabc").style.display = 'none';
    }
    if(<?php echo $row2['grade_entry'] ?> == 0){
        document.getElementById("headertabm").style.display = 'none';
    }
    if(<?php echo $row2['display_results']?> == 0){
        document.getElementById("headertabv").style.display = "none";
    }
</script>

<?php
    include 'includes/footer.php'
?>