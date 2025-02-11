
<!DOCTYPE html>
<html ng-app="app">
      <!-- HEAD SECTION-->
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/img/logo.ico"/>
    <title> LEASING TRACING</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">   
    <!-- Main STYLE SECTION-->
 
    <!--<link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/component.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/angular-chart.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/tab.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/button.css">     
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/upload_form.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/modal.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/fileinput.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/noty-animate.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/animate.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/angular-datepicker.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/fileinput/css/fileinput.min.css">

    <script>
        var $base_url = `<?=base_url()?>`;
    </script>
    <!-- END Main_tsms STYLE SECTION-->
</head>
<body ng-controller="decontroller">

<nav class="navbar">
    <div class="container-fluid">
        <!-- Nav tabs -->
        <ul class="nav navbar-nav nav-pills main-menu" role="tablist" style="border-bottom: solid 1px #ccc;">
            <li class="<?= $this->session->userdata('server') == 'MAIN' ? 'active' : ''; ?>">
                <a href="http://172.16.161.37/AGC-PMS/index.php/ctrl_leasing/home" style="font-weight: bolder;"><span class="glyphicon glyphicon-circle-arrow-left"></span> BACK TO LEASING</a>
            </li>
            <li role="presentation" id="single-entry">
                <a href="http://172.16.43.75/dummy/cntrl_tsms/"  id="single-entry">Single Entry</a>
            </li>
            <li role="presentation" id="sl-report">
                <a href="http://172.16.43.75/dummy/cntrl_tsms/sl_report">Subsidiary Ledger</a>
            </li>
           
            <li role="presentation "  id="per-tenant">
                <a href="http://172.16.43.75/dummy/cntrl_tsms/per_tenant" aria-controls="messages">Per Tenant Ledger</a>
            </li>
            <li role="presentation "  id="generate-txtfile">
                <a href="http://172.16.43.75/dummy/cntrl_tsms/generate_nav_txtfile" aria-controls="messages">Generate Textfiles</a>
            </li>

            <li role="presentation "  id="nav-docno">
                <a href="http://172.16.43.75/dummy/cntrl_tsms/nav_by_docno" aria-controls="messages">Navigate by Doc No.</a>
            </li>
        </ul>

        <ul class="nav navbar-nav nav-pills navbar-right">
            <li class="<?= $this->session->userdata('server') == 'MAIN' ? 'active' : ''; ?>">
                <a href="<?=base_url('cntrl_tsms/set_server/MAIN') ?>" style="font-weight: bolder;"><span class="glyphicon glyphicon-flag"></span> MAIN</a>
            </li>
            <li class="<?= in_array($this->session->userdata('server'), ['MAIN', 'cas']) ? '' : 'active'; ?>">
                <a href="<?=base_url('cntrl_tsms/set_server/talibon') ?>" style="font-weight: bolder;"><span class="glyphicon glyphicon-flag"></span> TALIBON</a>
            </li>
            <li class="<?= in_array($this->session->userdata('server'), ['MAIN', 'talibon']) ? '' : 'active'; ?>">
                <a href="<?=base_url('cntrl_tsms/set_server/cas') ?>" style="font-weight: bolder;"><span class="glyphicon glyphicon-flag"></span> CAS</a>
            </li>
        </ul> 
    </div>
</nav>   

<!-- Confirmation Modal -->
<div class="modal fade bounce animated" id = "confirmation_modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-question-circle"></i> Confirmation</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <span id="confirm_msg">You wish to delete this data?</span>
                    </div>        
                </div>
                <div class="modal-footer">
                    <a href="#" id="anchor_delete" class="btn btn-danger"><i class="fa fa-trash"></i> Proceed</a>
                    <button type="button" class="btn btn-primary" data-dismiss="modal"> <i class="fa fa-close"></i> Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<!-- End Confirmation Modal -->

<div class="modal fade bounce animated" id = "confirmation_modal1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-question-circle"></i> Confirmation</h4>
            </div>
            
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <span id="confirm_msg">You sure you to Upload this Data?</span>
                    </div>        
                </div>
                <div class="modal-footer">
                    <a href="#" id="anchor_confirm" class="btn btn-success"><i class="fa fa-chevron-circle-up"></i> Upload</a>
                    <button type="button" class="btn btn-primary" data-dismiss="modal"> <i class="fa fa-close"></i> Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

<div class="modal fade bounce animated" id = "confirmation_modal2">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-question-circle"></i> Confirmation</h4>
            </div>
            
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <span id="confirm_msg">Approve?</span>
                    </div>        
                </div>
                <div class="modal-footer">
                    <a href="#" id="anchor_approve" class="btn btn-success"><i class="fa fa-thumbs-up"></i> Approve</a>
                    <button type="button" class="btn btn-primary" data-dismiss="modal"> <i class="fa fa-close"></i> Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

<div class="modal fade bounce animated" id = "confirmation_modal3">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-question-circle"></i> Confirmation</h4>
            </div>
            
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <span id="confirm_msg">Block User?</span>
                    </div>        
                </div>
                <div class="modal-footer">
                    <a href="#" id="anchor_block" class="btn btn-success"><i class="fa fa-thumbs-up"></i> Approve</a>
                    <button type="button" class="btn btn-primary" data-dismiss="modal"> <i class="fa fa-close"></i> Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

<div class="modal fade bounce animated" id = "confirmation_modal4">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-question-circle"></i> Confirmation</h4>
            </div>
            
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <span id="confirm_msg">Disapprove?</span>
                    </div>        
                </div>
                <div class="modal-footer">
                    <a href="#" id="anchor_disapprove" class="btn btn-default"><i class="fa fa-thumbs-up"></i> Disapprove</a>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-close"></i> Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

<div class="modal fade bounce animated" id="change_username">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-user"></i> Change Username</h4>
            </div>
            <form 
                autocomplete="off"
                name="username_form" 
                ng-submit="formSubmit($base_url + 'tsms_controller/change_username', $event, 'clearUserSetting', '#change_username', 'Are you sure you want to continue changing your username?')">        

                <div class="modal-body" style="padding-bottom: 0">
                    <label>New Username: </label><br>
                    <input autocomplete="off" type="text" name="username" ng-model="cu_username" class="form-control">

                    <label>Confirm Password: </label><br>
                    <input autocomplete="off" type="password" name="password" ng-model="cu_password" class="form-control" >

                    <br>
                    <p class="text-info" style="font-size: 11px;">Enter your password to proceed changing your username.</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Change</button>
                    <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
                </div>
                
            </form>
            
        </div>
    </div>
</div>

<div class="modal fade bounce animated" id="change_password">
    <div class="modal-dialog" style="width: 400px !important">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-key"></i> Change Password</h4>
            </div>
            <form 
                autocomplete="off" 
                name="password_form" 
                ng-submit="formSubmit($base_url + 'tsms_controller/change_password', $event, 'clearUserSetting', '#change_password', 'Are you sure you want to continue changing your password?')">        
                <div class="modal-body" style="padding-bottom: 0">
                    <label>Current Password:</label>
                    <input 
                        autocomplete="off" 
                        type="password" 
                        name="curr_password" 
                        class="form-control"
                        required
                        ng-model="curr_password">
                        <div class="validate-error" style="font-size: 11px;">
                            <span style="color:red" ng-show="password_form.curr_password.$dirty && password_form.curr_password.$error.required">
                                <p class="error-display">This field is required.</p>
                            </span>
                        </div> 

                    <label>New Password:</label>
                    <input 
                        autocomplete="off" 
                        type="password" 
                        name="new_password" 
                        class="form-control"
                        minlength= "5"
                        required
                        ng-model="new_password">
                        <div class="validate-error" style="font-size: 11px;">
                            <span style="color:red" ng-show="password_form.new_password.$dirty && password_form.new_password.$error.required">
                                <p class="error-display">This field is required.</p>
                            </span>
                            <span style="color:red" ng-show="password_form.new_password.$dirty && password_form.new_password.$error.minlength">
                                <p class="error-display">Atleast 5 characters.</p>
                            </span>
                        </div>  
                        


                    <label>Confirm Password:</label>
                    <input 
                        autocomplete="off" 
                        type="password" 
                        name="conf_password" 
                        class="form-control"
                        required=""
                        ng-model="conf_password"
                        data-password-verify="new_password">

                    <div class="validate-error" style="font-size: 11px;">
                        <span style="color:red" ng-show="password_form.conf_password.$dirty && password_form.conf_password.$error.required">
                            <p class="error-display">This field is required.</p>
                        </span>
                        <span style="color:red" ng-show="password_form.conf_password.$dirty && password_form.conf_password.$error.passwordVerify">
                            <p class="error-display">Password Confirmation does not matched!</p>
                        </span>
                    </div>  
                    <br>
                    <p class="text-info" style="font-size: 11px;">Please do not to give any sensitive information (username/password) of your acccount.</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" ng-disabled="password_form.$invalid" class="btn btn-primary">Change Password</button>
                    <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
                </div>
                
            </form>
            
        </div>
    </div>
</div>


<style type="text/css">
    .nav .active a {
        border-radius: 0px !important;
    }
</style>