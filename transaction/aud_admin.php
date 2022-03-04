<?php
include('../dbcon.php');

// Add Admin
if (isset($_POST['add_admin'])){
    $username=mysqli_real_escape_string($conn, $_POST['username']);
    $fullname=mysqli_real_escape_string($conn, $_POST['fullname']);
    $password=mysqli_real_escape_string($conn, $_POST['password']);
    $deleteable=mysqli_real_escape_string($conn, $_POST['deleteable']);

    session_start();
    try{
        $result=mysqli_query($conn, "INSERT INTO admin_user (username,fullname,password,deleteable) VALUES('$username','$fullname','$password','$deleteable')");
        if($result >= 1){
            $_SESSION['transaction'] = "S";
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
    
    session_start();
    try{
        $result=0;
        if($_SESSION['deleteable'] == 0){
            $deleteable=mysqli_real_escape_string($conn, $_POST['deleteable']);
            $result=mysqli_query($conn, "UPDATE admin_user SET fullname='$fullname', password='$password', deleteable='$deleteable' WHERE username='$username'");
        }
        else{
            $result=mysqli_query($conn, "UPDATE admin_user SET fullname='$fullname', password='$password' WHERE username='$username'");
        }
        
        if($result >= 1){
            $_SESSION['transaction'] = "S";
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
        $result = 0;
        if ($_SESSION['username'] != $username){
            $result=mysqli_query($conn, "DELETE FROM admin_user WHERE username='$username'");
        }

        if($result >= 1){
            $_SESSION['transaction'] = "S";
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