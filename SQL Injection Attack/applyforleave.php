<?php
include 'dbcon.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ./index.php");
}
if ($_SESSION['admin'] == 1) {
    session_unset();
    session_destroy();
    header("location: ./index.php");
}
?>
<?php
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("location: ./index.php");
}

?>
<?php
$que = "select * from employee where emp_id='" . $_SESSION['username'] . "'";
$result = $conn->query($que) or die($conn->error);
$row = $result->fetch_assoc();
if (count($row) == 0) {
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
    <title>Apply for leave</title>

    <!-- Bootstrap core CSS -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/applyforleave.css">
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
                    <li class="nav-item active mr-4">
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



    <!-- main class begins here -->

    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            Leave Request
                        </div>
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label for="reason" class="col-md-4 col-form-label text-md-right">Reason</label>
                                    <div class="col-md-6">
                                        <input id="reason" type="text" class="form-control" name="reason" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="dt_from" class="col-md-4 col-form-label text-md-right">Date from</label>
                                    <div class="col-md-6">
                                        <input id="dt_from" type="date" class="form-control" name="dt_from" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="dt_to" class="col-md-4 col-form-label text-md-right">Date to</label>
                                    <div class="col-md-6">
                                        <input id="dt_to" type="date" class="form-control" name="dt_to" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="document" class="col-md-4 col-form-label text-md-right">Proof doc</label>
                                    <div class="col-md-6">
                                        <input id="document" type="file" class="form-control" name="document" accept="image/*">
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-5">
                                        <button type="submit" class="btn btn-primary" name="sub" data-toggle="modal" data-target="#myModal">
                                            Apply
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php
    if (isset($_POST['sub'])) {
        $reason = $_POST['reason'];
        $dt_from = $_POST['dt_from'];
        $dt_to = $_POST['dt_to'];
        $que = "select * from leavedet";
        $re = $conn->query($que) or die($conn->error);
        $ro = $re->fetch_assoc();
        $leaveid = $re->num_rows + 1;
        $que = "select * from leavedet where emp_id='" . $_SESSION['username'] . "'";
        $ro = $conn->query($que) or dir($conn->error);
        $already = true;
        if ($ro->num_rows > 0) {
            while ($re = $ro->fetch_assoc()) {
                if ($re['dt_from'] == $dt_from && $re['dt_to'] == $dt_to)
                    $already = false;
            }
        }
        if ($already) {
            $re = $conn->query($que) or die($conn->error);
            $ro = $re->fetch_assoc();
            if (isset($_FILES['document']['name'])) {
                $filename = $_FILES['document']['name'];
                if (!empty($filename)) {
                    $fileTmpName = $_FILES['document']['tmp_name'];
                    $fileExt = explode('.', $filename);
                    $fileActualExt = strtolower(end($fileExt));
                    $fileNameNew = $leaveid . "." . $fileActualExt;
                    $fileDestination = "storage/leave_docs/" . $fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                } else {
                    die("Please upload a file innerif");
                    header("Location: ./applyforleave.php");
                }
            } else {
                echo "Hello";
                die("Please upload file");
            }
            $curdate = date("Y-m-d");
            if (($dt_from >= $curdate) && ($dt_to >= $curdate)) {
                if ($dt_from <= $dt_to) {
                    $qe = "insert into leavedet(leave_id,emp_id,dt_from,dt_to,reason,document,timeee)  values (" . $leaveid . ",'" . $_SESSION['username'] . "','" . $dt_from . "','" . $dt_to . "','" . $reason . "','" . $fileDestination . "','" . date("Y-m-d H:i:s", time()) . "')";
                    $re = $conn->query($qe) or die($conn->error);
                } else {
                    die("A leave cannot end before starting");
                }
            } else {
                die("You cannot take an leave on a day that is over");
            }
        } else {
            die("pff ! you already have applied leave on this dates");
        }
    }
    ?>

</body>

</html>