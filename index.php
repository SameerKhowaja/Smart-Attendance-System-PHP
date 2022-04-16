<?php /* Created By Sameer Khowaja */ ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Login</title>
        <link rel="stylesheet" href="assets/cdn/bootstrap-min.css">
        <link rel="stylesheet" href="assets/cdn/font-awesome-min.css">
        <script src="assets/cdn/jquery-3-5-1-min.js"></script>
        <script src="assets/cdn/popper-min.js"></script>
        <script src="assets/cdn/bootstrap-min.js"></script>
        <link rel="stylesheet" href="assets/css/login.css">
    </head>
    <body>
        <?php include('dbcon.php'); ?>
        <?php
            session_start();
            session_destroy();
        ?>
        <div class="login-form">
            <form method="post">
                <img class="logo-center" src="assets/images/logo.png" alt="Logo Image">
                <h2 class="text-center">Log in</h2>       
                <div class="form-group">
                    <input type="text" class="form-control" name="login" placeholder="Username" required="required">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password" required="required">
                </div>
                <div class="form-group">
                    <button id="login-btn" type="submit" name="commit" class="btn btn-danger btn-block">Log in</button>
                    <a id="attendance-btn" href="mark_attendance.php" class="btn btn-primary btn-block">Mark Attendance</a>
                </div>
                <?php /* Created By Sameer Khowaja */ ?>
                <?php
                if (isset($_POST['commit'])){
                    session_start();
                    $username = mysqli_real_escape_string($conn, $_POST['login']);
                    $password = mysqli_real_escape_string($conn, $_POST['password']);
                    $query = "SELECT * FROM admin_user WHERE username='$username' AND password='$password'";
                    
                    $result = mysqli_query($conn, $query)or die(mysqli_error());
                    $num_row = mysqli_num_rows($result);
                    $row = mysqli_fetch_array($result);

                    if( $num_row > 0 ) {
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['fullname'] = $row['fullname'];
                        $_SESSION['deleteable'] = $row['deleteable'];
                        $_SESSION['add_member'] = $row['add_member'];
                        $_SESSION['update_member'] = $row['update_member'];
                        $_SESSION['delete_member'] = $row['delete_member'];
                        $_SESSION['add_department'] = $row['add_department'];
                        $_SESSION['update_department'] = $row['update_department'];
                        $_SESSION['delete_department'] = $row['delete_department'];
                        $_SESSION['update_attendance'] = $row['update_attendance'];
                        $_SESSION['delete_attendance'] = $row['delete_attendance'];
                        $_SESSION['bulk_timeout'] = $row['bulk_timeout'];
                        $_SESSION['transaction'] = "";

                        // update last signin
                        $username = $row['username'];
                        $Today = date('y-m-d');
                        $query2 = "UPDATE admin_user SET last_login_date='$Today' WHERE username='$username'";
                        mysqli_query($conn, $query2)or die(mysqli_error());
                        header('location: dashboard.php');
                    }
                    else{ 
                ?>
                        <div class="alert alert-danger">Access Denied</div>
                <?php
                    }
                }
                ?>

            </form>
        </div>

        <div style="position:fixed; bottom:0; right:0; font-size:12px;">Created By Sameer Khowaja</div>
    </body>
</html>
<?php /* Created By Sameer Khowaja */ ?>