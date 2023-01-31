<?php 
session_start();
include 'database.php';
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dean Academics | MNNIT Allahabad</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>

<header>
    <img id="mnnit" src="assets/MNNIT.png"/>
    <div id="head">
        <h2>MOTILAL NEHRU NATIONAL INSTITUTE OF TECHONOLOGY ALLAHABAD</h2>
        <nav>
            <ul>
                <li id="headertabs"><a href="javascript:void(0)" onclick="openStudentLoginModal()">Student Login</a></li>
                <li id="headertabf"><a href="javascript:void(0)" onclick="openFacultyLoginModal()">Faculty Login</a></li>
                <li id="headertaba"><a href="javascript:void(0)" onclick="openAdminLoginModal()">Admin Login</a></li>
                <li id="header-register"><a href="register.php">Register</a></li>
                
                <li><a id="pname" style="display: none"></a></li>
                <li><a id="logout" href="logout.php" style="display: none">Logout</a></li>
                <li><a id="cancel" href="index.php" style="display: none">Cancel</a></li>
            </ul>
        </nav>

    </div>
</header>

<?php
if (isset($_SESSION['loggedIn'])) {
    $name = $_SESSION['name'];
    echo "<script>" .
        "    document.getElementById('headertabs').style.display = 'none';" .
        "    document.getElementById('headertabf').style.display = 'none';" .
        "    document.getElementById('headertaba').style.display = 'none';" .
        "    document.getElementById('header-register').style.display = 'none';" .
        "    document.getElementById('logout').style.display = 'inline';" .
        "    document.getElementById('pname').style.display = 'inline';" .
        "    document.getElementById('pname').innerHTML = '$name';" .
        "</script>";

        switch($_SESSION['category']){
        case "Student":
            echo "<script>" .
                "document.getElementById('pname').setAttribute(\"href\", \"student.php\");" .
                "</script>";
            break;
        case "Employee":
            echo "<script>" .
                "document.getElementById('pname').setAttribute(\"href\", \"employee.php\");" .
                "</script>";
            break;   
        case "Admin":
            echo "<script>" .
                "document.getElementById('pname').setAttribute(\"href\", \"admin.php\");" .
                "</script>";
            break;
        }
}
    ?>