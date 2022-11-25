<?php
    include 'dbcon.php';
    $empid=$_GET['q'];
    $qe="update employee set is_hr=1 where emp_id='".$empid."'";
    $re=$conn->query($qe) or die($conn->error);
    $qe="update login set is_hr=1 where emp_id='".$empid."'";
    $re=$conn->query($qe) or die($conn->error);
    
?>