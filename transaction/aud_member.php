<?php /* Created By Sameer Khowaja */ ?>
<?php
include('../dbcon.php');

// Add Member
if (isset($_POST['add_member'])){
    $formid_number=mysqli_real_escape_string($conn, $_POST['formid_number']);
    $dept_id=mysqli_real_escape_string($conn, $_POST['dept_id']);
    $firstname=mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname=mysqli_real_escape_string($conn, $_POST['lastname']);
    $email=mysqli_real_escape_string($conn, $_POST['email']);
    $contact_number=mysqli_real_escape_string($conn, $_POST['contact_number']);
    $dob=mysqli_real_escape_string($conn, $_POST['dob']);
    $cnic=mysqli_real_escape_string($conn, $_POST['cnic']);
    $gender=mysqli_real_escape_string($conn, $_POST['gender']);
    $marital_status=mysqli_real_escape_string($conn, $_POST['marital_status']);
    $doj=mysqli_real_escape_string($conn, $_POST['doj']);
    $position=mysqli_real_escape_string($conn, $_POST['position']);
    $city=mysqli_real_escape_string($conn, $_POST['city']);
    $country=mysqli_real_escape_string($conn, $_POST['country']);
    $myaddress=mysqli_real_escape_string($conn, $_POST['myaddress']);
    $member_qr=$formid_number.$firstname.$lastname.$contact_number.$dob.$city;

    $image_file=addslashes(file_get_contents($_FILES["image_file"]["tmp_name"]));
    
    session_start();
    $created_by=$_SESSION['username'];
    $updated_by=$created_by;

    try{
        $result1=mysqli_query($conn, "INSERT INTO member (formid_number,dept_id,firstname,lastname,email,contact_number,dob,cnic,gender,marital_status,doj,position,city,country,myaddress,member_qr,image_file,created_by,updated_by) VALUES('$formid_number','$dept_id','$firstname','$lastname','$email','$contact_number','$dob','$cnic','$gender','$marital_status','$doj','$position','$city','$country','$myaddress','$member_qr','$image_file','$created_by','$updated_by')");
        if($result1 >= 1){
            $_SESSION['transaction'] = "S";
        }
        else{
            $_SESSION['transaction'] = "E";
        }
        header("Location: ../member.php");
    }
    catch(Exception $e) {
        $_SESSION['transaction'] = "E";
        header("Location: ../member.php");
    }
}
// Add Member
elseif (isset($_POST['update_member'])){
    $member_id=mysqli_real_escape_string($conn, $_POST['member_id']);
    $formid_number=mysqli_real_escape_string($conn, $_POST['formid_number']);
    $dept_id=mysqli_real_escape_string($conn, $_POST['dept_id']);
    $firstname=mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname=mysqli_real_escape_string($conn, $_POST['lastname']);
    $email=mysqli_real_escape_string($conn, $_POST['email']);
    $contact_number=mysqli_real_escape_string($conn, $_POST['contact_number']);
    $dob=mysqli_real_escape_string($conn, $_POST['dob']);
    $cnic=mysqli_real_escape_string($conn, $_POST['cnic']);
    $gender=mysqli_real_escape_string($conn, $_POST['gender']);
    $marital_status=mysqli_real_escape_string($conn, $_POST['marital_status']);
    $doj=mysqli_real_escape_string($conn, $_POST['doj']);
    $position=mysqli_real_escape_string($conn, $_POST['position']);
    $city=mysqli_real_escape_string($conn, $_POST['city']);
    $country=mysqli_real_escape_string($conn, $_POST['country']);
    $myaddress=mysqli_real_escape_string($conn, $_POST['myaddress']);
    $leaving_date=mysqli_real_escape_string($conn, $_POST['leaving_date']);
    $member_qr=mysqli_real_escape_string($conn, $_POST['member_qr']);
    $purpose_leaving="";
    $status=1;  // not left
    
    // contain something
    if($leaving_date != NULL){
        $status=0;  // left
        $purpose_leaving=mysqli_real_escape_string($conn, $_POST['purpose_leaving']);
    }

    $timestamp=filemtime(__FILE__);
    $updated_date=date('Y-m-d', $timestamp);

    $image_file=addslashes(file_get_contents($_FILES["image_file"]["tmp_name"]));
    
    session_start();
    $updated_by=$_SESSION['username'];

    if(isset($member_qr) && $member_qr!=''){
        $qr_result=mysqli_query($conn,"SELECT member_qr FROM member WHERE member_qr='$member_qr' AND member_id<>'$member_id'");
        $rowcount=mysqli_num_rows($qr_result);
        if($rowcount < 1){
            try{
                $result=0;
                if($image_file==NULL){
                    $result=mysqli_query($conn,"UPDATE member SET formid_number='$formid_number', dept_id='$dept_id', firstname='$firstname', lastname='$lastname', email='$email', contact_number='$contact_number', dob='$dob', cnic='$cnic', gender='$gender', marital_status='$marital_status', doj='$doj', position='$position', city='$city', country='$country', myaddress='$myaddress', member_qr='$member_qr', status='$status', leaving_date='$leaving_date', purpose_leaving='$purpose_leaving', updated_date='$updated_date', updated_by='$updated_by' WHERE member_id='$member_id'");
                }
                else{
                    $result=mysqli_query($conn,"UPDATE member SET formid_number='$formid_number', dept_id='$dept_id', firstname='$firstname', lastname='$lastname', email='$email', contact_number='$contact_number', dob='$dob', cnic='$cnic', gender='$gender', marital_status='$marital_status', doj='$doj', position='$position', city='$city', country='$country', myaddress='$myaddress', member_qr='$member_qr', image_file='$image_file', status='$status', leaving_date='$leaving_date', purpose_leaving='$purpose_leaving', updated_date='$updated_date', updated_by='$updated_by' WHERE member_id='$member_id'");
                }
                if($result >= 1){
                    $_SESSION['transaction'] = "S";
                }
                else{
                    $_SESSION['transaction'] = "E";
                }
                header("Location: ../member.php");
            }
            catch(Exception $e) {
                $_SESSION['transaction'] = "E";
                header("Location: ../member.php");
            }
        }
        else{
            $_SESSION['transaction'] = "E";
            header("Location: ../member.php");
        }        
    }
    else{
        $_SESSION['transaction'] = "E";
        header("Location: ../member.php");
    }
    
}
// Delete Department
elseif (isset($_POST['delete_member'])){
    $member_id=mysqli_real_escape_string($conn, $_POST['member_id']);
    
    session_start();

    try{
        $result=mysqli_query($conn,"DELETE FROM member WHERE member_id='$member_id'");
        if($result >= 1){
            $_SESSION['transaction'] = "S";
        }
        else{
            $_SESSION['transaction'] = "E";
        }
        header("Location: ../member.php");
    }
    catch(Exception $e) {
        $_SESSION['transaction'] = "E";
        header("Location: ../member.php");
    }
}
// Unknown Transaction
else{
    $_SESSION['transaction'] = "E";
    header("Location: ../member.php");
}
?>
<?php /* Created By Sameer Khowaja */ ?>