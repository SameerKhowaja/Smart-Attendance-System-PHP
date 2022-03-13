<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Mark Attendance</title>
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>
    <?php include('dbcon.php'); ?>
    <body>
        <div id="wrapper">
            <nav class="navbar navbar-default navbar-cls-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-brand" href="mark_attendance.php"><i class="fa fa-qrcode fa-1x"></i>&nbsp; Attendance</a> 
                </div>
                <div style="color:white; padding:15px 50px 5px 50px; float:right; font-size:16px;">
                    <?php 
                        $Today = date('y:m:d');
                        $new = date('l, F d, Y', strtotime($Today));
                        echo $new;
                    ?> 
                    &nbsp;
                    <a href="index.php" class="btn btn-danger square-btn-adjust">&nbsp;<b><</b>&nbsp; Back</a>
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
                                            <select class="form-control" id="pod_ME" name="pod_ME">
                                                <option value="pm">Evening</option>
                                                <option value="am">Morning</option>
                                            </select>
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
                                            <input id="time_inout" name="time_inout" type="time" class="form-control" value="" required/>
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

            <div class="body-wrap" style="background:white;">
                <div class="row">
                    <!-- Left Side -->
                    <div class="col-md-5">
                        <div class="row">
                            <div class="text-center">
                                <h2 style="margin-bottom:10px;"><b><u>Show QR to Mark Attendance</u></b></h2>
                                <video id="preview" style="width:90%; height:90%; border:2px solid black;"></video>
                                <div style="margin:auto; width:90%;">
                                    <div class="alert alert-success alert-dismissible" id="success" style="display:none;">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                    </div>
                                </div>
                                <div style="margin:auto; width:90%;">
                                    <div class="alert alert-danger alert-dismissible" id="failed" style="display:none;">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#manual_attendance"> Mark Attendance Manually</button>
                            </div>
                        </div>
                    </div>
                    <!-- Left Side -->

                    <!-- Right Side -->
                    <div class="col-md-6">
                        <div class="row">
                            <div class="text-center">
                                <h2 style="margin-bottom:10px;"><b><u>Attendance History</u></b></h2>
                            </div>
                            <div class="table-responsive" id="attendanceTable">
                                <table class="table table-striped table-bordered table-hover table-responsive" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;">Full Name</th>
                                            <th style="text-align:center;">Department</th>
                                            <th style="text-align:center;">AM/PM</th>
                                            <th style="text-align:center;">Time In</th>
                                            <th style="text-align:center;">Time Out</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query="SELECT m.firstname, m.lastname, d.dept_name, a.pod_ME, a.timeIn, a.timeOut FROM `attendance` a JOIN `member` m JOIN `department` d ON m.member_id=a.member_id AND m.dept_id=d.dept_id WHERE a.date=(SELECT MAX(aa.date) FROM `attendance` aa)";
                                        $user_query=mysqli_query($conn, $query)or die(mysqli_error());
                                        while($row=mysqli_fetch_array($user_query)){
                                        ?>
                                        <tr>
                                            <td style="text-align:center;"><?php echo $row['firstname']." ".$row['lastname']; ?></td>
                                            <td style="text-align:center;"><?php echo $row['dept_name']; ?></td>
                                            <td style="text-align:center;"><?php echo $row['pod_ME']=="am" ? "Morning" : "Evening"; ?></td>
                                            <td style="text-align:center;"><?php echo $row['timeIn']; ?></td>
                                            <td style="text-align:center;"><?php echo $row['timeOut']; ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Right Side -->
                </div>      
            </div>
        </div>

        <!-- Camera -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js" rel="nofollow"></script>
        <script type="text/javascript">
            function delay(time) {
                return new Promise(resolve => setTimeout(resolve, time));
            }

            var scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5, mirror: false });
            scanner.addListener('scan',function(content){
                var member_qr = content;
                if(member_qr!=""){
                    $.ajax({
                        url: "transaction/qr_markAttendance.php",
                        type: "POST",
                        data: {
                            member_qr: member_qr				
                        },
                        cache: false,
                        success: function(dataResult){
                            var dataResult = JSON.parse(dataResult);
                            if(dataResult.statusCode==1){
                                $("#failed").hide();
                                $("#success").show();
				                $('#success').html(dataResult.statusMsg);

                                const audio = new Audio("assets/sound/timeInOut_sound.mp3");
                                audio.play();

                                $('#dataTables-example').DataTable().destroy();
                                $("#attendanceTable").load("mark_attendance.php #dataTables-example");
                                delay(500).then(() => $('#dataTables-example').DataTable().draw());
                            }
                            else{
                                $("#success").hide();
                                $("#failed").show();
				                $('#failed').html(dataResult.statusMsg);
                            }
                        }
                    });
                }
            });
            Instascan.Camera.getCameras().then(function (cameras){
                if(cameras.length>0){
                    scanner.start(cameras[0]);
                    $('[name="options"]').on('change',function(){
                        if($(this).val()==1){
                            if(cameras[0]!=""){
                                scanner.start(cameras[0]);
                            }else{
                                alert('No Front camera found!');
                            }
                        }else if($(this).val()==2){
                            if(cameras[1]!=""){
                                scanner.start(cameras[1]);
                            }else{
                                alert('No Back camera found!');
                            }
                        }
                    });
                }else{
                    console.error('No cameras found.');
                    alert('No cameras found.');
                }
            }).catch(function(e){
                console.error(e);
                alert(e);
            });
        </script>
        
        <!-- Add Attendance Manually using Ajax Jquery -->
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
                                    $("#attendanceTable").load("mark_attendance.php #dataTables-example");
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
        </script>
        <!-- CUSTOM SCRIPTS -->
        <script src="assets/js/custom.js"></script>
    </body>
</html>
