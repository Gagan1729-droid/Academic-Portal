<?php
include 'includes/header.php';
echo "<script>" .
    "    document.getElementById('headertabs').style.display = 'none';" .
    "    document.getElementById('headertabf').style.display = 'none';" .
    "    document.getElementById('headertaba').style.display = 'none';" .
    "    document.getElementById('header-register').style.display = 'none';" .
    "    document.getElementById('cancel').style.display = 'inline';" .
    "</script>";
?>

<div class="radioclass">
    <div>Register as: </div>
    <div><input type="radio" name="student" id="rad_student" onclick="rad_student()">
    <label for="student">Student</label></div>

    <div><input type="radio" name="employee" id="rad_employee" onclick="rad_employee()">
    <label for="employee">Employee</label></div>
</div>

<div id="student">
    <form action="authenticate/register-inc.php" method="POST">
        <input type="text" name="name" placeholder="Name" required>
        <select name = "program">
            <option value="btech">B.Tech</option>
            <option value="mtech">M.Tech</option>
            <option value="mca">MCA</option>
            <option value="phd">PhD</option>
            <option value="mba">MBA</option>
        </select>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="cpassword" placeholder="Confirm Password" required>
        <input class="register" type="submit" name="submit" value="Register">
        <input name="student" type="hidden">
    </form>
</div>

<div id="employee">
    <form action="authenticate/register-inc.php" method="POST">
        <input type="text" name="name" placeholder="Name" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="cpassword" placeholder="Confirm Password" required>
        <input class="register" type="submit" name="submit" value="Register">
        <input name="employee" type="hidden">
    </form>
</div>

<script>
    var st_radio = document.getElementById("rad_student"),
        em_radio = document.getElementById("rad_employee");
    st_radio.checked = true;
    document.getElementById("employee").style.display = 'none';

    function rad_student(){
        if(em_radio.checked) em_radio.checked = false;
        st_radio.checked=true;
        document.getElementById("student").style.display = "block";
        document.getElementById("employee").style.display = 'none';
    }

    function rad_employee(){
        if(st_radio.checked) st_radio.checked = false;
        em_radio.checked=true;
        document.getElementById("student").style.display = "none";
        document.getElementById("employee").style.display = 'block';
    }

</script>

<style>
    .radioclass {
        text-align: center;
    }
    .radioclass div {
        display: inline;
        padding: 10px;
    }

    form{
        align-items: center;
    }

    form input, select{
        display: block;
        margin: 20px auto;
        text-align: center;
        width: 240px;
        height: 40px;
        background-color: #f2f2f2;
    }

    .register {
        background-color: #a7adb9;
        font-weight: bold;
        text-transform: uppercase;
        border-radius: 5px;
        color: #152648;
    }

    .register:hover {
        background-color: #152648;
        color: white;
        cursor: pointer;
    }
</style>

<?php 
include 'includes/footer.php'
?>
