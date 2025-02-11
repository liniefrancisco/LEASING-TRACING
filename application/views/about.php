<section id="Homepage">
<div class="container">
    <div class="well">
        <div class="panel panel-default">
          <!-- Default panel contents -->
            <div class="panel-heading panel-leasing"><i class="fa fa-users"></i> User Setup</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3 pull-right">
                        <input type = "text" class="form-control search-query" placeholder="Search Here..." ng-model="query" />
                    </div>
                    <div class="col-md-3 pull-left">
                        <a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#add_data" class = "btn btn-success btn-medium"><i class = "fa fa-plus-circle"></i> Add Data</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered" width="100%" ng-controller="tableController" ng-init="loadList('<?php echo base_url(); ?>index.php/leasing_mstrfile/get_leasing_users')">
                            <thead>
                                <tr>
                                    <th><a href="#" data-ng-click="sortField = 'full_name'; reverse = !reverse">Full Name</a></th>
                                    <th><a href="#" data-ng-click="sortField = 'username'; reverse = !reverse">Username</a></th>
                                    <th><a href="#" data-ng-click="sortField = 'user_type'; reverse = !reverse">User Type</a></th>
                                    <th><a href="#" data-ng-click="sortField = 'user_group'; reverse = !reverse">User Group</a></th>
                                    <th><a href="#" data-ng-click="sortField = 'status'; reverse = !reverse">Status</a></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
         
                            <tfoot>
                                <tr class="ng-cloak">
                                    <td colspan="7" style="padding: 5px;">
                                        <div >
                                            <ul class="pagination">
                                                <li ng-show="dataList.length!=0 && (dataList | filter:query).length != 0" ng-class="prevPageDisabled()">
                                                    <a href ng-click="prevPage()" style="border-radius: 0px;"><i class="fa fa-angle-double-left"></i> Prev</a>
                                                </li>
                                                <li ng-show="dataList.length!=0 && (dataList | filter:query).length != 0" ng-repeat="n in range()" ng-class="{active: n == currentPage}" ng-click="setPage(n)">
                                                <a href="#">{{n+1}}</a>
                                                </li>
                                                <li ng-show="dataList.length!=0 && (dataList | filter:query).length != 0" ng-class="nextPageDisabled()">
                                                    <a href ng-click="nextPage()" style="border-radius: 0px;">Next <i class="fa fa-angle-double-right"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- END OF WELL DIV  -->

      

</div> <!-- /.container -->
</section>

</body>
     <!-- Update Modal -->
    <div class="modal fade" id = "update_modal">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-edit"></i> Update Leasing User</h4>
                </div>
                <div class="modal-body" ng-repeat = "data in updateData">
                    <form action = "{{ 'update_leasingUser/' + data.id }}" method="post" novalidate name = "frm_update" id = "frm_update">
                        <div class="row">
                            <div class="col-md-11">
                                <div class="row">
                                    <div class="form-group">
                                        <label for="first_name" class="col-md-4 control-label text-right"><i class = "fa fa-asterisk"></i>First Name</label>
                                        <div class="col-md-8">
                                            <input 
                                                type="text" 
                                                required
                                                class="form-control" 
                                                ng-model="data.first_name"
                                                id="first_name"
                                                name = "first_name"
                                                autocomplete="off">
                                            <!-- FOR ERRORS -->
                                            <div class="validation-Error">
                                                <span ng-show="frm_update.first_name.$dirty && frm_update.first_name.$error.required">
                                                    <p class="error-display">This field is required.</p>
                                                </span>
                                            </div>  
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <label for="last_name" class="col-md-4 control-label text-right"><i class = "fa fa-asterisk"></i>Last Name</label>
                                        <div class="col-md-8">
                                            <input 
                                                type="text" 
                                                required
                                                class="form-control" 
                                                ng-model="data.last_name"
                                                id="last_name"
                                                name = "last_name"
                                                autocomplete="off">
                                            <!-- FOR ERRORS -->
                                            <div class="validation-Error">
                                                <span ng-show="frm_update.last_name.$dirty && frm_update.last_name.$error.required">
                                                    <p class="error-display">This field is required.</p>
                                                </span>
                                            </div>  
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <label for="username" class="col-md-4 control-label text-right"><i class = "fa fa-asterisk"></i>Username</label>
                                        <div class="col-md-8">
                                            <input 
                                                type="text" 
                                                required
                                                class="form-control" 
                                                ng-model="data.username"
                                                id="username"
                                                name = "username"
                                                autocomplete="off"
                                                ng-minlength="5"
                                                is-unique-update
                                                is-unique-id = "{{data.id}}"
                                                is-unique-api = "<?php echo base_url(); ?>index.php/for_validation/verifyandupdate_user/"
                                                ng-pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{5,}$/"
                                                autocomplete = "off"/>
                                            <!-- FOR ERRORS -->
                                            <div class="validation-Error">
                                                <span ng-show="frm_update.username.$dirty && frm_update.username.$error.required">
                                                    <p class="error-display">This field is required.</p>
                                                </span>
                                                <span ng-show="frm_update.username.$dirty && frm_update.username.$error.minlength">
                                                    <p class="error-display">Atleast 5 characters.</p>
                                                </span>
                                                <span ng-show="frm_update.username.$dirty && frm_update.username.$error.unique">
                                                    <p class="error-display">Username is already taken.</p>
                                                </span>
                                                <span ng-show="frm_update.username.$dirty && frm_update.username.$error.pattern">
                                                    <p class="error-display">A combination of alphanumeric characters and at least 1 upppercase.</p>
                                                </span>
                                            </div>  
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <label for="user_type" class="col-md-4 control-label text-right"><i class = "fa fa-asterisk"></i>User Type</label>
                                        <div class="col-md-8">
                                            <select
                                                class = "form-control" 
                                                name = "user_type" 
                                                required
                                                ng-model="data.user_type"
                                                id = "user_type">
                                                <option value="" disabled="" selected="" style="display:none">Please Select One</option>
                                                <option>Administrator</option>
                                                <option>Store Manager</option>
                                                <option>Supervisor</option>
                                                <option>Documentation Officer</option>
                                                <option>Accounting Staff</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="row" ng-show="data.user_type != 'Administrator'">
                                    <div class="form-group">
                                        <label for="user_group" class="col-md-4 control-label text-right"><i class = "fa fa-asterisk"></i>User Group</label>
                                        <div class="col-md-8">
                                            <select
                                                class = "form-control" 
                                                name = "user_group" 
                                                required
                                                id = "user_group">
                                                    <option selected="selected">{{data.store_name}}</option>
                                                <?php foreach ($stores as $value): ?>
                                                    <option><?php echo $value['store_name']; ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                            
                        <div class="modal-footer">
                            <button type="submit" ng-disabled = "frm_update.$invalid" class="btn btn-primary"> <i class = "fa fa-save"></i> Save Changes</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class = "fa fa-close"></i> Close</button>
                        </div>
                    </form>
                </div>
                
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Update Store Modal -->

    <!-- Add Data Modal -->
    <div class="modal fade" id = "add_data">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-pencil"></i> Add User</h4>
                </div>
                <form action="<?php echo base_url(); ?>index.php/main/add_user" name="add_form" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-11">
                                <div class="row">
                                    <div class="form-group">
                                        <label for="first_name" class="col-md-4 control-label text-right"><i class = "fa fa-asterisk"></i>First Name</label>
                                        <div class="col-md-8">
                                            <input 
                                                type="text" 
                                                required
                                                class="form-control" 
                                                ng-model="first_name"
                                                id="first_name"
                                                name = "first_name"
                                                autocomplete="off">
                                            <!-- FOR ERRORS -->
                                           
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="form-group">
                                        <label for="last_name" class="col-md-4 control-label text-right"><i class = "fa fa-asterisk"></i>Last Name</label>
                                        <div class="col-md-8">
                                            <input 
                                                type="text" 
                                                required
                                                class="form-control" 
                                                ng-model="last_name"
                                                id="last_name"
                                                name = "last_name"
                                                autocomplete="off">
                                            <!-- FOR ERRORS -->
                                           
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <label for="username" class="col-md-4 control-label text-right"><i class = "fa fa-asterisk"></i>Username</label>
                                        <div class="col-md-8">
                                            <input 
                                                type="text" 
                                                required
                                                class="form-control" 
                                                ng-model="username"
                                                id="username"
                                                name = "username"
                                                autocomplete="off"
                                                ng-minlength="5"
                                                is-unique
                                                is-unique-api = "<?php echo base_url(); ?>index.php/for_validation/verify_username/"
                                                ng-pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{5,}$/"
                                                autocomplete = "off"/>
                                            <!-- FOR ERRORS -->
                                        
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <label for="password" class="col-md-4 control-label text-right"><i class = "fa fa-asterisk"></i>Password</label>
                                        <div class="col-md-8">
                                            <input 
                                                type="password" 
                                                required
                                                class="form-control" 
                                                ng-model="password"
                                                id="password"
                                                name = "password"
                                                ng-minlength = "5"
                                                autocomplete="off"
                                                ng-pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{5,}$/">
                                            <!-- FOR ERRORS -->
                                           
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <label for="cpassword" class="col-md-4 control-label text-right"><i class = "fa fa-asterisk"></i>Re-Password</label>
                                        <div class="col-md-8">
                                            <input 
                                                type="password" 
                                                required
                                                class="form-control" 
                                                ng-model="cpassword"
                                                id="cpassword"
                                                name = "cpassword"
                                                data-password-verify="password">
                                            <!-- FOR ERRORS -->
                                            <div class="validation-Error">
                                                <span ng-show="add_form.cpassword.$dirty && add_form.cpassword.$error.required">
                                                    <p class="error-display">This field is required.</p>
                                                </span>
                                                <span ng-show="add_form.cpassword.$dirty && add_form.cpassword.$error.passwordVerify">
                                                    <p class="error-display">Password not match.</p>
                                                </span>
                                            </div>  
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="form-group">
                                        <label for="user_type" class="col-md-4 control-label text-right"><i class = "fa fa-asterisk"></i>User Type</label>
                                        <div class="col-md-8">
                                            <select
                                                class = "form-control" 
                                                name = "user_type" 
                                                required
                                                ng-model="user_type"
                                                id = "user_type">
                                                <option value="" disabled="" selected="" style="display:none">Please Select One</option>
                                                <option>Administrator</option>
                                                <option>Store Manager</option>
                                                <option>Supervisor</option>
                                                <option>Documentation Officer</option>
                                                <option>Accounting Staff</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                               
                    <div class="modal-footer">
                        <button type="submit" ng-disabled = "add_form.$invalid" class="btn btn-primary"> <i class = "fa fa-save"></i> Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class = "fa fa-close"></i> Close</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Data Modal -->