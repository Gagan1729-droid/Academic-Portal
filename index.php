<?php
include 'includes/header.php'?>

<img style="width:100%;" src="https://academics.mnnit.ac.in/static/img/jumbo.png"/>


<h2>About MNNIT</h2>
<hr>
<p>Motilal Nehru National Institute Of Technology, Allahabad was formerly Motilal Nehru Regional Engineering College, Allahabad . It is an institute with total commitment to quality and excellence in academic pursuits, is among one of the leading institutes in INDIA and was established in year 1961 as a joint enterprise of Govt. of India and Govt. of U.P. in accordance with the scheme of establishment of REC. However with effect from June 26th of 2002 the college became deemed university and is now known as Motilal Nehru National Institute of technology.
</p>

<p>The foundation stone of the college was laid by the first Prime Minister of India, Pt. Jawahar Lal Nehru on the 3rd of may, 1961 on a site spreading over 222 acres on the banks of the river Ganga. The main building of college was inaugurated by another illustrious son of India, Prime Minister Sri Lal Bahadur Shastri on 18th of April, 1965.
</p>

<p>The students are extensively exposed to cross-cultural environment as candidates from various other countries such as Sri Lanka, Nepal, Bangladesh, Bhutan, Mauritius, Malaysia, Iran, Yemen, Iraq, Palestine and Thailand also join MNNIT for various undergraduate and post-graduate programs.
</p>

<div class="modal" id="studentLoginModal">
    <div class="modal-content">
        <span class="close" id="sclose">&times;</span>
        <h1 style="align-items:center">Student Login</h1>
        <form action="" method="POST">
            <input type="text" name="regno" required placeholder="Registeration No.">
            <input type="password" name="password" required placeholder="Password">
            <input class="loginbtn" onclick="display()" type="submit" name="submit" value="Login">
        </form>
    </div>
</div>

<div class="modal" id="facultyLoginModal">
    <div class="modal-content">
        <span class="close" id="fclose">&times;</span>
        <h1 style="align-items:center">Faculty Login</h1>
        <form action="faculty-login-inc.php" method="POST">
            <input type="text" name="empno" required placeholder="Employee No.">
            <input type="password" name="password" required placeholder="Password">
            <input class="loginbtn" type="submit" name="submit" value="Login">
        </form>
    </div>
</div>

<div class="modal" id="adminLoginModal">
    <div class="modal-content">
        <span class="close" id="aclose">&times;</span>
        <h1 style="align-items:center">Admin Login</h1>
        <form action="admin-login-inc.php" method="POST">
            <input type="text" name="admin" required placeholder="Admin Username">
            <input type="password" name="password" required placeholder="Password">
            <input class="loginbtn" type="submit" name="submit" value="Login">
        </form>
    </div>
</div>

<script src="modal-script.js"></script>
<script>
    function display() {
        swal({
            title: "Error!",
            text: "Invalid Credentials",
            icon: "error",
            button: "Retry!"
            });
        }
</script>

<?php
include 'includes/footer.php'?>