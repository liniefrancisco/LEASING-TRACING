    
    <div class="modal fade" id = "pop-confirmation">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" onclick="pop.resolve(false)" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="pop-confirm-title"><i class="fa fa-warning"></i> Confirm</h4>
                </div>
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <span id="pop-confirm-message">Please confirm action to proceed!</span>
                        </div>        
                    </div>
                    
                </div><!-- /.modal-content -->
                <div class="modal-footer">
                    <button type="button"  onclick="pop.resolve(true)" id="pop-confirm-positive" name="btn-archive" class="btn btn-info" data-dismiss="modal"><i class="fa fa-check"></i> Confirm</button>
                    <button type="button" onclick="pop.resolve(false)" id="pop-confirm-negative" class="btn btn-primary" data-dismiss="modal"> <i class="fa fa-close"></i> Cancel</button>
                </div>

            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
    <!-- End Confirmation Modal -->

    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/angular.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/app.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/notification.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/massautocomplete.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/Chart.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.noty.packaged.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/fileinput.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/mask.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/ajax.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/angular.mask.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/angular-chart.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/directive.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/angular-input-masks-standalone.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/angular-datepicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/myplugin.js"></script>
    <script src="<?php echo base_url(); ?>node_modules/angular-money-mask/rw-money-mask.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/fileinput/js/fileinput.min.js"></script>
    <script type="text/javascript">

    <?php 
        if(isset($flashdata)):
        switch($flashdata): 
        case "Invalid Login": ?>
            generate('error', '<div class="activity-item bounce animated"> <i class="fa fa-ban text-success"></i> Invalid Login</div>');
        <?php break;?>
        
        <?php case "Added": ?>
            generate('success', '<div class="activity-item bounce animated"> <i class="fa fa-check text-success"></i> Successfully Saved.</div>');
        <?php break;?>

         <?php case "No Changes": ?>
            generate('success', '<div class="activity-item bounce animated"> <i class="fa fa-check text-success"></i> No Changes have been made.</div>');
        <?php break;?>

        <?php case "No Data": ?>
            generate('success', '<div class="activity-item bounce animated"> <i class="fa fa-check text-success"></i> No Data found.</div>');
        <?php break;?>

        <?php case "No File": ?>
            generate('error', '<div class="activity-item bounce animated"> <i class="fa fa-check text-success"></i> No File Selected.</div>');
        <?php break;?>

        <?php case "Files Dont Match": ?>
            generate1('error', '<div class="activity-item bounce animated"> <i class="fa fa-ban text-success"></i> Sales dont match but uploaded. View Variance Report</div>');
        <?php break;?>

        <?php case "Data Not Checked": ?>
            generate('error', '<div class="activity-item bounce animated"> <i class="fa fa-ban text-success"></i> Data Not Checked.</div>');
        <?php break;?>

        <?php case "Data Not Confirmed": ?>
            generate('error', '<div class="activity-item bounce animated"> <i class="fa fa-ban text-success"></i> Data Not Confirmed.</div>');
        <?php break;?>

          <?php case "Uploaded": ?>
            generate('success', '<div class="activity-item bounce animated"> <i class="fa fa-check text-success"></i> Sales Match and Successfully Uploaded.</div>');
        <?php break;?>

        <?php case "Already Checked": ?>
            generate('error', '<div class="activity-item bounce animated"> <i class="fa fa-check text-success"></i> Data Already Checked.</div>');
        <?php break;?>

        <?php case "Already Exist": ?>
            generate('error', '<div class="activity-item bounce animated"> <i class="fa fa-ban text-success"></i> Data Already Exist.</div>');
        <?php break;?>

        <?php case "Not saved": ?>
            generate('success', '<div class="activity-item bounce animated"> <i class="fa fa-ban text-success"></i> Transaction not saved. Error Occured.</div>');
        <?php break;?>

        <?php case "Deleted": ?>
            generate('error', '<div class="activity-item bounce animated"> <i class="fa fa-check text-success"></i> Successfully Deleted.</div>');
        <?php break;?>

        <?php case "Error": ?>
            generate('error', '<div class="activity-item bounce animated"> <i class="fa fa-ban text-success"></i> Error Occured. Action not saved.</div>');
        <?php break;?>

        <?php case "Updated": ?>
            generate('success', '<div class="activity-item bounce animated"> <i class="fa fa-check text-success"></i> Successfully Updated.</div>');
        <?php break;?>

        <?php case "Blocked": ?>
            generate('success', '<div class="activity-item bounce animated"> <i class="fa fa-check text-success"></i> User Successfully Blocked.</div>');
        <?php break;?>

        <?php case "Activated": ?>
            generate('success', '<div class="activity-item bounce animated"> <i class="fa fa-check text-success"></i> User Successfully Activated.</div>');
        <?php break;?>

        <?php case "Reset": ?>
            generate('success', '<div class="activity-item bounce animated"> <i class="fa fa-check text-success"></i> Password Successfully Reset.</div>');
        <?php break;?>

         <?php case "Successfully Updated": ?>
            generate('error', '<div class="activity-item bounce animated"> <i class="fa fa-times text-alert"></i> Invalid File</div>');
        <?php break;?>

        <?php case "Invalid File": ?>
            generate('error', '<div class="activity-item bounce animated"> <i class="fa fa-times text-alert"></i> Invalid File</div>');
        <?php break;?>

        <?php case "Incorrect": ?>
            generate('error', '<div class="activity-item bounce animated"> <i class="fa fa-times text-alert"></i> File Type Incorrect</div>');
        <?php break;?>

        <?php case "Not Match": ?>
            generate('error', '<div class="activity-item bounce animated"> <i class="fa fa-times text-alert"></i> Tenant Name Dont Match with the File</div>');
        <?php break;?>

        <?php case "Approved": ?>
            generate('success', '<div class="activity-item bounce animated"> <i class="fa fa-check text-success"></i> Approved</div>');
        <?php break;?>

        <?php case "To be reviewed": ?>
            generate('error', '<div class="activity-item bounce animated"> <i class="fa fa-times text-success"></i> Data dont match. To be reviewed</div>');
        <?php break;?>

        <?php case "IncorrectMangersKey": ?>
            generate('error', "Incorrect Manager's Key.");
        <?php break;?>

            generate('success', "Successfully Restored.");
        <?php break;?>
        <?php case "Restriction": ?>
            generate('error', "User Not allowed to do task. Contact Admin");
        <?php break;?>
    <?php endswitch;
    endif;
    ?>
</script>

    </html>