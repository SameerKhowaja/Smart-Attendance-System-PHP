<?php
include('../dbcon.php');

if (isset($_POST['delete_dept'])){
    $dept_id=$_POST['dept_id'];
    $result=mysqli_query($conn,"DELETE FROM department WHERE dept_id='$dept_id'")or die(mysqli_error());

    session_start();
    if($result == 1){
        $_SESSION['transaction'] = "S";
    }
    else{
        $_SESSION['transaction'] = "E";
    }

    header("Location: ../department.php");
}
?>