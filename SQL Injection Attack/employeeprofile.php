<?php
include 'dbcon.php';
session_start();
if (!isset($_SESSION['username'])) {
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
    <title>Profile</title>

    <!-- Bootstrap core CSS -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="./assets/css/employeeprofile.css">
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark  shadow-sm">
        <div class="container">
            <?php
            if ($row1['is_hr'] == "0") {
            ?>
                <a class="navbar-brand" href="./userdashboard.php"><?php echo $row1['username'] ?></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsDefault">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarsDefault">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item mr-4">
                            <a href="./employeeprofile.php" class="nav-link active">Profile</a>
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
            <?php
            } else {
            ?>
                <a class="navbar-brand" href="./admindashboard.php"><?php echo $row1['username'] ?></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsDefault">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarsDefault">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active mr-4">
                            <a href="./employeeprofile.php" class="nav-link">Profile</a>
                        </li>
                        <li class="nav-item mr-4">
                            <a href="./signup.php" class="nav-link">Register</a>
                        </li>
                        <li class="nav-item mr-4">
                            <a href="./leaveapplications.php" class="nav-link">Leave Applications</a>
                        </li>
                        <li class="nav-item mr-4">
                            <a href="manageemployee.php" class="nav-link">Manage Employee</a>
                        </li>
                        <li class="nav-item  mr-4">
                            <form method="POST">
                                <button class="nav-link" name="logout" style="border:hidden; background-color:#343A40;">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            <?php
            }
            ?>
        </div>
    </nav>

    <main class="py-4">
        <div class="container-fluid">
            <div class="row">
                <div class="userInfo">
                    <img src=<?php echo $row['profile_pic'] ?> class="rounded-circle" alt="img">
                    <h1><?php echo $row['first_name'] . ' ' . $row['last_name'] ?></h1>
                </div>
                <form class="profile-index-form" method="POSt" action="" enctype="multipart/form-data">
                    <div class="col-lg-6 col-sm-12 profile-index-section-1">
                        <div class="basic-details-wrapper">
                            <hr />
                            <h4>Basic Details</h4>
                            <div class="form-group row">
                                <label for="first_name" class="col-md-4 col-form-label text-md-right">First Name</label>
                                <div class="col-md-6">
                                    <input id="first_name" type="text" class="form-control" name="first_name" value=<?php echo $row['first_name']; ?> required readonly autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="middle_name" class="col-md-4 col-form-label text-md-right">Middle Name</label>
                                <div class="col-md-6">
                                    <input id="middle_name" type="text" class="form-control" name="middle_name" value=<?php echo $row['middle_name']; ?> required readonly autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="last_name" class="col-md-4 col-form-label text-md-right">Last Name</label>
                                <div class="col-md-6">
                                    <input id="last_name" type="text" class="form-control" name="last_name" value=<?php echo $row['last_name']; ?> required readonly autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                                <div class="col-md-6">
                                    <input id="email" type="text" class="form-control" name="email" value=<?php echo $row['email']; ?> readonly required autofocus>
                                </div>
                            </div>
                            <?php
                            if ($row['edit_profile'] == 0) {
                            ?>
                            <div class="form-group row">
                                <label for="pswd" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input id="pswd" type="password" class="form-control" name="email" value=<?php echo $row['email']; ?>  required autofocus>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                            <div class="form-group row">
                                <label for="mobile" class="col-md-4 col-form-label text-md-right">Mobile Number</label>
                                <div class="col-md-6">
                                    <input id="mobile" type="text" class="form-control" name="mobile" value=<?php echo $row['phone']; ?> readonly required autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="user_name" class="col-md-4 col-form-label text-md-right">User Name</label>
                                <div class="col-md-6">
                                    <input id="user_name" type="text" class="form-control" name="user_name" value=<?php echo $row1['username']; ?> readonly required autofocus>
                                </div>
                            </div>
                        </div>

                        <div class="address-wrapper pt-5">
                            <hr />
                            <h4>Address</h4>
                            <?php
                            if ($row['edit_profile'] == 0) {
                            ?>
                                <div class="form-group row">
                                    <label for="lane1" class="col-md-4 col-form-label text-md-right">Address</label>

                                    <div class="col-md-6">
                                        <textarea id="address" type="textbox" class="form-control" name="address" required autofocus></textarea>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="state" class="col-md-4 col-form-label text-md-right">State</label>

                                    <div class="col-md-6">
                                        <input id="state" type="textbox" class="form-control" name="state" value="" required autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="country" class="col-md-4 col-form-label text-md-right">Country</label>

                                    <div class="col-md-6">
                                        <input id="country" type="textbox" class="form-control" name="country" value="" required autofocus>
                                    </div>
                                </div>
                        </div>
                    </div>


                    <div class="col-lg-6 col-sm-12 profile-index-section-2">
                        <div class="other-wrapper">
                            <hr />
                            <h4>Other Details</h4>
                            <div class="form-group row">
                                <label for="gender" class="col-md-4 col-form-label text-md-right">Gender</label>
                                <div class="col-md-6">
                                    <input id="male" type="radio" name="gender" value="M"><label>Male</label>
                                    <input id="female" type="radio" name="gender" value="F"><label>Female</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="marriage" class="col-md-4 col-form-label text-md-right">Marital Status</label>
                                <div class="col-md-6">
                                    <input id="unmarried" type="radio" name="marriage" value="0"><label>Unmarried</label>
                                    <input id="married" type="radio" name="marriage" value="1"><label>Married</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bday" class="col-md-4 col-form-label text-md-right">Birth Date</label>

                                <div class="col-md-6">
                                    <input id="bday" type="date" class="form-control" name="bday" required autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bank_acc" class="col-md-4 col-form-label text-md-right">Bank Account</label>
                                <div class="col-md-6">
                                    <input id="bank_acc" type="text" class="form-control" name="bank_acc" required autofcous>
                                </div>
                            </div>
                        </div>
                    <?php
                            } else {
                    ?>

                        <!-- BEgins -->

                        <div class="form-group row">
                            <label for="lane1" class="col-md-4 col-form-label text-md-right">Address</label>

                            <div class="col-md-6">
                                <textarea id="address" style="border:1px solid #F38B34;" class="form-control" name="address" required autofocus><?php echo $row['address']; ?> </textarea>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="state" class="col-md-4 col-form-label text-md-right">State</label>

                            <div class="col-md-6">
                                <input id="state" type="textbox" class="form-control" name="state" value=<?php echo $row['state']; ?> required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="country" class="col-md-4 col-form-label text-md-right">Country</label>

                            <div class="col-md-6">
                                <input id="country" type="textbox" class="form-control" name="country" value=<?php echo $row['country']; ?> required autofocus>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="col-lg-6 col-sm-12 profile-index-section-2">
                <div class="education-wrapper">
                    <hr />
                    <h4>Other Details</h4>
                    <div class="form-group row">
                        <label for="gender" class="col-md-4 col-form-label text-md-right">Gender</label>
                        <div class="col-md-6">
                            <input id="male" type="radio" name="gender" value="M" <?php if ($row['gender'] == "M") echo "checked" ?>><label>Male</label>
                            <input id="female" type="radio" name="gender" value="F" <?php if ($row['gender'] == "F") echo "checked" ?>><label>Female</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="marriage" class="col-md-4 col-form-label text-md-right">Marital Status</label>
                        <div class="col-md-6">
                            <input id="unmarried" type="radio" name="marriage" value="0" <?php if ($row['marital'] == "0") echo "checked" ?>><label>Unmarried</label>
                            <input id="married" type="radio" name="marriage" value="1" <?php if ($row['marital'] == "1") echo "checked" ?>><label>Married</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bday" class="col-md-4 col-form-label text-md-right">Birth Date</label>

                        <div class="col-md-6">
                            <input id="bday" type="date" class="form-control" name="bday" value=<?php echo $row['birthdate']; ?> requirede autofocus>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bank_acc" class="col-md-4 col-form-label text-md-right">Bank Account</label>
                        <div class="col-md-6">
                            <input id="bank_acc" type="text" class="form-control" name="bank_acc" value=<?php echo $row['account_number']; ?> required autofcous>
                        </div>
                    </div>
                </div>

                <!-- Ends -->


            <?php
                            }
            ?>
            <div class="image-wrapper pt-5 mt-5">
                <hr />
                <h4>Change Profile Image</h4>

                <div class="form-group row">
                    <label for="img" class="col-md-4 col-form-label text-md-right">Profile Image</label>
                    <div class="col-md-6">
                        <input id="img" type="file" class="form-control" name="img" accept="image/*" autofocus>
                    </div>
                </div>
            </div>
            <div class="button-wrapper p-5 m-5">
                <button class="btn btn-primary" id="profileBtn" type="submit" name="save">Save Changes</button>
            </div>
            </div>
            </form>
        </div>
        </div>
    </main>


    <?php
    if (isset($_POST['save'])) {
        $addr = $_POST['address'];
        $state = $_POST['state'];
        if ($row['edit_profile'] == 0) {
            $password=$_POST['pswd'];
            $ins=$conn->query("update login set password='".$password."' where emp_id='".$_SESSION['username']."'");
        }
        $country = $_POST['country'];
        $gender = $_POST['gender'];
        $martial = $_POST['marriage'];
        $bday = $_POST['bday'];
        $bank = $_POST['bank_acc'];
        if (isset($_FILES['img']['name'])) {
            $file = $_FILES['img'];
            $filename = $_FILES['img']['name'];
            if (empty($filename)) {
                $fileDestination = $row['profile_pic'];
            } else {
                $fileTmpName = $_FILES['img']['tmp_name'];
                $fileSize = $_FILES['img']['size'];
                $fileExt = explode('.', $filename);
                $fileActualExt = strtolower(end($fileExt));
                if ($fileSize < 1000000) {
                    $fileNameNew = $_SESSION['username'] . "." . $fileActualExt;
                    $fileDestination = "./storage/profile_images/" . $fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                }
            }
        }
        $ins = "update employee set gender='" . $gender . "',birthdate='" . $bday . "',marital=" . $martial . ",address='" . $addr . "',state='" . $state . "',country='" . $country . "',account_number='" . $bank . "',profile_pic='" . $fileDestination . "',edit_profile=1 where emp_id='" . $_SESSION['username'] . "'";
        $ins1 = $conn->query($ins) or die($conn->error);
    }
    ?>
</body>

</html>