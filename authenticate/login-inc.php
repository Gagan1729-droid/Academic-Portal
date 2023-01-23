<?php

if(isset($_POST['submit'])){
    require '../database.php';

    if(isset($_POST['regno'])){
        $regno = $_POST['regno'];
        $password = $_POST['password'];
        if(empty($regno) || empty($password)){
            header("Location: ../index.php?error=emptyfields&regno=".$regno);
            exit();
        } else {
            $sql = "SELECT * FROM student WHERE regno=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ../index.php?error=sqlerror");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $regno);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if($row = mysqli_fetch_assoc($result)){
                    $pass_check = password_verify($password, $row['password']);
                    if($password != $row['password']){
                        header("Location: ../index.php?error=wrongpass");
                        exit();
                    }
                    else {
                        session_start();
                        $_SESSION['sessionUser'] = $row['regno'];
                        header("Location: ../index.php?success=loggedin");
                        exit();
                    }
                } else {
                    header("Location: ../index.php?error=nouser");
                    exit();
                }
            }
        }
    }

    else if(isset($_POST['empno'])) {
        $empno = $_POST['empno'];
        $password = $_POST['password'];
        if(empty($empno) || empty($password)){
            header("Location: ../index.php?error=emptyfields&empno=".$empno);
            exit();
        } else {
            $sql = "SELECT * FROM employee WHERE empno=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ../index.php?error=sqlerror");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $empno);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if($row = mysqli_fetch_assoc($result)){
                    $pass_check = password_verify($password, $row['password']);
                    if($password != $row['password']){
                        header("Location: ../index.php?error=wrongpass");
                        exit();
                    }
                    else {
                        session_start();
                        $_SESSION['sessionUser'] = $row['empno'];
                        header("Location: ../index.php?success=loggedin");
                        exit();
                    }
                } else {
                    header("Location: ../index.php?error=nouser");
                    exit();
                }
            }
        }
    } else if(isset($_POST['username'])) {
        $empno = $_POST['username'];
        $password = $_POST['password'];
        if(empty($username) || empty($password)){
            header("Location: ../index.php?error=emptyfields&username=".$username);
            exit();
        } else {
            $sql = "SELECT * FROM admins WHERE username=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ../index.php?error=sqlerror");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if($row = mysqli_fetch_assoc($result)){
                    $pass_check = password_verify($password, $row['password']);
                    if($password != $row['password']){
                        header("Location: ../index.php?error=wrongpass");
                        exit();
                    }
                    else {
                        session_start();
                        $_SESSION['sessionUser'] = $row['username'];
                        header("Location: ../index.php?success=loggedin");
                        exit();
                    }
                } else {
                    header("Location: ../index.php?error=nouser");
                    exit();
                }
            }
        }
    }
    
}
else {
    header("Location: ../index.php");
    exit();
}

?>