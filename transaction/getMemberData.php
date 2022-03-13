<?php
include('../dbcon.php');

$member_id=mysqli_real_escape_string($conn, $_POST['member_id']);
$query="SELECT m.position, d.dept_name FROM member m JOIN department d ON m.dept_id=d.dept_id WHERE m.member_id='$member_id'";
$sql_query=mysqli_query($conn, $query);
$rowcount=mysqli_num_rows($sql_query);

$dept_name="No Data";
$position="No Data";

if($rowcount > 0){
    $rtn_arr=mysqli_fetch_array($sql_query);
    $position=$rtn_arr[0];
    $dept_name=$rtn_arr[1];
}

echo json_encode(array("position"=>$position, "dept_name"=>$dept_name));
?>