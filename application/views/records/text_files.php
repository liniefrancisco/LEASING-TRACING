<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-trash" aria-hidden="true"></i> Delete Text File Status</div>
        </div>
        <div class="well" ng-controller="tablecontroller">
            <div class="upload-control">

                <div class="col-md-10">
                    <div class="col-md-3">
                        <div class="form-group">
                              <select
                              class = "form-control" 
                              name = "tenant_list"
                              ng-model="tenant_list" 
                              required
                              id = "tenant_list"
                              ng-change="getTenants('<?php echo base_url(); ?>index.php/tsms_controller/get_tenants/' + tenant_list)">
                              <option class="placeholder" selected disabled value="">Select Tenant Type</option>
                              <option id="long_term_tenants">Long Term Tenants</option>
                              <option id="short_term_tenants">Short Term Tenants</option>
                              </select>
                        </div>
                    </div>
                    <div class="col-md-3" >
                        <div class="form-group">
                              <select
                              class = "form-control" 
                              name = "trade_name"
                              ng-model="trade_name" 
                              required
                              id = "trade_name"
                              ng-change="getLocation('<?php echo base_url(); ?>index.php/tsms_controller/get_location_code/' + trade_name)">
                              <option class="placeholder" selected disabled value="">Select Trade Name</option>
                              <option ng-repeat = "tenant in tenantlist">{{tenant.trade_name}}</option>
                              </select>
                        </div>
                    </div>
                    <div class="col-md-3" >
                        <div class="form-group">
                              <select
                              class = "form-control" 
                              name = "location_code"
                              ng-model="location_code" 
                              required
                              id = "location_code"
                              ng-change="getRental('<?php echo base_url(); ?>index.php/tsms_controller/get_rental_type/' + location_code)">
                              <option class="placeholder" selected disabled value="">Select Id</option>
                              <option ng-repeat = "tenant in locationcode">{{tenant.location_code}}</option>
                              </select>
                        </div>
                    </div>
                    <div class="col-md-3" >
                        <div class="form-group">
                              <input
                              type="text"
                              class="form-control"
                              name="txtfile_name"
                              id="txtfile_name"
                              ng-model="txtfile_name">
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <div class="col-md-2"  >
                          <button type="button" ng-click="delupload_status_button('<?php echo base_url(); ?>index.php/tsms_controller/get_delupload_status/'+ trade_name + '/'+ txtfile_name )" class="btn btn-default" style="margin-bottom: 20px"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" ng-controller="mytablecontroller">
                <div class="col-md-12">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="sort" ng-click="sort('tenant_name')">Tenant Name</th>
                                <th class="sort" ng-click="sort('location_code')">Location Code</th>
                                <th class="sort" ng-click="sort('date_upload')">Date Upload</th>
                                <th class="sort" ng-click="sort('txtfile_name')">Text File Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="ng-cloak"  ng-repeat="data in upload_status_list  | sortBy : field : reverse | tableOffset: page : ipp">
                                <td>{{data.tenant_name}}</td>
                                <td>{{data.location_code}}</td>
                                <td>{{data.date_upload}}</td>
                                <td>{{data.txtfile_name}}</td>
                                <td>
                                    <div class="btn-group">
                                        <div class="img_menu">
                                            <img src="<?php echo base_url(); ?>img/menu3.png" style="height: 15px; width: 13px;" data-toggle="dropdown" id="img_menu">
                                               <ul style="position:absulote;left: -40px; top: -5px; background: white; border-top: none;" class="dropdown-menu">
                                                    <li><a href="#" ng-click="deleteDataAjax('<?php echo base_url(); ?>index.php/tsms_controller/delete_upload_status/' + data.id, 'upload_status_list', data)"> <i class = "fa fa-trash"></i> Delete</a></li>
                                                   
                                                </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="ng-cloak" ng-show="!upload_status_list || upload_status_list.length==0 || (upload_status_list | filter:query).length == 0">
                                <td colspan="7"><center>No Data Available.</center></td>
                            </tr>
                        </tbody>
                        <tfoot>
                           <tr class="ng-cloak" ng-init="ipp = 15">
                              <td colspan="14">
                                  <div>
                                      <ul class="pagination" ng-show="paginate(upload_status_list | filter:query | sortBy: field : reverse)">
                                          <li ng-class="{disabled : disable('first')}">
                                              <a href ng-click="firstPage()" style="border-radius: 0px;"> First</a>
                                              <a href ng-click="prevPage()" style="border-radius: 0px;"><i class="fa fa-toggle-left"></i> Prev</a>
                                          </li>
                                          <li ng-repeat="n in range()" ng-class="{active: n == page}" ng-click="setPage(n)">
                                              <a href>{{n+1}}</a>
                                          </li>
                                          <li ng-class="{disabled : disable('last')}">
                                              <a href ng-click="nextPage()" style="border-radius: 0px;">Next <i class="fa fa-toggle-right"></i></a>
                                              <a href ng-click="lastPage()" style="border-radius: 0px;">Last</a>
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

<div class="modal fade" id = "view">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-bug"></i> Variance Report</h4>
            </div>
            <div class="modal-body" ng-repeat = "data in updateData">
                <form action = "{{ '<?php echo base_url(); ?>index.php/tsms_controller/update_variance/' + data.id }}" method="post" name = "frm_update" id = "frm_update">
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
                                                required
                                                class="form-control" 
                                                ng-model="data.variance"
                                                id="variance"
                                                name = "variance"
                                                autocomplete="off">
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


                        