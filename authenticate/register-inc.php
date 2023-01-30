<?php

    if(isset($_POST['submit'])){
        require '../includes/database.php';
        if(isset($_POST['student'])){
            $name = $_POST['name'];
            $program = $_POST['program'];
            $branch = $_POST['branch'];
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
            // If table doesn't exist , create
            if ($row == NULL) {
                $query = "CREATE TABLE `mnnit`.`$table` ( `regno` INT(10) NOT NULL AUTO_INCREMENT ," .
                    " `password` VARCHAR(1000) NOT NULL , `name` VARCHAR(50) NOT NULL ," .
                    " `branch` ENUM(\"cse\",\"ece\",\"ee\",\"me\",\"ce\",\"che\",\"be\",\"pie\")" .
                    " NOT NULL, `semester` INT(3) NOT NULL DEFAULT '1' ," .
                    " `cpi` FLOAT NULL , PRIMARY KEY (`regno`))";
                mysqli_query($conn, $query);
            }
            $sql = "INSERT INTO $table (`name`, `password`, `branch`) VALUES ('$name', '$hashed_password', '$branch')";
            $result = mysqli_query($conn, $sql);
            if($result){
                // Insert in academics table
                $regno = mysqli_insert_id($conn);
                $table = "academics_" . $program . "_2020";
                $row = mysqli_fetch_assoc(mysqli_query($conn, "SHOW TABLES LIKE '$table'"));
                if($row == NULL){
                    $query = "CREATE TABLE `mnnit`.`$table` ( `regno` INT NOT NULL , PRIMARY KEY (`regno`))";
                    mysqli_query($conn, $query);
                }
                mysqli_query($conn, "INSERT INTO $table(`regno`) VALUES($regno)");
                header("Location: ../index.php?success=registeredsuccessfully");
                exit(); 
            }
            else {
                header("Location: ../register.php?error=sqlerror");
                exit();
            }
        }
        //For employee registeration
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