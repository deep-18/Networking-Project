<?php
include 'dbcon.php';
session_start();
if (!isset($_SESSION['bossname'])) {
    session_unset();
    session_destroy();
    header("Location:. /index.php");
}
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ./index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add new HR</title>

    <!-- Bootstrap core CSS -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="./assets/css/addnewHR.css">
    <script>
        function showdet(deptid) {
            var xhttp;
            if (deptid == "") {
                console.log("blah");
            } else {
                xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.querySelector(".empselector").style.display = "block";
                        document.querySelector(".empbody").innerHTML = this.responseText;
                    }
                }
                xhttp.open("GET", "showemployees.php?q=" + deptid, true);
                xhttp.send();
            }
        }

        function make() {
            var empid = $("input[name=sel_hr]:checked").val()
            console.log(empid);
            var xhttp;
            if (empid == "") {
                console.log("blah");
            } else {
                xhttp = new XMLHttpRequest();
                console.log("in xhhttpp");
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        window.location.reload();
                    }
                }
                xhttp.open("GET", "makehr.php?q=" + empid, true);
                xhttp.send();
            }
        }

        function remEmp() {
            var depid = document.getElementById("del").value;
            var xhttp;
            if (depid == "") {
                console.log("blah");
            } else {
                xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        window.location.reload();
                    }
                }
                xhttp.open("GET", "rmhr.php?q=" + depid, true);
                xhttp.send();
            }
        }
    </script>

</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark  shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="./bossdashboard.php">Welcome CEO</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsDefault">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarsDefault">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item mr-4">
                        <a href="./addnewHR.php" class="active nav-link">Manage HR</a>
                    </li>
                    <li class="nav-item mr-4">
                        <a href="./manageDept.php" class="nav-link">Manage Departments</a>
                    </li>
                    <li class="nav-item  mr-4">
                        <form method="POST">
                            <button class="nav-link" name="logout" style="border:hidden; background-color:#343A40;">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            Select department
                        </div>
                        <div class="card-body ">
                            <form method="POST" id="myform">
                                <div class="form-group row">
                                    <label for="" class="col-md-4 col-form-label text-md-right">Select Department</label>
                                    <div class="col-md-6">
                                        <select class="form-control" onchange="showdet(this.value)" required>
                                            <option value="">Select Department</option>
                                            <?php
                                            $qu = "select * from department";
                                            $re = $conn->query($qu) or die($conn->error);
                                            while ($ro = $re->fetch_assoc()) {
                                            ?>
                                                <option value=<?php echo "'" . $ro['dept_id'] . "'"; ?>><?php echo $ro['dept_name']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="container empselector">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            Select Employee
                        </div>
                        <div class="card-body empbody">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>