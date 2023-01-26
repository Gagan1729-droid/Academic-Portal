<?php

    if(isset($_POST['submit'])){
        require '../includes/database.php';
        if(isset($_POST['student'])){
            $name = $_POST['name'];
            $course = $_POST['course'];
            $password = $_POST['password'];
            $cpassword = $_POST['cpassword'];
            if($cpassword != $password){
                header('Location: ../register.php?error=passwordsdonotmatch');
                exit();
            }
            $year = date("Y");
            $table = "student_" . $course . "_2020" ;
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO $table (`name`, `password`, `semester`, `year`, `cpi`) VALUES ('$name', '$hashed_password', '1', '1', '0.0')";
            $result = mysqli_query($conn, $sql);
            if($result){
                header("Location: ../index.php?success=registeredsuccessfully");
                exit(); 
            }
            else {
                header("Location: ../register.php?error=sqlerror");
                exit();
            }
        }
        else if(isset($_POST['employee'])){
            $name = $_POST['name'];
            $password = $_POST['password'];
            $cpassword = $_POST['cpassword'];
            if($cpassword != $password){
                header('Location: ../register.php?error=passwordsdonotmatch');
                exit();
            }
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO employee (`name`, `password`) VALUES ('$name', '$hashed_password')";
            $result = mysqli_query($conn, $sql);
            if($result){
                header("Location: ../index.php?success=registeredsuccessfully");
                exit(); 
            }
            else {
                header("Location: ../register.php?error=sqlerror");
                exit();
            }
        }
    }
    else {
        header("Location: ../register.php");
        exit();
    }

?>