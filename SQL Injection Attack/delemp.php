<?php
    include 'dbcon.php';
    $id=$_GET['q'];
    
    //Deleting employee's leave requests 

    $que = "delete from leavedet where emp_id='".$id."'";
    $result=$conn->query($que) or die($conn->error);

    //Deleting employee's login details

    $que = "delete from login where emp_id='".$id."'";
    $result=$conn->query($que) or die($conn->error);

    //Fetching employee's department

    $que2="select dept_id from employee where emp_id='".$id."'";
    $result1=$conn->query($que2) or die($conn->error);
    $row=$result1->fetch_assoc();
    $dep=(int)$row['dept_id'];
    //Deleting employee from employee's details
    
    $que = "delete from employee where emp_id='".$id."'";
    $result=$conn->query($que) or die($conn->error);

    //Fetching department id of the employee

    $que3="select * from department where dept_id=".$dep;
    $result=$conn->query($que3) or die($conn->error);
    $row1=$result->fetch_assoc();
    $no=(int)$row1['current_employeed']-1;

    //Updating the number of current employees employeed


    $que4="update department set current_employeed=".$no." where dept_id=".$dep."";
    echo $que4;
    $result2=$conn->query($que4) or die($conn->error);
?>