<?php
include('../dbcon.php');

$member_qr=mysqli_real_escape_string($conn, $_POST['member_qr']);
$member_id="";
$pod_ME="";
$date="";
$time_inout="";
$msg="";
$final_query="";

// GET member_id from member_qr
$query1="SELECT member_id FROM member WHERE member_qr='$member_qr'";
$sql_query1=mysqli_query($conn, $query1);
$rowcount1=mysqli_num_rows($sql_query1);

if($rowcount1 > 0){
    $member_id=mysqli_fetch_array($sql_query1)[0]; // member_id

    $month = date('m');
    $day = date('d');
    $year = date('Y');
    $date = $year . '-' . $month . '-' . $day;  // date

    $hour = date('H');
    $minute = date('i');
    $second = date('s');
    $time_inout = $hour . ":" . $minute . ":" . $second;

    $am_pm = date('a');
    $pod_ME = $am_pm=="am" ? "M" : "E";

    // Validation 
    // (No twice time in/out on same day, if time in then make it out for that day else make it time in)
    $query2="SELECT timeIn, timeOut FROM attendance WHERE member_id='$member_id' AND pod_ME='$pod_ME' AND date='$date'";
    $valdation_query=mysqli_query($conn, $query2);
    $rowcount2=mysqli_num_rows($valdation_query);

    if($rowcount2 <= 0){
        // Time in manual
        $final_query="INSERT INTO attendance (member_id, pod_ME, date, timeIn, timeIn_MA) VALUES('$member_id','$pod_ME','$date','$time_inout','A')";
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
            $final_query="UPDATE attendance SET timeOut='$time_inout', timeOut_MA='A' WHERE member_id='$member_id' AND pod_ME='$pod_ME' AND date='$date'";
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
}
else{
    $msg="Error: No Such QR Code Exists !";
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