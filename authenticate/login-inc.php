<?php

if(isset($_POST['submit'])){
    require '../includes/database.php';

    if(isset($_POST['regno'])){
        $regno = $_POST['regno'];
        $password = $_POST['password'];
        $program = $_POST['program'];
        if(empty($regno) || empty($password)){
            header("Location: ../index.php?error=emptyfields&regno=".$regno);
            exit();
        } else {
            $table = "student_" . $program . "_2020"; //. substr($regno, 0, 4);
            $sql = "SELECT * FROM $table WHERE regno=?";
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

                    if($pass_check == false){
                        header("Location: ../index.php?error=wrongpass");
                        exit();                    
                    }
                    else {
                        session_start();
                        $_SESSION['loggedIn'] = true;
                        $_SESSION['sessionUser'] = $row['regno'];
                        $_SESSION['program'] = $program;
                        $_SESSION['name'] = $row['name'];
                        header("Location: ../student.php?regno=".$regno);
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
                    if(!$pass_check){
                        header("Location: ../index.php?error=wrongpass");
                        exit();
                    }
                    else {
                        session_start();
                        $_SESSION['loggedIn'] = true;
                        $_SESSION['sessionUser'] = $row['empno'];
                        $_SESSION['name'] = $row['name'];
                        header("Location: ../employee.php?empno=" . $empno);
                        exit();
                    }
                } else {
                    header("Location: ../index.php?error=nouser");
                    exit();
                }
            }
        }
    } else if(isset($_POST['admin'])) {
        $password = $_POST['password'];
        if(empty($password)){
            header("Location: ../index.php?error=emptyfields&username=".$username);
            exit();
        } else {
            $pass_check = password_verify($password, "\$2y$10\$aqtiE2iE1UY7BH0qPViaFOWKBYT7MUsQV8CUIlQg/3KJCZOl1px/2");
            if(!$pass_check){
                header("Location: ../index.php?error=wrongpass");
                exit();
            }
            else {
                session_start();
                $_SESSION['loggedIn'] = true;
                $_SESSION['name'] = 'Admin';
                header("Location: ../admin.php");
                exit();
            }
        }
    }
    
}
else {
    header("Location: ../index.php");
    exit();
}

?>