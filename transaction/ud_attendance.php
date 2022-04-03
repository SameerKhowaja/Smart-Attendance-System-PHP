<?php
include('../dbcon.php');

// Update Attendance
if (isset($_POST['update_attendance'])){
    $attendance_id=mysqli_real_escape_string($conn, $_POST['attendance_id']);
    $page_url=mysqli_real_escape_string($conn, $_POST['page_url']);
    $date=mysqli_real_escape_string($conn, $_POST['date']);
    $timeIn=mysqli_real_escape_string($conn, $_POST['timeIn']);
    $timeOut=mysqli_real_escape_string($conn, $_POST['timeOut']);
    $timeIn_MA="M";
    $timeOut_MA="M";

    session_start();

    $query="";
    if($timeOut == NULL){
        $query="UPDATE attendance SET timeIn='$timeIn', timeIn_MA='$timeIn_MA' WHERE id='$attendance_id'";
        $_SESSION['transaction'] = "S";
    }
    else{
        if($timeOut <= $timeIn){
            $_SESSION['transaction'] = "E";
            header("Location: ../attendance/view_attendance.php?".$page_url);
        }
        else{
            $query="UPDATE attendance SET timeIn='$timeIn', timeIn_MA='$timeIn_MA', timeOut='$timeOut', timeOut_MA='$timeOut_MA' WHERE id='$attendance_id'";
            $_SESSION['transaction'] = "S";
        }
    }

    if($query!=""){
        try{
            $result=mysqli_query($conn, $query);
            if($result >= 1){
                $_SESSION['transaction'] = "S";
            }
            else{
                $_SESSION['transaction'] = "E";
            }
            header("Location: ../attendance/view_attendance.php?".$page_url);
        }
        catch(Exception $e) {
            $_SESSION['transaction'] = "E";
            header("Location: ../attendance/view_attendance.php?".$page_url);
        }
    }
}
// Delete Attendance
elseif (isset($_POST['delete_attendance'])){
    $attendance_id=mysqli_real_escape_string($conn, $_POST['attendance_id']);
    $page_url=$_POST['page_url'];
    
    session_start();
    try{
        $result=mysqli_query($conn,"DELETE FROM attendance WHERE id='$attendance_id'");
        if($result >= 1){
            $_SESSION['transaction'] = "S";
        }
        else{
            $_SESSION['transaction'] = "E";
        }
        header("Location: ../attendance/view_attendance.php?".$page_url);
    }
    catch(Exception $e) {
        $_SESSION['transaction'] = "E";
        header("Location: ../attendance/view_attendance.php?".$page_url);
    }
}
// Unknown Transaction
else{
    $_SESSION['transaction'] = "E";
    header("Location: ../attendance/view_attendance.php?".$page_url);
}
?>