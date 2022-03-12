<?php
include('../dbcon.php');

$member_id=mysqli_real_escape_string($conn, $_POST['member_id']);
$pod_ME=mysqli_real_escape_string($conn, $_POST['pod_ME']);
$date=mysqli_real_escape_string($conn, $_POST['date']);
$time_inout=mysqli_real_escape_string($conn, $_POST['time_inout']);
$msg="";

// Validation 
// (No twice time in/out on same day, if time in then make it out for that day else make it time in)
$query="SELECT timeIn, timeOut FROM attendance WHERE member_id='$member_id' AND pod_ME='$pod_ME' AND date='$date'";
$valdation_query=mysqli_query($conn, $query);
$rowcount=mysqli_num_rows($valdation_query);

$final_query="";
if($rowcount <= 0){
    // Time in manual
    $final_query="INSERT INTO attendance (member_id, pod_ME, date, timeIn, timeIn_MA) VALUES('$member_id','$pod_ME','$date','$time_inout','M')";
    $msg="Successfully Time In ".$time_inout." ".$date." !";
}
else{
    // Time in Exist
    // Check if Timeout exist and greater than Timein
    $row=mysqli_fetch_array($valdation_query);
    $time_in=$row[0];
    $time_out=$row[1];
    if($time_out==NULL && $time_inout>$time_in){
        // Time out manual
        $final_query="UPDATE attendance SET timeOut='$time_inout', timeOut_MA='M' WHERE member_id='$member_id' AND pod_ME='$pod_ME' AND date='$date'";
        $msg="Successfully Time Out ".$time_inout." ".$date." !";
    }
    elseif($time_out!=NULL){
        $msg="Error: Today's Time In & Out Exist Already !";
    }
    elseif($time_inout>=$time_in){
        $msg="Error: Time Out is Greater than Time In !";
    }
    else{
        $msg="Error: Database Malfunction !";
    }
}

if($final_query!=""){
    if (mysqli_query($conn, $final_query)) {
        echo json_encode(array("statusMsg"=>$msg, "statusCode"=>1));
    } 
    else {
        $msg="Error: Database Malfunction !";
        echo json_encode(array("statusMsg"=>$msg, "statusCode"=>0));
    }
}
else {
    echo json_encode(array("statusMsg"=>$msg, "statusCode"=>0));
}

mysqli_close($conn);
?>