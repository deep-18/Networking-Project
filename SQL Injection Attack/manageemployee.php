<?php
include 'dbcon.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("location:./index.php");
}
if ($_SESSION['admin'] == 0) {
    session_unset();
    session_destroy();
    header("location:./index.php");
}
?>
<?php
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("location:./index.php");
}
?>
<?php
$abc = "select * from login where emp_id='" . $_SESSION['username'] . "'";
$re = $conn->query($abc) or die($conn->error);
$usr = $re->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Employees</title>

    <!-- Bootstrap core CSS -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <link rel="stylesheet" href="./assets/css/manageemployee.css">

    <script>
        function showDet(eid) {
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("modalbody").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "getempdet.php?q=" + eid, true);
            xhttp.send();
        }

        function delDet(eid) {
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                }
            }
            xhttp.open("GET", "delemp.php?q=" + eid, true);
            xhttp.send();
            location.reload();
        }
    </script>
</head>

<body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark  shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="./admindashboard.php"><?php echo $usr['username']; ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsDefault">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarsDefault">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item mr-4">
                        <a href="./employeeprofile.php" class="nav-link">Profile</a>
                    </li>
                    <li class="nav-item mr-4">
                        <a href="./signup.php" class="nav-link">Register</a>
                    </li>
                    <li class="nav-item mr-4">
                        <a href="./leaveapplications.php" class="nav-link">Leave Applications</a>
                    </li>
                    <li class="nav-item mr-4">
                        <a href="./manageemployee.php" class="active nav-link">Manage Employee</a>
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
    <div class="container">
        <div class="row">
            <?php
            $sql1 = "select dept_id from employee where emp_id='" . $_SESSION['username'] . "'";
            $res1 = $conn->query($sql1) or die($conn->error);
            $ro = $res1->fetch_assoc();
            $dept = $ro['dept_id'];
            $sql = "select * from employee where is_hr='0' and dept_id=" . $dept;
            $result = $conn->query($sql) or die($conn->error);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <div class="col-md-6 col-sm-12">
                        <div class="card-wrapper">
                            <div class="img-wrapper">
                                <img class="rounded-circle img-profile" height="100" width="100" src=<?php echo $row['profile_pic']; ?> alt="img">
                            </div>
                            <div class="info-wrapper">
                                <h2><?php echo $row['first_name'] . ' ' . $row['last_name'] ?></h2>
                                <h6><?php echo $row['email'] ?></h6>
                                <hr>
                                <h6><?php echo $row['post'] ?></h6>
                                <h6><?php echo $row['phone'] ?></h6>
                            </div>
                            <div class="button-wrappper">
                                <!-- <form class="show_details"> -->
                                <button class="btn btn-primary viewdet" onclick="showDet(this.value)" data-toggle="modal" data-target="#myModal" value=<?php echo "'" . $row['emp_id'] . "'"; ?>>View Details</button>
                                <!-- </form> -->
                                <!-- <form class="delete_acc"> -->
                                <br>
                                <button class="btn btn-danger" onclick="delDet(this.value)" type="submit" value=<?php echo "'" . $row['emp_id'] . "'"; ?>>Delete Account</button>
                                <!-- </form> -->
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" tabindex="-1" id="myModal">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h4 class="modal-title">Employee Details</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body" id="modalbody">
                                        Modal body..
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="w-100 d-flex justify-content-center align-items-center p-5 m-5">
                    <h4>No Employees To Manage</h4>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</body>

</html>