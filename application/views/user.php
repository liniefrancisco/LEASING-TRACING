<div class="container">
    <div class="cover1">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-user" aria-hidden="true"></i> User Data </div>
            </div>
            <div id="user_control">
                <div class="col-md-2 pull-left">
                    <button type="button" class="btn btn-success" data-target="#add_data" data-toggle="modal"><i class="fa fa-plus"></i> Add User</button>
                </div>
                <div class="col-md-2 pull-right">
                    <input ng-model="query" class="form-control search-query" placeholder="Search Here..."/>
                </div>
            </div>
        <div class="well">    
            <div class="user-table" id="table2">
                    <table class="table table-bordered table-hover" ng-controller="tablecontroller" ng-init="loadList($base_url +'tsms_controller/get_users'); getStores($base_url +'tsms_controller/get_stores');">
                        <thead>
                            <tr>
                                <th style="text-align:center;">Full Name</th>
                                <th style="text-align:center;">Username</th>
                                <th style="text-align:center;">User Type</th>
                                <th style="text-align:center;">Status</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                    <tbody>
                        <tr class="ng-cloak" ng-show="dataList.length!=0" ng-repeat= "user in dataList | filter:query | orderBy:sortField:reverse | offset: currentPage*itemsPerPage | limitTo: itemsPerPage">
                        <td>{{user.name}} {{user.last_name}}</td>
                        <td>{{user.username}}</td>
                        <td>{{user.user_type}}</td>
                        <td>{{user.status}}</td>
                        <td>
                            <div class="btn-group">            
                                <div class="img_menu">
                                   <img src="<?php echo base_url(); ?>img/menu3.png" style="height: 15px; width: 13px;" data-toggle="dropdown" id="img_menu">
                                     <ul id="ul1" class="dropdown-menu">
                                        <li>
                                            <a href="#" data-backdrop="static" title="View" data-keyboard="false" data-toggle="modal" data-target="#view_modal" ng-click="setData(user)"> <i class = "fa fa-search"></i> View</a>
                                        </li>
                                        <li>
                                            <a href="#" data-backdrop="static" title="Update"data-keyboard="false" data-toggle="modal" data-target="#update_user_modal" ng-click="setData(user)"> <i class = "fa fa-edit"></i> Update</a>
                                        </li>
                                        <li ng-if="user.status == 'Active'">
                                            <a href="#" ng-click="sendAjax($base_url + 'tsms_controller/block_user/' + user.id, 'Do you wish to continue blocking this user?', 'loadList')" > <i class = "fa fa-ban"></i> Block</a>
                                        </li>
                                        <li ng-if="user.status == 'Blocked'">
                                            <a href="#" ng-click="sendAjax($base_url + 'tsms_controller/activate_user/' + user.id, 'Do you wish to continue activating this user?', 'loadList')"> <i class = "fa fa-key"></i> Activate</a>
                                        </li>

                                        <li >
                                            <a href="#" ng-click="sendAjax($base_url + 'tsms_controller/reset_password/' + user.id, 'Do you wish to continue resetting the user\'s password? <br><br> <b>Default : agc-tsms</b>', 'loadList')"> <i class = "fa fa-key"></i> Reset Password</a>
                                        </li>
                                        <li>
                                            <a href="#" ng-click="deleteDataAjax($base_url + 'tsms_controller/delete_user/' + user.id, 'dataList', user)"> <i class = "fa fa-trash"></i> Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>                               
                        </tr>
                        <tr class="ng-cloak" ng-show="dataList.length==0 || (dataList | filter:query).length == 0">
                            <td colspan="7"><center>No Data Available.</center></td>
                        </tr>
                    </tbody>
                    <tfoot>
                         <tr class="ng-cloak">
                            <td colspan="7" style="padding: 5px;">
                                <div>
                                    <ul class="pagination">
                                        <li ng-show="dataList.length!=0 && (dataList | filter:query).length != 0" ng-class="prevPageDisabled()">
                                            <a href ng-click="prevPage()" style="border-radius: 0px;"><i class="fa fa-toggle-left"></i> Prev</a>
                                        </li>
                                        <li ng-show="dataList.length!=0 && (dataList | filter:query).length != 0" ng-repeat="n in range()" ng-class="{active: n == currentPage}" ng-click="setPage(n)">
                                            <a href="#">{{n+1}}</a>
                                        </li>
                                        <li ng-show="dataList.length!=0 && (dataList | filter:query).length != 0" ng-class="nextPageDisabled()">
                                            <a href ng-click="nextPage()" style="border-radius: 0px;">Next <i class="fa fa-toggle-right"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>        
            </div><!--end of table-->    
        </div>
    </div>
</div>
     

<!-- Update User Data Modal -->
     <div class="modal fade" id = "update_user_modal">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-pencil"></i> Update User</h4>
                </div>
                <form ng-submit="formSubmit($base_url + 'tsms_controller/update_user/'+data.id, $event, 'loadList', '#update_user_modal')" method="post" name="update_form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-11">
                                <div class="row">
                                    <div class="form-group">
                                        <label for="first_name" class="col-md-4 control-label text-right"> First Name</label>
                                        <div class="col-md-8">
                                            <input 
                                                type="text" 
                                                required
                                                class="form-control" 
                                                ng-model="data.name"
                                                name = "first_name"
                                                autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <label for="last_name" class="col-md-4 control-label text-right"> Last Name</label>
                                        <div class="col-md-8">
                                            <input 
                                                type="text" 
                                                required
                                                class="form-control" 
                                                ng-model="data.last_name"
                                                name = "last_name"
                                                autocomplete="off">                                        
                                        </div>
                                    </div>
                                </div>
                                <br>
                                 <div class="row">
                                    <div class="form-group">
                                        <label for="username" class="col-md-4 control-label text-right">Username</label>
                                        <div class="col-md-8">
                                            <input 
                                                type="text" 
                                                required
                                                class="form-control" 
                                                ng-model="data.username"
                                                name = "username"
                                                autocomplete = "off"/>                                       
                                        </div>
                                    </div>
                                </div>
                                <br>
                                 
                                <div class="row">
                                    <div class="form-group">
                                        <label for="user_type" class="col-md-4 control-label text-right"> User Type</label>
                                        <div class="col-md-8">
                                            <select
                                                class = "form-control" 
                                                name = "user_type"
                                                required
                                                ng-model="data.user_type">
                                                <option value="" disabled="" selected="" style="display:none">Please Select One</option>
                                                <option>Administrator</option>
                                                <option>Store Manager</option>
                                                <option>Supervisor</option>
                                                <option>Documentation Officer</option>
                                                <option>Accounting Staff</option>
                                                <option>IAD</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <label for="user_group" class="col-md-4 control-label text-right"> User Group</label>
                                        <div class="col-md-8"> 
                                            <select 
                                                class="form-control"
                                                ng-model="data.user_group"
                                                ng-options="s.id as s.store_name for s in stores">
                                                <option selected=""></option>                 
                                            </select>
                                            <input type="hidden" name = "user_group" ng-value="data.user_group">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                              
                    <div class="modal-footer">
                        <button type="submit" ng-disabled="update_form.$invalid" class="btn btn-primary"> <i class = "fa fa-save"></i> Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class = "fa fa-close"></i> Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<!-- Add Data Modal -->
     <div class="modal fade" id = "add_data">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-pencil"></i> Add User</h4>
                </div>
                <form ng-submit="formSubmit($base_url + 'tsms_controller/add_user', $event, 'loadList', '#add_data')" name="add_form" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-11">
                                <div class="row">
                                    <div class="form-group">
                                        <label for="first_name" class="col-md-4 control-label text-right"> First Name</label>
                                        <div class="col-md-8">
                                            <input 
                                                type="text" 
                                                required
                                                class="form-control" 
                                                ng-model="first_name"
                                                id="first_name"
                                                name = "first_name"
                                                autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <label for="last_name" class="col-md-4 control-label text-right"> Last Name</label>
                                        <div class="col-md-8">
                                            <input 
                                                type="text" 
                                                required
                                                class="form-control" 
                                                ng-model="last_name"
                                                name = "last_name"
                                                autocomplete="off">                                        
                                        </div>
                                    </div>
                                </div>
                                <br>
                                 <div class="row">
                                    <div class="form-group">
                                        <label for="username" class="col-md-4 control-label text-right">Username</label>
                                        <div class="col-md-8">
                                            <input 
                                                type="text" 
                                                required
                                                class="form-control" 
                                                ng-model="username"
                                                name = "username"
                                                is-unique
                                                is-unique-api = "<?php echo base_url(); ?>index.php/tsms_controller/verify_username/"
                                                autocomplete = "off"/>
                                            <!-- FOR ERRORS -->
                                            <div class="validation-Error">
                                                <span style="color:red" ng-show="add_form.username.$dirty && add_form.username.$error.unique">
                                                    <p class="error-display">Username is already taken.</p>
                                                </span>
                                                <span style="color:red" ng-show="add_form.username.$dirty && add_form.username.$error.pattern">
                                                    <p class="error-display">A combination of alphanumeric characters and at least 1 upppercase.</p>
                                                </span>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                                <br>
                                 <div class="row">
                                    <div class="form-group">
                                        <label for="password" class="col-md-4 control-label text-right">Password</label>
                                        <div class="col-md-8">
                                            <input 
                                                type="password" 
                                                required
                                                class="form-control" 
                                                ng-model="password"
                                                id="password"
                                                name = "password"
                                                ng-minlength = "5"
                                                autocomplete="off">
                                                <div class="validate-error">
                                                    <span style="color:red" ng-show="add_form.password.$dirty && add_form.password.$error.required">
                                                        <p class="error-display">This field is required.</p>
                                                    </span>
                                                    <span style="color:red" ng-show="add_form.password.$dirty && add_form.password.$error.minlength">
                                                        <p class="error-display">Atleast 5 characters.</p>
                                                    </span>
                                                </div>  
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <label for="cpassword" class="col-md-4 control-label text-right">Re-Password</label>
                                        <div class="col-md-8">
                                            <input 
                                                type="password" 
                                                required
                                                class="form-control" 
                                                ng-model="cpassword"
                                                id="cpassword"
                                                name = "cpassword"
                                                data-password-verify="password">
                                                <div class="validate-error">
                                                <span style="color:red" ng-show="add_form.cpassword.$dirty && add_form.cpassword.$error.required">
                                                    <p class="error-display">This field is required.</p>
                                                </span>
                                                <span style="color:red" ng-show="add_form.cpassword.$dirty && add_form.cpassword.$error.passwordVerify">
                                                    <p class="error-display">Password dont match.</p>
                                                </span>
                                                </div>  
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <label for="user_type" class="col-md-4 control-label text-right"> User Type</label>
                                        <div class="col-md-8">
                                            <select
                                                class = "form-control" 
                                                name = "user_type"
                                                required
                                                ng-model="user_type">
                                                <option value="" disabled="" selected="" style="display:none">Please Select One</option>
                                                <option>Administrator</option>
                                                <option>Store Manager</option>
                                                <option>Supervisor</option>
                                                <option>Documentation Officer</option>
                                                <option>Accounting Staff</option>
                                                <option>IAD</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <label for="user_group" class="col-md-4 control-label text-right"> User Group</label>
                                        <div class="col-md-8">
                                            <select
                                                class = "form-control" 
                                                name = "user_group"
                                                ng-model="user_group"
                                                id = "user_group">
                                                <option value="" disabled="" selected="" style="display:none">Please Select One</option>
                                                <option selected=""></option> 
                                                <option ng-repeat="store in stores">{{store.store_name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                              
                    <div class="modal-footer">
                        <button type="submit" ng-disabled="add_form.$invalid" class="btn btn-primary"> <i class = "fa fa-save"></i> Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class = "fa fa-close"></i> Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<!-- View Modal -->
    <div class="modal fade" id = "view_modal">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-search"></i> View User</h4>
                </div>
                <div class="modal-body">
                    <form action = "{{ '<?php echo base_url(); ?>index.php/tsms_controller/update_user/' + user.id }}" method="post" name = "frm_update" id = "frm_update">
                    <input type="text" style="display:none;" name="id_to_update" id="id_to_update" ng-model="user.id">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="row">
                                    <div class="form-group">
                                        <label for="name" class="col-md-4 control-label text-right"> First Name</label>
                                        <div class="col-md-6">
                                            <input 
                                                type="text" 
                                                required
                                                class="form-control" 
                                                ng-model="data.name"
                                                id="name"
                                                name = "name"
                                                autocomplete="off"
                                                is-unique-update
                                                is-unique-id = "{{user.id}}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <label for="last_name" class="col-md-4 control-label text-right"> Last Name</label>
                                        <div class="col-md-6">
                                            <input 
                                                type="text" 
                                                required
                                                class="form-control" 
                                                ng-model="data.last_name"
                                                name = "last_name"
                                                autocomplete="off"
                                                is-unique-update
                                                is-unique-id = "{{user.id}}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <label for="username" class="col-md-4 control-label text-right"> Username</label>
                                        <div class="col-md-6">
                                            <input 
                                                type="text" 
                                                required
                                                class="form-control" 
                                                ng-model="data.username"
                                                name = "username"
                                                autocomplete="off"
                                                is-unique-update
                                                is-unique-id = "{{user.id}}"
                                                readonly>
                                           
                                        </div>
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="form-group">
                                        <label for="status" class="col-md-4 control-label text-right"> Status</label>
                                        <div class="col-md-6">
                                            <input 
                                                type="text" 
                                                required
                                                class="form-control" 
                                                ng-model="data.status"
                                                id="status"
                                                name = "status"
                                                autocomplete="off"
                                                is-unique-update
                                                is-unique-id = "{{user.id}}"
                                                readonly>
                                           
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <label for="user_type" class="col-md-4 control-label text-right"> User Type</label>
                                        <div class="col-md-6">
                                            <input 
                                                type="text" 
                                                required
                                                class="form-control" 
                                                ng-model="data.user_type"
                                                name = "user_type"
                                                autocomplete="off"
                                                is-unique-update
                                                is-unique-id = "{{user.id}}"
                                                readonly>
                                           
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <label for="user_group" class="col-md-4 control-label text-right"> User Group</label>
                                        <div class="col-md-6"> 
                                            <select 
                                                class="form-control"
                                                required=""
                                                ng-model="data.user_group"
                                                ng-options="s.id as s.store_name for s in stores"
                                                disabled="">        
                                            </select>
                                        </div>
                                    </div>
                                </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class = "fa fa-close"></i> Close</button>
                        </div>
                        </div>
                        </div>
                    </form>
                    </div> 
                </div>
            </div>
        </div>
    </div><!-- modal -->
    <!-- End View Modal -->

