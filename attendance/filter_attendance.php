<?php /* Created By Sameer Khowaja */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Filtered Attendance History</title>
        <!-- BOOTSTRAP STYLES-->
        <link href="../assets/css/bootstrap.css" rel="stylesheet" />
        <!-- FONTAWESOME STYLES-->
        <link href="../assets/css/font-awesome.css" rel="stylesheet" />
        <link rel="stylesheet" href="../assets/fontawesome-free/css/all.css">
        <!-- MORRIS CHART STYLES-->
    
            <!-- CUSTOM STYLES-->
        <link href="../assets/css/custom.css" rel="stylesheet" />
        <!-- GOOGLE FONTS-->
        <link href='../assets/cdn/font-sans.css' rel='stylesheet' type='text/css' />
        <!-- TABLE STYLES-->
        <link href="../assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
        <script src="../assets/cdn/jquery-min4.js"></script>
    </head>
    <?php include('../dbcon.php'); ?>
    <body>
        <?php include('../session.php'); ?>

        <div id="wrapper">
            <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="../dashboard.php">Administrator</a> 
                </div>
                <div style="color: white;
                padding: 15px 50px 5px 50px;
                float: right;
                font-size: 16px;"> Welcome: <?php echo $_SESSION['fullname']; ?> &nbsp; <a href="logout.php" class="btn btn-danger square-btn-adjust"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a> 
                </div>
            </nav>   
           
            <!-- /. NAV TOP  -->
            <nav class="navbar-default navbar-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="main-menu">
                        <li class="text-center">
                            <img src="../assets/images/logo.png" class="user-image img-responsive"/>
                        </li>
                        <li>
                            <a href="../dashboard.php"><i class="fa fa-dashboard fa-2x"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="../department.php"><i class="fa fa-desktop fa-2x"></i> Departments</a>
                        </li>
                        <li>
                            <a href="../member.php"><i class="fa fa-bar-chart-o fa-2x"></i> Members</a>
                        </li>
                        <li>
                            <a href="../memberByDepartment.php"><i class="fa fa-sitemap fa-2x"></i> Members By Department</a>
                        </li>	
                        <li>
                            <a type="button" data-toggle="modal" data-target="#qrCardGenerator"><i class="fa fa-qrcode fa-2x"></i> QR Card Generator</a>
                        </li>
                        <li>
                            <a class="active-menu" href="../attendance.php"><i class="fa fa-table fa-3x"></i> Manage Attendance</a>
                        </li>
                        <li>
                            <a href="../report_backup.php"><i class="fa fa-edit fa-2x"></i> Report/Backup</a>
                        </li>
                    </ul>
                </div>
            </nav> 

            <!-- /. NAV SIDE  -->
            <div id="page-wrapper" >
                <div id="page-inner">
                    <?php 
                    if (isset($_POST['filter_attendance'])){
                        $date=mysqli_real_escape_string($conn, $_POST['date']);                   
                        $year=mysqli_real_escape_string($conn, $_POST['year']);                   
                        $month=mysqli_real_escape_string($conn, $_POST['month']);                   
                        $member_id=mysqli_real_escape_string($conn, $_POST['member_id']);                   
                        $query_check=mysqli_real_escape_string($conn, $_POST['query_check']); 

                        $query="SELECT a.member_id, m.firstname, m.lastname, a.date, a.pod_ME, timeIn, timeIn_MA, timeOut, timeOut_MA FROM `attendance` a JOIN `member` m ON  a.member_id=m.member_id";

                        // For Date Check
                        if($query_check == "date"){
                            $query=$query." WHERE a.date='$date'";
                        }
                        // For Year Check
                        elseif($query_check == "year"){
                            $query=$query." WHERE year(a.date)='$year'";
                        }
                        // For Year & Month Check   
                        elseif($query_check == "year_month"){
                            $query=$query." WHERE year(a.date)='$year' AND month(a.date)='$month'";
                        }
                        else{
                            echo "<h3 style='text-align:center;'>NO Check Validation Exist!</h3>";
                            die();
                        }
                        
                        // For All Members
                        if($member_id == "all"){
                            $query=$query;
                        }
                        // For Selected Members
                        else{
                            $query=$query." AND member_id='$member_id'";
                        }
                    ?>
                    <?php /* Created By Sameer Khowaja */ ?>
                    <!-- /. ROW  -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Advanced Tables -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <b>Attendance History</b>
                                    <div class="pull-right">
                                        <a href="../attendance.php" type="button" class="btn btn-primary btn-xs">
                                            <i class="fa-solid fa-backward"></i> Back
                                        </a>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <div class="table-responsive" id="attendanceTable">
                                        <table class="table table-striped table-bordered table-hover table-responsive" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center;">Member ID</th>
                                                    <th style="text-align:center;">Member Full Name</th>
                                                    <th style="text-align:center;">Date</th>
                                                    <th style="text-align:center;">AM/PM</th>
                                                    <th style="text-align:center;">Time IN</th>
                                                    <th style="text-align:center;">Time IN Source</th>
                                                    <th style="text-align:center;">Time Out</th>
                                                    <th style="text-align:center;">Time Out Source</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $user_query=mysqli_query($conn, $query)or die(mysqli_error());
                                            while($row=mysqli_fetch_array($user_query)){
                                            ?>
                                                <tr>
                                                    <td style="text-align:center;"><?php echo $row['member_id']; ?></td>
                                                    <td style="text-align:center;"><?php echo $row['firstname']." ".$row['lastname']; ?></td>
                                                    <td style="text-align:center;"><?php echo $row['date']; ?></td>
                                                    <td style="text-align:center;"><?php echo $row['pod_ME']=="am" ? "Morning" : "Evening"; ?></td>
                                                    <td style="text-align:center;"><?php echo $row['timeIn']; ?></td>
                                                    <td style="text-align:center;"><?php echo $row['timeIn_MA']=="A" ? "QR" : "Manual"; ?></td>
                                                    <td style="text-align:center;"><?php echo $row['timeOut']; ?></td>
                                                    <td style="text-align:center;">
                                                        <?php 
                                                        if ($row['timeOut_MA']=="A"){
                                                            echo "QR";
                                                        } 
                                                        elseif($row['timeOut_MA']=="M"){
                                                            echo "Manual";
                                                        }
                                                        else{
                                                            echo "";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
							</div>
                            <!--End Advanced Tables -->
                        </div>
                    </div>
                    <!-- /. ROW  -->

                    <?php
                    }
                    else{
                        echo "<h3 style='text-align:center;'>NO Data Found!</h3>";
                    }               
                    ?>
                </div>       
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
        <!-- /. WRAPPER  -->

        <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
        <!-- Add Attendance Manually using Ajax Jquery -->
        <!-- JQUERY SCRIPTS -->
        <script src="../assets/js/jquery-1.10.2.js"></script>
        <!-- BOOTSTRAP SCRIPTS -->
        <script src="../assets/js/bootstrap.min.js"></script>
        <!-- METISMENU SCRIPTS -->
        <script src="../assets/js/jquery.metisMenu.js"></script>
        <!-- DATA TABLE SCRIPTS -->
        <script src="../assets/js/dataTables/jquery.dataTables.js"></script>
        <script src="../assets/js/dataTables/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
            $(document).ready(function () {
                $('.dataTables-memberQRList').dataTable();
            });
        </script>
        <!-- CUSTOM SCRIPTS -->
        <script src="../assets/js/custom.js"></script>
    </body>
</html>
<?php /* Created By Sameer Khowaja */ ?>