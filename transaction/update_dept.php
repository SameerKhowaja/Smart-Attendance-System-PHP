<?php
include('../dbcon.php');

if (isset($_POST['update_dept'])){
    $dept_id=$_POST['dept_id'];
    $dept_name=$_POST['dept_name'];
    $dept_head_name=$_POST['dept_head_name'];
    $dept_area=$_POST['dept_area'];
    $dept_location=$_POST['dept_location'];
    $dept_phone=$_POST['dept_phone'];
    $dept_comment=$_POST['dept_comment'];
    
    $timestamp=filemtime(__FILE__);
    $dept_audit_timestamp=date('Y-m-d H:i:s', $timestamp);
    
    $result=mysqli_query($conn,"UPDATE department SET dept_name='$dept_name', dept_head_name='$dept_head_name' , dept_area = '$dept_area' , dept_location = '$dept_location' , dept_phone = '$dept_phone' , dept_comment = '$dept_comment' , dept_audit_timestamp = '$dept_audit_timestamp' WHERE dept_id='$dept_id'")or die(mysqli_error());
    
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