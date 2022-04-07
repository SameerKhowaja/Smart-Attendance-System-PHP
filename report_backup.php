<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Reports & Backup</title>
        <!-- BOOTSTRAP STYLES-->
        <link href="assets/css/bootstrap.css" rel="stylesheet" />
        <!-- FONTAWESOME STYLES-->
        <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- MORRIS CHART STYLES-->
    
            <!-- CUSTOM STYLES-->
        <link href="assets/css/custom.css" rel="stylesheet" />
        <!-- GOOGLE FONTS-->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
        <!-- TABLE STYLES-->
        <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    </head>
    <?php include('dbcon.php'); ?>
    <body>
        <?php include('session.php'); ?>

        <div id="wrapper">
            <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="dashboard.php">Administrator</a> 
                </div>
                <div style="color: white;
                padding: 15px 50px 5px 50px;
                float: right;
                font-size: 16px;"> Welcome: <?php echo $_SESSION['fullname']; ?> &nbsp; <a href="logout.php" class="btn btn-danger square-btn-adjust">Logout</a> 
                </div>
            </nav>   
           
            <!-- /. NAV TOP  -->
            <nav class="navbar-default navbar-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="main-menu">
                        <li class="text-center">
                            <img src="assets/images/logo.png" class="user-image img-responsive"/>
                        </li>
                        <li>
                            <a href="dashboard.php"><i class="fa fa-dashboard fa-2x"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="department.php"><i class="fa fa-desktop fa-2x"></i> Departments</a>
                        </li>
                        <li>
                            <a href="member.php"><i class="fa fa-bar-chart-o fa-2x"></i> Members</a>
                        </li>
                        <li>
                            <a href="memberByDepartment.php"><i class="fa fa-sitemap fa-2x"></i> Members By Department</a>
                        </li>	
                        <li>
                            <a type="button" data-toggle="modal" data-target="#qrCardGenerator"><i class="fa fa-qrcode fa-2x"></i> QR Card Generator</a>
                        </li>
                        <li>
                            <a href="attendance.php"><i class="fa fa-table fa-2x"></i> Manage Attendance</a>
                        </li>
                        <li>
                            <a class="active-menu" href="report_backup.php"><i class="fa fa-edit fa-3x"></i> Report/Backup</a>
                        </li>
                    </ul>
                </div>
            </nav> 

            <!-- Members By Department Modal -->
            <div class="modal fade" id="memberByDepartment" tabindex="-1" role="dialog" aria-labelledby="memberByDepartment" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                <h4><b>Member By Department</b></h4>
                            </div>
                            <form method="post" action="reports/memberByDepartment_data_to_excel.php">
                                <table>
                                    <tbody style="text-align:left;">
                                        <tr>
                                            <td><b>Department</b></td>
                                            <td style="padding-top:5px; padding-left:10px;">
                                                <select id="dept_id" name="dept_id" class="form-control">
                                                    <option value="">-- Please Select --</option>
                                                    <?php $user_query=mysqli_query($conn, "SELECT * FROM department")or die(mysqli_error());
                                                        while($row=mysqli_fetch_array($user_query)){
                                                            $id=$row['dept_id'];
                                                    ?>
                                                    <option value="<?php echo $id ?>"><?php echo $row['dept_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <button style="margin-top:10px" class="btn btn-info" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Close</button>
                                            </td>
                                            <td>
                                                <button style="margin-top:10px;width:150px;float:right;" name="memberByDepartment" type="submit" class="btn btn-success"><i class="icon-save icon-large"></i>&nbsp;Download</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Members By Department Modal -->

            <!-- Attendance Modal -->
            <div class="modal fade" id="attendance" tabindex="-1" role="dialog" aria-labelledby="attendance" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                <h4><b>Attendance</b></h4>
                            </div>
                            <form method="post" action="reports/attendance_data_to_excel.php">
                                <table>
                                    <tbody style="text-align:left;">
                                        <tr>
                                            <td><b>Year</b></td>
                                            <td style="padding-top:5px; padding-left:10px;">
                                                <input class="form-control" id="year" name="year" style="width:190px;" type="number" min="2000" max="2099" step="1" value="<?php echo date("Y"); ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Month</b></td>
                                            <td style="padding-top:5px; padding-left:10px;">
                                                <input class="form-control" id="month" name="month" style="width:190px;" type="number" min="1" max="12" step="1" value="<?php echo date("m"); ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Member</b></td>
                                            <td style="padding-top:5px; padding-left:10px;">
                                                <select id="member_id" name="member_id" class="form-control">
                                                    <option value="all">-- All Members --</option>
                                                    <?php $user_query=mysqli_query($conn, "SELECT * FROM member")or die(mysqli_error());
                                                        while($row=mysqli_fetch_array($user_query)){
                                                            $id=$row['member_id'];
                                                    ?>
                                                    <option value="<?php echo $id ?>"><?php echo $row['firstname']." ".$row['lastname']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>--------------</td>
                                            <td>-----------------------------------------</td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top:5px; padding-left:10px;">
                                                <input type="hidden" name="complete_check" value="0" />
                                                <input type="checkbox" name="complete_check" value="1">
                                            </td>
                                            <td><b>Check to Download YTD Attendance Data</b></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <button style="margin-top:10px" class="btn btn-info" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Close</button>
                                            </td>
                                            <td>
                                                <button style="margin-top:10px;width:150px;float:right;" name="attendance" type="submit" class="btn btn-success"><i class="icon-save icon-large"></i>&nbsp;Download</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Attendance Modal -->
            
            <!-- /. NAV SIDE  -->
            <div id="page-wrapper" >
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12"> 
                            <!-- Backup -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <b>Complete Database Backup & Save .SQL File</b>
                                    <div class="pull-right">
                                        <a href="transaction/backup_database.php" type="button" class="btn btn-primary btn-xs">
                                            &nbsp;<b>></b>&nbsp; Download Backup
                                        </a>
                                    </div>
                                </div>
							</div>
                            <!--End Backup -->

                            <!-- Backup -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <b>Excel Report Download</b>
                                </div>

                                <div class="panel-body">
                                <div class="table-responsive">
                                        <table class="table table-responsive">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center;">S.No</th>
                                                    <th style="text-align:center;">Data to Download</th>
                                                    <th style="text-align:center;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody style="text-align:center;">
                                                <tr>
                                                    <td><b>1. </b></td>
                                                    <td><b>Administrators</b></td>
                                                    <td><a href="reports/admin_data_to_excel.php" class="btn btn-success btn-sm">Download in Excel</a></td>
                                                </tr>
                                                <tr>
                                                    <td><b>2. </b></td>
                                                    <td><b>Departments</b></td>
                                                    <td><a href="reports/department_data_to_excel.php" class="btn btn-success btn-sm">Download in Excel</a></td>
                                                </tr>
                                                <tr>
                                                    <td><b>3. </b></td>
                                                    <td><b>Members</b></td>
                                                    <td><a href="reports/member_data_to_excel.php" class="btn btn-success btn-sm">Download in Excel</a></td>
                                                </tr>
                                                <tr>
                                                    <td><b>4. </b></td>
                                                    <td><b>Members By Department</b></td>
                                                    <td><a id="memberByDepartment" href="#memberByDepartment" data-toggle="modal" class="btn btn-success btn-sm">Download in Excel</a></td>
                                                </tr>
                                                <tr>
                                                    <td><b>5. </b></td>
                                                    <td><b>Attendance</b></td>
                                                    <td><a id="attendance" href="#attendance" data-toggle="modal" class="btn btn-success btn-sm">Download in Excel</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
							</div>
                            <!--End Backup -->

                        </div>
                    </div>
                </div>       
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
        <!-- /. WRAPPER  -->

        <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
        <!-- JQUERY SCRIPTS -->
        <script src="assets/js/jquery-1.10.2.js"></script>
        <!-- BOOTSTRAP SCRIPTS -->
        <script src="assets/js/bootstrap.min.js"></script>
        <!-- METISMENU SCRIPTS -->
        <script src="assets/js/jquery.metisMenu.js"></script>
        <!-- DATA TABLE SCRIPTS -->
        <script src="assets/js/dataTables/jquery.dataTables.js"></script>
        <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
            $(document).ready(function () {
                $('.dataTables-memberQRList').dataTable();
            });
        </script>
        <!-- CUSTOM SCRIPTS -->
        <script src="assets/js/custom.js"></script>
    </body>
</html>
