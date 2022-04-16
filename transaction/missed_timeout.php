<?php /* Created By Sameer Khowaja */ ?>
<?php
include('../dbcon.php');

$date=mysqli_real_escape_string($conn, $_POST['date']);
$year=mysqli_real_escape_string($conn, $_POST['year']);
$month=mysqli_real_escape_string($conn, $_POST['month']);
$member_id=mysqli_real_escape_string($conn, $_POST['member_id']);
$query_check=mysqli_real_escape_string($conn, $_POST['query_check']);
$addHours=mysqli_real_escape_string($conn, $_POST['addHours']);
$addMinutes=mysqli_real_escape_string($conn, $_POST['addMinutes']);
$addHourMinutes=$addHours.".".$addMinutes;
$timeOut_MA="M";

$final_query="UPDATE attendance SET timeOut_MA = 'M', timeOut = CASE WHEN DATE_ADD(timeIn,interval '$addHourMinutes' HOUR_MINUTE) > '23:59:00' THEN '23:59:00' ELSE DATE_ADD(timeIn,interval '$addHourMinutes' HOUR_MINUTE) END WHERE timeOut IS NULL";

// Add Hours to timein and set timeout
if(isset($_POST['timeout'])){
    // For date check
    if($query_check == "date"){
        // For All Members
        if($member_id == "all"){
            $final_query=$final_query." AND date='$date'";
        }
        // For Selected Members
        else{
            $final_query=$final_query." AND date='$date' AND member_id='$member_id'";
        }
    }
    // For year & month check
    elseif($query_check == "year_month"){
        // For All Members
        if($member_id == "all"){
            $final_query=$final_query." AND year(date)='$year' AND month(date)='$month'";
        }
        // For Selected Members
        else{
            $final_query=$final_query." AND year(date)='$year' AND month(date)='$month' AND member_id='$member_id'";
        }
    }

    session_start();
    try{
        $result=mysqli_query($conn, $final_query);
        $rowcount = mysqli_affected_rows($conn);
        
        if($rowcount >= 1){
            $_SESSION['transaction'] = "S";
        }
        elseif($rowcount == 0){
            $_SESSION['transaction'] = "N";
        }
        else{
            $_SESSION['transaction'] = "E";
        }
        header("Location: ../attendance.php");
    }
    catch(Exception $e) {
        $_SESSION['transaction'] = "E";
        header("Location: ../attendance.php");
    }
}

?>
<?php /* Created By Sameer Khowaja */ ?>