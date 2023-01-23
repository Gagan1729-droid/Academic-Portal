<?php 
session_start();
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
                <li><a href="javascript:void(0)" onclick="openStudentLoginModal()">Student Login</a></li>
                <li><a href="javascript:void(0)" onclick="openFacultyLoginModal()">Faculty Login</a></li>
                <li><a href="javascript:void(0)" onclick="openAdminLoginModal()">Admin Login</a></li>
            </ul>
        </nav>

    </div>
</header>

<script>
    window.onload = function() {
        var url = document.location.href,
        params = url.split('?')[1], tmp;
        tmp = params.split('=');
        if(tmp[0] == 'error'){
            displaySwal();
        }        
    }
    function displaySwal() {
        swal({
            title: "Error!",
            text: "Invalid Credentials",
            icon: "error",
            button: "Retry!"
            });
        }
</script>
