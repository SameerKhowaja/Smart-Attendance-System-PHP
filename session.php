<?php
    //Start session
    session_start();
    //Check whether the session variable SESS_MEMBER_ID is present or not
    if (!isset($_SESSION['username']) || (trim($_SESSION['username']) == '')) {
        header("location: index.php");
        exit();
    }
    $session_id=$_SESSION['username'];
?>

<!-- Modal Error -->
<div class="modal fade" id="modal_error" tabindex="-1" role="dialog" aria-labelledby="modal_error" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <div class="card-img"> <img style="width:70px; height:70px;" class="img-fluid" src="assets/images/error.png"> </div>
                    <h1 style="color:red;"><b>Error!</b></h1>
                    <h4>Transaction Failed</h4>
                    <button style="margin-top:10px; width:150px" class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Error -->

<!-- Modal Success -->
<div class="modal fade" id="modal_success" tabindex="-1" role="dialog" aria-labelledby="modal_success" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <div class="card-img"> <img style="width:70px; height:70px;" class="img-fluid" src="assets/images/success.png"> </div>
                    <h1 style="color:green;"><b>Success!</b></h1>
                    <h4>Transaction Completed</h4>
                    <button style="margin-top:10px; width:150px" class="btn btn-success" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Success -->