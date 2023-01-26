<?php
    include 'includes/header.php';
    if(!isset($_SESSION['sessionUser'])){
        header('Location: index.php');
        exit();
    }
    $empno = $_SESSION['sessionUser'];
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
            <li id="headertabc"><a href="javascript:void(0)">Enter courses for current semester</a></li>
            <li id="headertabm"><a href="javascript:void(0)">Enter marks</a></li>
            <li id="headertabs"><a href="javascript:void(0)">See your courses for current semester</a></li>
            
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
</script>

<?php
    include 'includes/footer.php'
?>