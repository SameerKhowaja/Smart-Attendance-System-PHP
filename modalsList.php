<?php include('dbcon.php'); ?>

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

<!-- Modal qrCardGenerator -->
<div class="modal fade" id="qrCardGenerator" tabindex="-1" role="dialog" aria-labelledby="qrCardGenerator" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3><b>Generate QR Card of Member</b></h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered table-hover table-responsive dataTables-memberQRList">
                            <thead>
                                <th style="text-align:center;">Form ID</th>
                                <th style="text-align:center;">Full Name</th>
                                <th style="text-align:center;">Department Name</th>
                                <th style="text-align:center;">Postion</th>
                                <th style="text-align:center;">Joining Date</th>
                                <th style="text-align:center;">Action</th>
                            </thead>
                            <tbody>
                                <?php 
                                $query_list=mysqli_query($conn, "SELECT m.member_id, m.formid_number, m.firstname, m.lastname, d.dept_id, d.dept_name, m.doj, m.position FROM member m JOIN department d ON m.dept_id = d.dept_id WHERE m.status='1'")or die(mysqli_error());
                                $rowcount=mysqli_num_rows($query_list);
                                if($rowcount > 0){
                                    while($row=mysqli_fetch_array($query_list)){
                                        $member_id=$row['member_id'];
                                ?>
                                <tr>
                                    <td style="text-align:center;"><?php echo $row['formid_number']; ?></td>
                                    <td style="text-align:center;"><?php echo $row['firstname']." ".$row['lastname']; ?></td>
                                    <td style="text-align:center;"><?php echo $row['dept_name']; ?></td>
                                    <td style="text-align:center;"><?php echo $row['position']; ?></td>
                                    <td style="text-align:center;"><?php echo $row['doj']; ?></td>
                                    <td style="text-align:center;">
                                        <?php 
                                            $urlStr=$_SERVER['PHP_SELF'];
                                            if(strpos($urlStr, "member_form") !== false || strpos($urlStr, "update_member") !== false || strpos($urlStr, "view_attendance") !== false){
                                        ?>
                                            <a id="<?php echo $member_id; ?>" href="../qrCardGenerator.php?member_id=<?php echo $member_id; ?>" target="_blank" class="btn btn-danger btn-sm">Generate QR</a>
                                        <?php } else{ ?>
                                            <a id="<?php echo $member_id; ?>" href="qrCardGenerator.php?member_id=<?php echo $member_id; ?>" target="_blank" class="btn btn-danger btn-sm">Generate QR</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php }} else{ echo "<h3 style='text-align:center;'>NO Data Found!</h3>"; } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal qrCardGenerator -->


