<?php
include 'backup_function.php';

$server = 'localhost';
$username = 'root';
$password = '';
$dbname = 'dbsmartattendance';

backDb($server, $username, $password, $dbname);
header("Location: ../report_backup.php");
?>