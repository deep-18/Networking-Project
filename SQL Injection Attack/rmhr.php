<?php
    include 'dbcon.php';
    $depid=$_GET['q'];
    $qe="select emp_id from employee where dept_id='".$depid."' and is_hr=1";
    $re=$conn->query($qe) or die($conn->error);
    $row=$re->fetch_assoc();
    $empid=$row['emp_id'];
    echo "<script>console.log('".$empid."')</script>";
    $qe="update employee set is_hr=0 where emp_id='".$empid."'";
    $re=$conn->query($qe) or die($conn->error);
    $qe="update login set is_hr=0 where emp_id='".$empid."'";
    $re=$conn->query($qe) or die($conn->error);
?>