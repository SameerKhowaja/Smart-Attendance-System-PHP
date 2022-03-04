<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Department</title>
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
                font-size: 16px;"> Welcome: <?php echo $_SESSION['fullname'] ?> &nbsp; <a href="logout.php" class="btn btn-danger square-btn-adjust">Logout</a> 
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
                            <a class="active-menu" href="member.php"><i class="fa fa-bar-chart-o fa-3x"></i> Members/Khidmaatgar</a>
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
                            <h2>New Member Form</h2>   
                            <h5>Fill Below Data to Add New Member to List.</h5>
                        </div>
                    </div>
                    
                    <!-- /. ROW  -->
                    <hr />
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Form Elements -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Fill New Member Form
                                    <div class="pull-right">
                                        <a href="member.php" type="button" class="btn btn-primary btn-xs">
                                            &nbsp;<b><</b>&nbsp; Back
                                        </a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form method="post" action="transaction/aud_member.php">
                                                <div class="form-group">
                                                    <label>Text Input with Placeholder</label>
                                                    <input class="form-control" placeholder="PLease Enter Keyword" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Just A Label Control</label>
                                                    <p class="form-control-static">info@yourdomain.com</p>
                                                </div>
                                                <div class="form-group">
                                                    <label>File input</label>
                                                    <input type="file" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Text area</label>
                                                    <textarea class="form-control" rows="3"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label>Checkboxes</label>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" value="" />Checkbox Example One
                                                        </label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" value=""/>Checkbox Example Two
                                                        </label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" value=""/>Checkbox Example Three
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Inline Checkboxes Examples</label>
                                                    <label class="checkbox-inline">
                                                        <input type="checkbox"/> One
                                                    </label>
                                                    <label class="checkbox-inline">
                                                        <input type="checkbox"/> Two
                                                    </label>
                                                    <label class="checkbox-inline">
                                                        <input type="checkbox"/> Three
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <label>Radio Button Examples</label>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked />Radio Example One
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2"/>Radio Example Two
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3"/>Radio Example Three
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Select Example</label>
                                                    <select class="form-control">
                                                        <option>One Vale</option>
                                                        <option>Two Vale</option>
                                                        <option>Three Vale</option>
                                                        <option>Four Vale</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Multiple Select Example</label>
                                                    <select multiple class="form-control">
                                                        <option>One Vale</option>
                                                        <option>Two Vale</option>
                                                        <option>Three Vale</option>
                                                        <option>Four Vale</option>
                                                    </select>
                                                </div>

                                                <button style="float:right;" type="submit" class="btn btn-danger">Submit Form</button>
                                                <button type="reset" class="btn btn-info">Clear All</button>
                                            </form>                          
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Form Elements -->
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
        </script>
            <!-- CUSTOM SCRIPTS -->
        <script src="assets/js/custom.js"></script>
    </body>
</html>
