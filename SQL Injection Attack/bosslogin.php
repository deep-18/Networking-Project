<?php
include 'dbcon.php';
session_start();
if (isset($_SESSION['bossname'])) {
  header("Location: ./bossdashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Boss Login</title>

  <!-- Bootstrap core CSS -->

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


  <link rel="stylesheet" href="./assets/css/bosslogin.css">

</head>

<body>
  
  <!-- Navbar -->

  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="./index.php">Emploo</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsDefault">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </nav>
  
  <div class="container h-50">
    <div class="container h-100 w-50" id="main">
      <div class="d-flex align-items-center justify-content-center h-100 ">
        <!-- <div class="d-flex flex-column">
          <h2 id="hes">Heading</h2>
          <img src="images/loginEmployee.png" class="img-fluid w-50" id="logo">
        </div> -->
        <div class="d-flex flex-column w-100">
          <div class="container">
            <form action="" method="POST">
              <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" style="border-color: #F38B34;" class="form-control" id="email" placeholder="Enter email" name="email" required>
              </div>
              <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" style="border-color: #F38B34;" class="form-control" id="pwd" placeholder="Enter password" name="pswd" required>
              </div>
              <div class="form-group form-check">
                <label class="form-check-label">
                  <input class="form-check-input" type="checkbox" name="remember"> Remember me
                </label>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-primary" name="login">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- PHP code -->


  <?php
  if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['pswd'];
    $sql = "SELECT * from bosslogin where username='" . $email . "'";
    $result = $conn->query($sql) or die($conn->error);
    $row = $result->fetch_assoc();
    if (mysqli_num_rows($result) > 0) {
      $_SESSION['bossname'] = "boss";
      if ($pass == $row['password']) {
        header("Location: ./bossdashboard.php");
      } else {
        echo "<script>alert('Wrong password')</script>";
      }
    } else {
      echo "<script>alert('The account does not exist')</script>";
    }
  }
  ?>

</body>

</html>