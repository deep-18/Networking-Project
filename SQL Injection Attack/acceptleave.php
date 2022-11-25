<?php
    include 'dbcon.php';
    $id=(int)$_GET['q'];
    $t=time();
    $ts=date("Y-m-d H:i:s",$t);
    $qu="update leavedet set status=1,pending=0,timeee='".$ts."' where leave_id=".$id;
    $result=$conn->query($qu);  
?>