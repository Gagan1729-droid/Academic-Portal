<?php
    include 'includes/header.php';
    if(!isset($_SESSION['loggedIn'])){
        header('Location: index.php');
        exit();
    }
    // To make sure that this is only accessible to admin
    if($_SESSION['category'] != 'Admin'){
        header('Location: index.php');
        exit();
    }
    $table = "admin";
    $query = "SELECT * FROM $table ORDER BY semester DESC LIMIT 1 ";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $semester = $row['semester'];
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

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
            <li id="headertabd"><a href="javascript:void(0)">Display results for current semester:</a>
                <button id="start-display-results" onclick="start_display_results()">Start</button>
                <button id="stop-display-results" onclick="stop_display_results()">Stop</button></li>
            <li id="headertabl"><a href="professors-not-entered-marks.php">Professors who haven't yet entered marks</a>
            
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
    if(<?php echo $row['display_results'] ?> == 1){
        document.getElementById("start-display-results").style.display = 'none';
    } else {
        document.getElementById('stop-display-results').style.display = 'none';
    }

    document.getElementById("changeSemInput").value = <?php echo $semester; ?>;

    function change_semester() {
        post('semester', document.getElementById("changeSemInput").value);
    }

    function start_grade_entry() {
        post('grade_entry', '1');
        document.getElementById("start-grade-entry").style.display = 'none';
        document.getElementById('stop-grade-entry').style.display = 'inline';
    }

    function stop_grade_entry() {
        post('grade_entry', '0');
        document.getElementById("start-grade-entry").style.display = 'inline';
        document.getElementById('stop-grade-entry').style.display = 'none';
    }

    function start_course_entry() {
        post('course_entry', '1');
        document.getElementById("start-course-entry").style.display = 'none';
        document.getElementById('stop-course-entry').style.display = 'inline';
    }

    function stop_course_entry() {
        post('course_entry', '0');
        document.getElementById("start-course-entry").style.display = 'inline';
        document.getElementById('stop-course-entry').style.display = 'none';
    }

    function start_display_results(){
        post('display_results', '1');
        document.getElementById("start-display-results").style.display = 'none';
        document.getElementById('stop-display-results').style.display = 'inline';
    }

    function stop_display_results(){
        post('display_results', '0');
        document.getElementById("start-display-results").style.display = 'inline';
        document.getElementById('stop-display-results').style.display = 'none';
    }

    function post(attribute, value){
    $.ajax({
        type: "POST",
        url: "includes/admin-ajax.php",
        data: {
        attribute: attribute,
        value: value,
        semester: document.getElementById('changeSemInput').value
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