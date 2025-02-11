<div class="well"  style="margin-top: 20px;margin-left: 10px;margin-right: 10px;">
    <div class="tabs">
        <ul class="nav nav-tabs">
            <li class="active" style="width: 100%"><a href="#menu2" data-toggle="tab" style="font-weight: bold;">Compute Monthly Sales</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade in active row">
                
                <form ng-submit="filterby_day('<?php echo base_url(); ?>tsms_controller/filter_sales_m/'+ tenant_list + '_'+ filter_date + '_'+ location_code + '/'+ trade_name ); $event.preventDefault();" class="upload-control">
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
                            ng-model="trade_name" 
                            required
                            id = "trade_name"
                            ng-change="getLocation('<?php echo base_url(); ?>index.php/tsms_controller/get_location_code/' + trade_name)">
                            <option class="placeholder" selected disabled value="">Select Trade Name</option>
                            <option ng-repeat = "tenant in tenantlist">{{tenant.trade_name}}</option>
                            </select>
                        </div>
                    </div>
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
                    <div class="form-group">
                        <div class="col-md-2 text-left">  
                            <div class="input-group">
                                <div class="input-group-addon input-date"><strong><i class="fa fa-calendar"></i></strong></div>
                                <datepicker date-format="yyyy-MM">
                                    <input 
                                        type="text" 
                                        required 
                                        placeholder="Choose a date" 
                                        class="form-control"  
                                        ng-model="filter_date"
                                        id="filter_date"
                                        name = "filter_date"
                                        autocomplete="off">
                                </datepicker>
                            </div>
                        </div>
                    </div> 
                    <div class="form-group">
                        <div class="col-md-2"  >
                            <button type="submit" style="left:-20px; position: inherit;"  class="btn btn-default"><i class="fa fa-search"></i> Filter Daily Sales</button>
                        </div>
                    </div>
                </form><!-- end upload control-->

                <div style="max-height: 400px; max-width: 100% !important; overflow-y: scroll; !important; display: inline-block; padding-left: 20px;">
                    <table class="table table-bordered table-hover" ng-show="filterdata">
                        <thead>
                            <tr>
                                <th>Tenant Type</th>
                                <th>Tenant Code</th>
                                <th>POS No.</th>
                                <th>Trade Name</th>
                                <th>Transaction Date</th>
                                <th>Old Accumulated Total</th>
                                <th>New Accumulated Total</th>
                                <th>Total Gross Sales</th>
                                <th>Total Netsales</th>
                                <th>Total Cash Sales</th>
                                <th>Total Nontax Sales</th>
                                <th>Total SC Discount</th>
                                <th>Total PWD Discount</th>
                                <th>Other Discount</th>
                                <th>Total Refund Amount</th>
                                <th>Total Tax Vat</th>
                                <th>Total Other Charges</th>
                                <th>Total Service Charges</th>
                                <th>Total Charge Sales</th>
                                <th>Total GC/Other Values</th>
                                <th>Total Void Amount</th>
                                <th>Total Customer Count</th>
                                <th>Control Number</th>
                                <th>Total Sales Transaction</th>
                                <th>Total Sales Type</th>
                                <th>Net Sales Amount</th>
                                <th> Rental Type </th>
                                <th>Status</th>
                                <th>Approved By</th>
                                <th>Adjustment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat= "data in filterdata | filter:query">
                                <td>{{data.tenant_type}}</td>
                                <td>{{data.tenant_code}}</td>
                                <td>{{data.pos_num}}</td>
                                <td>{{data.trade_name}}</td>
                                <td>{{data.transac_date | date}}</td>
                                <td>{{data.old_acctotal | currency :''}}</td>
                                <td>{{data.new_acctotal | currency :''}}</td>
                                <td>{{data.total_gross_sales | currency :''}}</td>
                                <td>{{data.total_net_sales | currency :''}}</td>
                                <td>{{data.total_cash_sales | currency :''}}</td>
                                <td>{{data.total_nontax_sales | currency :''}}</td>
                                <td>{{data.total_sc_discounts | currency :''}}</td>
                                <td>{{data.total_pwd_discounts | currency :''}}</td>
                                <td>{{data.other_discounts | currency :''}}</td>
                                <td>{{data.total_refund_amount  | currency :''}}</td>
                                <td>{{data.total_taxvat | currency :''}}</td>
                                <td>{{data.total_other_charges | currency :''}}</td>
                                <td>{{data.total_service_charge | currency :''}}</td>
                                <td>{{data.total_charge_sales | currency :''}}</td>
                                <td>{{data.total_gcother_values | currency :''}}</td>
                                <td>{{data.total_void_amount | currency :''}}</td>
                                <td>{{data.total_customer_count }}</td>
                                <td>{{data.control_num}}</td>
                                <td>{{data.total_sales_transaction }}</td>
                                <td>{{data.sales_type}}</td>
                                <td>{{data.total_netsales_amount | currency :''}}</td>
                                <td>{{data.rental_type}}</td>
                                <td>{{data.status}}</td>
                                <td>{{data.approved_by}}</td>
                                <td>{{data.adjustment}}</td>
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

<div class="well" style="margin-top: 20px;margin-left: 10px;margin-right: 10px;">
    <label for="total_hourly_sales" class="col-md-12 control-label text-top"><h4>Tenant Total Monthly Sales</h4></label>
    <form  action = "" method="post" name="save_total">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="form-group">
                                <label for="trade_name" class="col-md-7 control-label text-top">Trade Name</label>
                                    <div class="col-md-8">
                                        <input type="text"
                                        required
                                        class="form-control currency"
                                        
                                        ng-model="trade_name" 
                                        name="trade_name"
                                        readonly
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="form-group">
                                    <label for="tenant_type" class="col-md-7 control-label text-top">Tenant Type</label>
                                    <div class="col-md-8">
                                        <input type="text"
                                        required
                                        class="form-control currency"
                                        
                                        ng-model="tenant_type" 
                                        name="tenant_type"
                                        readonly
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="form-group">
                                    <label for="total_hourly_sales" class="col-md-8 control-label text-top">Old Accumulated Total</label>
                                    <div class="col-md-8">
                                        <input type="text"
                                        required
                                        class="form-control currency"
                                        id="old_acctotal"
                                        ng-model="old_acctotal"
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
                                    <label for="new_acctotal" class="col-md-8 control-label text-top">New Accumulated Total</label>
                                    <div class="col-md-8">
                                        <input type="text"
                                        required
                                        class="form-control currency"
                                        id="new_acctotal"
                                        ng-model="new_acctotal" 
                                        name="new_acctotal"
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
                                    <label for="total_hourly_sales" class="col-md-12 control-label text-top">Total Service Charge</label>
                                    <div class="col-md-8">
                                        <input type="text"
                                        required
                                        class="form-control currency"
                                        ng-model="total_service_charge" 
                                        name=""
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
                                    <label for="total_nontax_sales" class="col-md-7 control-label text-top">Total Nontax Sales</label>
                                    <div class="col-md-8">
                                        <input type="text"
                                        required
                                        class="form-control currency"
                                        id="total_nontax_sales"
                                        ng-model="total_nontax_sales" 
                                        name="total_nontax_sales"
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
                                <label for="total_sc_discounts" class="col-md-7 control-label text-top">Total SC Discounts</label>
                                    <div class="col-md-8">
                                        <input type="text"
                                        required
                                        class="form-control currency"
                                        id="total_sc_discounts"
                                        ng-model="total_sc_discounts" 
                                        name="total_sc_discounts"
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
                                    <label for="total_pwd_discounts" class="col-md-7 control-label text-top">Total PWD Discounts</label>
                                    <div class="col-md-8">
                                        <input type="text"
                                        required
                                        class="form-control currency"
                                        id="total_pwd_discounts"
                                        ng-model="total_pwd_discounts" 
                                        name="total_pwd_discounts"
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
                                    <label for="other_discounts" class="col-md-7 control-label text-top">Other Discounts</label>
                                    <div class="col-md-8">
                                        <input type="text"
                                        required
                                        class="form-control currency"
                                        id="other_discounts"
                                        ng-model="other_discounts" 
                                        name="other_discounts"
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
                                    <label for="total_refund_amount" class="col-md-7 control-label text-top">Total Refund Amount</label>
                                    <div class="col-md-8">
                                        <input type="text"
                                        required
                                        class="form-control currency"
                                        id="total_refund_amount"
                                        ng-value="total_refund_amount | numberFormat" 
                                        name="total_refund_amount"
                                        readonly
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="form-group">
                                    <label for="total_taxvat" class="col-md-7 control-label text-top">Total Tax Vat</label>
                                    <div class="col-md-8">
                                        <input type="text"
                                        required
                                        class="form-control currency"
                                        id="total_taxvat"
                                        ng-model="total_taxvat" 
                                        name="total_taxvat"
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
                                    <label for="total_other_charges" class="col-md-7 control-label text-top">Total Other Charges</label>
                                    <div class="col-md-8">
                                        <input type="text"
                                        required
                                        class="form-control currency"
                                        id="total_other_charges"
                                        ng-model="total_other_charges" 
                                        name="total_other_charges"
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
                                    <label for="sales_type" class="col-md-7 control-label text-top">Sales Type</label>
                                    <div class="col-md-8">
                                        <input type="text"
                                        required
                                        class="form-control currency"
                                        id="sales_type"
                                        ng-model="sales_type" 
                                        name="sales_type"
                                        readonly
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="form-group">
                                    <label for="pos_num" class="col-md-7 control-label text-top">Pos No.</label>
                                    <div class="col-md-8">
                                        <input type="text"
                                        required
                                        class="form-control currency"
                                        id="pos_num"
                                        ng-model="pos_num" 
                                        name="pos_num"
                                        readonly
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="form-group">
                                    <label for="total_gross_sales" class="col-md-8 control-label text-top">Total Gross Sales</label>
                                    <div class="col-md-8">
                                        <input type="text"
                                        required
                                        class="form-control currency"
                                       
                                        ng-model="total_gross_sales" 
                                        name="total_gross_sales"
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
                                    <label for="total_net_sales" class="col-md-6 control-label text-top">Total Net Sales</label>
                                    <div class="col-md-8">
                                        <input type="text"
                                        required
                                        class="form-control currency"
                                        
                                        ng-model="total_net_sales" 
                                        name=""
                                        ui-number-mask="2"
                                        readonly
                                        >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-4"  >
                                        <button type="button" id="calculate"class="btn btn-default"  data-toggle="modal" data-target="#calculate_modal_m"><i class="fa fa-calculator"></i></button>
                                    </div>
                                </div>
    <!-- calculate -->       </div>
                        </div><!--col-md-6-->
                        <div class="col-md-6">
                            <div class="row">
                                <div class="form-group">
                                    <label for="total_cash_sales" class="col-md-7 control-label text-top">Total Cash Sales</label>
                                    <div class="col-md-8">
                                        <input type="text"
                                        required
                                        class="form-control currency"
                                        
                                        ng-model="total_cash_sales" 
                                        name=""
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
                                    <label for="total_charge_sales" class="col-md-7 control-label text-top">Total Charge Sales</label>
                                    <div class="col-md-8">
                                        <input type="text"
                                        required
                                        class="form-control currency"
                                        
                                        ng-model="total_charge_sales" 
                                        name=""
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
                                    <label for="total_gcother_values" class="col-md-7 control-label text-top">Total GC Other Values</label>
                                    <div class="col-md-8">
                                        <input type="text"
                                        required
                                        class="form-control currency"
                                        
                                        ng-model="total_gcother_values" 
                                        name=""
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
                                    <label for="total_void_amount" class="col-md-7 control-label text-top">Total Void Amount</label>
                                    <div class="col-md-8">
                                        <input type="text"
                                        required
                                        class="form-control currency"
                                        
                                        ng-model="total_void_amount" 
                                        name=""
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
                                    <label for="total_customer_count" class="col-md-7 control-label text-top">Total Customer Count </label>
                                    <div class="col-md-8">
                                        <input type="text"
                                        required
                                        class="form-control currency"
                                       
                                        ng-model="total_customer_count"
                                        readonly 
                                        name=""
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="form-group">
                                    <label for="total_sales_transaction" class="col-md-7 control-label text-top">Total Sales Transaction</label>
                                    <div class="col-md-8">
                                        <input type="text"
                                        required
                                        class="form-control currency"
                                        
                                        ng-model="total_sales_transaction" 
                                        name="total_sales_transaction"
                                        readonly
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="form-group">
                                    <label for="total_netsales_amount" class="col-md-7 control-label text-top">Total Netsales Amount</label>
                                    <div class="col-md-8">
                                        <input type="text"
                                        required
                                        class="form-control currency"
                                        id="total_netsales_amount"
                                        ng-model="total_netsales_amount" 
                                        name="total_netsales_amount"
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
                                    <label for="control_num" class="col-md-7 control-label text-top">Control No.</label>
                                    <div class="col-md-8">
                                        <input type="text"
                                        required
                                        class="form-control currency"
                                        
                                        ng-model="control_num" 
                                        name="control_num"
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
                                        id="tenant_type_code"
                                        ng-model="tenant_type_code" 
                                        name="tenant_type_code"
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
                                        class="form-control currency"
                                        id="tenant_code"
                                        ng-model="tenant_code" 
                                        name="tenant_code"
                                        readonly
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="row">
                                <div class="form-group">
                                    <label for="total_discounts_w_approval" class="col-md-12 control-label text-top">Discounts w/ Approval</label>
                                    <div class="col-md-8">
                                        <input type="text"
                                        required
                                        class="form-control currency"
                                        
                                        ng-model="total_discounts_w_approval" 
                                        name=""
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
                                    <label for="total_discounts_wo_approval" class="col-md-12 control-label text-top">Discounts w/o Approval</label>
                                    <div class="col-md-8">
                                        <input type="text"
                                        required
                                        class="form-control currency"
                                        
                                        ng-model="total_discounts_wo_approval" 
                                        name=""
                                        ui-number-mask="2"
                                        readonly
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div><!--daily-->

<div class="modal fade" role="dialog" id="calculate_modal_m" aria-labelledby="view_calculate_modal_m">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4><i class="fa fa-search"></i> View Modal</h4>
            </div>
                <div class="modal-body">
                <form method="post" name="save_total" ng-submit="ajaxPost( $base_url + 'index.php/tsms_controller/save_monthly_sale_computation/'+ tenant_list + '_'+ filter_date + '_'+ location_code + '/'+ trade_name, {discounts_w_approval : discounts_w_approval} ); $event.preventDefault()">
                        <div class="col-lg-12">
                              <div class="col-lg-6">
                                  <label for="total_hourly_sales" class="col-md-12 control-label text-top" style="margin-bottom: 20px;"><h4>Total Monthly Sales</h4></label>
                                  <div class="row">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-right">Trade Name</label>
                                            <div class="col-md-6">                                                
                                                <input 
                                                    type="text" 
                                                    required
                                                    
                                                    name="trade_name" 
                                                    class="form-control emphasize" 
                                                    ng-model="trade_name"
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
                                                    ng-model="tenant_type"
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
                                                    ng-model="rental_type"
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
                                                            
                                                            name="old_acctotal" 
                                                            class="form-control emphasize" 
                                                            ng-model="old_acctotal"
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
                                                          
                                                          name="new_acctotal" 
                                                          class="form-control emphasize" 
                                                          ng-model="new_acctotal"
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
                                                      
                                                      ng-model="total_gross_sales" 
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
                                            <label for="total_net_sales" class="col-md-4 control-label text-right">Total Net Sales</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                      <input type="text"
                                                      required
                                                      class="form-control currency"
                                                      id="total_net_sales"
                                                      ng-model="total_net_sales" 
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
                                                          ng-model="total_cash_sales"
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
                                            <label for="transac_date" class="col-md-4 control-label text-right">Total Non Tax Sales</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                      <input type="text"
                                                      required
                                                      class="form-control currency"
                                                      
                                                      name="total_nontax_sales" 
                                                      ng-model="total_nontax_sales" 
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
                                                      
                                                      ng-model="total_sc_discounts" 
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
                                                      
                                                      ng-model="total_pwd_discounts" 
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
                                            <label for="total_discounts_w_approval" class="col-md-4 control-label text-right">Total Discounts w/ Approval</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                      <input type="text"
                                                      required
                                                      class="form-control currency"
                                                      id="total_discounts_w_approval"
                                                      ng-model="total_discounts_w_approval" 
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
                                                      ng-model="total_discounts_wo_approval" 
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
                                                          
                                                          name="other_discounts" 
                                                          class="form-control emphasize" 
                                                          ng-model="other_discounts"
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
                                                          name="total_refund_amount" 
                                                          class="form-control emphasize" 
                                                          ng-value="total_refund_amount | numberFormat"
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
                                                      
                                                      ng-model="total_taxvat" 
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
                                                      
                                                      ng-model="total_other_charges" 
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
                                                        ng-model="total_service_charge" 
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
                                            <label for="total_charge_sales" class="col-md-4 control-label text-right">Total Charge Sales</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                        <input type="text"
                                                        required
                                                        class="form-control currency"
                                                        id="total_charge_sales"
                                                        ng-model="total_charge_sales" 
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
                                                        ng-model="total_gcother_values" 
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
                                                      ng-model="total_void_amount" 
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
                                                ng-model="total_customer_count" 
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
                                                ng-model="total_sales_transaction" 
                                                name="total_sales_transaction"
                                                ui-number-mask="2"
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
                                                          
                                                          name="total_netsales_amount" 
                                                          class="form-control emphasize" 
                                                          ng-model="total_netsales_amount"
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
                                                    ng-model="control_num"
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
                                                    
                                                    name="sales_type" 
                                                    class="form-control emphasize" 
                                                    ng-model="sales_type"
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
                                                   
                                                    name="pos_num" 
                                                    class="form-control emphasize" 
                                                    ng-model="pos_num"
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
                                                    
                                                    name="tenant_type_code" 
                                                    class="form-control emphasize" 
                                                    ng-model="tenant_type_code"
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
                                                    
                                                    name="tenant_code" 
                                                    class="form-control emphasize" 
                                                    ng-model="tenant_code"
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
                                                    ng-model="location_code"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-right">Date </label>
                                            <div class="col-md-6">
                                                <input 
                                                    type="text" 
                                                    required
                                                    id="date"
                                                    name="date" 
                                                    class="form-control emphasize" 
                                                    ng-model="date"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>     

                              </div>

                        <!--divider-->
                            <div class="col-lg-6">
                              <label for="total_hourly_sales" class="col-md-12 control-label text-top" style="margin-bottom: 20px;"><h4>Data For Leasing</h4></label>
                                  <div class="row">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-right">Trade Name</label>
                                            <div class="col-md-6">
                                                <input 
                                                    type="text" 
                                                    required
                                                    id="get_trade_name"
                                                    name="trade_name" 
                                                    class="form-control emphasize" 
                                                    ng-model="trade_name"
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
                                                    
                                                    name="tenant_type" 
                                                    class="form-control emphasize" 
                                                    ng-model="tenant_type"
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
                                                  
                                                  name="rental_type" 
                                                  class="form-control emphasize" 
                                                  ng-model="rental_type"
                                                  readonly>
                                          </div>
                                      </div>
                                    </div>
                                    <br>
                                    <div class="row" ng-if="asd == 'GROSS'">
                                      <div class="form-group">
                                          <label class="col-md-4 control-label text-right">GROSS</label>
                                          <div class="col-md-6">
                                          </div>
                                      </div>
                                    </div>
                                    <div class="row" ng-if="asd == 'GROSS'">
                                        <div class="form-group">
                                            <label for="total_gross_sales" class="col-md-4 control-label text-right">Gross Sales</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                      <input type="text"
                                                      required
                                                      class="form-control currency"
                                                      
                                                      name="total_gross_sales" 
                                                      ng-model="total_gross_sales" 
                                                      ui-number-mask="2"
                                                      readonly>
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="total_refund_amount" class="col-md-5 control-label text-right"> less -- Total Refund Amount</label>
                                            <div class="col-md-5">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                      <input type="text"
                                                      required
                                                      class="form-control currency"
                                                      
                                                      name="total_refund_amount" 
                                                      ng-model="total_refund_amount" 
                                                      ui-number-mask="2"
                                                      readonly>
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" ng-show="asd == 'NET'">
                                      <div class="form-group">
                                          <label class="col-md-4 control-label text-right">NET</label>
                                          <div class="col-md-6">
                                          </div>
                                      </div>
                                    </div>
                                    <div class="row" ng-show="asd == 'VATABLE SALES'">
                                      <div class="form-group">
                                          <label class="col-md-4 control-label text-right">VATABLE SALES</label>
                                          <div class="col-md-6">
                                          </div>
                                      </div>
                                    </div>
                                    <div class="row" ng-show="asd == 'VATABLE SALES'">
                                        <div class="form-group">
                                            <label for="total_gross_sales" class="col-md-4 control-label text-right">Gross Sales</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                      <input type="text"
                                                      required
                                                      class="form-control currency"
                                                      id="total_gross_sales"
                                                      name="total_gross_sales" 
                                                      ng-model="total_gross_sales" 
                                                      ui-number-mask="2"
                                                      readonly>
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="total_refund_amount" class="col-md-5 control-label text-right"> less -- Total Refund Amount</label>
                                            <div class="col-md-5">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                      <input type="text"
                                                      required
                                                      class="form-control currency"
                                                     
                                                      name="total_refund_amount" 
                                                      ng-model="total_refund_amount" 
                                                      ui-number-mask="2"
                                                      readonly>
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="total_nontax_sales" class="col-md-5 control-label text-right"> less -- Vat-Exempt</label>
                                            <div class="col-md-5">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                      <input type="text"
                                                      required
                                                      class="form-control currency"
                                                      
                                                      name="total_nontax_sales" 
                                                      ng-model="total_nontax_sales" 
                                                      ui-number-mask="2"
                                                      readonly>
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="discounts_w_approval" class="col-md-5 control-label text-right">less -- Discounts w/ Approval</label>
                                            <div class="col-md-5">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                      <input type="text"
                                                      required
                                                      class="form-control currency"
                                                      ng-model="discounts_w_approval" 
                                                      ui-number-mask="2">
                                                      <input type="hidden" name="discounts_w_approval" ng-value="discounts_w_approval">
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="total_sc_discounts" class="col-md-5 control-label text-right">less -- SC Discounts</label>
                                            <div class="col-md-5">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                      <input type="text"
                                                      required
                                                      class="form-control currency"
                                                      
                                                      name="total_sc_discounts" 
                                                      ng-model="total_sc_discounts" 
                                                      ui-number-mask="2"
                                                      readonly>
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-right">Rentable Sale</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                      <input 
                                                          type="text" 
                                                          required
                                                          id="sales" 
                                                          class="form-control emphasize" 
                                                          ng-model="sales"
                                                          name="sales" 
                                                          ui-number-mask="2"
                                                          readonly>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row" ng-if="asd == 'VATABLE SALES'">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label text-right">Calculate Total Rentable </label>
                                            <div class="col-md-6"  >
                                                <button type="button" style="left:-20px; position: inherit;" ng-click="calculate_m()" class="btn btn-default"><i class="fa fa-calculator"></i> Calculate</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" ng-if="asd == 'NET'">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label text-right">Calculate Total Rentable </label>
                                            <div class="col-md-6"  >
                                                <button type="button" style="left:-20px; position: inherit;" ng-click="calculate_m()" class="btn btn-default"><i class="fa fa-calculator"></i> Calculate</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" ng-if="asd == 'GROSS'">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label text-right">Calculate Total Rentable </label>
                                            <div class="col-md-6"  >
                                                <button type="button" style="left:-20px; position: inherit;" ng-click="calculate_m()" class="btn btn-default"><i class="fa fa-calculator"></i> Calculate</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!--
                                    <div class="row" ng-hide="hide_button">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label text-right">Sales Type </label>
                                            <div class="col-md-6"  >
                                                <button type="button" style="left:-20px; position: inherit;" ng-click="tenant_sales_type('<?php echo base_url ();?>index.php/tsms_controller/sales_type/'+ location_code)" class="btn btn-default"><i class="fa fa-calculator"></i> Sales Type</button>
                                            </div>
                                        </div>
                                    </div>
                                    -->
                                  
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" ng-disabled="save_total.$invalid" class="btn btn-success"><i class="fa fa-money"></i> Save Calculated Monthly Sales</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class = "fa fa-close"></i> Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    </div>
