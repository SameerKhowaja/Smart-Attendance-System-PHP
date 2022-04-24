<?php /* Created By Sameer Khowaja */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Add Member</title>
        <!-- BOOTSTRAP STYLES-->
        <link href="../assets/css/bootstrap.css" rel="stylesheet" />
        <!-- FONTAWESOME STYLES-->
        <link href="../assets/css/font-awesome.css" rel="stylesheet" />
        <link rel="stylesheet" href="../assets/fontawesome-free/css/all.css">
        <!-- MORRIS CHART STYLES-->
    
            <!-- CUSTOM STYLES-->
        <link href="../assets/css/custom.css" rel="stylesheet" />
        <!-- GOOGLE FONTS-->
        <link href='../assets/cdn/font-sans.css' rel='stylesheet' type='text/css' />
        <!-- TABLE STYLES-->
        <link href="../assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    </head>
    <?php include('../dbcon.php'); ?>
    <body>
        <?php include('../session.php'); ?>
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
                font-size: 16px;"> Welcome: <?php echo $_SESSION['fullname'] ?> &nbsp; <a href="logout.php" class="btn btn-danger square-btn-adjust"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a> 
                </div>
            </nav>   
           
            <!-- /. NAV TOP  -->
            <nav class="navbar-default navbar-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="main-menu">
                        <li class="text-center">
                            <img src="../assets/images/logo.png" class="user-image img-responsive"/>
                        </li>
                        <li>
                            <a href="../dashboard.php"><i class="fa fa-dashboard fa-2x"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="../department.php"><i class="fa fa-desktop fa-2x"></i> Departments</a>
                        </li>
                        <li>
                            <a class="active-menu" href="../member.php"><i class="fa fa-bar-chart-o fa-3x"></i> Members</a>
                        </li>
                        <li>
                            <a href="../memberByDepartment.php"><i class="fa fa-sitemap fa-2x"></i> Members By Department</a>
                        </li>	
                        <li>
                            <a type="button" data-toggle="modal" data-target="#qrCardGenerator"><i class="fa fa-qrcode fa-2x"></i> QR Card Generator</a>
                        </li>
                        <li>
                            <a href="../attendance.php"><i class="fa fa-table fa-2x"></i> Manage Attendance</a>
                        </li>
                        <li>
                            <a href="../report_backup.php"><i class="fa fa-edit fa-2x"></i> Report/Backup</a>
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
                    <?php if(isset($_SESSION['add_member']) && $_SESSION['add_member']==1){ ?>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Form Elements -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Fill New Member Form
                                    <div class="pull-right">
                                        <a href="../member.php" type="button" class="btn btn-primary btn-xs">
                                            <i class="fa-solid fa-backward"></i> Back
                                        </a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form method="post" enctype="multipart/form-data" action="../transaction/aud_member.php">
                                                <div class="col-md-12">
                                                    <!-- Left Side -->
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <img id="member_mage" class="img-thumbnail" style="width:280px; height:300px;" src="../assets/images/no-image.jpg" alt="Your Image">
                                                                </div>
                                                                <div class="form-group">
                                                                    <input id="image_file" name="image_file" type="file" accept="image/gif, image/jpeg, image/png, image/jpg" onchange="readURL(this);" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Left Side -->
                                                    <?php /* Created By Sameer Khowaja */ ?>
                                                    <!-- Right Side -->
                                                    <div class="col-md-8">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="formid_number">Form ID Number</label>
                                                                    <input id="formid_number" name="formid_number" type="text" class="form-control" placeholder="Your Form ID Number" required/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="dept_id">Department Name</label>
                                                                    <select id="dept_id" name="dept_id" class="form-control">
                                                                        <option value="">-- Please Select --</option>
                                                                        <?php $user_query=mysqli_query($conn, "SELECT * FROM department")or die(mysqli_error());
                                                                            while($row=mysqli_fetch_array($user_query)){
                                                                                $id=$row['dept_id'];
                                                                        ?>
                                                                        <option value="<?php echo $id ?>"><?php echo $row['dept_name']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="firstname">First Name</label>
                                                                    <input id="firstname" name="firstname" type="text" class="form-control" placeholder="Your First Name" required/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="lastname">Last Name</label>
                                                                    <input id="lastname" name="lastname" type="text" class="form-control" placeholder="Your Last Name" required/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="email">Email Address (optional)</label>
                                                                    <input id="email" name="email" type="email" class="form-control" placeholder="Your Email Address"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="contact_number">Contact Number</label>
                                                                    <input id="contact_number" name="contact_number" type="text" class="form-control" placeholder="Your Contact Number" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" required/>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="dob">Date of Birth</label>
                                                                    <input id="dob" name="dob" type="date" class="form-control" required/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="cnic">CNIC Number</label>
                                                                    <input id="cnic" name="cnic" type="text" class="form-control" placeholder="Your CNIC Number" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" required/>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="gender">Gender</label>
                                                                    <select id="gender" name="gender" class="form-control">
                                                                        <option value="">-- Please Select --</option>
                                                                        <option value="Male">Male</option>
                                                                        <option value="Female">Female</option>
                                                                        <option value="Other">Other</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="marital_status">Marital Status</label>
                                                                    <select id="marital_status" name="marital_status" class="form-control">
                                                                        <option value="">-- Please Select --</option>
                                                                        <option value="Single">Single</option>
                                                                        <option value="Married">Married</option>
                                                                        <option value="Divorced">Divorced</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        
                                                    </div>
                                                    <!-- Right Side -->
                                                </div>
                                                <?php /* Created By Sameer Khowaja */ ?>
                                                <!-- Center -->
                                                <div class="col-md-12">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="doj">Date of Joining</label>
                                                                    <input id="doj" name="doj" type="date" class="form-control" required/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="position">Badge / Position</label>
                                                                    <select id="position" name="position" class="form-control">
                                                                        <option value="">-- Please Select --</option>
                                                                        <option value="Chairman">Chairman</option>
                                                                        <option value="Secretary">Secretary</option>
                                                                        <option value="Finance">Finance</option>
                                                                        <option value="Duty Incharge">Duty Incharge</option>
                                                                        <option value="Member">Member</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="city">City</label>
                                                                    <input id="city" name="city" type="text" class="form-control" placeholder="Your City" required/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="country">Country</label>
                                                                    <input id="country" name="country" type="text" class="form-control" placeholder="Your Country" required/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="myaddress">Home Address</label>
                                                                    <textarea id="myaddress" name="myaddress" class="form-control" rows="2" placeholder="Your Home Address" required></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <button style="float:right; width:150px;" name="add_member" type="submit" class="btn btn-danger">Submit Form</button>
                                                        <button style="width:150px;" type="reset" class="btn btn-info">Clear All</button>
                                                    </div>
                                                </div>
                                                <!-- Center -->
                                            </form>                          
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Form Elements -->
                        </div>
                    </div>
                    <?php 
                    }else{
                        echo "<h2 style='text-align:center'>You Do Not Have Rights...!</h2>";
                    } 
                    ?>
                    <!-- /. ROW  -->
                </div>       
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
        <!-- /. WRAPPER  -->

        <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
        <!-- Image Upload Script -->
        <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#member_mage').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        </script>                                                                        
        <!-- JQUERY SCRIPTS -->
        <script src="../assets/js/jquery-1.10.2.js"></script>
        <!-- BOOTSTRAP SCRIPTS -->
        <script src="../assets/js/bootstrap.min.js"></script>
        <!-- METISMENU SCRIPTS -->
        <script src="../assets/js/jquery.metisMenu.js"></script>
        <!-- DATA TABLE SCRIPTS -->
        <script src="../assets/js/dataTables/jquery.dataTables.js"></script>
        <script src="../assets/js/dataTables/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready(function () {
                $('.dataTables-memberQRList').dataTable();
            });
        </script>
            <!-- CUSTOM SCRIPTS -->
        <script src="../assets/js/custom.js"></script>
    </body>
</html>
<?php /* Created By Sameer Khowaja */ ?>