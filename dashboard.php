<?php /* Created By Sameer Khowaja */ ?>
<!DOCTYPE html>
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
    <link href='assets/cdn/font-sans.css' rel='stylesheet' type='text/css' />
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
            font-size: 16px;"> Welcome: <?php echo $_SESSION['fullname']; ?> &nbsp;  
                <a href="mark_attendance.php" target="_blank" class="btn btn-primary square-btn-adjust">Mark Attendance</a> 
                <a href="logout.php" class="btn btn-danger square-btn-adjust">Logout</a>
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

        <!-- Modal add admin -->
        <div class="modal fade" id="add_admin" tabindex="-1" role="dialog" aria-labelledby="add_admin" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center">
                            <h4><b>Add NEW Administrator</b></h4>
                        </div>
                        <form method="post" action="transaction/aud_admin.php">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="fullname">Fullname</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Administrator</label>
                                <select class="form-control" id="deleteable" name="deleteable">
                                    <option value="1">No</option>
                                    <option value="0">Yes</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button name="add_admin" type="submit" class="btn btn-danger" style="width:150px;float:right;"><i class="icon-save icon-large"></i>&nbsp;Save</button>
                                <button class="btn btn-info" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal add admin -->
        <?php /* Created By Sameer Khowaja */ ?>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Dashboard</h2>  
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
                        <h5>Welcome <b><?php echo $_SESSION['username'] ?></b> , Love to see you back. </h5>
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
                                    if ($result=mysqli_query($conn, $sql)) {
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
                            <p class="main-text">Total: 
                                <?php
                                    $sql = "SELECT * FROM member";
                                    if ($result=mysqli_query($conn, $sql)) {
                                        $rowcount=mysqli_num_rows($result);
                                        echo $rowcount; 
                                    }
                                ?>
                            </p>
                            <p class="text-muted">Members / Khidmaatgar</p>
                        </div>
                    </div>
		        </div>

                <!-- /. ROW  -->
                <div class="row" >
                    <div class="col-md-3 col-sm-12 col-xs-12">                       
						<div class="panel panel-primary text-center no-boder bg-color-white">
                            <div class="panel-body">
                                <i class="fa fa-bar-chart-o fa-4x"></i>
                                <h5>
                                    Admin: 
                                    <b>
                                    <?php
                                        $sql = "SELECT * FROM admin_user WHERE deleteable=0";
                                        if ($result=mysqli_query($conn, $sql)) {
                                            $rowcount=mysqli_num_rows($result);
                                            echo $rowcount; 
                                        }
                                    ?>
                                    </b>
                                    <br>
                                    Non-Admin: 
                                    <b>
                                    <?php
                                        $sql = "SELECT * FROM admin_user WHERE deleteable=1";
                                        if ($result=mysqli_query($conn, $sql)) {
                                            $rowcount=mysqli_num_rows($result);
                                            echo $rowcount; 
                                        }
                                    ?>
                                    </b>
                                </h5>
                                <hr>
                                <i class="fa fa-edit fa-4x"></i>
                                <h5>
                                    Active Members: 
                                    <b>
                                    <?php
                                        $sql = "SELECT * FROM member WHERE status='1'";
                                        if ($result=mysqli_query($conn, $sql)) {
                                            $rowcount=mysqli_num_rows($result);
                                            echo $rowcount; 
                                        }
                                    ?>
                                    </b>
                                    <br>
                                    Inactive Members:
                                    <b>
                                    <?php
                                        $sql = "SELECT * FROM member WHERE status='0'";
                                        if ($result=mysqli_query($conn, $sql)) {
                                            $rowcount=mysqli_num_rows($result);
                                            echo $rowcount; 
                                        }
                                    ?>
                                    </b>
                                </h5>
                            </div>
                            <div class="panel-footer back-footer-white"></div>
                        </div>                       
                    </div>
                    
                    <div class="col-md-9 col-sm-12 col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <b>Administrator Data</b>
                                <?php if($_SESSION['deleteable'] == 0){ ?>
                                <div class="pull-right">
                                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#add_admin">
                                        &nbsp;<b>+</b>&nbsp; Add New Administrator
                                    </button>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="panel-body">
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
                                            Transaction Failed Due To Some Reasons...!
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
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover table-responsive">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center;">Username</th>
                                                <th style="text-align:center;">Fullname</th>
                                                <th style="text-align:center;">Last Login</th>
                                                <th style="text-align:center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $user_query=mysqli_query($conn, "SELECT * FROM admin_user")or die(mysqli_error());
                                                while($row=mysqli_fetch_array($user_query)){
                                                    $id=$row['username'];
                                            ?>
                                            <tr>
                                                <td style="text-align:center;"><?php echo $row['username']; ?></td>
                                                <td style="text-align:center;"><?php echo $row['fullname']; ?></td>
                                                <td style="text-align:center;">
                                                    <?php 
                                                        if ($row['last_login_date'] == NULL){
                                                            echo "<b>NEW</b>";
                                                        }
                                                        else{
                                                            echo $row['last_login_date']; 
                                                        }
                                                    ?>
                                                </td>
                                                <td style="text-align:center;">
                                                    <?php
                                                    // Role Based Setting
                                                    if($_SESSION['deleteable'] == 0){   // You are Admin
                                                        if($row['deleteable'] == 1){    // Non-Admin Users
                                                        ?>
                                                        <a rel="tooltip" title="Update" id="<?php echo $id; ?>" href="#update_role<?php echo $id; ?>" data-toggle="modal" class="btn btn-info btn-sm">Roles</a>
                                                        <!-- Update Role Modal -->
                                                        <div class="modal fade" id="update_role<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="update_admin" aria-hidden="true">
                                                            <div class="modal-dialog modal-sm" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <div class="text-center">
                                                                            <h4><b>Update Roles</b></h4>
                                                                        </div>
                                                                        <form method="post" action="transaction/aud_admin.php">
                                                                            <table>
                                                                                <tbody style="text-align:left;">
                                                                                    <?php if($_SESSION['deleteable'] == 0){ ?>
                                                                                        <tr hidden>
                                                                                            <td><b>Username</b></td>
                                                                                            <td style="padding-top:5px; padding-left:10px;"><input style="width:110px;" type="text" class="form-control" id="username" name="username" value="<?php echo $row['username']; ?>" readonly></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><b>Add Member</b></td>
                                                                                            <td style="padding-top:5px; padding-left:10px;">
                                                                                                <select style="width:110px;" class="form-control" id="add_member" name="add_member">
                                                                                                    <option value="<?php echo $row['add_member'];?>"><?php echo $row['add_member'] ? 'Yes' : 'No'; ?></option>
                                                                                                    <option value="0">No</option>
                                                                                                    <option value="1">Yes</option>
                                                                                                </select>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><b>Update Member</b></td>
                                                                                            <td style="padding-top:5px; padding-left:10px;">
                                                                                                <select style="width:110px;" class="form-control" id="update_member" name="update_member">
                                                                                                    <option value="<?php echo $row['update_member'];?>"><?php echo $row['update_member'] ? 'Yes' : 'No'; ?></option>
                                                                                                    <option value="0">No</option>
                                                                                                    <option value="1">Yes</option>
                                                                                                </select>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><b>Delete Member</b></td>
                                                                                            <td style="padding-top:5px; padding-left:10px;">
                                                                                                <select style="width:110px;" class="form-control" id="delete_member" name="delete_member">
                                                                                                    <option value="<?php echo $row['delete_member'];?>"><?php echo $row['delete_member'] ? 'Yes' : 'No'; ?></option>
                                                                                                    <option value="0">No</option>
                                                                                                    <option value="1">Yes</option>
                                                                                                </select>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><b>Add Department</b></td>
                                                                                            <td style="padding-top:5px; padding-left:10px;">
                                                                                                <select style="width:110px;" class="form-control" id="add_department" name="add_department">
                                                                                                    <option value="<?php echo $row['add_department'];?>"><?php echo $row['add_department'] ? 'Yes' : 'No'; ?></option>
                                                                                                    <option value="0">No</option>
                                                                                                    <option value="1">Yes</option>
                                                                                                </select>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><b>Update Department</b></td>
                                                                                            <td style="padding-top:5px; padding-left:10px;">
                                                                                                <select style="width:110px;" class="form-control" id="update_department" name="update_department">
                                                                                                    <option value="<?php echo $row['update_department'];?>"><?php echo $row['update_department'] ? 'Yes' : 'No'; ?></option>
                                                                                                    <option value="0">No</option>
                                                                                                    <option value="1">Yes</option>
                                                                                                </select>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><b>Delete Department</b></td>
                                                                                            <td style="padding-top:5px; padding-left:10px;">
                                                                                                <select style="width:110px;" class="form-control" id="delete_department" name="delete_department">
                                                                                                    <option value="<?php echo $row['delete_department'];?>"><?php echo $row['delete_department'] ? 'Yes' : 'No'; ?></option>
                                                                                                    <option value="0">No</option>
                                                                                                    <option value="1">Yes</option>
                                                                                                </select>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><b>Update Attendance</b></td>
                                                                                            <td style="padding-top:5px; padding-left:10px;">
                                                                                                <select style="width:110px;" class="form-control" id="update_attendance" name="update_attendance">
                                                                                                    <option value="<?php echo $row['update_attendance'];?>"><?php echo $row['update_attendance'] ? 'Yes' : 'No'; ?></option>
                                                                                                    <option value="0">No</option>
                                                                                                    <option value="1">Yes</option>
                                                                                                </select>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><b>Delete Attendance</b></td>
                                                                                            <td style="padding-top:5px; padding-left:10px;">
                                                                                                <select style="width:110px;" class="form-control" id="delete_attendance" name="delete_attendance">
                                                                                                    <option value="<?php echo $row['delete_attendance'];?>"><?php echo $row['delete_attendance'] ? 'Yes' : 'No'; ?></option>
                                                                                                    <option value="0">No</option>
                                                                                                    <option value="1">Yes</option>
                                                                                                </select>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><b>Bulk Timeout</b></td>
                                                                                            <td style="padding-top:5px; padding-left:10px;">
                                                                                                <select style="width:110px;" class="form-control" id="bulk_timeout" name="bulk_timeout">
                                                                                                    <option value="<?php echo $row['bulk_timeout'];?>"><?php echo $row['bulk_timeout'] ? 'Yes' : 'No'; ?></option>
                                                                                                    <option value="0">No</option>
                                                                                                    <option value="1">Yes</option>
                                                                                                </select>
                                                                                            </td>
                                                                                        </tr>
                                                                                    <?php } ?>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <button style="margin-top:10px" class="btn btn-info" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Close</button>
                                                                                        </td>
                                                                                        <td>
                                                                                            <button style="margin-top:10px;width:110px;float:right;" name="update_role" type="submit" class="btn btn-danger"><i class="icon-save icon-large"></i>&nbsp;Update</button>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Update Role Modal -->
                                                        <?php
                                                        }
                                                    }
                                                    ?>

                                                    <?php
                                                    // Update & Delete
                                                    if($_SESSION['deleteable'] == 0){   // You are Admin
                                                        if($_SESSION['username'] != $row['username']){  // You not part of list
                                                        ?>
                                                            <a rel="tooltip" title="Update" id="<?php echo $id; ?>" href="#update_admin<?php echo $id; ?>" data-toggle="modal" class="btn btn-warning btn-sm">Update</a>
                                                            <!-- Update Modal -->
                                                            <div class="modal fade" id="update_admin<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="update_admin" aria-hidden="true">
                                                                <div class="modal-dialog modal-sm" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-body">
                                                                            <div class="text-center">
                                                                                <h4><b>Update Administrator</b></h4>
                                                                            </div>
                                                                            <form method="post" action="transaction/aud_admin.php">
                                                                                <table>
                                                                                    <tbody style="text-align:left;">
                                                                                        <tr>
                                                                                            <td><b>Username</b></td>
                                                                                            <td style="padding-top:5px; padding-left:10px;"><input style="width:165px;" type="text" class="form-control" id="username" name="username" value="<?php echo $row['username']; ?>" readonly></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><b>Fullname</b></td>
                                                                                            <td style="padding-top:5px; padding-left:10px;"><input style="width:165px;" type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $row['fullname']; ?>" required></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><b>Password</b></td>
                                                                                            <td style="padding-top:5px; padding-left:10px;"><input style="width:165px;" type="password" class="form-control" id="password" name="password" value="<?php echo $row['password'];?>" required></td>
                                                                                        </tr>
                                                                                        <?php if($_SESSION['deleteable'] == 0){ ?>
                                                                                        <tr>
                                                                                            <td><b>Administrator</b></td>
                                                                                            <td style="padding-top:5px; padding-left:10px;">
                                                                                                <select style="width:165px;" class="form-control" id="deleteable" name="deleteable">
                                                                                                    <option value="<?php echo $row['deleteable'];?>"><?php echo $row['deleteable'] ? 'No' : 'Yes'; ?></option>
                                                                                                    <option value="1">No</option>
                                                                                                    <option value="0">Yes</option>
                                                                                                </select>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <?php } ?>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <button style="margin-top:10px" class="btn btn-info" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Close</button>
                                                                                            </td>
                                                                                            <td>
                                                                                                <button style="margin-top:10px;width:150px;float:right;" name="update_admin" type="submit" class="btn btn-danger"><i class="icon-save icon-large"></i>&nbsp;Update</button>
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

                                                            <a rel="tooltip" title="Delete" id="<?php echo $id; ?>" href="#delete_admin<?php echo $id; ?>" data-toggle="modal" class="btn btn-danger btn-sm">Delete</a>
                                                            <!-- Delete Modal -->
                                                            <div class="modal fade" id="delete_admin<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="delete_dept<?php echo $id; ?>" aria-hidden="true">
                                                                <div class="modal-dialog modal-sm" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-body">
                                                                            <div class="text-center">
                                                                                <h4><b>Delete "<?php echo $row['username']; ?>"</b></h4>
                                                                            </div>
                                                                            <form method="post" action="transaction/aud_admin.php">
                                                                                <div class="form-group">
                                                                                    <input type="hidden" class="form-control" id="username" name="username" value="<?php echo $row['username']; ?>" readonly>
                                                                                    <h5>Are you sure to DELETE Administrator Data? <?php $_SESSION['username'] ?></h5>
                                                                                </div>
                                                                                <br>
                                                                                <div class="form-group">
                                                                                    <button class="btn btn-info" data-dismiss="modal" aria-hidden="true">&nbsp;No</button>
                                                                                    <button name="delete_admin" type="submit" class="btn btn-danger"><i class="icon-save icon-large" style="width:50px;float:right;"></i>&nbsp;Yes</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Delete Modal -->
                                                        <?php
                                                        }
                                                        else{ // You part of list then you can only update your self
                                                        ?>
                                                            <a rel="tooltip" title="Update" id="<?php echo $id; ?>" href="#update_admin<?php echo $id; ?>" data-toggle="modal" class="btn btn-warning btn-sm">Update</a>
                                                            <!-- Update Modal -->
                                                            <div class="modal fade" id="update_admin<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="update_admin" aria-hidden="true">
                                                                <div class="modal-dialog modal-sm" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-body">
                                                                            <div class="text-center">
                                                                                <h4><b>Update Administrator</b></h4>
                                                                            </div>
                                                                            <form method="post" action="transaction/aud_admin.php">
                                                                                <table>
                                                                                    <tbody style="text-align:left;">
                                                                                        <tr>
                                                                                            <td><b>Username</b></td>
                                                                                            <td style="padding-top:5px; padding-left:10px;"><input style="width:165px;" type="text" class="form-control" id="username" name="username" value="<?php echo $row['username']; ?>" readonly></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><b>Fullname</b></td>
                                                                                            <td style="padding-top:5px; padding-left:10px;"><input style="width:165px;" type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $row['fullname']; ?>" required></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><b>Password</b></td>
                                                                                            <td style="padding-top:5px; padding-left:10px;"><input style="width:165px;" type="password" class="form-control" id="password" name="password" value="<?php echo $row['password'];?>" required></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <button style="margin-top:10px" class="btn btn-info" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Close</button>
                                                                                            </td>
                                                                                            <td>
                                                                                                <button style="margin-top:10px;width:150px;float:right;" name="update_admin" type="submit" class="btn btn-danger"><i class="icon-save icon-large"></i>&nbsp;Update</button>
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
                                                        <?php
                                                        }
                                                    }
                                                    else{   // You are Non-Admin
                                                        if($_SESSION['username'] == $row['username']){   // Update yourself
                                                        ?>
                                                            <a rel="tooltip" title="Update" id="<?php echo $id; ?>" href="#update_admin<?php echo $id; ?>" data-toggle="modal" class="btn btn-warning btn-sm">Update</a>
                                                            <!-- Update Modal -->
                                                            <div class="modal fade" id="update_admin<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="update_admin" aria-hidden="true">
                                                                <div class="modal-dialog modal-sm" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-body">
                                                                            <div class="text-center">
                                                                                <h4><b>Update Administrator</b></h4>
                                                                            </div>
                                                                            <form method="post" action="transaction/aud_admin.php">
                                                                                <table>
                                                                                    <tbody style="text-align:left;">
                                                                                        <tr>
                                                                                            <td><b>Username</b></td>
                                                                                            <td style="padding-top:5px; padding-left:10px;"><input style="width:165px;" type="text" class="form-control" id="username" name="username" value="<?php echo $row['username']; ?>" readonly></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><b>Fullname</b></td>
                                                                                            <td style="padding-top:5px; padding-left:10px;"><input style="width:165px;" type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $row['fullname']; ?>" required></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><b>Password</b></td>
                                                                                            <td style="padding-top:5px; padding-left:10px;"><input style="width:165px;" type="password" class="form-control" id="password" name="password" value="<?php echo $row['password'];?>" required></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <button style="margin-top:10px" class="btn btn-info" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Close</button>
                                                                                            </td>
                                                                                            <td>
                                                                                                <button style="margin-top:10px;width:150px;float:right;" name="update_admin" type="submit" class="btn btn-danger"><i class="icon-save icon-large"></i>&nbsp;Update</button>
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
                                                        <?php
                                                        }
                                                        else{   // No Rights
                                                            echo "<b>Cannot Update/Delete</b>";
                                                        }
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
                    </div>
                </div>
                 <!-- /. ROW  -->
            </div>
            <div style="bottom:0; right:0; font-size:12px;">Created By Sameer Khowaja</div>
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
    <!-- DATA TABLE SCRIPTS -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script>
        $(document).ready(function () {
            $('.dataTables-memberQRList').dataTable();
        });
    </script>
      <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
    
   
</body>
</html>
<?php /* Created By Sameer Khowaja */ ?>