<?php /* Created By Sameer Khowaja */ ?>
<?php
include('../dbcon.php');

// Filter the excel data 
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
} 

if (isset($_POST['attendance'])){
    $year=mysqli_real_escape_string($conn, $_POST['year']);
    $month=mysqli_real_escape_string($conn, $_POST['month']);
    $member_id=mysqli_real_escape_string($conn, $_POST['member_id']);
    $complete_check=mysqli_real_escape_string($conn, $_POST['complete_check']);

    $query="";
    // Means All Data YTD
    if($complete_check == 1){
        // All Members
        if($member_id == "all"){
            $query="SELECT m.member_id, m.formid_number, m.firstname, m.lastname, m.dept_id, d.dept_name, m.position, a.date, month(a.date) month, year(a.date) year, a.pod_ME, a.timeIn, a.timeIn_MA, a.timeOut, a.timeOut_MA FROM `attendance` a JOIN `member` m JOIN `department` d ON a.member_id=m.member_id AND d.dept_id=m.dept_id";
        }
        // Particular Member
        else{
            $query="SELECT m.member_id, m.formid_number, m.firstname, m.lastname, m.dept_id, d.dept_name, m.position, a.date, month(a.date) month, year(a.date) year, a.pod_ME, a.timeIn, a.timeIn_MA, a.timeOut, a.timeOut_MA FROM `attendance` a JOIN `member` m JOIN `department` d ON a.member_id=m.member_id AND d.dept_id=m.dept_id AND m.member_id='$member_id'";
        }
    }
    // Data by month & year
    else{
        // All members
        if($member_id == "all"){
            $query="SELECT m.member_id, m.formid_number, m.firstname, m.lastname, m.dept_id, d.dept_name, m.position, a.date, month(a.date) month, year(a.date) year, a.pod_ME, a.timeIn, a.timeIn_MA, a.timeOut, a.timeOut_MA FROM `attendance` a JOIN `member` m JOIN `department` d ON a.member_id=m.member_id AND d.dept_id=m.dept_id AND month(a.date)='$month' AND year(a.date)='$year'";
        }
        // Particular Member
        else{
            $query="SELECT m.member_id, m.formid_number, m.firstname, m.lastname, m.dept_id, d.dept_name, m.position, a.date, month(a.date) month, year(a.date) year, a.pod_ME, a.timeIn, a.timeIn_MA, a.timeOut, a.timeOut_MA FROM `attendance` a JOIN `member` m JOIN `department` d ON a.member_id=m.member_id AND d.dept_id=m.dept_id AND month(a.date)='$month' AND year(a.date)='$year' AND m.member_id='$member_id'";
        }
    }

    // Excel file name for download 
    $backup_datetime="";
    $mt = date('m');
    $dy = date('d');
    $yr = date('Y');
    $dateObj = DateTime::createFromFormat('!m', $mt);
    $mtn = $dateObj->format('F');
    $backup_datetime = '(' . $dy . '-' . $mtn . '-' . $yr . ')';
    $fileName = "attendance_data_" . $backup_datetime . ".xls"; 

    // Column names 
    $fields = array('MEMBER ID', 'FORM ID', 'FIRST NAME', 'LAST NAME', 'DEPARTMENT ID', 'DEPARTMENT NAME', 'POSITION', 'DATE', 'MONTHCD', 'MONTH', 'YEAR', 'PART OF DAY', 'AM/PM', 'TIME IN', 'TIME IN SOURCE', 'TIME OUT', 'TIME OUT SOURCE');

    // Display column names as first row 
    $excelData = implode("\t", array_values($fields)) . "\n"; 

    // Fetch records from database 
    $query = $conn->query($query); 
    if($query->num_rows > 0){ 
        // Output each row of the data 
        while($row = $query->fetch_assoc()){ 
            $pod_ME = ($row['pod_ME'] == 'am')?'Morning':"Evening"; 
            $monthNum  = $row['month'];
            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
            $monthName = $dateObj->format('F');
            $lineData = array($row['member_id'], $row['formid_number'], $row['firstname'], $row['lastname'], $row['dept_id'], $row['dept_name'], $row['position'], $row['date'], $row['month'], $monthName, $row['year'], $pod_ME, $row['pod_ME'], $row['timeIn'], $row['timeIn_MA'], $row['timeOut'], $row['timeOut_MA']); 
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
}

?>
<?php /* Created By Sameer Khowaja */ ?>