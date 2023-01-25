<?php
    include 'includes/header.php';
    if(!isset($_SESSION['sessionUser'])){
        header('Location: index.php');
        exit();
    }
    $regno = $_SESSION['sessionUser'];
    $query = "SELECT * FROM student WHERE regno = " . $regno;
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
    echo "<script>" .
    "    document.getElementById('headertabs').style.display = 'none';" .
    "    document.getElementById('headertabf').style.display = 'none';" .
    "    document.getElementById('headertaba').style.display = 'none';" .
    "    document.getElementById('header-register').style.display = 'none';" .
    "    document.getElementById('logout').style.display = 'inline';" .
    "    document.getElementById('pname').style.display = 'inline';" .
    "    document.getElementById('pname').innerHTML = '$name';" .
    "</script>"
?>




<link rel = "stylesheet" type="text/css" href="student-style.css">
<div class="container">
<h2><?php echo $row['course'] ?></h2>
<h2>Current Semester: <?php echo $row['semester'] ?></h2>
<h2>Status: <?php if ($row['cpi'] > 4)
    echo "Pass";
else
    echo "Fail"; ?> </h2>
    <nav>
        <ul>
            <li id="headertabs"><a href="javascript:void(0)">Get Transcript</a></li>
            <li id="headertabf"><a href="javascript:void(0)">Previous semester performance</a></li>
            <li id="headertaba"><a href="javascript:void(0)">See courses for current semester</a></li>
            
        </ul>
    </nav>
</div>


<?php
    include 'includes/footer.php'
?>