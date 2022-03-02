﻿<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
     <!-- MORRIS CHART STYLES-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
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
                        <a class="active-menu" href="dashboard.php"><i class="fa fa-dashboard fa-3x"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="department.php"><i class="fa fa-desktop fa-2x"></i> Departments</a>
                    </li>
                    <li>
                        <a href="member.php"><i class="fa fa-bar-chart-o fa-2x"></i> Members/Khidmaatgar</a>
                    </li>	
                    <li>
                        <a href="attendance.php"><i class="fa fa-table fa-2x"></i> Attendance</a>
                    </li>
                    <li>
                        <a href="user-attendance.php"><i class="fa fa-qrcode fa-3x"></i> User Attendance</a>
                    </li>
                    <li>
                        <a href="report.php"><i class="fa fa-edit fa-2x"></i> Report</a>
                    </li>
                </ul>
            </div>
        </nav> 

        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2>Admin Dashboard</h2>  
                        <h5>
                            <div class="pull-right">
                                <i class="icon-calendar icon-large"></i>
                                <?php
                                $Today = date('y:m:d');
                                $new = date('l, F d, Y', strtotime($Today));
                                echo "<center>".$new."</center>";
                                ?>
                            </div>
                        </h5> 
                        <h5>Welcome <b><?php echo $_SESSION['fullname'] ?></b> , Love to see you back. </h5>
                    </div>
                </div>              
                 <!-- /. ROW  -->
                <hr />
                <div class="col-md-6 col-sm-12 col-xs-12">           
			        <div class="panel panel-back noti-box">
                        <span class="icon-box bg-color-green set-icon">
                            <i class="fa fa-rocket"></i>
                        </span>
                        <div class="text-box" >
                            <p class="main-text">Total: 
                                <?php
                                    $sql = "SELECT * FROM department";
                                    if ($result=mysqli_query($conn,$sql)) {
                                        $rowcount=mysqli_num_rows($result);
                                        echo $rowcount; 
                                    }
                                ?>
                            </p>
                            <p class="text-muted">Departments / Committee</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">           
                    <div class="panel panel-back noti-box">
                        <span class="icon-box bg-color-blue set-icon">
                            <i class="fa fa-bars"></i>
                        </span>
                        <div class="text-box" >
                            <p class="main-text">Total: 240</p>
                            <p class="text-muted">Members / Khidmaatgar</p>
                        </div>
                    </div>
		        </div>

                <div class="row" >
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                            Top Attendance Record of 
                            <b>
                                <?php
                                    $Today = date('y:m:d');
                                    $new = date('F, Y', strtotime($Today));
                                    echo $new;
                                ?>
                            </b>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Username</th>
                                                <th>User No.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Mark</td>
                                                <td>Otto</td>
                                                <td>@mdo</td>
                                                <td>100090</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
             <!-- /. PAGE INNER  -->
        </div>
         <!-- /. PAGE WRAPPER  -->
    </div>
     <!-- /. WRAPPER  -->
     
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
     <!-- MORRIS CHART SCRIPTS -->
     <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
    
   
</body>
</html>
