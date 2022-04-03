<?php
include('../dbcon.php');

// Filter the excel data 
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
} 

if (isset($_POST['memberByDepartment'])){
    $dept_id=mysqli_real_escape_string($conn, $_POST['dept_id']);
    
    if(isset($dept_id) && $dept_id != ""){
        // Excel file name for download 
        $backup_datetime="";
        $mt = date('m');
        $dy = date('d');
        $yr = date('Y');
        $dateObj = DateTime::createFromFormat('!m', $mt);
        $mtn = $dateObj->format('F');
        $backup_datetime = '(' . $dy . '-' . $mtn . '-' . $yr . ')';
        $fileName = "member_data_department_".$dept_id."_" . $backup_datetime . ".xls"; 

        // Column names 
        $fields = array('MEMBER ID', 'FORM ID', 'FIRST NAME', 'LAST NAME', 'DEPARTMENT ID', 'DEPARTMENT NAME', 'EMAIL', 'CONTACT NUMBER', 'DATE OF BIRTH', 'CNIC NUMBER', 'GENDER', 'MARITAL STATUS', 'DATE OF JOINING', 'POSITION', 'CITY', 'COUNTRY', 'ADDRESS', 'MEMBER QR CODE', 'STATUS', 'LEAVING DATE', 'LEAVING PURPOSE', 'CREATED DATE', 'CREATED BY', 'UPDATED DATE', 'UPDATED BY');


        // Display column names as first row 
        $excelData = implode("\t", array_values($fields)) . "\n"; 

        // Fetch records from database 
        $query = $conn->query("SELECT m.member_id, m.formid_number, m.firstname, m.lastname, m.dept_id, d.dept_name, m.email, m.contact_number, m.dob, m.cnic, m.gender, m.marital_status, m.doj, m.position, m.city, m.country, m.myaddress, m.member_qr, m.status, m.leaving_date, m.purpose_leaving, m.created_date, m.created_by, m.updated_date, m.updated_by FROM `member` m LEFT JOIN `department` d ON m.dept_id = d.dept_id WHERE m.dept_id='$dept_id'"); 
        if($query->num_rows > 0){ 
            // Output each row of the data 
            while($row = $query->fetch_assoc()){ 
                $status = ($row['status'] == 0)?'LEFT':"-"; 
                $lineData = array($row['member_id'], $row['formid_number'], $row['firstname'], $row['lastname'], $row['dept_id'], $row['dept_name'], $row['email'], $row['contact_number'], $row['dob'], $row['cnic'], $row['gender'], $row['marital_status'], $row['doj'], $row['position'], $row['city'], $row['country'], $row['myaddress'], $row['member_qr'], $status, $row['leaving_date'], $row['purpose_leaving'], $row['created_date'], $row['updated_date'], $row['leaving_date'], $row['updated_by']); 
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
    else{
        header("Location: ../report_backup.php");
    }
}
?>