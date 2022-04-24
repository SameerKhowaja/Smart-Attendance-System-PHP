<?php /* Created By Sameer Khowaja */ ?>
<?php
include('../dbcon.php');

// Add Admin
if (isset($_POST['add_admin'])){
    $username=mysqli_real_escape_string($conn, $_POST['username']);
    $fullname=mysqli_real_escape_string($conn, $_POST['fullname']);
    $password=mysqli_real_escape_string($conn, $_POST['password']);
    $password_hash=password_hash($password, PASSWORD_BCRYPT);

    $deleteable=mysqli_real_escape_string($conn, $_POST['deleteable']);

    $add_member=0;
    $update_member=0;
    $delete_member=0;
    $add_department=0;
    $update_department=0;
    $delete_department=0;
    $update_attendance=0;
    $delete_attendance=0;
    $bulk_timeout=0;

    if($deleteable==0){ // Means Admin
        $add_member=1;
        $update_member=1;
        $delete_member=1;
        $add_department=1;
        $update_department=1;
        $delete_department=1;
        $update_attendance=1;
        $delete_attendance=1;
        $bulk_timeout=1;
    }

    session_start();
    try{
        $result=mysqli_query($conn, "INSERT INTO admin_user (username,fullname,password,deleteable,add_member,update_member,delete_member,add_department,update_department,delete_department,update_attendance,delete_attendance,bulk_timeout) VALUES('$username','$fullname','$password_hash','$deleteable','$add_member','$update_member','$delete_member','$add_department','$update_department','$delete_department','$update_attendance','$delete_attendance','$bulk_timeout')");
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
        header("Location: ../dashboard.php");
    }
    catch(Exception $e) {
        $_SESSION['transaction'] = "E";
        header("Location: ../dashboard.php");
    }
}
// Update Admin
elseif (isset($_POST['update_admin'])){
    $username=mysqli_real_escape_string($conn, $_POST['username']);
    $fullname=mysqli_real_escape_string($conn, $_POST['fullname']);
    
    $password=mysqli_real_escape_string($conn, $_POST['password']);
    $pass_query = "SELECT password FROM admin_user WHERE username='$username'";
    $pass_result = mysqli_query($conn, $pass_query)or die(mysqli_error());
    $num_row_pass = mysqli_num_rows($pass_result);
    $pass_row = mysqli_fetch_array($pass_result);
    if( $num_row_pass > 0 ) {
        if( $pass_row['password'] != $password ){
            $password=password_hash($password, PASSWORD_BCRYPT);
        }
    }
    else{
        echo "User not exist...!";
        die();
    }

    $deleteable=1;
    $add_member=0;
    $update_member=0;
    $delete_member=0;
    $add_department=0;
    $update_department=0;
    $delete_department=0;
    $update_attendance=0;
    $delete_attendance=0;
    $bulk_timeout=0;
    $qry="";
    
    if(isset($_POST['deleteable'])){
        $deleteable=mysqli_real_escape_string($conn, $_POST['deleteable']);

        if($deleteable==0){ // Means Admin
            $add_member=1;
            $update_member=1;
            $delete_member=1;
            $add_department=1;
            $update_department=1;
            $delete_department=1;
            $update_attendance=1;
            $delete_attendance=1;
            $bulk_timeout=1;
        }

        $qry="UPDATE admin_user SET fullname='$fullname', password='$password', deleteable='$deleteable', add_member='$add_member', update_member='$update_member', delete_member='$delete_member', add_department='$add_department', update_department='$update_department', delete_department='$delete_department', update_attendance='$update_attendance', delete_attendance='$delete_attendance', bulk_timeout='$bulk_timeout' WHERE username='$username'";
    }
    else{
        $qry="UPDATE admin_user SET fullname='$fullname', password='$password' WHERE username='$username'";
    }
    
    session_start();
    try{
        $result=mysqli_query($conn, $qry);
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

        // Same User
        if($_SESSION['username'] == $username){
            header("Location: ../index.php");
        }
        else{
            header("Location: ../dashboard.php");
        }
    }
    catch(Exception $e) {
        $_SESSION['transaction'] = "E";
        header("Location: ../dashboard.php");
    }
}
// Delete Admin
elseif (isset($_POST['delete_admin'])){
    $username=mysqli_real_escape_string($conn, $_POST['username']);
    
    session_start();
    try{
        $rowcount = 0;
        if ($_SESSION['username'] != $username){
            $result=mysqli_query($conn, "DELETE FROM admin_user WHERE username='$username'");
            $rowcount = mysqli_affected_rows($conn);
        }

        if($rowcount >= 1){
            $_SESSION['transaction'] = "S";
        }
        elseif($rowcount == 0){
            $_SESSION['transaction'] = "N";
        }
        else{
            $_SESSION['transaction'] = "E";
        }
        header("Location: ../dashboard.php");
    }
    catch(Exception $e) {
        $_SESSION['transaction'] = "E";
        header("Location: ../dashboard.php");
    }
}
// Update Roles
elseif(isset($_POST['update_role'])){
    $username=mysqli_real_escape_string($conn, $_POST['username']);
    $add_member=mysqli_real_escape_string($conn, $_POST['add_member']);
    $update_member=mysqli_real_escape_string($conn, $_POST['update_member']);
    $delete_member=mysqli_real_escape_string($conn, $_POST['delete_member']);
    $add_department=mysqli_real_escape_string($conn, $_POST['add_department']);
    $update_department=mysqli_real_escape_string($conn, $_POST['update_department']);
    $delete_department=mysqli_real_escape_string($conn, $_POST['delete_department']);
    $update_attendance=mysqli_real_escape_string($conn, $_POST['update_attendance']);
    $delete_attendance=mysqli_real_escape_string($conn, $_POST['delete_attendance']);
    $bulk_timeout=mysqli_real_escape_string($conn, $_POST['bulk_timeout']);

    session_start();
    try{
        $result=mysqli_query($conn, "UPDATE admin_user SET add_member='$add_member', update_member='$update_member', delete_member='$delete_member', add_department='$add_department', update_department='$update_department', delete_department='$delete_department', update_attendance='$update_attendance', delete_attendance='$delete_attendance', bulk_timeout='$bulk_timeout' WHERE username='$username'");
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
        header("Location: ../dashboard.php");
    }
    catch(Exception $e) {
        $_SESSION['transaction'] = "E";
        header("Location: ../dashboard.php");
    }
}
// Unknown Transaction
else{
    $_SESSION['transaction'] = "E";
    header("Location: ../dashboard.php");
}
?>
<?php /* Created By Sameer Khowaja */ ?>