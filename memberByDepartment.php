<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Members by Department</title>
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
                            <a class="active-menu" href="memberByDepartment.php"><i class="fa fa-sitemap fa-3x"></i> Members By Department</a>
                        </li>	
                        <li>
                            <a type="button" data-toggle="modal" data-target="#qrCardGenerator"><i class="fa fa-qrcode fa-2x"></i> QR Card Generator</a>
                        </li>	
                        <li>
                            <a href="attendance.php"><i class="fa fa-table fa-2x"></i> Manage Attendance</a>
                        </li>
                        <li>
                            <a href="report_backup.php"><i class="fa fa-edit fa-2x"></i> Report/Backup</a>
                        </li>
                    </ul>
                </div>
            </nav> 

            <!-- /. NAV SIDE  -->
            <div id="page-wrapper" >
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12">                            
                            <!-- Advanced Tables -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Members Inrolled in Department
                                </div>

                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover table-responsive" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center;">Dept ID</th>
                                                    <th style="text-align:center;">Name</th>
                                                    <th style="text-align:center;">Head Name</th>
                                                    <th style="text-align:center;">Total Members</th>
                                                    <th style="text-align:center;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $dept_query=mysqli_query($conn, "SELECT * FROM department")or die(mysqli_error());
                                                    while($row=mysqli_fetch_array($dept_query)){
                                                        $id=$row['dept_id'];
                                                        $user_query=mysqli_query($conn, "SELECT COUNT(*) FROM member WHERE dept_id='$id'")or die(mysqli_error());
                                                        $member_count=mysqli_fetch_array($user_query)[0];
                                                ?>
                                                <tr class="odd gradeX">
                                                    <td style="text-align:center;"><?php echo $row['dept_id']; ?></td>
                                                    <td style="text-align:center;"><?php echo $row['dept_name']; ?></td>
                                                    <td style="text-align:center;"><?php echo $row['dept_head_name']; ?></td>
                                                    <td style="text-align:center;"><?php echo $member_count ?></td>
                                                    <td style="width:220; text-align:center;">
                                                        <a rel="tooltip" title="View" id="<?php echo $id; ?>" href="#view_members<?php echo $id; ?>" data-toggle="modal" class="btn btn-danger btn-sm">View Members List</a>
                                                        <!-- View Modal -->
                                                        <div class="modal fade" id="view_members<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="view_members" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <div class="text-center">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                            <h3><b>View Members List</b></h3>
                                                                        </div>
                                                                        <?php if($member_count > 0){ ?>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <table class="table table-striped table-bordered table-hover table-responsive dataTables-memberList">
                                                                                        <thead>
                                                                                            <th style="text-align:center;">Form ID</th>
                                                                                            <th style="text-align:center;">Full Name</th>
                                                                                            <th style="text-align:center;">Contact#</th>
                                                                                            <th style="text-align:center;">Postion</th>
                                                                                            <th style="text-align:center;">Date of Joining</th>
                                                                                            <th style="text-align:center;">Gender</th>
                                                                                            <th style="text-align:center;">Action</th>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <?php 
                                                                                                $member_query=mysqli_query($conn, "SELECT * FROM member WHERE dept_id='$id'")or die(mysqli_error());
                                                                                                while($mem=mysqli_fetch_array($member_query)){
                                                                                                    $id=$mem['member_id'];
                                                                                            ?>
                                                                                            <tr>
                                                                                                <td><?php echo $mem['formid_number']; ?></td>
                                                                                                <td><?php echo $mem['firstname']." ".$mem['lastname']; ?></td>
                                                                                                <td><?php echo $mem['contact_number']; ?></td>
                                                                                                <td><?php echo $mem['position']; ?></td>
                                                                                                <td>
                                                                                                    <?php 
                                                                                                    if($mem['status'] == 1){
                                                                                                        echo $mem['doj']; 
                                                                                                    }
                                                                                                    else{
                                                                                                        echo "LEFT";
                                                                                                    }
                                                                                                    ?>
                                                                                                </td>
                                                                                                <td><?php echo $mem['gender']; ?></td>
                                                                                                <td><a id="<?php echo $mem['member_id']; ?>" href="member/update_member.php?member_id=<?php echo $mem['member_id']; ?>" target="_blank" class="btn btn-warning btn-sm">View / Update</a></td>
                                                                                            </tr>
                                                                                            <?php } ?>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        <?php } else{ echo "<h3 style='text-align:center;'>NO Memebers Data Found!</h3>";} ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- View Modal -->
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
                    $('.dataTables-memberList').dataTable();
                });
                $(document).ready(function () {
                    $('.dataTables-memberQRList').dataTable();
                });
        </script>
            <!-- CUSTOM SCRIPTS -->
        <script src="assets/js/custom.js"></script>
    </body>
</html>
