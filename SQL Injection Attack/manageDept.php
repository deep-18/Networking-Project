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
    <title>Manage Departments</title>

    <!-- Bootstrap core CSS -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="./assets/js/manageDept.js"> </script>
    <link rel="stylesheet" href="./assets/css/manageDept.css">

</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark  shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="bossdashboard.php">Welcome CEO</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsDefault">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarsDefault">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item mr-4">
                        <a href="./addnewHR.php" class="nav-link">Manage HR</a>
                    </li>
                    <li class="nav-item mr-4">
                        <a href="./manageDept.php" class="nav-link active">Manage Departments</a>
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

    <!-- Main body -->

    <main class="py-4 tugaya">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <form method="POST" id="myform">
                        <div class="form-group row justify-content-center">
                            <div class="table-responsive ">
                                <table class="table table-hover table-striped ">
                                    <thead> 
                                    <tr >
                                        <th scope="col" style="border-top:1px solid orange;border-bottom:1px solid orange;">Department ID</th>
                                        <th scope="col" style="border-top:1px solid orange;border-bottom:1px solid orange;">Department Name</th>
                                        <th scope="col" style="border-top:1px solid orange;border-bottom:1px solid orange;">Current Employeed</th>
                                        <th scope="col" style="border-top:1px solid orange;border-bottom:1px solid orange;">Maximum Employees</th>
                                        <th scope="col" style="border-top:1px solid orange;border-bottom:1px solid orange;">Department Offset</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $qu = "select * from department";
                                    $re = $conn->query($qu) or die($conn->error);
                                    while ($p1 = $re->fetch_assoc()) {
                                    ?>
                                        <tr>
                                            <td><?php echo $p1['dept_id']; ?></td>
                                            <td><?php echo $p1['dept_name']; ?></td>
                                            <td><?php echo $p1['current_employeed']; ?></td>
                                            <td><?php echo $p1['max_empl']; ?></td>
                                            <td><?php echo $p1['dept_offset']; ?></td>
                                            
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-0">
                                    <button type="button" class="btn btn-primary" onclick="unhide()" name="register">
                                        Update
                                    </button>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-primary" onclick="unhide2()" name="register">
                                        Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <main class="py-4">
        <div class="container hoide">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            enter new details
                        </div>
                        <div class="card-body">
                            <form method="POST" id="myform">
                                <div class="form-group row">
                                    <label for="dept_id" class="col-md-4 col-form-label text-md-right">Department id</label>
                                    <div class="col-md-6">
                                        <input id="dept_id" type="number" class="form-control" name="dept_id" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="dept_name" class="col-md-4 col-form-label text-md-right">Department Name</label>
                                    <div class="col-md-6">
                                        <input id="dept_name" type="text" class="form-control" name="dept_name" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="max_emp" class="col-md-4 col-form-label text-md-right">Maximum Employees</label>
                                    <div class="col-md-6">
                                        <input id="max_emp" type="number" class="form-control" name="max_emp" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-5">
                                        <button type="submit" class="btn btn-primary" name="upunh">
                                            Update
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
    <main class="py-4 addnew">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            Enter Department details
                        </div>
                        <div class="card-body">
                            <form method="POST" id="myform">
                                <div class="form-group row">
                                    <label for="dept_name" class="col-md-4 col-form-label text-md-right">Department Name</label>
                                    <div class="col-md-6">
                                        <input id="dept_name" type="text" class="form-control" name="dept_name" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="max_emp" class="col-md-4 col-form-label text-md-right">Maximum Employees</label>
                                    <div class="col-md-6">
                                        <input id="max_emp" type="number" class="form-control" name="max_emp" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="dept_off" class="col-md-4 col-form-label text-md-right">Department Offset</label>
                                    <div class="col-md-6">
                                        <input id="dept_off" type="text" class="form-control" name="dept_off" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-5">
                                        <button type="submit" class="btn btn-primary" name="newap">
                                            Add
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
</body>

</html>
<?php
if (isset(($_POST['upunh']))) {
    $depid = $_POST['dept_id'];
    $depname = $_POST['dept_name'];
    $maxemp = $_POST['max_emp'];
    $que = "select * from department where dept_id='" . $depid . "'";
    $res = $conn->query($que) or die($conn->error);
    if ($res->num_rows > 0) {
        $que1 = "select * from department where dept_name='" . $depname . "'";
        $res1 = $conn->query($que1) or die($conn->error);
        if ($res1->num_rows == 0) {
            $que1 = "update department set dept_name='" . $depname . "',max_empl=" . $maxemp . " where dept_id='" . $depid . "'";
            $res1 = $conn->query($que1) or die($conn->error);
            header("Location: ./manageDept.php");
        } else {
            echo "already exist";
        }
    } else {
        echo "The department id doesn't exist";
    }
}
if (isset($_POST['newap'])) {
    $depoff = $_POST['dept_off'];
    $depname = $_POST['dept_name'];
    $maxemp = $_POST['max_emp'];
    $q = "select * from department where dept_name='" . $depname . "'";
    $r = $conn->query($q) or die($conn->error);
    if ($r->num_rows == 0) {
        $q = "select * from department where dept_offset='" . $depoff . "'";
        $r = $conn->query($q) or die($conn->error);
        if ($r->num_rows == 0) {
            $que = "select count(*) from department ";
            $res = $conn->query($que) or die($conn->error);
            $row = $res->fetch_assoc();
            $deptid = (int) $row['count(*)'] + 1;
            $que = "insert into department values (" . $deptid . ",'" . $depname . "',0," . $maxemp . ",'" . $depoff . "')";
            $re = $conn->query($que);
        } else {
            echo "Please select unique offset";
        }
    } else {
        echo "This department already exists";
    }
}
?>