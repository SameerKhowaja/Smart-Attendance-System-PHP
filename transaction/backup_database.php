<?php /* Created By Sameer Khowaja */ ?>
<?php
include '../dbcon.php';
include 'backup_function.php';

backDb($server, $username, $password, $dbname);
header("Location: ../report_backup.php");
?>
<?php /* Created By Sameer Khowaja */ ?>