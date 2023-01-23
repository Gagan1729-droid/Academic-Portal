    var studentModal = document.getElementById("studentLoginModal");
    var facultyModal = document.getElementById("facultyLoginModal");
    var adminModal = document.getElementById("adminLoginModal");
    var span = document.getElementById("sclose");
    var span2 = document.getElementById("fclose");
    var span3 = document.getElementById("aclose");
    console.log(span);

    function openStudentLoginModal(){
        studentModal.style.display = "block";
    }

    function openFacultyLoginModal(){
        facultyModal.style.display = "block";
    }

    function openAdminLoginModal(){
        adminModal.style.display = "block";
    }

    span.onclick = function() {
        studentModal.style.display = "none";
    }

    span2.onclick = function() {
        facultyModal.style.display = "none";
    }

    span3.onclick = function() {
        adminModal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == studentModal) {
            studentModal.style.display = "none";
        }
        else if (event.target == facultyModal) {
            facultyModal.style.display = "none";
        }
        else if (event.target == adminModal) {
            adminModal.style.display = "none";
        }
    }
