<?php
include 'dbcon.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("location:./index.php");
}
if ($_SESSION['admin'] == 1) {
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
$que = "select * from employee where emp_id='" . $_SESSION['username'] . "'";
$result = $conn->query($que) or die($conn->error);
$row = $result->fetch_assoc();
if ($result->num_rows<= 0) {
    die("invalid employee id");
}
$result1 = $conn->query("select * from login where login.emp_id='" . $_SESSION['username'] . "'") or die($conn->error);
$row1 = $result1->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Staff</title>

    <!-- Bootstrap core CSS -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="./assets/css/userdashboard.css">
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark  shadow-sm">
        <div class="container">
            <a class="navbar-brand active" href="./userdashboard.php"><?php echo $row1['username']; ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsDefault">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarsDefault">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item mr-4">
                        <a href="./employeeprofile.php" class="nav-link">Profile</a>
                    </li>
                    <li class="nav-item mr-4">
                        <a href="./applyforleave.php" class="nav-link">Apply for Leave</a>
                    </li>
                    <li class="nav-item active mr-4">
                        <form method="POST">
                            <button class="nav-link" name="logout" style="border:hidden; background-color:#343A40;">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <img src="./images/userdashboard.svg">
    </main>

</body>

</html>