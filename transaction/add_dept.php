<?php
include('../dbcon.php');

if (isset($_POST['add_dept'])){
    $dept_name=$_POST['dept_name'];
    $dept_head_name=$_POST['dept_head_name'];
    $dept_area=$_POST['dept_area'];
    $dept_location=$_POST['dept_location'];
    $dept_phone=$_POST['dept_phone'];
    $dept_comment=$_POST['dept_comment'];
    $result=mysqli_query($conn,"INSERT INTO department (dept_name,dept_head_name,dept_area,dept_location,dept_phone,dept_comment) VALUES('$dept_name','$dept_head_name','$dept_area','$dept_location','$dept_phone','$dept_comment')")or die(mysqli_error());
    
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