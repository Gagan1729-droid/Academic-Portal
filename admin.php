<?php
    include 'includes/header.php';
    if(!isset($_SESSION['loggedIn'])){
        header('Location: index.php');
        exit();
    }
    $table = "admin";
    $query = "SELECT * FROM $table ORDER BY semester DESC LIMIT 1 ";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $semester = $row['semester'];
?>

<link rel = "stylesheet" type="text/css" href="student-style.css">
<div class="container">
<h2>Current Semester: <?php echo $row['semester'] ?></h2>
    <nav>
        <ul>
            <li id="headertabs"><a href="javascript:void(0)">Change current semester</a>
                <input type = "number" id = "changeSemInput" placeholder="Semester">
                <button id="changeSemBtn" onclick="change_semester()">Change</button></li>
            <li id="headertabf"><a href="javascript:void(0)">Grade Entry:</a>
                <button id="start-grade-entry" onclick="start_grade_entry()">Start</button>
                <button id="stop-grade-entry" onclick="stop_grade_entry()">Stop</button></li>
            <li id="headertaba"><a href="javascript:void(0)">Course Entry:</a>
                <button id="start-course-entry" onclick="start_course_entry()">Start</button>
                <button id="stop-course-entry" onclick="stop_course_entry()">Stop</button></li>
            
        </ul>
    </nav>
</div>

<script>
    if(<?php echo $row['grade_entry'] ?> == 1){
        document.getElementById("start-grade-entry").style.display = 'none';
    } else {
        document.getElementById('stop-grade-entry').style.display = 'none';
    }
    if(<?php echo $row['course_entry'] ?> == 1){
        document.getElementById("start-course-entry").style.display = 'none';
    } else {
        document.getElementById('stop-course-entry').style.display = 'none';
    }

    document.getElementById("changeSemInput").value = <?php echo $semester; ?>;

    function change_semester() {
        // <php $sem = "2";
        // $query = "INSERT INTO admin('semester', 'grade_entry', 'course_entry') VALUES ('$sem', '0', '0')";
        // $result = mysqli_query($conn, $query); ?>
    }

    function start_grade_entry() {
        <?php $query = "UPDATE admin SET grade_entry = 1 WHERE semester = " . $semester;
        $result = mysqli_query($conn, $query); ?>
        document.getElementById("start-grade-entry").style.display = 'none';
        document.getElementById('stop-grade-entry').style.display = 'inline';
    }

    function stop_grade_entry() {
        <?php $query = "UPDATE admin SET grade_entry = 0 WHERE semester = " . $semester;
        $result = mysqli_query($conn, $query); ?>
        document.getElementById("start-grade-entry").style.display = 'inline';
        document.getElementById('stop-grade-entry').style.display = 'none';
    }

    function start_course_entry() {
        <?php $query = "UPDATE admin SET course_entry = 1 WHERE semester = " . $semester;
        $result = mysqli_query($conn, $query); ?>
        document.getElementById("start-course-entry").style.display = 'none';
        document.getElementById('stop-course-entry').style.display = 'inline';
    }

    function stop_course_entry() {
        <?php $query = "UPDATE admin SET course_entry = 0 WHERE semester = " . $semester;
        $result = mysqli_query($conn, $query); ?>
        document.getElementById("start-course-entry").style.display = 'inline';
        document.getElementById('stop-course-entry').style.display = 'none';
    }

</script>


<style>
    input, button {
        text-decoration: none;
        color: black;
        font-size: 18px;
        font-family: sans-serif;
        text-align: center;
    }
    input {
        width: 100px;
    }
    
</style>
<?php
    include 'includes/footer.php'
?>