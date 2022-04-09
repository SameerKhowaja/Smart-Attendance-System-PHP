<?php /* Created By Sameer Khowaja */ ?>
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
    $created_by=$_SESSION['username'];
    $updated_by=$created_by;
    
    try{
        $result=mysqli_query($conn,"INSERT INTO department (dept_name,dept_head_name,dept_area,dept_location,dept_phone,dept_comment,created_by,updated_by) VALUES('$dept_name','$dept_head_name','$dept_area','$dept_location','$dept_phone','$dept_comment','$created_by','$updated_by')");
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
    $updated_date=date('Y-m-d', $timestamp);
    
    session_start();
    $updated_by=$_SESSION['username'];

    try{
        $result=mysqli_query($conn, "UPDATE department SET dept_name='$dept_name', dept_head_name='$dept_head_name', dept_area='$dept_area', dept_location='$dept_location', dept_phone='$dept_phone', dept_comment='$dept_comment', updated_date='$updated_date', updated_by='$updated_by' WHERE dept_id='$dept_id'");
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
<?php /* Created By Sameer Khowaja */ ?>