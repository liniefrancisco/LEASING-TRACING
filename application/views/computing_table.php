<div class="well" ng-controller="tablecontroller" ng-controller="decontroller" style="margin-top: 20px;margin-left: 10px;margin-right: 10px;">
    <form ng-submit="filterby_hour($base_url + 'tsms_controller/filter_sales/'+ tenant_list + '_'+ filter_date + '/'+ tenant.trade_name + '/' + location_code); $event.preventDefault();" class="upload-control">
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
                      ng-change="getTenants('<?php echo base_url(); ?>index.php/tsms_controller/get_tenants/' + tenant_list)">
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
                      ng-model="tenant.trade_name"
                      <?php if($this->session->userdata('user_type') == 'Administrator'):?>
                        ng-change="getLocation('<?php echo base_url(); ?>index.php/tsms_controller/get_location_code/' + tenant.trade_name)"
                      <?php endif; ?>
                      >
                      <option class="placeholder" selected disabled value="">Select Trade Name</option>
                      <option ng-repeat = "tenant in tenantlist">{{tenant.trade_name}}</option>
                  </select>
            </div>
        </div>
        <?php if($this->session->userdata('user_type') == 'Administrator'):?>
        <div class="col-md-2" >
            <div class="form-group">
                <select 
                    class="form-control"
                    required=""
                    ng-model="location_code"
                    ng-options="l.location_code as l.location_code for l in locations">                
                </select>
            </div>
        </div>
        <?php endif; ?>
        <div class="form-group">
            <div class="col-md-2 text-left">  
                <div class="input-group">
                    <div class="input-group-addon input-date"><strong><i class="fa fa-calendar"></i></strong></div>
                    <datepicker date-format="yyyy-MM-dd">
                        <input 
                            type="text" 
                            required 
                            placeholder="Choose a date" 
                            class="form-control"  
                            ng-model="filter_date"
                            id="date"
                            name = "date"
                            autocomplete="off">
                    </datepicker>
                </div>
            </div>
        </div> 
        <div class="form-group">
            <div class="col-md-2" >
              <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Filter Hourly Sales</button>
            </div>
        </div>
    </form><!-- end upload control-->
    <div class="tabs">
        <ul class="nav nav-tabs">
            <li class="active" style="width: 100%"><a href="#menu1" data-toggle="tab" style="font-weight: bold;">Hourly and Daily Sales Total</a></li>
        </ul>
        <br>
        <div class="table-computing" id="table1">  
            <div class="tab-content">
                <div id="menu1" class="tab-pane fade in active" >
                    <table class="table table-bordered table-hover" ng-show="filterdata_hourly">
                        <thead>
                            <tr>
                                <th>Tenant Name</th>
                                <th>Transaction Date</th>
                                <th>POS No.</th>
                                <th>Hour Code</th>
                                <th>Net Sales Amount/Hour</th>
                                <th>Number of Sales Transaction/Hour</th>
                                <th>Customer Count/Hour</th>
                                <th>Status</th>
                                <th>Approved By</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="data in filterdata_hourly | filter:query">
                                <td>{{data.trade_name}}</td>
                                <td>{{data.transac_date }}</td>
                                <td>{{data.pos_num}}</td>
                                <td>{{data.hour_code}}{{':00'}}</td>
                                <td>{{data.netsales_amount_hour | currency : ' ' }}</td>
                                <td>{{data.numsales_transac_hour}}</td>
                                <td>{{data.customer_count_hour}}</td>
                                <td>{{data.status}}</td>
                                <td>{{data.approved_by}}</td>
                            </tr>
                            <tr class="ng-cloak" ng-show="filterdata_hourly.length==0 || (filterdata_hourly | filter:query).length == 0">
                                <td colspan="7"><center>No Data Available.</center></td>
                            </tr>    
                        </tbody>
                    </table>
                </div><!--menu1-->
            </div>
        </div>
    </div>
</div>

<div class="well" ng-hide="hourly" style="margin-top: 20px;margin-left: 10px;margin-right: 10px;">
    <label for="total_hourly_sales" class="col-md-12 control-label text-top"><h4>Tenant Total Hourly Sales</h4></label>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="form-group">
                            <label for="total_hourly_sales" class="col-md-7 control-label text-top">Trade Name</label>
                                <div class="col-md-8">
                                    <input type="text"
                                    required
                                    class="form-control currency"
                                    id="trade_name"
                                    name="trade_name" 
                                    ng-model="trade_name"
                                    readonly 
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="form-group">
                                <label for="total_hourly_sales" class="col-md-7 control-label text-top">Tenant Type</label>
                                <div class="col-md-8">
                                    <input type="text"
                                    required
                                    class="form-control currency"
                                    id=""
                                    ng-model="tenant_type"
                                    readonly 
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="form-group">
                                <label for="total_hourly_sales" class="col-md-7 control-label text-top">Net Sales Amount Hour</label>
                                <div class="col-md-8">
                                    <input type="text"
                                    required
                                    class="form-control currency"
                                    id=""
                                    ng-model="netsales_amount_hour"
                                    ui-number-mask="2"
                                    readonly 
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="form-group">
                                <label for="numsales_transac_hour" class="col-md-8 control-label text-top">Number of Sales Transaction</label>
                                <div class="col-md-8">
                                    <input type="text"
                                    required
                                    class="form-control currency"
                                    id=""
                                    ng-model="numsales_transac_hour" 
                                    name=""
                                    readonly
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="form-group">
                                <label for="totalnumber_sales_transac" class="col-md-8 control-label text-top">Total Sales Transaction Hour</label>
                                <div class="col-md-8">
                                    <input type="text"
                                    required
                                    class="form-control currency"
                                    id=""
                                    ng-model="totalnumber_sales_transac" 
                                    name=""
                                    readonly
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="form-group">
                                <label for="total_customer_count_day" class="col-md-8 control-label text-top">Total Customer Count Day</label>
                                <div class="col-md-8">
                                    <input type="text"
                                    required
                                    class="form-control currency"
                                    id=""
                                    ng-model="total_customer_count_day" 
                                    name=""
                                    readonly
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- col-md-12 -->
            </div> <!-- col-md-6 -->
            <div class="col-md-6">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="form-group">
                                <label for="rental_type" class="col-md-7 control-label text-top">Rental Type</label>
                                <div class="col-md-8">
                                    <input type="text"
                                    required
                                    class="form-control currency"
                                    id=""
                                    ng-model="rental_type" 
                                    name=""
                                    readonly
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="form-group">
                                <label for="tenant_code" class="col-md-7 control-label text-top">Tenant Code</label>
                                <div class="col-md-8">
                                    <input type="text"
                                    required
                                    class="form-control"
                                    id=""
                                    ng-model="tenant_code" 
                                    name=""
                                    readonly
                                    >
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4" >
                                  <button type="button" id="calculate"class="btn btn-default" data-toggle="modal"  data-target="#calculate_modal"><i class="fa fa-calculator"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="form-group">
                            <label for="pos_num" class="col-md-7 control-label text-top">POS Num</label>
                                <div class="col-md-8">
                                    <input type="text                                    id=""
"
                                    required
                                    class="form-control currency"
                                    ng-model="pos_num" 
                                    name=""
                                    readonly
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="form-group">
                                <label for="customer_count_hour" class="col-md-7 control-label text-top">Customer Count Hour</label>
                                <div class="col-md-8">
                                    <input type="text"
                                    required
                                    class="form-control currency"
                                    id=""
                                    ng-model="customer_count_hour" 
                                    name=""
                                    readonly
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="form-group">
                                <label for="tenant_type_code" class="col-md-7 control-label text-top">Tenant Type Code</label>
                                <div class="col-md-8">
                                    <input type="text"
                                    required
                                    class="form-control currency"
                                    id=""
                                    ng-model="tenant_type_code" 
                                    name=""
                                    readonly
                                    >
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="form-group">
                                <label for="transac_date" class="col-md-7 control-label text-top">Transac Date</label>
                                <div class="col-md-8">
                                    <input type="text"
                                    required
                                    class="form-control currency"
                                    id=""
                                    ng-model="transac_date" 
                                    name=""
                                    readonly
                                    >
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--col-md-6-->
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="calculate_modal" aria-labelledby="view_calculate_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4><i class="fa fa-search"></i> View Modal</h4>
            </div>
                <div class="modal-body">
                <form  action="#" method="post" name = "frm_update" id = "frm_update">
                        <div class="col-lg-12">
                                  <div class="col-lg-6">
                                  <label for="total_hourly_sales" class="col-md-12 control-label text-top" style="margin-bottom: 20px;"><h4>Total Hourly Sales</h4></label>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-right">POS No.</label>
                                            <div class="col-md-6">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="pos_num"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-right">Total Net Sales Amount</label>
                                            <div class="col-md-6">
                                              <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                      <input 
                                                          type="text" 
                                                          required 
                                                          class="form-control emphasize" 
                                                          ng-model="netsales_amount_hour"
                                                          ui-number-mask="2"
                                                          readonly>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                <div class="row">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-right">Total Number of Sales Transaction</label>
                                            <div class="col-md-6">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="numsales_transac_hour"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="customer_count_hour" class="col-md-4 control-label text-right">Total Customer Count</label>
                                            <div class="col-md-6">
                                                <input type="text"
                                                required
                                                class="form-control currency"
                                                id=""
                                                ng-model="customer_count_hour" 
                                                name=""
                                                readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    <!-- <div class="row">
                                        <div class="form-group">
                                            <label for="transac_date" class="col-md-4 control-label text-right">Total Net Sales Amount Hour</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                        <input type="text"
                                                        required
                                                        class="form-control currency"
                                                        id=""
                                                        ng-model="totalnetsales_amount_hour" 
                                                        name=""
                                                        ui-number-mask="2"
                                                        readonly>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="totalnumber_sales_transac" class="col-md-4 control-label text-right">Total Sales Transaction Hour</label>
                                            <div class="col-md-6">
                                                <input type="text"
                                                required
                                                class="form-control currency"
                                                id=""
                                                ng-model="totalnumber_sales_transac" 
                                                name=""
                                                readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="total_customer_count_day" class="col-md-4 control-label text-right">Total Customer Count Day</label>
                                            <div class="col-md-6">
                                                <input type="text"
                                                required
                                                class="form-control currency"
                                                id=""
                                                ng-model="total_customer_count_day" 
                                                name=""
                                                readonly>
                                            </div>
                                        </div>
                                    </div> -->
                                    <br>
                              </div>

                            <!--divider-->
                            <div class="col-lg-6">
                              <label for="total_hourly_sales" class="col-md-12 control-label text-top" style="margin-bottom: 20px;"><h4>Total Daily Sales</h4></label>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-right">POS No.</label>
                                            <div class="col-md-6">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="pos_num_daily"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-right">Net Sales Amount Day</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                      <input 
                                                          type="text" 
                                                          required 
                                                          class="form-control emphasize" 
                                                          ng-model="total_net_sales"
                                                          ui-number-mask="2"
                                                          readonly>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-right">Number of Sales Transaction/Day</label>
                                            <div class="col-md-6">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="total_sales_transaction"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                <div class="row">
                                        <div class="form-group">
                                            <label for="customer_count_hour" class="col-md-4 control-label text-right">Customer Count Day</label>
                                            <div class="col-md-6">
                                                <input type="text"
                                                required
                                                class="form-control currency"
                                                id=""
                                                ng-model="total_customer_count" 
                                                name=""
                                                readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="transac_date" class="col-md-4 control-label text-right">Total Net Sales Amount Day</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                        <input type="text"
                                                        required
                                                        class="form-control currency"
                                                        id=""
                                                        ng-model="total_netsales_amount"
                                                        ui-number-mask="2" 
                                                        name=""
                                                        readonly>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <!--
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="customer_count_hour" class="col-md-4 control-label text-right">Match with Daily</label>
                                            <div class="col-md-6">
                                            <button type="button" class="btn btn-success" ng-click="match_sales('<?php echo base_url(); ?>index.php/tsms_controller/match_hourly_daily/' + transac_date + '/' + trade_name )"><i class ="fa fa-calculator"></i> Match</button>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    -->
                                    
                            </div>

                            <div class="col-md-12">
                                <table class="table table-hoverable table-primary">
                                    <thead>
                                        <tr>
                                            <th>Tenant Type</th>
                                            <th>Trade Name</th>
                                            <th>Location Code</th>
                                            <th>Transaction Date</th>
                                            <th>Matching Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{tenant_type}}</td>
                                            <td>{{trade_name}}</td>
                                            <td>{{tenant_code}}</td>
                                            <td>{{transac_date}}</td>
                                            <td> <button type="button" ng-class="['btn', 'btn-sm', genStatus == 'Matched' ? 'btn-primary' : 'btn-danger']" style="padding: 2px 10px !important;">{{genStatus}}</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class = "fa fa-close"></i> Close</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div><!--end of calculate modal-->

  



