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
                            <a class="active-menu" href="department.php"><i class="fa fa-desktop fa-3x"></i> Departments</a>
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
                            <a href="report_backup.php"><i class="fa fa-edit fa-2x"></i> Report/Backup</a>
                        </li>
                    </ul>
                </div>
            </nav> 

            <!-- Modal add department -->
            <div class="modal fade" id="add_dept" tabindex="-1" role="dialog" aria-labelledby="add_dept" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                <h4><b>Add NEW Department</b></h4>
                            </div>
                            <form method="post" action="transaction/aud_dept.php">
                                <div class="form-group">
                                    <label for="dept_name">Department Name</label>
                                    <input type="text" class="form-control" id="dept_name" name="dept_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="dept_head_name">Department Head Name</label>
                                    <input type="text" class="form-control" id="dept_head_name" name="dept_head_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="dept_area">Department Area Name</label>
                                    <input type="text" class="form-control" id="dept_area" name="dept_area" required>
                                </div>
                                <div class="form-group">
                                    <label for="dept_location">Location / Address</label>
                                    <input type="text" class="form-control" id="dept_location" name="dept_location" required>
                                </div>
                                <div class="form-group">
                                    <label for="dept_phone">Phone Number</label>
                                    <input type="text" class="form-control" id="dept_phone" name="dept_phone" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                </div>
                                <div class="form-group">
                                    <label for="dept_comment">Any Comments</label>
                                    <input type="text" class="form-control" id="dept_comment" name="dept_comment">
                                </div>
                                <div class="form-group">
                                    <button name="add_dept" type="submit" class="btn btn-danger" style="width:150px;float:right;"><i class="icon-save icon-large"></i>&nbsp;Save</button>
                                    <button class="btn btn-info" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal add department -->

            <!-- /. NAV SIDE  -->
            <div id="page-wrapper" >
                <div id="page-inner">
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
                                    Departments Data
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#add_dept">
                                            &nbsp;<b>+</b>&nbsp; Add New Department
                                        </button>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover table-responsive" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center;">Dept ID</th>
                                                    <th style="text-align:center;">Name</th>
                                                    <th style="text-align:center;">Head Name</th>
                                                    <th style="text-align:center;">Area</th>
                                                    <th style="text-align:center;">Update On</th>
                                                    <th style="text-align:center;">Update By</th>
                                                    <th style="text-align:center;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $user_query=mysqli_query($conn, "SELECT * FROM department")or die(mysqli_error());
                                                    while($row=mysqli_fetch_array($user_query)){
                                                        $id=$row['dept_id'];
                                                ?>
                                                <tr class="odd gradeX">
                                                    <td style="text-align:center;"><?php echo $row['dept_id']; ?></td>
                                                    <td><?php echo $row['dept_name']; ?></td>
                                                    <td><?php echo $row['dept_head_name']; ?></td>
                                                    <td><?php echo $row['dept_area']; ?></td>
                                                    <td style="text-align:center;"><?php echo $row['updated_date']; ?></td>
                                                    <td style="text-align:center;"><?php echo $row['updated_by']; ?></td>
                                                    <td style="width:220; text-align:center;">
                                                        <a rel="tooltip" title="Update" id="<?php echo $id; ?>" href="#update_dept<?php echo $id; ?>" data-toggle="modal" class="btn btn-warning btn-sm">View / Update</a>
                                                        <!-- View/Update Modal -->
                                                        <div class="modal fade" id="update_dept<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="update_dept" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <div class="text-center">
                                                                            <h4><b>View / Update Department</b></h4>
                                                                        </div>
                                                                        <form method="post" action="transaction/aud_dept.php">
                                                                            <table>
                                                                                <tbody style="text-align:left;">
                                                                                    <tr>
                                                                                        <td><b>Department ID</b></td>
                                                                                        <td style="padding-top:5px; padding-left:10px;"><input style="width:350px;" type="text" class="form-control" id="dept_id" name="dept_id" value="<?php echo $row['dept_id']; ?>" readonly></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><b>Department Name</b></td>
                                                                                        <td style="padding-top:5px; padding-left:10px;"><input style="width:350px;" type="text" class="form-control" id="dept_name" name="dept_name" value="<?php echo $row['dept_name']; ?>" required></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><b>Department Head Name</b></td>
                                                                                        <td style="padding-top:5px; padding-left:10px;"><input style="width:350px;" type="text" class="form-control" id="dept_head_name" name="dept_head_name" value="<?php echo $row['dept_name'];?>" required></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><b>Department Area Name</b></td>
                                                                                        <td style="padding-top:5px; padding-left:10px;"><input style="width:350px;" type="text" class="form-control" id="dept_area" name="dept_area" value="<?php echo $row['dept_area']; ?>" required></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><b>Location / Address</b></td>
                                                                                        <td style="padding-top:5px; padding-left:10px;"><input style="width:350px;" type="text" class="form-control" id="dept_location" name="dept_location" value="<?php echo $row['dept_location']; ?>" required></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><b>Phone Number</b></td>
                                                                                        <td style="padding-top:5px; padding-left:10px;"><input style="width:350px;" type="text" class="form-control" id="dept_phone" name="dept_phone" value="<?php echo $row['dept_phone']; ?>" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><b>Any Comments</b></td>
                                                                                        <td style="padding-top:5px; padding-left:10px;"><input style="width:350px;" type="text" class="form-control" id="dept_comment" name="dept_comment" value="<?php echo $row['dept_comment']; ?>"></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><b>Created On & By</b></td>
                                                                                        <td style="padding-top:5px; padding-left:10px;"><p style="width:350px;" class="form-control"><?php echo $row['created_date']." ( <b>".$row['created_by']."</b> )"; ?></p></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><b>Updated On & By</b></td>
                                                                                        <td style="padding-top:5px; padding-left:10px;"><p style="width:350px;" class="form-control"><?php echo $row['updated_date']." ( <b>".$row['updated_by']."</b> )"; ?></p></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <button style="margin-top:10px" class="btn btn-info" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Close</button>
                                                                                        </td>
                                                                                        <td>
                                                                                            <button style="margin-top:10px;width:150px;float:right;" name="update_dept" type="submit" class="btn btn-danger"><i class="icon-save icon-large"></i>&nbsp;Update</button>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- View/Update Modal -->
                                                        
                                                        <a rel="tooltip" title="Delete" id="<?php echo $id; ?>" href="#delete_dept<?php echo $id; ?>" data-toggle="modal" class="btn btn-danger btn-sm">Delete</a>
                                                        <!-- Delete Modal -->
                                                        <div class="modal fade" id="delete_dept<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="delete_dept<?php echo $id; ?>" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <div class="text-center">
                                                                            <h4><b>Delete Department "<?php echo $row['dept_name']; ?>"</b></h4>
                                                                        </div>
                                                                        <form method="post" action="transaction/aud_dept.php">
                                                                            <div class="form-group">
                                                                                <input type="hidden" class="form-control" id="dept_id" name="dept_id" value="<?php echo $row['dept_id']; ?>" readonly>
                                                                                <h5>Are you sure to DELETE Department Data?</h5>
                                                                            </div>
                                                                            <br>
                                                                            <div class="form-group">
                                                                                <button class="btn btn-info" data-dismiss="modal" aria-hidden="true">&nbsp;No</button>
                                                                                <button name="delete_dept" type="submit" class="btn btn-danger"><i class="icon-save icon-large" style="width:50px;float:right;"></i>&nbsp;Yes</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Delete Modal -->
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
                $('.dataTables-memberQRList').dataTable();
            });
        </script>
            <!-- CUSTOM SCRIPTS -->
        <script src="assets/js/custom.js"></script>
    </body>
</html>
