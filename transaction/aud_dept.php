<?php
include('../dbcon.php');

// Add Department
if (isset($_POST['add_dept'])){
    $dept_name=mysqli_real_escape_string($conn, $_POST['dept_name']);
    $dept_head_name=mysqli_real_escape_string($conn, $_POST['dept_head_name']);
    $dept_area=mysqli_real_escape_string($conn, $_POST['dept_area']);
    $dept_location=mysqli_real_escape_string($conn, $_POST['dept_location']);
    $dept_phone=mysqli_real_escape_string($conn, $_POST['dept_phone']);
    $dept_comment=mysqli_real_escape_string($conn, $_POST['dept_comment']);

    session_start();

    try{
        $result=mysqli_query($conn,"INSERT INTO department (dept_name,dept_head_name,dept_area,dept_location,dept_phone,dept_comment) VALUES('$dept_name','$dept_head_name','$dept_area','$dept_location','$dept_phone','$dept_comment')");
        if($result >= 1){
            $_SESSION['transaction'] = "S";
        }
        else{
            $_SESSION['transaction'] = "E";
        }
        header("Location: ../department.php");
    }
    catch(Exception $e) {
        $_SESSION['transaction'] = "E";
        header("Location: ../department.php");
    }
}
// Update Department
elseif (isset($_POST['update_dept'])){
    $dept_id=mysqli_real_escape_string($conn, $_POST['dept_id']);
    $dept_name=mysqli_real_escape_string($conn, $_POST['dept_name']);
    $dept_head_name=mysqli_real_escape_string($conn, $_POST['dept_head_name']);
    $dept_area=mysqli_real_escape_string($conn, $_POST['dept_area']);
    $dept_location=mysqli_real_escape_string($conn, $_POST['dept_location']);
    $dept_phone=mysqli_real_escape_string($conn, $_POST['dept_phone']);
    $dept_comment=mysqli_real_escape_string($conn, $_POST['dept_comment']);
    
    $timestamp=filemtime(__FILE__);
    $dept_audit_timestamp=date('Y-m-d H:i:s', $timestamp);
    
    session_start();

    try{
        $result=mysqli_query($conn,"UPDATE department SET dept_name='$dept_name', dept_head_name='$dept_head_name' , dept_area = '$dept_area' , dept_location = '$dept_location' , dept_phone = '$dept_phone' , dept_comment = '$dept_comment' , dept_audit_timestamp = '$dept_audit_timestamp' WHERE dept_id='$dept_id'");
        if($result >= 1){
            $_SESSION['transaction'] = "S";
        }
        else{
            $_SESSION['transaction'] = "E";
        }
        header("Location: ../department.php");
    }
    catch(Exception $e) {
        $_SESSION['transaction'] = "E";
        header("Location: ../department.php");
    }
}
// Delete Department
elseif (isset($_POST['delete_dept'])){
    $dept_id=mysqli_real_escape_string($conn, $_POST['dept_id']);
    
    session_start();

    try{
        $result=mysqli_query($conn,"DELETE FROM department WHERE dept_id='$dept_id'");
        if($result >= 1){
            $_SESSION['transaction'] = "S";
        }
        else{
            $_SESSION['transaction'] = "E";
        }
        header("Location: ../department.php");
    }
    catch(Exception $e) {
        $_SESSION['transaction'] = "E";
        header("Location: ../department.php");
    }
}
// Unknown Transaction
else{
    $_SESSION['transaction'] = "E";
    header("Location: ../department.php");
}
?>