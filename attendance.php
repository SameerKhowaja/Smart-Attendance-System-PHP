<?php /* Created By Sameer Khowaja */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Manage Attendance</title>
        <!-- BOOTSTRAP STYLES-->
        <link href="assets/css/bootstrap.css" rel="stylesheet" />
        <!-- FONTAWESOME STYLES-->
        <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- MORRIS CHART STYLES-->
    
            <!-- CUSTOM STYLES-->
        <link href="assets/css/custom.css" rel="stylesheet" />
        <!-- GOOGLE FONTS-->
        <link href='assets/cdn/font-sans.css' rel='stylesheet' type='text/css' />
        <!-- TABLE STYLES-->
        <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
        <script src="assets/cdn/jquery-min3.js"></script>
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
                            <a class="active-menu" href="attendance.php"><i class="fa fa-table fa-3x"></i> Manage Attendance</a>
                        </li>
                        <li>
                            <a href="report_backup.php"><i class="fa fa-edit fa-2x"></i> Report/Backup</a>
                        </li>
                    </ul>
                </div>
            </nav> 

            <!-- Modal mark manual attendance -->
            <div class="modal fade" id="manual_attendance" tabindex="-1" role="dialog" aria-labelledby="manual_attendance" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                <h4><b>Mark Attendance Manually</b></h4>
                            </div>
                            <hr>
                            <form id="fupForm" name="form1" method="post">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="member_id">Member Fullname</label>
                                            <select class="form-control" id="member_id" name="member_id" onchange="getComboA(this)">
                                                <option value="">-- Select --</option>
                                                <?php
                                                    $user_query=mysqli_query($conn, "SELECT member_id, firstname, lastname FROM member WHERE status='1'")or die(mysqli_error());
                                                    while($row=mysqli_fetch_array($user_query)){
                                                        $id=$row['member_id'];
                                                ?>
                                                <option value="<?php echo $id; ?>"><?php echo $row['firstname']." ".$row['lastname']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="pod_ME">Part of the Day</label>
                                            <input id="pod_ME" name="pod_ME" type="text" class="form-control" value="No Data" required disabled/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Position</label>
                                            <p id="position" class="form-control">No Data</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Department Name</label>
                                            <p id="dept_name" class="form-control">No Data</p>
                                        </div>           
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">Date</label>
                                            <?php
                                                $month = date('m');
                                                $day = date('d');
                                                $year = date('Y');
                                                $today = $year . '-' . $month . '-' . $day;
                                            ?>
                                            <input id="date" name="date" type="date" class="form-control" value="<?php echo $today; ?>" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="time_inout">Time (In/Out)</label>
                                            <input id="time_inout" name="time_inout" type="time" class="form-control" value="" onchange="getPartofDay(this)" required/>
                                        </div>         
                                    </div>
                                </div>

                                <div style="margin:auto;">
                                    <div class="alert alert-success alert-dismissible" id="modal-success" style="display:none;">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                    </div>
                                </div>
                                <div style="margin:auto;">
                                    <div class="alert alert-danger alert-dismissible" id="modal-failed" style="display:none;">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="button" name="save" class="btn btn-danger" value="Mark Attendance" id="butsave" style="width:150px;float:right;">
                                    <button class="btn btn-info" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal mark manual attendance -->
            
            <?php /* Created By Sameer Khowaja */ ?>

            <!-- Timeout Modal -->
            <div class="modal fade" id="timeout" tabindex="-1" role="dialog" aria-labelledby="timeout" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                <h4><b>Timeout</b></h4>
                            </div>
                            <form method="post" action="transaction/missed_timeout.php">
                                <table>
                                    <tbody style="text-align:left;">
                                        <tr>
                                            <td><b>Date</b></td>
                                            <td style="padding-top:5px; padding-left:10px;">
                                                <input class="form-control" id="date" name="date" style="width:190px;" type="date" value="<?php echo date('Y-m-d'); ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td style="padding-top:5px; padding-left:10px;"><b>OR</b></td>
                                        </tr>
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
                                            <td>--------------</td>
                                            <td>-----------------------------------------</td>
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
                                            <td><b>Hours</b></td>
                                            <td style="padding-top:5px; padding-left:10px;">
                                                <input class="form-control" id="addHours" name="addHours" style="width:190px;" type="number" min="0" max="10" step="1" value="1"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Minutes</b></td>
                                            <td style="padding-top:5px; padding-left:10px;">
                                                <input class="form-control" id="addMinutes" name="addMinutes" style="width:190px;" type="number" min="0" max="60" step="5" value="30"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>--------------</td>
                                            <td>-----------------------------------------</td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left:10px;">
                                                <input type="radio" id="query_check01" name="query_check" value="date" checked>
                                            </td>
                                            <td><b><label for="query_check01">Select Date Only</label></b></td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left:10px;">
                                                <input type="radio" id="query_check02" name="query_check" value="year_month">
                                            </td>
                                            <td><b><label for="query_check02">Select Year & Month</label></b></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <button style="margin-top:10px" class="btn btn-info" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Close</button>
                                            </td>
                                            <td>
                                                <button style="margin-top:10px;width:150px;float:right;" name="timeout" type="submit" class="btn btn-danger"><i class="icon-save icon-large"></i>&nbsp;Timeout</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Timeout Modal -->

            <!-- Attendance Filter Modal -->
            <div class="modal fade" id="attendance_filter" tabindex="-1" role="dialog" aria-labelledby="attendance_filter" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                <h4><b>Filter Attendance</b></h4>
                            </div>
                            <form method="post" action="attendance/filter_attendance.php">
                                <table>
                                    <tbody style="text-align:left;">
                                        <tr>
                                            <td><b>Date</b></td>
                                            <td style="padding-top:5px; padding-left:10px;">
                                                <input class="form-control" id="date" name="date" style="width:190px;" type="date" value="<?php echo date('Y-m-d'); ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td style="padding-top:5px; padding-left:10px;"><b>OR</b></td>
                                        </tr>
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
                                            <td>--------------</td>
                                            <td>-----------------------------------------</td>
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
                                            <td style="padding-left:10px;">
                                                <input type="radio" id="query_check1" name="query_check" value="date" checked>
                                            </td>
                                            <td><b><label for="query_check1">Select Date Only</label></b></td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left:10px;">
                                                <input type="radio" id="query_check2" name="query_check" value="year">
                                            </td>
                                            <td><b><label for="query_check2">Select Year Only</label></b></td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left:10px;">
                                                <input type="radio" id="query_check3" name="query_check" value="year_month">
                                            </td>
                                            <td><b><label for="query_check3">Select Year & Month</label></b></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <button style="margin-top:10px" class="btn btn-info" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Close</button>
                                            </td>
                                            <td>
                                                <button style="margin-top:10px;width:150px;float:right;" name="filter_attendance" type="submit" class="btn btn-warning"><i class="icon-save icon-large"></i>&nbsp;View Details</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Attendance Filter Modal -->

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

                            <!-- Timeout -->
                            <?php if(isset($_SESSION['bulk_timeout']) && $_SESSION['bulk_timeout']==1){ ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <b>Mark Missed Timeout in Bulk</b>
                                    <div class="pull-right">
                                        <a id="timeout" href="#timeout" data-toggle="modal" class="btn btn-primary btn-xs">
                                            &nbsp;<b>></b>&nbsp; Timeout User
                                        </a>
                                    </div>
                                </div>
							</div>
                            <?php } ?>
                            <!--End Timeout -->
                            <?php /* Created By Sameer Khowaja */ ?>
                            <!-- Advanced Tables -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <b>Manage Attendance</b>
                                    <div class="pull-right">
                                        <a type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#attendance_filter">
                                            &nbsp;<b>#</b>&nbsp; More Filter
                                        </a>
                                        <a type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#manual_attendance">
                                            &nbsp;<b>+</b>&nbsp; Mark Attendance Manually
                                        </a>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <div class="table-responsive" id="attendanceTable">
                                        <table class="table table-striped table-bordered table-hover table-responsive" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center;">Full Name</th>
                                                    <th style="text-align:center;">Department</th>
                                                    <th style="text-align:center;">Designation</th>
                                                    <th style="text-align:center;">Year</th>
                                                    <th style="text-align:center;">Month</th>
                                                    <th style="text-align:center;">Presents (AM/PM)</th>
                                                    <th style="text-align:center;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $query="SELECT m.member_id, m.firstname, m.lastname, m.position, d.dept_name, year(a.date) year, month(a.date) month, COUNT(a.timeIn) total_presents FROM `attendance` a JOIN `member` m JOIN `department` d ON m.member_id=a.member_id AND m.dept_id=d.dept_id GROUP BY m.member_id, year, month";
                                            $user_query=mysqli_query($conn, $query)or die(mysqli_error());
                                            while($row=mysqli_fetch_array($user_query)){
                                                $id=$row['member_id'];
                                                $yr=$row['year'];
                                                $mt=$row['month'];
                                            ?>
                                            <tr>
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
                                                <td style="width:220; text-align:center;">
                                                    <a id="<?php echo $id; ?>" href="attendance/view_attendance.php?member_id=<?php echo $id; ?>&year=<?php echo $yr; ?>&month=<?php echo $mt; ?>" class="btn btn-warning btn-sm">View Details</a>
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
        <!-- Add Attendance Manually using Ajax Jquery -->
        <script src="assets/cdn/jquery-3-6-0-min.js"></script>
        <script type="text/javascript">
            function delay(time) {
                return new Promise(resolve => setTimeout(resolve, time));
            }
        </script>

        <script>
            $(document).ready(function() {
                $('#butsave').on('click', function() {
                    var member_id = $('#member_id').val();
                    var pod_ME = $('#pod_ME').val();
                    var date = $('#date').val();
                    var time_inout = $('#time_inout').val();
                    
                    if(member_id!="" && pod_ME!="" && date!="" && time_inout!=""){
                        $.ajax({
                            url: "transaction/manual_markAttendance.php",
                            type: "POST",
                            data: {
                                member_id: member_id,
                                pod_ME: pod_ME,
                                date: date,
                                time_inout: time_inout				
                            },
                            cache: false,
                            success: function(dataResult){
                                var dataResult = JSON.parse(dataResult);
                                if(dataResult.statusCode==1){
                                    $("#modal-failed").hide();
                                    $("#modal-success").show();
                                    $('#modal-success').html(dataResult.statusMsg);

                                    $('#dataTables-example').DataTable().destroy();
                                    $("#attendanceTable").load("attendance.php #dataTables-example");
                                    delay(500).then(() => $('#dataTables-example').DataTable().draw());
                                }
                                else{
                                    $("#modal-success").hide();
                                    $("#modal-failed").show();
                                    $('#modal-failed').html(dataResult.statusMsg);
                                }
                            }
                        });
                    }
                    else{
                        console.error('Please fill all the fields!');
                        alert('Please fill all the fields!');  
                    }
                });
            });
        </script>

        <!-- Manual Attendance Event -->
        <script>
            function getPartofDay(selectObject){
                var time_inout = selectObject.value; 
                var H = +time_inout.substr(0, 2);
                var h = H % 12 || 12;
                var ampm = (H < 12 || H === 24) ? "AM" : "PM";
                if (ampm == "AM"){
                    $("#pod_ME").val("Morning");
                }
                else{
                    $("#pod_ME").val("Evening");
                }
            }

            function getComboA(selectObject) {
                var member_id = selectObject.value;  
                console.log(member_id);
                if(member_id!=""){
                    $.ajax({
                        url: "transaction/getMemberData.php",
                        type: "POST",
                        data: {
                            member_id: member_id				
                        },
                        cache: false,
                        success: function(dataResult){
                            var dataResult = JSON.parse(dataResult);
                            $("#position").html(dataResult.position);
                            $("#dept_name").html(dataResult.dept_name);
                        }
                    });
                }
            }

            $(document).ready(function () {
                $('#manual_attendance').on('hidden.bs.modal', function () {
                    $(this).find('form').trigger('reset');
                    $("#position").html("No Data");
                    $("#dept_name").html("No Data");
                    $("#modal-success").hide();
                    $("#modal-failed").hide();
                })
            });
        </script>


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
<?php /* Created By Sameer Khowaja */ ?>