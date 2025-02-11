<div class="container">
    <div class="cover">
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Data For Upload </div>
        </div>
        <div class="well" ng-controller="tablecontroller" ng-controller="decontroller" >
            <div class="upload-control">
                <div class="col-md-2 pull-right">
                    <input ng-model="query" class="form-control search-query" placeholder="Search Here..."/>
                </div>
                <div class="form-group">
                    <div class="col-md-2">
                          <select
                          class = "form-control" 
                          name = "tenant_list"
                          ng-model="tenant_list" 
                          required
                          id = "tenant_list"
                          ng-change="getTenants($base_url + 'tsms_controller/get_tenants/' + tenant_list)">
                          <option class="placeholder" selected disabled value="">Select Tenant Type</option>
                          <option id="long_term_tenants">Long Term Tenants</option>
                          <option id="short_term_tenants">Short Term Tenants</option>
                          </select>
                    </div>
                </div>
                <div class="col-md-2" >
                    <div class="form-group">
                          <select
                          class = "form-control" 
                          name = "trade_name" 
                          required
                          id = "trade_name"
                          ng-model="tenant.trade_name">
                          <option class="placeholder" selected disabled value="">Select Trade Name</option>
                          <option ng-repeat = "tenant in tenantlist">{{tenant.trade_name}}</option>
                          </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-2"  >
                      <button type="button" ng-click="leasing_data_button($base_url +'tsms_controller/for_leasing_data/'+ tenant_list + '/'+ tenant.trade_name )" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
                    </div>
                </div>
            </div><!-- end upload control-->
            <div class="tabs">
                <ul class="nav nav-tabs">
                    <li class="active" style="width: 100%"><a href="#menu2" data-toggle="tab" style="font-weight: bold; ">Data for Leasing </a></li>
                </ul>
            </div>
            <br>
            <div id="table-upload">
                <table class="table table-bordered table-hover" ng-controller="tablecontroller" ng-init="uploadData($base_url + 'tsms_controller/get_upload_data/')">
                    <thead>
                      <tr>
                        <th>Trade Name</th>
                        <th>Date</th>
                        <th>Rental Type</th>
                        <th>Percentage of Monthly Sales</th>
                        <th>Tenant Type</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="data in uploadData_List | filter:query">
                            <td>{{data.trade_name}}</td>
                            <td name="date_end">{{data.date_end }}</td>
                            <td name="rental_type">{{data.rental_type}}</td>
                            <td name="total_netsales_amount">{{data.total_netsales_amount | currency :''}}</td>
                            <td name="tenant_type">{{data.tenant_type}}</td>
                            <td>{{data.status}} </td>
                            <td>
                                <div class="btn-group">
                                    <div class="img_menu">
                                        <img src="<?php echo base_url(); ?>img/menu3.png" style="height: 15px; width: 13px;" data-toggle="dropdown" id="img_menu">
                                        <ul style="position:absulote;left: -40px; top: -5px; background: white; border-top: none;" class="dropdown-menu">
                                            <li><a href="#" data-toggle="modal" data-target="#confirmation_modal_upload" ng-click="setData(data)"> <i class = "fa fa-chevron-circle-up"></i> Upload</a></li>
                                            <li><a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#view_modal_daily" ng-click="setData(data)"> <i class = "fa fa-search"></i> View</a></li>
                                            <?php if($this->session->userdata('user_type') == 'Administrator' || $this->session->userdata('user_type') == 'Supervisor'): ?>
                                            <li><a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#update_modal_daily" ng-click="setData(data)"> <i class = "fa fa-edit"></i> Update</a></li>
                                            
                                            <li><a href="#" ng-click="deleteDataForLeasing($base_url + 'tsms_controller/delete_monthly_total/' + data.id)"> <i class = "fa fa-trash"></i> Delete</a></li>
                                            <?php endif ?>
                                        </ul>
                                    </div>
                                </div>
                            </td> 
                        </tr>
                        <tr class="ng-cloak" ng-show="leasing_data.length==0 || (leasing_data | filter:query).length == 0">
                            <td colspan="7"><center>No Data Available.</center></td>
                        </tr>    
                    </tbody>
                </table>
            </div>
        </div><!--end div well-->
    </div><!--end div cover-->
</div><!--end div container-->

<!--view modal daily-->
<div id="view_modal_daily" class="modal fade" role="dialog" aria-labelledby="tenant_daily_sales">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3><i class="fa fa-search"></i> View Data for Upload</h3>
            </div>
            <div class="modal-body">
                <form  action = "#" method="post" name = "frm_update" id = "frm_update">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group">
                                <label for="tenant_type" class="col-md-4 control-label text-right">Tenant Type</label>
                                <div class="col-md-6">
                                    <input 
                                        type="text" 
                                        required 
                                        class="form-control currency" 
                                        ng-model="data.tenant_type" 
                                        id="tenant_type" 
                                        name = "tenant_type"
                                        is-unique-update
                                        is-unique-id = "{{data.id}}"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="tenant_code" class="col-md-4 control-label text-right">Tenant Code</label>
                                <div class="col-md-6">
                                    <input 
                                        type="text" 
                                        required 
                                        class="form-control currency" 
                                        ng-model="data.tenant_code" 
                                        id="1" 
                                        name = "tenant_code"
                                        is-unique-update
                                        is-unique-id = "{{data.id}}"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="trade_name" class="col-md-4 control-label text-right">Trade Name</label>
                                <div class="col-md-6">
                                    <input 
                                        type="text" 
                                        required 
                                        class="form-control currency" 
                                        ng-model="data.trade_name" 
                                        id="trade_name" 
                                        name = "trade_name"
                                        is-unique-update
                                        is-unique-id = "{{data.id}}"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="rental_type" class="col-md-4 control-label text-right">Rental Type</label>
                                <div class="col-md-6">
                                    <input 
                                        type="text" 
                                        required 
                                        class="form-control currency" 
                                        ng-model="data.rental_type" 
                                        id="rental_type" 
                                        name = "rental_type"
                                        is-unique-update
                                        is-unique-id = "{{data.id}}"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="date_end" class="col-md-4 control-label text-right"> Date</label>
                                <div class="col-md-6">
                                    <input 
                                        type="text"
                                        readonly 
                                        required 
                                        class="form-control currency" 
                                        ng-model="data.date_end" 
                                        id="date_end" 
                                        name = "date_end"
                                        is-unique-update
                                        is-unique-id = "{{data.id}}">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="total_nontax_sales" class="col-md-4 control-label text-right">Total Nontaxable Sales</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-addon"><strong>&#8369;</strong></div>
                                        <input 
                                            type="text" 
                                            required 
                                            class="form-control currency" 
                                            ng-model="data.total_nontax_sales" 
                                            id="total_nontax_sales" 
                                            name = "total_nontax_sales"
                                            is-unique-update
                                            ui-number-mask="2"
                                            is-unique-id = "{{data.id}}"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="total_netsales_amount" class="col-md-4 control-label text-right">Sales</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-addon"><strong>&#8369;</strong></div>
                                        <input 
                                            type="text" 
                                            required 
                                            class="form-control currency" 
                                            ng-model="data.total_netsales_amount" 
                                            id="total_netsales_amount" 
                                            name = "total_netsales_amount"
                                            is-unique-update
                                            ui-number-mask="2"
                                            is-unique-id = "{{data.id}}"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class = "fa fa-close"></i> Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!--view modal daily-->

<!--update modal daily-->
<div id="update_modal_daily" class="modal fade" role="dialog" aria-labelledby="tenant_daily_sales">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3><i class="fa fa-edit"></i> Update Leasing Data</h3>
            </div>
            <div class="modal-body">
                <form ng-submit="updateDataForLeasing($base_url + 'tsms_controller/update_leasing_data/' + data.id, $event)" action = "{{'<?php echo base_url();?>index.php/tsms_controller/update_leasing_data/' + data.id }} " method="post" name = "frm_update" id = "frm_update">
                    <input type = "text" style = "display:none;" ng-model="data.id" = name = "id_to_update" />
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group">
                                <label for="tenant_type" class="col-md-4 control-label text-right">Tenant Type</label>
                                <div class="col-md-6">
                                    <input 
                                        type="text" 
                                        required 
                                        class="form-control currency" 
                                        ng-model="data.tenant_type" 
                                        id="1" 
                                        name = "tenant_type"
                                        is-unique-update
                                        is-unique-id = "{{data.id}}"
                                        >
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="tenant_code" class="col-md-4 control-label text-right">Tenant Code</label>
                                <div class="col-md-6">
                                    <input 
                                        type="text" 
                                        required 
                                        class="form-control currency" 
                                        ng-model="data.tenant_code" 
                                        id="1" 
                                        name = "tenant_code"
                                        is-unique-update
                                        is-unique-id = "{{data.id}}"
                                        >
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="trade_name" class="col-md-4 control-label text-right">Trade Name</label>
                                <div class="col-md-6">
                                    <input 
                                        type="text" 
                                        required 
                                        class="form-control currency" 
                                        ng-model="data.trade_name" 
                                        id="trade_name" 
                                        name = "trade_name"
                                        is-unique-update
                                        is-unique-id = "{{data.id}}"
                                        >
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="rental_type" class="col-md-4 control-label text-right">Rental Type</label>
                                <div class="col-md-6">
                                    <input 
                                        type="text" 
                                        required 
                                        class="form-control currency" 
                                        ng-model="data.rental_type" 
                                        id="rental_type" 
                                        name = "rental_type"
                                        is-unique-update
                                        is-unique-id = "{{data.id}}"
                                        >
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="date_end" class="col-md-4 control-label text-right"> Date</label>
                                <div class="col-md-6">
                                    <input 
                                        type="text"
                                        required 
                                        class="form-control currency" 
                                        ng-model="data.date_end" 
                                        id="date_end" 
                                        name = "date_end"
                                        is-unique-update
                                        is-unique-id = "{{data.id}}">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="total_nontax_sales" class="col-md-4 control-label text-right">Total Nontaxable Sales</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-addon"><strong>&#8369;</strong></div>
                                        <input 
                                            type="text" 
                                            required 
                                            class="form-control currency" 
                                            ng-model="data.total_nontax_sales" 
                                            id="total_nontax_sales" 
                                            name = "total_nontax_sales"
                                            is-unique-update
                                            ui-number-mask="2"
                                            is-unique-id = "{{data.id}}"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="total_netsales_amount" class="col-md-4 control-label text-right">Sales</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-addon"><strong>&#8369;</strong></div>
                                        <input 
                                            type="text" 
                                            required 
                                            class="form-control currency" 
                                            ng-model="data.total_netsales_amount" 
                                            id="total_netsales_amount" 
                                            name = "total_netsales_amount"
                                            is-unique-update
                                            ui-number-mask="2"
                                            is-unique-id = "{{data.id}}"
                                            >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>  
                    <div class="modal-footer">
                        <button type="submit" ng-disabled = "frm_update.$invalid" class="btn btn-primary"> <i class = "fa fa-save"></i> Save Changes</button>
                        <button type="button" data-dismiss="modal" class="btn btn-danger"> <i class = "fa fa-close"></i> Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    <!--upload--> 
<div class="modal fade bounce animated" id = "confirmation_modal_upload">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-question-circle"></i> Confirmation</h4>
            </div>
            <div class="modal-body">
                <form ng-submit="uploadForLeasing($base_url + 'tsms_controller/upload_to_leasing/'+ data.id, $event);"  action= "{{'<?php echo base_url(); ?>index.php/tsms_controller/upload_to_leasing/'+ data.id}}" method="post" name = "frm_update" id = "frm_update">
                <div class="col-md-12">
                    <div class="row">
                        <h4>Do you want to Upload this Data?<h4>
                        <br>
                    </div>
                </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group">
                                <label for="tenant_type" class="col-md-4 control-label text-right">Tenant Type</label>
                                <div class="col-md-6">
                                    <input 
                                        type="text" 
                                        required 
                                        class="form-control currency" 
                                        ng-model="data.tenant_type" 
                                        id="tenant_type" 
                                        name = "tenant_type"
                                        is-unique-update
                                        is-unique-id = "{{data.id}}"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="tenant_code" class="col-md-4 control-label text-right">Tenant Code</label>
                                <div class="col-md-6">
                                    <input 
                                        type="text" 
                                        required 
                                        class="form-control currency" 
                                        ng-model="data.tenant_code" 
                                        id="1" 
                                        name = "tenant_code"
                                        is-unique-update
                                        is-unique-id = "{{data.id}}"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="trade_name" class="col-md-4 control-label text-right">Trade Name</label>
                                <div class="col-md-6">
                                    <input 
                                        type="text" 
                                        required 
                                        class="form-control currency" 
                                        ng-model="data.trade_name" 
                                        id="trade_name" 
                                        name = "trade_name"
                                        is-unique-update
                                        is-unique-id = "{{data.id}}"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="rental_type" class="col-md-4 control-label text-right">Rental Type</label>
                                <div class="col-md-6">
                                    <input 
                                        type="text" 
                                        required 
                                        class="form-control currency" 
                                        ng-model="data.rental_type" 
                                        id="rental_type" 
                                        name = "rental_type"
                                        is-unique-update
                                        is-unique-id = "{{data.id}}"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="date_end" class="col-md-4 control-label text-right"> Date</label>
                                <div class="col-md-6">
                                    <input 
                                        type="text"
                                        readonly 
                                        required 
                                        class="form-control currency" 
                                        ng-model="data.date_end" 
                                        id="date_end" 
                                        name = "date_end"
                                        is-unique-update
                                        is-unique-id = "{{data.id}}">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="total_nontax_sales" class="col-md-4 control-label text-right">Total Nontaxable Sales</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-addon"><strong>&#8369;</strong></div>
                                        <input 
                                            type="text" 
                                            required 
                                            class="form-control currency" 
                                            ng-model="data.total_nontax_sales" 
                                            id="total_nontax_sales" 
                                            name = "total_nontax_sales"
                                            is-unique-update
                                            ui-number-mask="2"
                                            is-unique-id = "{{data.id}}"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="total_netsales_amount" class="col-md-4 control-label text-right">Sales</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-addon"><strong>&#8369;</strong></div>
                                        <input 
                                            type="text" 
                                            required 
                                            class="form-control currency" 
                                            ng-model="data.total_netsales_amount" 
                                            id="total_netsales_amount" 
                                            name = "total_netsales_amount"
                                            is-unique-update
                                            ui-number-mask="2"
                                            is-unique-id = "{{data.id}}"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>                      
                    <div class="modal-footer">
                        <button type="submit"  class="btn btn-success"><i class="fa fa-chevron-circle-up"></i> Upload</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal"> <i class="fa fa-close"></i> Close</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
   