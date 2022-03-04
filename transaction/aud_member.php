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
    $address=mysqli_real_escape_string($conn, $_POST['address']);



}

?>