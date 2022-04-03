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
$fileName = "department_data_" . $backup_datetime . ".xls"; 

// Column names 
$fields = array('DEPARTMENT ID', 'DEPARTMENT NAME', 'DEPARTMENT HEAD NAME', 'AREA', 'LOCATION', 'PHONE NUMBER', 'MEMBERS COUNT', 'COMMENT', 'UPDATED BY', 'UPDATED DATE');

// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 

// Fetch records from database 
$query = $conn->query("SELECT d.dept_id, d.dept_name, d.dept_head_name, d.dept_area, d.dept_location, d.dept_phone, COUNT(m.member_id) members_count, d.dept_comment, d.created_by, d.created_date, d.updated_by, d.updated_date FROM `department` d LEFT JOIN `member` m ON d.dept_id = m.dept_id GROUP BY d.dept_id"); 
if($query->num_rows > 0){ 
    // Output each row of the data 
    while($row = $query->fetch_assoc()){ 
        $updated_by = ($row['updated_by'] == NULL)?$row['created_by']:$row['updated_by']; 
        $updated_date = ($row['updated_date'] == NULL)?$row['created_date']:$row['updated_date'];  
        $lineData = array($row['dept_id'], $row['dept_name'], $row['dept_head_name'], $row['dept_area'], $row['dept_location'], $row['dept_phone'], $row['members_count'], $row['dept_comment'], $updated_by, $updated_date); 
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