<?php
    include 'dbcon.php';
    $deptid=(int)$_GET['q'];
    $qe="select * from employee where dept_id=".$deptid." and is_hr=1";
    $re=$conn->query($qe) or die($conn->error);
    if($re->num_rows>0)
    {
        $p1=$re->fetch_assoc();
        echo "A HR is already alloted for this department";
        echo "<br>";
        echo "
        <table class='table table-hover table-striped'>
                <thead>
                    <tr>
                        <th>EmployeeID</th>
                        <th>Firstname</th>
                        <th>Middlename</th>
                        <th>Lastname</th>
                        <th>Post</th>
                        <th>Salary</th>
                    </tr>
                </thead>
                <tbody>";
        echo"            <tr>";
        echo"               <td>".$p1['emp_id']."</td>";
        echo"               <td>".$p1['first_name']."</td>";
        echo"               <td>".$p1['middle_name']."</td>";
        echo"               <td>".$p1['last_name']."</td>";
        echo"               <td>".$p1['post']."</td>";
        echo"               <td>".$p1['salary']."</td>";
        echo"   </tbody>";
        echo"</table>";
        echo "Click the button to immediately remove the current HR";
            echo "
            <form method='POST'>
                <div class='form-group row mb-0'>
                    <div class='col-md-6 offset-md-5'>
                        <button type='button' class='btn btn-danger' id='del' value='".$deptid."' onclick='remEmp()'>
                        Delete
                        </button>
                    </div>
            </div>
                </div>
            </form>
            ";
    }
    else
    {
        $qe="select * from employee where dept_id=".$deptid." and is_hr=0";
        $re=$conn->query($qe) or die($conn->error);
        if($re->num_rows==0)
        {
            echo "<h2>There are no employees in this department</h2>";
            echo "<br>";
            echo "Click the button to add employee and then appoint him/her as HR";
            echo "
            <form method='POST' action='./addbyboss.php'>
                <div class='form-group row mb-0'>
                    <div class='col-md-6 offset-md-5'>
                        <input type=hidden value='".$deptid."' name='deptid'>
                        <button type='submit' class='btn btn-primary' name='del'>
                        Add
                        </button>
                    </div>
            </div>
                </div>
            </form>
            ";
        }
        else
        {
            echo "
            <table class='table table-hover table-striped'>
                <thead>
                    <tr>
                        <th>select</th>
                        <th>Firstname</th>
                        <th>Middlename</th>
                        <th>Lastname</th>
                    </tr>
                </thead>
                <tbody>";
            while($ro=$re->fetch_assoc())
            {
                echo "<tr>";
                echo "  <td><input type=radio name='sel_hr' value='".$ro['emp_id']."'></td>";
                echo    "<td>".$ro['first_name']."</td>";
                echo    "<td>".$ro['middle_name']."</td>";
                echo    "<td>".$ro['last_name']."</td>";
                echo "</tr>";
            }
            echo "
                </tbody>
            </table> 
            <h4>Make selected candidate HR</h4>
            <form method='POST'>
                <div class='form-group row mb-0'>
                    <div class='col-md-6 offset-md-5'>
                        <button type='button' class='btn btn-primary'  onclick='make()'>
                        Make
                        </button>
                    </div>
                </div>
                </div>
            </form>   
            ";
        }
    }
?>