<div class="container">
    <div class="cover"> 
        <div class="well" >
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i> Compute Yearly Sales </div>
            </div>
            <form ng-submit="get_monthly_sales($base_url + 'tsms_controller/filter_sales_yearly', $event)" class="upload-control">
                
                <div class="col-md-2">
                    <div class="form-group">
                          <select
                          class = "form-control" 
                          name = "tenant_list"
                          ng-model="tenant_list" 
                          required
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
                          ng-model="tradename"
                          ng-change="getLocation($base_url + 'tsms_controller/get_location_code/' + tradename)"
                          >
                          <option class="placeholder" selected disabled value="">Select Trade Name</option>
                          <option ng-repeat = "tenant in tenantlist">{{tenant.trade_name}}</option>
                          </select>
                    </div>
                </div>
                <?php if($this->session->userdata('user_type') == 'Administrator'): ?>
                <div class="col-md-2" >
                    <div class="form-group">
                       <select
                            class="form-control"
                            name="location_code"
                            required=""
                            ng-model="location_code"
                            ng-options="l.location_code as l.location_code for l in locations">                
                        </select>
                    </div>
                </div>
                <?php endif; ?>
               
                <div class="col-md-2" >
                    <div class="form-group">
                        <select
                        class = "form-control" 
                        name = "year" 
                        required
                        id = "year"
                        ng-model="year">
                        <option class="placeholder" selected disabled value="">Year</option>
                        <option>2017</option>
                        <option>2018</option>
                        <option>2019</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                      <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Filter Monthly Sales</button>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                      <button type="button" id="calculate"class="btn btn-default"  data-toggle="modal"  data-target="#calculate_modal_m"><i class="fa fa-calculator"></i></button>
                    </div>
                </div>
                
            </form><!-- end upload control-->
           
            

            <div class="tabs"  ng-controller="tablecontroller">
                <div class="row">
                    <div class="col-md-2 pull-right"">
                      <input ng-model="query" class="form-control search-query" placeholder="Search Here..."/>
                    </div>
                </div>
                <div class="table-computing" id="table1">  
                    <div class="tab-content">
                        <div id="menu1" class="tab-pane fade in active">
                            <table class="table table-bordered" ng-show="filter_monthlydata">
                                <thead>
                                  <tr>
                                    <th>Tenant Type {{query}}</th>
                                    <th>Trade Name</th>
                                    <th>Tenant Code</th>
                                    <th>POS No.</th>
                                    <th>Date</th>
                                    <th>Old Accumulated Total</th>
                                    <th>New Accumulated Total</th>
                                    <th>Total Gross Sales</th>
                                    <th>Total Nontax Sales</th>
                                    <th>Total SC Discount</th>
                                    <th>Total PWD Discount</th>
                                    <th>Other Discount</th>
                                    <th>Total Refund Amount</th>
                                    <th>Total Tax Vat</th>
                                    <th>Total Other Charges</th>
                                    <th>Total Service Charges</th>
                                    <th>Total Netsales</th>
                                    <th>Total Cash Sales</th>
                                    <th>Total Charge Sales</th>
                                    <th>Total GC/Other Values</th>
                                    <th>Total Void Amount</th>
                                    <th>Total Customer Count</th>
                                    <th>Control Number</th>
                                    <th>Total Sales Transaction</th>
                                    <th>Sales Type</th>
                                    <th>Net Sales Amount</th>
                                    <th> Rental Type </th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr ng-repeat= "md in filter_monthlydata | filter:query">
                                    <td>{{md.tenant_type}}</td>
                                    <td>{{md.trade_name}}</td>
                                    <td>{{md.tenant_code}}</td>
                                    <td>{{md.pos_num}}</td>
                                    <td>{{md.date_end}}</td>
                                    <td>{{md.old_acctotal | numberFormat}}</td>
                                    <td>{{md.new_acctotal | numberFormat}}</td>
                                    <td>{{md.total_gross_sales | numberFormat}}</td>
                                    <td>{{md.total_nontax_sales | numberFormat}}</td>
                                    <td>{{md.total_sc_discounts | numberFormat}}</td>
                                    <td>{{md.total_pwd_discounts | numberFormat}}</td>
                                    <td>{{md.other_discounts | numberFormat}}</td>
                                    <td>{{md.total_refund_amount  | numberFormat}}</td>
                                    <td>{{md.total_taxvat | numberFormat}}</td>
                                    <td>{{md.total_other_charges | numberFormat}}</td>
                                    <td>{{md.total_service_charge | numberFormat}}</td>
                                    <td>{{md.total_net_sales | numberFormat}}</td>
                                    <td>{{md.total_cash_sales | numberFormat}}</td>
                                    <td>{{md.total_charge_sales | numberFormat}}</td>
                                    <td>{{md.total_gcother_values | numberFormat}}</td>
                                    <td>{{md.total_void_amount | numberFormat}}</td>
                                    <td>{{md.total_customer_count}}</td>
                                    <td>{{md.control_num}}</td>
                                    <td>{{md.total_sales_transaction }}</td>
                                    <td>{{md.sales_type}}</td>
                                    <td>{{md.total_netsales_amount | numberFormat}}</td>
                                    <td>{{md.rental_type}}</td>
                                  </tr>
                                  <tr class="ng-cloak" ng-show="filterdata.length==0 || (filterdata | filter:query).length == 0">
                                      <td colspan="7"><center>No Data Available.</center></td>
                                  </tr>
                                </tbody>
                            </table>
                        </div> <!--end of tab2-->
                    </div>
                </div>
            </div>
        </div>
    </div>


<div class="modal fade" role="dialog" id="calculate_modal_m" aria-labelledby="view_calculate_modal_m">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4><i class="fa fa-search"></i> View Modal</h4>
            </div>
                <div class="modal-body">
                <form ng-submit="saveComputedYearlySale($base_url + 'tsms_controller/save_computed_yearly_sale', $event);" method="post" >
                    <div class="col-lg-12">
                          <div class="col-lg-12">
                              <label for="total_hourly_sales" class="col-md-12 control-label text-top" style="margin-bottom: 20px;"><h4>Total Yearly Sales</h4></label>
                              <div class="row">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-right">Trade Name</label>
                                        <div class="col-md-6">
                                            <input 
                                                type="text" 
                                                required
                                                name="trade_name" 
                                                class="form-control emphasize" 
                                                ng-model="data.trade_name"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-right">Tenant Code </label>
                                        <div class="col-md-6">
                                            <input 
                                                type="text" 
                                                required
                                                id="tenant_code"
                                                name="tenant_code" 
                                                class="form-control emphasize" 
                                                ng-model="data.tenant_code"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <br> 
                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-right">Tenant Type</label>
                                        <div class="col-md-6">
                                            <input 
                                                type="text" 
                                                required
                                                id="tenant_type"
                                                name="tenant_type" 
                                                class="form-control emphasize" 
                                                ng-model="data.tenant_type"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-right">Rental Type</label>
                                        <div class="col-md-6">
                                            <input 
                                                type="text" 
                                                required
                                                id="rental_type"
                                                name="rental_type" 
                                                class="form-control emphasize"
                                                ng-model="data.rental_type"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-right">Old Accumulated Total</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                    <input 
                                                        type="text" 
                                                        required
                                                        id="old_acctotal"
                                                        name="old_acctotal" 
                                                        class="form-control emphasize" 
                                                        ng-model="data.old_acctotal"
                                                        ui-number-mask="2"
                                                        readonly>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            <div class="row">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-right">New Accumulated Total</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                  <input 
                                                      type="text" 
                                                      required
                                                      id="new_acctotal"
                                                      name="new_acctotal" 
                                                      class="form-control emphasize" 
                                                      ng-model="data.new_acctotal"
                                                      ui-number-mask="2"
                                                      readonly>
                                              </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            <div class="row">
                                    <div class="form-group">
                                        <label for="total_gross_sales" class="col-md-4 control-label text-right">Total Gross Sales</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                  <input type="text"
                                                  required
                                                  class="form-control currency"
                                                  id="total_gross_sales"
                                                  ng-model="data.total_gross_sales" 
                                                  name="total_gross_sales"
                                                  ui-number-mask="2"
                                                  readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <label for="transac_date" class="col-md-4 control-label text-right">Total Non Tax Sales</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                  <input type="text"
                                                  required
                                                  class="form-control currency"
                                                  id="total_nontax_sales"
                                                  name="total_nontax_sales" 
                                                  ng-model="data.total_nontax_sales" 
                                                  ui-number-mask="2"
                                                  readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <label for="total_sc_discounts" class="col-md-4 control-label text-right">Total SC Discounts</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                  <input type="text"
                                                  required
                                                  class="form-control currency"
                                                  id="total_sc_discounts"
                                                  ng-model="data.total_sc_discounts" 
                                                  name="total_sc_discounts"
                                                  ui-number-mask="2"
                                                  readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <label for="total_pwd_discounts" class="col-md-4 control-label text-right">Total PWD Discounts</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                  <input type="text"
                                                  required
                                                  class="form-control currency"
                                                  id="total_pwd_discounts"
                                                  ng-model="data.total_pwd_discounts" 
                                                  name="total_pwd_discounts"
                                                  ui-number-mask="2"
                                                  readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <label for="total_discounts_w_approval" class="col-md-4 control-label text-right">Total Discounts w Approval</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                  <input type="text"
                                                  required
                                                  class="form-control currency"
                                                  id="total_discounts_w_approval"
                                                  ng-model="data.total_discounts_w_approval" 
                                                  name="total_discounts_w_approval"
                                                  ui-number-mask="2"
                                                  readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br> 
                                <div class="row">
                                    <div class="form-group">
                                        <label for="total_discounts_wo_approval" class="col-md-4 control-label text-right">Total Discounts w/o Approval</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                  <input type="text"
                                                  required
                                                  class="form-control currency"
                                                  id="total_discounts_wo_approval"
                                                  ng-model="data.total_discounts_wo_approval" 
                                                  name="total_discounts_wo_approval"
                                                  ui-number-mask="2"
                                                  readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>  

                                 <div class="row">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-right">Other Discounts </label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                  <input 
                                                      type="text" 
                                                      required
                                                      id="other_discounts"
                                                      name="other_discounts" 
                                                      class="form-control emphasize" 
                                                      ng-model="data.other_discounts"
                                                      ui-number-mask="2"
                                                      readonly>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            <div class="row">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-right">Total Refund Amount </label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                  <input 
                                                      type="text" 
                                                      required
                                                      id="total_refund_amount"
                                                      name="total_refund_amount" 
                                                      class="form-control emphasize" 
                                                      ng-model="data.total_refund_amount"
                                                      ui-number-mask="2"
                                                      readonly>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            <div class="row">
                                    <div class="form-group">
                                        <label for="total_taxvat" class="col-md-4 control-label text-right">Total Tax Vat</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                  <input type="text"
                                                  required
                                                  class="form-control currency"
                                                  id="total_taxvat"
                                                  ng-model="data.total_taxvat" 
                                                  name="total_taxvat"
                                                  ui-number-mask="2"
                                                  readonly>
                                              </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <label for="total_other_charges" class="col-md-4 control-label text-right">Total Other Charges</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                  <input type="text"
                                                  required
                                                  class="form-control currency"
                                                  id="total_other_charges"
                                                  ng-model="data.total_other_charges" 
                                                  name="total_other_charges"
                                                  ui-number-mask="2"
                                                  readonly>
                                              </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <label for="total_service_charge" class="col-md-4 control-label text-right">Total Service Charge </label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                    <input type="text"
                                                    required
                                                    class="form-control currency"
                                                    id="total_service_charge"
                                                    ng-model="data.total_service_charge" 
                                                    name="total_service_charge"
                                                    ui-number-mask="2"
                                                    readonly>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                              <div class="row">
                                    <div class="form-group">
                                        <label for="total_net_sales" class="col-md-4 control-label text-right">Total Net Sales</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                  <input type="text"
                                                  required
                                                  class="form-control currency"
                                                  id="total_net_sales"
                                                  ng-model="data.total_net_sales" 
                                                  name="total_net_sales"
                                                  ui-number-mask="2"
                                                  readonly>
                                              </div>
                                        </div>
                                    </div>
                                </div>
                                <br>

                            <div class="row">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-right">Total Cash Sales</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                  <input 
                                                      type="text" 
                                                      required 
                                                      class="form-control emphasize" 
                                                      ng-model="data.total_cash_sales"
                                                      id="total_cash_sales"
                                                      name="total_cash_sales" 
                                                      ui-number-mask="2"
                                                      readonly>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            <div class="row">
                                    <div class="form-group">
                                        <label for="total_charge_sales" class="col-md-4 control-label text-right">Total Charge Sales</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                    <input type="text"
                                                    required
                                                    class="form-control currency"
                                                    id="total_charge_sales"
                                                    ng-model="data.total_charge_sales" 
                                                    name="total_charge_sales"
                                                    ui-number-mask="2"
                                                    readonly>
                                              </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <label for="total_gcother_values" class="col-md-4 control-label text-right">Total GC/Other Values </label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                    <input type="text"
                                                    required
                                                    class="form-control currency"
                                                    id="total_gcother_values"
                                                    ng-model="data.total_gcother_values" 
                                                    name="total_gcother_values"
                                                    ui-number-mask="2"
                                                    readonly>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <label for="total_void_amount" class="col-md-4 control-label text-right">Total Void Amount </label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                  <input type="text"
                                                  required
                                                  class="form-control currency"
                                                  id="total_void_amount"
                                                  ng-model="data.total_void_amount" 
                                                  name="total_void_amount"
                                                  ui-number-mask="2"
                                                  readonly>
                                              </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <label for="total_customer_count" class="col-md-4 control-label text-right">Total Customer Count </label>
                                        <div class="col-md-6">
                                            <input type="text"
                                            required
                                            class="form-control currency"
                                            id="total_customer_count"
                                            ng-model="data.total_customer_count" 
                                            name="total_customer_count"
                                            readonly>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                 <div class="row">
                                    <div class="form-group">
                                        <label for="total_sales_transaction" class="col-md-4 control-label text-right">Total Sales Transaction</label>
                                        <div class="col-md-6">
                                            <input type="text"
                                            required
                                            class="form-control currency"
                                            id="total_sales_transaction"
                                            ng-model="data.total_sales_transaction" 
                                            name="total_sales_transaction"
                                            readonly>
                                        </div>
                                    </div>
                                </div>
                                <br> 
                                 <div class="row">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-right">Total Netsales Amount </label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                  <input 
                                                      type="text" 
                                                      required
                                                      id="total_netsales_amount"
                                                      name="total_netsales_amount" 
                                                      class="form-control emphasize" 
                                                      ng-model="data.total_netsales_amount"
                                                      ui-number-mask="2"
                                                      readonly>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-right">Control No. </label>
                                        <div class="col-md-6">
                                            <input 
                                                type="text" 
                                                required
                                                id="control_num"
                                                name="control_num" 
                                                class="form-control emphasize" 
                                                ng-model="data.control_num"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-right">Sales Type </label>
                                        <div class="col-md-6">
                                            <input 
                                                type="text" 
                                                required
                                                id="sales_type"
                                                name="sales_type" 
                                                class="form-control emphasize" 
                                                ng-model="data.sales_type"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <br> 
                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-right">POS No. </label>
                                        <div class="col-md-6">
                                            <input 
                                                type="text" 
                                                required
                                                id="pos_num"
                                                name="pos_num" 
                                                class="form-control emphasize" 
                                                ng-model="data.pos_num"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <br> 
                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-right">Tenant Type Code </label>
                                        <div class="col-md-6">
                                            <input 
                                                type="text" 
                                                required
                                                id="tenant_type_code"
                                                name="tenant_type_code" 
                                                class="form-control emphasize" 
                                                ng-model="data.tenant_type_code"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label text-right">Location Code </label>
                                        <div class="col-md-6">
                                            <input 
                                                type="text" 
                                                required
                                                id="location_code"
                                                name="location_code" 
                                                class="form-control emphasize" 
                                                ng-model="data.location_code"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <br>    

                          </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><i class="fa fa-money"></i> Save Calculated Yearly Sales</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class = "fa fa-close"></i> Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div><!-- well -->