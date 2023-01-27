<?php

    if(isset($_POST['submit'])){
        require '../includes/database.php';
        if(isset($_POST['student'])){
            $name = $_POST['name'];
            $program = $_POST['program'];
            $password = $_POST['password'];
            $cpassword = $_POST['cpassword'];
            if($cpassword != $password){
                header('Location: ../register.php?error=passwordsdonotmatch');
                exit();
            }
            $year = date("Y");
            $table = "student_" . $program . "_2020" ;
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $check = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
            $row = mysqli_fetch_assoc($check);
            if ($row == NULL) {
                $query = "CREATE TABLE `mnnit`.`$table` ( `regno` INT(10) NOT NULL AUTO_INCREMENT ," .
                    " `password` VARCHAR(1000) NOT NULL , `name` VARCHAR(50) NOT NULL , `semester` INT(3) NOT NULL DEFAULT '1' ," .
                    " `cpi` FLOAT NULL , PRIMARY KEY (`regno`))";
                mysqli_query($conn, $query);
            }
            $sql = "INSERT INTO $table (`name`, `password`) VALUES ('$name', '$hashed_password')";
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