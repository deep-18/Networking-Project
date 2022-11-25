<?php
include 'dbcon.php';
session_start();
if (!isset($_SESSION['username'])) {
    if ($_SESSION['admin'] == 1)
        header("location:./admindashboard.php");
    else
        header("location:./userdashboard.php");
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
    <title>Register</title>

    <!-- Bootstrap core CSS -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <link rel="stylesheet" href="./assets/css/signup.css">
</head>

<body>

    <div class="my_navbar">

        <!-- Navigation bar -->

        <nav class="navbar navbar-expand-md navbar-dark bg-dark  shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="./admindashboard.php"><?php echo $usr['username'] ?></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsDefault">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarsDefault">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item mr-4">
                            <a href="./employeeprofile.php" class="nav-link">Profile</a>
                        </li>
                        <li class="nav-item mr-4">
                            <a href="./signup.php" class="active nav-link">Register</a>
                        </li>
                        <li class="nav-item mr-4">
                            <a href="./leaveapplications.php" class="nav-link">Leave Applications</a>
                        </li>
                        <li class="nav-item mr-4">
                            <a href="./manageemployee.php" class="nav-link">Manage Employee</a>
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
        <?php
        if (isset($_POST['register'])) {
            $sql = "SELECT employee.dept_id,department.current_employeed,department.dept_offset,department.max_empl from employee,department where emp_id='" . $_SESSION['username'] . "' and employee.dept_id=department.dept_id";
            $result = $conn->query($sql) or die($conn->error);
            $row = $result->fetch_assoc();
            $user = $_POST['user_name'];
            $first = $_POST['first_name'];
            $mid = $_POST['mid_name'];
            $last = $_POST['last_name'];
            $email = $_POST['email'];
            $mob = $_POST['mob_num'];
            $post = $_POST['post'];
            $sql2 = "select * from login where username='" . $user . "'";
            $result1 = $conn->query($sql2) or die($conn->error);
            $pass = $user;
            if ($result1->num_rows > 0) {
        ?>
                <p style="color:red">This username already exists</p>
        <?php
            } else {
                if ($row != false) {
                    if ((int) $row['current_employeed'] >= (int) $row['max_empl']) {
                        echo "<script>alert('Your Department is full')</script>";
                    } else {
                        $eid1 = (int) ($row['current_employeed'] + 1);
                        $sql2 = "update department set current_employeed=" . $eid1 . " where dept_id=" . $row['dept_id'];
                        $conn->query($sql2) or die($conn->error);
                        $eid = $row['dept_offset'] . (string) $eid1;
                        $sql1 = "insert into login values ('" . $eid . "','" . $user . "','" . $pass . "','0','" . date("Y/m/d") . "')";
                        $result1 = $conn->query($sql1) or die($conn->error);
                        $sql2 = "insert into employee(emp_id,first_name,middle_name,last_name,post,dept_id,phone,email) values ('" . $eid . "','" . $first . "','" . $mid . "','" . $last . "','" . $post . "'," . (int) $row['dept_id'] . ",'" . $mob . "','" . $email . "')";
                        echo $sql2;
                        $result2 = $conn->query($sql2) or die($conn->error);
                        header("location:./signup.php");
                    }
                }
            }
        }
        ?>


        <!-- Register form -->

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                User Register
                            </div>
                            <div class="card-body">
                                <form method="POST" id="myform">
                                    <div class="form-group row">
                                        <label for="user_name" class="col-md-4 col-form-label text-md-right">User Name</label>
                                        <div class="col-md-6">
                                            <input id="user_name" type="text" class="form-control" name="user_name" required>
                                            <p id="invaliduser" style="color:red;display:none">This username already exists</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="first_name" class="col-md-4 col-form-label text-md-right">First Name</label>
                                        <div class="col-md-6">
                                            <input id="first_name" type="text" class="form-control" name="first_name" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="mid_name" class="col-md-4 col-form-label text-md-right">Middle Name</label>
                                        <div class="col-md-6">
                                            <input id="mid_name" type="text" class="form-control" name="mid_name" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="last_name" class="col-md-4 col-form-label text-md-right">Last Name</label>
                                        <div class="col-md-6">
                                            <input id="last_name" type="text" class="form-control" name="last_name" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">Email Id</label>
                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control" name="email" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="mob_num" class="col-md-4 col-form-label text-md-right">Mobile Number</label>
                                        <div class="col-md-6">
                                            <input id="mob_num" type="number" class="form-control" name="mob_num" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="post" class="col-md-4 col-form-label text-md-right">Post</label>
                                        <div class="col-md-6">
                                            <input id="post" type="text" class="form-control" name="post" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-5">
                                            <button type="submit" class="btn btn-primary" class="register" name="register" data-toggle="modal" data-target="#myModal">
                                                Register
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

        <!-- Form ends here -->
    </div>

    <!-- Main div ends here -->

</body>

</html>