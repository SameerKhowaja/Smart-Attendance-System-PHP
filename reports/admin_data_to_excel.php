<?php
include('../dbcon.php');

// Filter the excel data 
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
} 

// Excel file name for download 
$backup_datetime="";
$mt = date('m');
$dy = date('d');
$yr = date('Y');
$dateObj = DateTime::createFromFormat('!m', $mt);
$mtn = $dateObj->format('F');
$backup_datetime = '(' . $dy . '-' . $mtn . '-' . $yr . ')';
$fileName = "administrator_data_" . $backup_datetime . ".xls"; 

// Column names 
$fields = array('USERNAME', 'FULL NAME', 'LAST LOGIN DATE', 'FULL ADMIN');

// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 

// Fetch records from database 
$query = $conn->query("SELECT username, fullname, last_login_date, deleteable FROM admin_user"); 
if($query->num_rows > 0){ 
    // Output each row of the data 
    while($row = $query->fetch_assoc()){ 
        $last_login_date = ($row['last_login_date'] == NULL)?'NEW':$row['last_login_date']; 
        $deleteable = ($row['deleteable'] == 0)?'YES':'NO'; 
        $lineData = array($row['username'], $row['fullname'], $last_login_date, $deleteable); 
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    } 
}else{ 
    $excelData .= 'No records found...'. "\n"; 
} 
 
// Headers for download 
header("Content-Type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=\"$fileName\""); 
echo $excelData;
?>