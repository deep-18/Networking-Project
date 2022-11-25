<?php
include 'dbcon.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location:. /index.php");
}
if ($_SESSION['admin'] == 0) {
    session_unset();
    session_destroy();
    header("Location: ./index.php");
}
?>
<?php
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ./index.php");
}
?>
<?php
$sql2 = "select * from login where emp_id='" . $_SESSION['username'] . "'";
$result2 = $conn->query($sql2) or die($conn->error);
$row2 = $result2->fetch_assoc();
$sql = "select * from employee where emp_id='" . $_SESSION['username'] . "'";
$res = $conn->query($sql) or die($conn->error);
$row1 = $res->fetch_assoc();
$curdep = $row1['dept_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>

    <!-- Bootstrap core CSS -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="./assets/css/admindashboard.css">
</head>

<body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark  shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="./admindashboard.php"><?php echo $row2['username']; ?></a>
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
                        <a href="./manageemployee.php" class="nav-link">Manage Employee</a>
                    </li>
                    <li class="nav-item  mr-4">
                        <form method="POST">
                            <button class="nav-link btn-dark" name="logout" style="border:hidden; background-color:#343A40;">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="py-4">
        <div class="card-wrapper" id="card-1">
            <h4>Employee's Leaves</h4>
            <div class="card-deck">
                <?php
                $que = "select leavedet.* ,employee.* from leavedet,employee where employee.emp_id=leavedet.emp_id and employee.dept_id='" . $curdep . "' and pending=1";
                $re = $conn->query($que) or die($conn->error);
                if ($re->num_rows > 0) {
                    while ($row = $re->fetch_assoc()) {
                ?>
                <div class="card woo">
                    <div class="card-body">
                        <img class="rounded-circle" style="height: 120px; width: 120px; float: left;" src=<?php echo $row['profile_pic']; ?> data-holder-rendered="true" alt="img">
                        <h5 class="card-body"><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></h5>
                        <p><?php echo $row['post']; ?></p>
                        <p><?php echo $row['status']; ?></p>
                        <br>
                        <p>From:<?php echo $row['dt_from']; ?></p>
                        <p>To:<?php echo $row['dt_to']; ?></p>
                        <p>Total days:<?php
                        $date1 = date_create($row['dt_from']);
                        $date2 = date_create($row['dt_to']);
                        echo $date1->diff($date2)->format("%d");
                        ?></p>
                    </div>
                </div>
                <?php
                     }
                 } 
                else {
                ?>
                    <div class="w-100 d-flex justify-content-center align-items-center p-5 m-5">
                        <p>Sit back and Relax,No leave requests</p>
                        <img id="sitback" src="./images/sitbackandrelax.svg">
                    </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </main>

</body>

</html>