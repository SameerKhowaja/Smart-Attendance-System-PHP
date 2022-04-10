<?php /* Created By Sameer Khowaja */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>QR Card Generator</title>
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
        <script src="assets/cdn/jquery-1-10-2.js"></script>
        <script src="assets/cdn/jquery-ui.js"></script>
    </head>
    <?php include('dbcon.php'); ?>
    <body>
        <?php include('session.php'); ?>
        <?php include ('phpqrcode/qrlib.php'); ?>

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
                            <a class="active-menu" type="button" data-toggle="modal" data-target="#qrCardGenerator"><i class="fa fa-qrcode fa-3x"></i> QR Card Generator</a>
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
                            <h2>Generate QR Card for Member ID: <?php echo $_GET['member_id']; ?></h2>
                        </div>
                    </div>
                    <hr />
                    <?php
                        $member_id=$_GET['member_id'];
                        $query1=mysqli_query($conn, "SELECT m.member_id, m.formid_number, m.firstname, m.lastname, d.dept_id, d.dept_name, m.doj, m.position, m.member_qr, m.image_file FROM member m JOIN department d ON m.dept_id = d.dept_id WHERE m.member_id='$member_id' AND m.status='1'")or die(mysqli_error());
                        $rowcount=mysqli_num_rows($query1);
                        if($rowcount > 0){
                            while($row=mysqli_fetch_array($query1)){
                                $member_id=$row['member_id'];
                    ?>

                    <div id="html-content-holder" style="background-color:#fff;">
                        <div class="row" style="border:1px dotted black; margin:35px 30px; padding:15px 10px;">
                            <div class="col-md-12">
                                <!-- Left Side -->
                                <div class="col-md-1" style="margin:0px; padding:0px;"></div>
                                <div class="col-md-5">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <?php
                                                if($row['image_file'] != NULL){
                                                    echo '<img id="member_mage" class="img-thumbnail" style="width:300px; height:270px;" alt="Your Image" src="data:image/jpeg;base64,'.base64_encode($row['image_file']).'"/>';
                                                }
                                                else{
                                                    echo '<img id="member_mage" class="img-thumbnail" style="width:300px; height:270px;" src="assets/images/no-image.jpg" alt="Your Image">';
                                                }   
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <h4 style="text-align:center;"><b>Joining Date: </b><?php echo $row['doj']; ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Left Side -->
                                <?php /* Created By Sameer Khowaja */ ?>
                                <!-- Right Side -->
                                <div class="col-md-5" style="margin:0px; padding:0px;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <h3 style="text-align:center;"><b><?php echo $row['dept_name']; ?></b></h3>
                                                <h3 style="text-align:center; border:1px solid black; padding:2px; margin:1px;" class="member-fullname"><?php echo $row['firstname']." ".$row['lastname']; ?></h3>
                                                <h3 style="text-align:center; border:1px solid black; padding:2px; margin:1px;"><?php echo $row['position']; ?></h3>
                                            </div>
                                            <?php
                                                try{
                                                    $fileLocation="assets/images/qr/".$row['member_id'].".png";
                                                    if (file_exists($fileLocation)) {
                                                        unlink($fileLocation);
                                                    }
                                                    QRcode::png($row['member_qr'], $fileLocation, 'L', 100, 1);
                                                
                                            ?>
                                                <div class="row" style="text-align:center;margin-top:5px;">
                                                    <img id="member_mage" class="img-thumbnail" style="width:250px; height:190px; margin:auto;" src="<?php echo $fileLocation; ?>" alt="QR Image Error">
                                                </div>
                                            <?php
                                                }
                                                catch(Exception $e){
                                            ?>
                                                <div class="row" style="text-align:center;margin-top:5px;">
                                                    <img id="member_mage" class="img-thumbnail" style="width:250px; height:190px; margin:auto;" alt="QR Image Error">
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1" style="margin:0px; padding:0px;"></div>
                                <!-- Right Side -->
                            </div>
                        </div>
                    </div>
                    <!-- <p><?php // echo $row['member_qr']; ?></p>-->
                    <hr />
                    <div style="margin:20px; text-align:center;">
                        <input id="btn-Preview-Image" type="button" class="btn btn-info btn-lg" style="width:300px;" value="Preview"/>
                        <a id="btn-Convert-Html2Image" href="#" class="btn btn-primary btn-lg" style="width:300px;">Download</a>
                    </div>
                    <hr>

                    <div id="previewImage"></div>

                    <?php } } else{ echo "<h1 style='text-align:center;'>NO Data Found!</h1>"; } ?>
                    <hr />
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
        <!-- SAVE DIV AS IMAGE -->
        <script src="assets/cdn/jquery-min.js"></script>
        <script src="assets/cdn/html2canvas.js"></script>
        <script>
            $(document).ready(function(){
                var element = $("#html-content-holder"); // global variable
                var getCanvas; // global variable
                var imgFileName = $('.member-fullname').text().replace(/\s+/g, '_').toLowerCase();
            
                $("#btn-Preview-Image").on('click', function () {
                    html2canvas(element, {
                    onrendered: function (canvas) {
                            $("#previewImage").append(canvas);
                            getCanvas = canvas;
                        }
                    });
                });

                $("#btn-Convert-Html2Image").on('click', function () {
                    var imgageData = getCanvas.toDataURL("image/png");
                    // Now browser starts downloading it instead of just showing it
                    var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
                    $("#btn-Convert-Html2Image").attr("download", imgFileName+".png").attr("href", newData);
                });
            });
        </script>

    </body>
</html>
<?php /* Created By Sameer Khowaja */ ?>