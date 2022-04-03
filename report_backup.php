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

            <!-- /. NAV SIDE  -->
            <div id="page-wrapper" >
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12">                            
                            <!-- Backup -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <b>Complete Database Backup</b>
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
                                    Excel Report Download
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
                                                    <td><a href="reports/departments_data_to_excel.php" class="btn btn-success btn-sm">Download in Excel</a></td>
                                                </tr>
                                                <tr>
                                                    <td><b>3. </b></td>
                                                    <td><b>Members</b></td>
                                                    <td>Download in Excel</td>
                                                </tr>
                                                <tr>
                                                    <td><b>4. </b></td>
                                                    <td><b>Members By Department</b></td>
                                                    <td>Download in Excel</td>
                                                </tr>
                                                <tr>
                                                    <td><b>5. </b></td>
                                                    <td><b>Attendance</b></td>
                                                    <td>Download in Excel</td>
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
