<?php
    $hostname="localhost";
    $username="root";
    $password="";
    $database_name="employeedb";
    $conn=new mysqli($hostname,$username,$password,$database_name);
    if(mysqli_connect_error()){
        echo "<script>alert('Database connection failed')</script>";
    }
?>