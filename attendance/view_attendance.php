<?php /* Created By Sameer Khowaja */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Member Attendance History</title>
        <!-- BOOTSTRAP STYLES-->
        <link href="../assets/css/bootstrap.css" rel="stylesheet" />
        <!-- FONTAWESOME STYLES-->
        <link href="../assets/css/font-awesome.css" rel="stylesheet" />
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
                font-size: 16px;"> Welcome: <?php echo $_SESSION['fullname']; ?> &nbsp; <a href="../logout.php" class="btn btn-danger square-btn-adjust">Logout</a> 
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
                    $member_id = ""; 
                    $year = ""; 
                    $month = "";    
                    
                    if (isset($_GET['member_id']) && isset($_GET['year']) && isset($_GET['month'])){
                        $member_id = mysqli_real_escape_string($conn, $_GET['member_id']); 
                        $year = mysqli_real_escape_string($conn, $_GET['year']);
                        $month = mysqli_real_escape_string($conn, $_GET['month']); 
                    }
                    ?>

                    <!-- /. ROW  -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Advanced Tables -->
                            <div>
                                <div class="panel-body">
                                    <div class="table-responsive" id="attendanceTable12">
                                        <table class="table table-striped table-hover table-responsive" id="dataTables-example12">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center;">Member ID</th>
                                                    <th style="text-align:center;">Full Name</th>
                                                    <th style="text-align:center;">Department</th>
                                                    <th style="text-align:center;">Designation</th>
                                                    <th style="text-align:center;">Year</th>
                                                    <th style="text-align:center;">Month</th>
                                                    <th style="text-align:center;">Presents (AM/PM)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            if (isset($member_id) && isset($year) && isset($month)){
                                                $query="SELECT m.member_id, m.firstname, m.lastname, m.position, d.dept_name, year(a.date) year, month(a.date) month, COUNT(a.timeIn) total_presents FROM `attendance` a JOIN `member` m JOIN `department` d ON m.member_id=a.member_id AND m.dept_id=d.dept_id WHERE m.member_id='$member_id' AND year(a.date)='$year' AND month(a.date)='$month' GROUP BY m.member_id, year, month";
                                                $user_query=mysqli_query($conn, $query)or die(mysqli_error());
                                                $rowcount=mysqli_num_rows($user_query);
                                                if($rowcount < 1){
                                                    echo "<h3 style='text-align:center;'>NO Data Found!</h3>";
                                                }
                                                else{
                                                    while($row=mysqli_fetch_array($user_query)){
                                                        $id=$row['member_id'];
                                            ?>
                                            <tr>
                                                <td style="text-align:center;"><?php echo $row['member_id']; ?></td>
                                                <td style="text-align:center;"><?php echo $row['firstname']." ".$row['lastname']; ?></td>
                                                <td style="text-align:center;"><?php echo $row['dept_name']; ?></td>
                                                <td style="text-align:center;"><?php echo $row['position']; ?></td>
                                                <td style="text-align:center;"><?php echo $row['year']; ?></td>
                                                <td style="text-align:center;">
                                                    <?php 
                                                        $monthNum  = $row['month'];
                                                        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                                        $monthName = $dateObj->format('F');
                                                        echo $monthName;
                                                    ?>
                                                </td>
                                                <td style="text-align:center;"><?php echo $row['total_presents']; ?></td>
                                            </tr>
                                            <?php } } }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
							</div>
                            <!--End Advanced Tables -->
                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <?php /* Created By Sameer Khowaja */ ?>
                    <!-- /. ROW  -->
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            if(isset($_SESSION['transaction']) && !empty($_SESSION['transaction'])){
                                if($_SESSION['transaction'] == "S"){    //success
                                    ?>
                                    <div class="alert alert-success alert-dismissible show" style="font-size:16px;">
                                        Transaction Completed Successfully...!
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php
                                }
                                elseif($_SESSION['transaction'] == "N"){    //no action
                                    ?>
                                    <div class="alert alert-info alert-dismissible show" style="font-size:16px;">
                                        Transaction Not Occurred Due To Some Reasons...!
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php
                                }
                                elseif($_SESSION['transaction'] == "E"){    //error
                                    ?>
                                    <div class="alert alert-danger alert-dismissible show" style="font-size:16px;">
                                        Transaction Failed Due To Some Reason...!
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php
                                }
                                //reset session variable
                                unset($_SESSION['transaction']);
                            }
                            ?>

                            <!-- Advanced Tables -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <b>Attendance History</b>
                                    <div class="pull-right">
                                        <a href="../attendance.php" type="button" class="btn btn-primary btn-xs">
                                            &nbsp;<b><</b>&nbsp; Back
                                        </a>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <div class="table-responsive" id="attendanceTable">
                                        <table class="table table-striped table-bordered table-hover table-responsive" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center;">Date</th>
                                                    <th style="text-align:center;">AM/PM</th>
                                                    <th style="text-align:center;">Time IN</th>
                                                    <th style="text-align:center;">Time IN Source</th>
                                                    <th style="text-align:center;">Time Out</th>
                                                    <th style="text-align:center;">Time Out Source</th>
                                                    <th style="text-align:center;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $query="SELECT a.id, a.member_id, a.date, a.pod_ME, timeIn, timeIn_MA, timeOut, timeOut_MA FROM `attendance` a WHERE a.member_id='$member_id' AND year(a.date)='$year' AND month(a.date)='$month'";
                                            $user_query=mysqli_query($conn, $query)or die(mysqli_error());
                                            while($row=mysqli_fetch_array($user_query)){
                                                $id=$row['id'];
                                            ?>
                                            <tr>
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

                                                <?php if((isset($_SESSION['update_attendance']) && $_SESSION['update_attendance']==1) || (isset($_SESSION['delete_attendance']) && $_SESSION['delete_attendance']==1)){ ?>
                                                <td style="width:220; text-align:center;">
                                                    <?php if(isset($_SESSION['update_attendance']) && $_SESSION['update_attendance']==1){ ?>
                                                        <a rel="tooltip" title="Update" id="<?php echo $id; ?>" href="#update_attendance<?php echo $id; ?>" data-toggle="modal" class="btn btn-warning btn-sm">Update</a>
                                                        <!-- Update Modal -->
                                                        <div class="modal fade" id="update_attendance<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="update_attendance<?php echo $id; ?>" aria-hidden="true">
                                                            <div class="modal-dialog modal-sm" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <div class="text-center">
                                                                            <h4><b>Update Attendace Data</b></h4>
                                                                        </div>
                                                                        <form method="post" action="../transaction/ud_attendance.php">
                                                                            <input type="hidden" class="form-control" id="attendance_id" name="attendance_id" value="<?php echo $id; ?>" readonly>
                                                                            <input type="hidden" class="form-control" id="page_url" name="page_url" value="<?php echo explode('?', $_SERVER['REQUEST_URI'])[1];?>" readonly>
                                                                            
                                                                            <table>
                                                                                <tbody style="text-align:left;">
                                                                                    <tr>
                                                                                        <td><b>Date</b></td>
                                                                                        <td style="padding-top:5px; padding-left:10px;"><input style="width:180px;" type="date" class="form-control" id="date" name="date" value="<?php echo $row['date']; ?>" required readonly></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><b>AM/PM</b></td>
                                                                                        <td style="padding-top:5px; padding-left:10px;"><input style="width:180px;" type="text" class="form-control" id="pod_ME" name="pod_ME" value="<?php echo $row['pod_ME']=="am" ? "Morning" : "Evening"; ?>" required disabled></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><b>Time In</b></td>
                                                                                        <td style="padding-top:5px; padding-left:10px;"><input style="width:180px;" type="time" class="form-control" id="timeIn" name="timeIn" value="<?php echo $row['timeIn'];?>" required></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><b>Time Out</b></td>
                                                                                        <td style="padding-top:5px; padding-left:10px;"><input style="width:180px;" type="time" class="form-control" id="timeOut" name="timeOut" value="<?php echo $row['timeOut']; ?>"></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <button style="margin-top:10px" class="btn btn-info" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Close</button>
                                                                                        </td>
                                                                                        <td>
                                                                                            <button style="margin-top:10px;width:150px;float:right;" name="update_attendance" type="submit" class="btn btn-danger"><i class="icon-save icon-large"></i>&nbsp;Update</button>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Update Modal -->
                                                    <?php } ?>
                            
                                                    <?php if(isset($_SESSION['delete_attendance']) && $_SESSION['delete_attendance']==1){ ?>
                                                        <a rel="tooltip" title="Delete" id="<?php echo $id; ?>" href="#delete_attendance<?php echo $id; ?>" data-toggle="modal" class="btn btn-danger btn-sm">Delete</a>
                                                        <!-- Delete Modal -->
                                                        <div class="modal fade" id="delete_attendance<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="delete_attendance<?php echo $id; ?>" aria-hidden="true">
                                                            <div class="modal-dialog modal-sm" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <div class="text-center">
                                                                            <h4><b>Delete Attendace Data</b></h4>
                                                                        </div>
                                                                        <form method="post" action="../transaction/ud_attendance.php">
                                                                            <div class="form-group">
                                                                                <input type="hidden" class="form-control" id="attendance_id" name="attendance_id" value="<?php echo $id; ?>" readonly>
                                                                                <input type="hidden" class="form-control" id="page_url" name="page_url" value="<?php echo explode('?', $_SERVER['REQUEST_URI'])[1];?>" readonly>
                                                                                <h5>Are you sure to DELETE Data?</h5>
                                                                            </div>
                                                                            <br>
                                                                            <div class="form-group">
                                                                                <button class="btn btn-info" data-dismiss="modal" aria-hidden="true">&nbsp;No</button>
                                                                                <button name="delete_attendance" type="submit" class="btn btn-danger"><i class="icon-save icon-large" style="width:50px;float:right;"></i>&nbsp;Yes</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Delete Modal -->
                                                    <?php } ?>
                                                </td>
                                                <?php 
                                                }else{
                                                    echo "<td style='width:220; text-align:center;'><b>Cannot Update/Delete</b></td>";
                                                } ?>

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