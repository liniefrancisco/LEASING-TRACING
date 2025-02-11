<div class="container" ng-controller="chartController">
    <div class="cover1">
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-bug" aria-hidden="true"></i> Variance Report </div>
        </div>
        <div id="user_control">
            <div class="col-md-2 pull-right">
                <input ng-model="query" class="form-control search-query" placeholder="Search Here..."/>
            </div>
        </div>
        <div class="well" ng-controller="tablecontroller" ng-controller="decontroller" >
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-hover" ng-init="input_loadList('<?php echo base_url(); ?>index.php/tsms_controller/get_variance')">
                        <thead>
                            <tr>
                                <th>Tenant Name</th>
                                <th>Tenant Type</th>
                                <th>Variance</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="ng-cloak"  ng-repeat="data in input_list | filter:query | orderBy:sortField:reverse | offset: currentPage*itemsPerPage | limitTo: itemsPerPage">
                                <td>{{data.trade_name}}</td>
                                <td>{{data.tenant_type}}</td>
                                <td>{{data.variance | currency : ' &#8369; '}}</td>
                                <td>{{data.date}}</td>
                                <td>{{data.status}}</td>
                                <td>
                                    <div class="btn-group">
                                        <div class="img_menu">
                                            <img src="<?php echo base_url(); ?>img/menu3.png" style="height: 15px; width: 13px;" data-toggle="dropdown" id="img_menu">
                                               <ul style="position:absulote;left: -40px; top: -5px; background: white; border-top: none;" class="dropdown-menu">
                                                  <li><a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#variance_report" ng-click="update('<?php echo base_url(); ?>index.php/tsms_controller/get_variance_data/' + data.id)"> <i class = "fa fa-search"></i> Update</a></li>
                                                  <li><a ng-click="deleteDataAjax($base_url + 'tsms_controller/delete_variance/' + data.id, 'input_list', data)"> <i class = "fa fa-trash"></i> Delete</a></li>
                                                </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="ng-cloak" ng-show="input_list.length==0 || (input_list | filter:query).length == 0">
                                <td colspan="7"><center>No Data Available.</center></td>
                            </tr>
                        </tbody>
                        <tfoot>
                             <tr class="ng-cloak">
                                <td colspan="7" style="padding: 5px;">
                                    <div>
                                        <ul class="pagination">
                                            <li ng-show="input_list.length!=0 && (input_list | filter:query).length != 0" ng-class="prevPageDisabled3()">
                                                <a href ng-click="prevPage3()" style="border-radius: 0px;"><i class="fa fa-toggle-left"></i> Prev</a>
                                            </li>
                                            <li ng-show="input_list.length!=0 && (input_list | filter:query).length != 0" ng-repeat="n in range3()" ng-class="{active: n == currentPage3}" ng-click="setPage3(n)">
                                                <a href="#">{{n+1}}</a>
                                            </li>
                                            <li ng-show="input_list.length!=0 && (input_list | filter:query).length != 0" ng-class="nextPageDisabled3()">
                                                <a href ng-click="nextPage3()" style="border-radius: 0px;">Next <i class="fa fa-toggle-right"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div><!--end div well-->
    </div><!--end div cover-->
</div><!--end div container-->

<div class="modal fade" id = "variance_report">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-bug"></i> Variance Report</h4>
            </div>
            <div class="modal-body" ng-repeat = "data in updateData">
                <form ng-submit="updateVariance($base_url + 'tsms_controller/update_variance/' + data.id, $event)" action = "{{ '<?php echo base_url(); ?>index.php/tsms_controller/update_variance/' + data.id }}" method="post" name = "frm_update" id = "frm_update">
                <input type="text" style="display:none;" name="id_to_update" id="id_to_update" ng-model="data.id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group">
                                    <label for="trade_name" class="col-md-4 control-label text-right"> Trade Name</label>
                                    <div class="col-md-6">
                                        <input 
                                            type="text" 
                                            required
                                            class="form-control" 
                                            ng-model="data.trade_name"
                                            id="trade_name"
                                            name = "trade_name"
                                            autocomplete="off"
                                            is-unique-update
                                            is-unique-id = "{{data.id}}"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <label for="tenant_type" class="col-md-4 control-label text-right"> Tenant Type</label>
                                    <div class="col-md-6">
                                        <input 
                                            type="text" 
                                            required
                                            class="form-control" 
                                            ng-model="data.tenant_type"
                                            id="tenant_type"
                                            name = "tenant_type"
                                            autocomplete="off"
                                            is-unique-update
                                            is-unique-id = "{{data.id}}"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <label for="variance" class="col-md-4 control-label text-right"> Variance</label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-addon"><strong>&#8369;</strong></div>
                                            <input 
                                                type="text"
                                                class="form-control text-right" 
                                                ng-model="data.variance" 
                                                money-mask
                                                money-mask-prepend="₱"/>
                                            <input
                                                type="hidden"
                                                ng-value="data.variance"
                                                name="variance">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <label for="date" class="col-md-4 control-label text-right"> Date</label>
                                    <div class="col-md-6">
                                        <input 
                                            type="text" 
                                            required
                                            class="form-control" 
                                            ng-model="data.date"
                                            id="date"
                                            name = "date"
                                            autocomplete="off"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <label for="date_upload" class="col-md-4 control-label text-right"> Date Upload</label>
                                    <div class="col-md-6">
                                        <input 
                                            type="text" 
                                            required
                                            class="form-control" 
                                            ng-model="data.date_upload"
                                            id="date_upload"
                                            name = "date_upload"
                                            autocomplete="off"
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
                                            type="read" 
                                            required
                                            class="form-control" 
                                            ng-model="data.status"
                                            id="status"
                                            name = "status"
                                            autocomplete="off"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <label for="status" class="col-md-4 control-label text-right">Select to Update</label>
                                    <div class="col-md-6">
                                      <select 
                                        name = "status" 
                                        required
                                        required class="form-control"
                                        id="status"
                                        is-unique-update
                                        is-unique-id="{{data.id}}">
                                            <option class="placeholder" selected disabled value="">Select to Update</option>
                                            <option>Update</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="modal-footer">
                                <button type="submit" ng-disabled = "frm_update.$invalid" class="btn btn-primary"> <i class = "fa fa-save"></i> Save Changes</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class = "fa fa-close"></i> Close</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div> 
        </div>
    </div>
</div>


                        