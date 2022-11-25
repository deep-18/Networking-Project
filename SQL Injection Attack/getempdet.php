
<?php 
    include 'dbcon.php';

    $id= $_GET['q'];
    $que="select * from employee where emp_id='".$id."'";
    $result=$conn->query($que) or die($conn->error);
    $row=$result->fetch_assoc();
    echo "<h4>Name:".$row['first_name']." ".$row['middle_name']." ".$row['last_name']."</h4>";
    echo "<h5>Gender:".$row['gender']."</h5>";
    echo "<h5>Post:".$row['post']."</h5>";
    echo "<h5>Birthday:".$row['birthdate']."</h5>";
    echo "<h5>Mob:".$row['phone']."</h5>";
    echo "<h5>Email:".$row['email']."</h5>";
    echo "<h5>Address:".$row['address']."</h5>";
    echo "<h5>".$row['state'].",".$row['country']."</h5>"; 
?>