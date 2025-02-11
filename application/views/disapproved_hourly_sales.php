<div class="well" style="margin-top: 20px;margin-left: 10px;margin-right: 10px;">
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-thumbs-down" aria-hidden="true"></i> Disapproved Hourly Data </div>
        </div>
        <div class="col-md-2 pull-right">
            <input ng-model="query" class="form-control query" placeholder="Search Here..."/>
        </div>
    <div class="tabs">
            <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#menu1" style="font-weight: bold;">Disapproved Hourly Sales Record</a></li>
            </ul>
        <div class="table-transaction" id="table1">  
            <div class="tab-content">
                <div id="menu1" class="tab-pane fade in active">
                    <table class="table table-bordered" ng-controller="tablecontroller" ng-init="disHourInit('<?php echo base_url(); ?>index.php/tsms_controller/get_disapproved_hourly/')">
                        <thead>
                          <tr>
                            <th><a href="#" data-ng-click="sortField = 'tenant_type'; reverse = !reverse">Tenant Type</a></th>
                            <th><a href="#" data-ng-click="sortField = 'trade_name'; reverse = !reverse">Tenant Name</a></th>
                            <th><a href="#" data-ng-click="sortField = 'transac_date'; reverse = !reverse">Transaction Date</a></th>
                            <th><a href="#" data-ng-click="sortField = 'netsales_amount_hour'; reverse = !reverse">Net Sales Amount</a></th>
                            <th><a href="#" data-ng-click="sortField = 'numsales_transac_hour'; reverse = !reverse">Number of Sales Transaction</a></th>
                            <th><a href="#" data-ng-click="sortField = 'status'; reverse = !reverse">Rental Type</a></th>
                            <th><a href="#" data-ng-click="sortField = 'status'; reverse = !reverse">Tenant Code</a></th>
                            <th><a href="#" data-ng-click="sortField = 'status'; reverse = !reverse">Action</a></th>
                          </tr>
                        </thead>
                        <tbody>
                            <tr class="ng-cloak" ng-show="disHourList.length!=0" ng-repeat= "data in disHourList | filter:query | orderBy:sortField:reverse ">
                                <td>{{data.tenant_type }}</td>
                                <td>{{data.trade_name }}</td>
                                <td>{{data.transac_date | date }}</td>
                                <td>{{data.netsales_amount_hour | currency : ' &#8369; ' }}</td>
                                <td>{{data.numsales_transac_hour}}</td>
                                <td>{{data.rental_type}}</td>
                                <td>{{data.tenant_code}}</td>
                                <td>
                                    <div class="btn-group">
                                        <div class="img_menu">
                                          <img src="<?php echo base_url(); ?>img/menu3.png" style="height: 15px; width: 13px;" data-toggle="dropdown" id="img_menu">
                                            <ul style="position:absulote;left: -40px; top: -5px; background: white; border-top: none;" class="dropdown-menu">
                                              <li><a href="#"  data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#hourly_sales_data" ng-click="viewDis('<?php echo base_url(); ?>index.php/tsms_controller/view_disapprove_data_hourly/' + data.transac_date + '/' + data.trade_name)"> <i class = "fa fa-search"></i> View</a></li>
                                              <li><a href="#" data-toggle="modal" title="Approve" data-target="#confirmation_modal2" ng-click="approve('<?php echo base_url(); ?>index.php/tsms_controller/update_disapprove_hourly/' + data.txtfile_name)"> <i class = "fa fa-thumbs-up"></i> Approve</a></li>
                                              <?php if($this->session->userdata('user_type') == 'Administrator'): ?>
                                              <li><a href="#" data-toggle="modal" data-target="#confirmation_modal" ng-click="delete('<?php echo base_url(); ?>index.php/tsms_controller/delete_disapprove_hourly/' + data.txtfile_name)"> <i class = "fa fa-trash"></i> Delete</a></li>
                                              <?php endif ?>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="ng-cloak" ng-show="disHourList.length==0 || (disHourList | filter:query).length == 0">
                                <td colspan="8"><center>No Data Available.</center></td>
                            </tr> 
                        </tbody> 
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="hourly_sales_data">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title"><i class="fa fa-search"></i> View Disapproved Hourly Sales</h4>
            </div>
                <div class="modal-body">
                  <table class="table table-bordered" ng-controller="tablecontroller">
                    <thead>
                      <tr>
                        <th>Tenant Type</th>
                        <th>Tenant Name</th>
                        <th>Transaction Date</th>
                        <th>Hour Code</th>
                        <th>Net Sales Amount/Hour</th>
                        <th>Number of Sales Transaction/Hour</th>
                        <th>Customer Count/Hour</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr ng-repeat="sales in disData ">
                        <td>{{sales.tenant_type }}</td>
                        <td>{{sales.trade_name }}</td>
                        <td>{{sales.transac_date | date }}</td>
                        <td>{{sales.hour_code}}{{':00'}}</td>
                        <td>{{sales.netsales_amount_hour | currency : ' &#8369; ' }}</td>
                        <td>{{sales.numsales_transac_hour}}</td>
                        <td>{{sales.customer_count_hour}}</td>
                        <td>{{sales.status}}</td>
                      </tr>
                    </tbody> 
                  </table>
                  <div class="modal-footer">
                      <div class="form-group">
                          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class = "fa fa-close"></i> Close</button>
                      </div>
                  </div>
            </div>
        </div>
    </div>
</div>

<!--view modal hourly-->
  <div id="view_modal" class="modal fade" role="dialog" aria-labelledby="tenant_hourly_sales">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h3><i class="fa fa-search"></i> View Hourly Sales</h3>
                </div>
                <div class="modal-body" ng-repeat="data in updateData">
                    <form  action = "#" method="post" name = "frm_update" id = "frm_update">
                       <input type = "text" style = "display:none" ng-model="data.id" = name = "id_to_update" />
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                <div class="row">
                                        <div class="form-group">
                                            <label for="tenant_type" class="col-md-4 control-label text-right">Tenant Type</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="data.tenant_type"
                                                    ng-disabled = "frm_update.$invalid" 
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
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                  
                                                    class="form-control emphasize" 
                                                    ng-model="data.tenant_code"
                                                    ng-disabled = "frm_update.$invalid" 
                                                    id="tenant_code" 
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
                                            <label for="trade_name" class="col-md-4 control-label text-right">Tenant Name</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                  
                                                    class="form-control emphasize" 
                                                    ng-model="data.trade_name"
                                                    ng-disabled = "frm_update.$invalid" 
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
                                            <label for="transac_date" class="col-md-4 control-label text-right">Transaction Date</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                  
                                                    class="form-control emphasize"
                                                    ng-disabled = "frm_update.$invalid" 
                                                    ng-model="data.transac_date" 
                                                    id="transac_date" 
                                                    name = "transac_date"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="hour_code" class="col-md-4 control-label text-right">Hour Code</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize"
                                                    ng-disabled = "frm_update.$invalid" 
                                                    ng-model="data.hour_code" 
                                                    id="hour_code" 
                                                    name = "hour_code"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                  <div class="row">
                                        <div class="form-group">
                                            <label for="netsales_amount_hour" class="col-md-4 control-label text-right">Net Sales Amount Hour</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize"
                                                    ng-disabled = "frm_update.$invalid" 
                                                    ng-model="data.netsales_amount_hour" 
                                                    id="netsales_amount_hour" 
                                                    name = "netsales_amount_hour"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                   <div class="row">
                                        <div class="form-group">
                                            <label for="numsales_transac_hour" class="col-md-4 control-label text-right">Number of Sales per Hour</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize"
                                                    ng-disabled = "frm_update.$invalid" 
                                                    ng-model="data.numsales_transac_hour" 
                                                    id="numsales_transac_hour" 
                                                    name = "numsales_transac_hour"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="customer_count_hour" class="col-md-4 control-label text-right">Customer Count Hour</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize"
                                                    ng-disabled = "frm_update.$invalid" 
                                                    ng-model="data.customer_count_hour" 
                                                    id="customer_count_hour" 
                                                    name = "customer_count_hour"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="prospect_id" class="col-md-4 control-label text-right">Prospect Id</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize"
                                                    ng-disabled = "frm_update.$invalid" 
                                                    ng-model="data.prospect_id" 
                                                    id="prospect_id" 
                                                    name = "prospect_id"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    
                                </div>
                                <!-- Divider -->
                                <div class="col-md-6">
                                   <div class="row">
                                        <div class="form-group">
                                            <label for="totalnetsales_amount_hour" class="col-md-4 control-label text-right">Total Net Sales per Hour</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                        <input 
                                                            type="text" 
                                                            required 
                                                            class="form-control currency"
                                                            ng-disabled = "frm_update.$invalid" 
                                                            ng-model="data.totalnetsales_amount_hour"
                                                            id="totalnetsales_amount_hour"
                                                            name = "totalnetsales_amount_hour"
                                                            autocomplete="off"
                                                            readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="totalnumber_sales_transac" class="col-md-4 control-label text-right">Total Sales Transaction Hour</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize"
                                                    ng-disabled = "frm_update.$invalid" 
                                                    ng-model="data.totalnumber_sales_transac" 
                                                    id="totalnumber_sales_transac" 
                                                    name = "totalnumber_sales_transac"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                   <div class="row">
                                        <div class="form-group">
                                            <label for="total_customer_count_day" class="col-md-4 control-label text-right">Total Customer Count per Day</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="data.total_customer_count_day" 
                                                    id="total_customer_count_day"
                                                    ng-disabled = "frm_update.$invalid" 
                                                    name = "total_customer_count_day"
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
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="data.rental_type" 
                                                    id="rental_type"
                                                    ng-disabled = "frm_update.$invalid" 
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
                                            <label for="pos_num" class="col-md-4 control-label text-right">POS No.</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="data.pos_num" 
                                                    id="pos_num" 
                                                    ng-disabled = "frm_update.$invalid"
                                                    name = "pos_num"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="form-group">
                                            <label for="txtfile_name" class="col-md-4 control-label text-right">Text File Name</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="data.txtfile_name" 
                                                    id="txtfile_name" 
                                                    ng-disabled = "frm_update.$invalid"
                                                    name = "txtfile_name"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="form-group">
                                            <label for="date_upload" class="col-md-4 control-label text-right">Date Upload</label>
                                            <div class="col-md-8">
                                                <input 
                                                type="text"
                                                name = "date_upload" 
                                                required
                                                ng-model = "data.date_upload"
                                                required class="form-control"
                                                id="date_upload"
                                                is-unique-update
                                                is-unique-id="{{data.id}}"
                                                readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="form-group">
                                        <label for="status" class="col-md-4 control-label text-right">Tenant Type Code</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="data.tenant_type_code" 
                                                    id="tenant_type_code" 
                                                    name = "tenant_type_code"
                                                    ng-disabled = "frm_update.$invalid"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="status" class="col-md-4 control-label text-right">Status</label>
                                            <div class="col-md-8">
                                                <input 
                                                name = "status" 
                                                required
                                                ng-model = "data.status"
                                                ng-disabled = "frm_update.$invalid" 
                                                required class="form-control"
                                                id="status"
                                                is-unique-update
                                                is-unique-id="{{data.id}}"
                                                readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                     
                                     
                                </div>
                            </div>
                        </div>   
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class = "fa fa-close"></i> Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> <!--view modal hourly-->