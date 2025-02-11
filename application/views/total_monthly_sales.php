<div class="container">
	<div class="cover">
    	<div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-money" aria-hidden="true"></i> Total Monthly Sales </div>
        </div>
        <div class="well" ng-controller="tablecontroller" ng-controller="decontroller" >
            <div class="table-totalsales">
                <form action="<?=base_url()?>reports/total_monthly_sales" target="_blank" method="post" name = "frm_print" id="frm_print">  
                    <div class="tab-content">
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
                                      ng-change="getTenants('<?php echo base_url(); ?>index.php/tsms_controller/get_tenants/' + tenant_list)">
                                      <option class="placeholder" selected disabled value="">Select Tenant Type</option>
                                      <option id="long_term_tenants">Long Term Tenants</option>
                                      <option id="short_term_tenants">Short Term Tenants</option>
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
                                                readonly
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
                                  <button type="button" ng-click="monthly_total_button('<?php echo base_url(); ?>index.php/tsms_controller/monthly_total/'+ tenant_list + '_'+ filter_date)" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
                                </div>
                            </div>
                        </div><!-- end upload control-->
                        <div id="menu1" class="tab-pane fade in active">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                          <tr>
                                            <th>Trade Name</th>
                                            <th>Date</th>
                                            <th>Rental Type</th>
                                            <th>Monthly Net Sales</th>
                                            <th>Monthly Gross Sales</th>
                                            <th>Monthly Cash Sales</th>
                                            <th>Tenant Type</th>
                                            <th>Action</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="data in monthly_total | filter:query">
                                                <td>{{data.trade_name}}</td>
                                                <td>{{data.date_end }}</td>
                                                <td>{{data.rental_type}}</td>
                                                <td>{{data.total_netsales_amount | currency : ''}}</td>
                                                <td>{{data.total_gross_sales | currency : ''}}</td>
                                                <td>{{data.total_cash_sales | currency : ''}}</td>
                                                <td>{{data.tenant_type}}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <div class="img_menu">
                                                            <img src="<?php echo base_url(); ?>img/menu3.png" style="height: 15px; width: 13px;" data-toggle="dropdown" id="img_menu">
                                                            <ul style="position:absulote;left: -40px; top: -5px; background: white; border-top: none;" class="dropdown-menu">
                                                                <li>
                                                                    <a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#view_modal_daily" ng-click="setData(data)">
                                                                        <i class = "fa fa-search"></i> View</a>
                                                                </li>
                                                                <?php if($this->session->userdata('user_type') == 'Administrator'): ?>
                                                                    <li>
                                                                        <a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#update_modal_daily" ng-click="setData(data)"> <i class = "fa fa-edit"></i> Update</a>
                                                                    </li>
                                                                <?php endif ?>
                                                                <li>
                                                                    <a href="#" ng-click="deleteDataAjax($base_url + 'tsms_controller/delete_monthly_total/' + data.id, 'monthly_total', data)" > <i class = "fa fa-trash"></i> Delete</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td> 
                                            </tr>
                                            <tr class="ng-cloak" ng-show="monthly_total.length==0 || (monthly_total | filter:query).length == 0">
                                                <td colspan="7"><center>No Data Available.</center></td>
                                            </tr>    
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1" id="print_button">
                                    <button type="submit" ng-disabled = "monthly_total.length==0 || frm_print.$invalid"  class="btn btn-primary"><i class="fa fa-print"> Print</i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
		</div><!--end div well-->
	</div><!--end div cover-->
</div><!--end div container-->

<!--view modal daily-->
<div id="view_modal_daily" class="modal fade" role="dialog" aria-labelledby="tenant_daily_sales">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <h4><i class="fa fa-search"></i> View Monthly Total</h4>
                </div>
                <div class="modal-body">
                    <form  action = "#" method="post" name = "frm_update" id = "frm_update">
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
                                            <label for="trade_name" class="col-md-4 control-label text-right">Trade Name</label>
                                            <div class="col-md-8">
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
                                            <label for="tenant_code" class="col-md-4 control-label text-right">Tenant Code</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control currency" 
                                                    ng-model="data.tenant_code" 
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
                                            <label for="date_end" class="col-md-4 control-label text-right">Transaction Date</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text"
                                                    readonly 
                                                    required 
                                                    class="form-control" 
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
                                            <label for="pos_num" class="col-md-4 control-label text-right">POS No.</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control" 
                                                    ng-model="data.pos_num" 
                                                    id="pos_num" 
                                                    name = "pos_num"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>


                                <!--1-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="old_acctotal" class="col-md-4 control-label text-right">Old Accumulated Total</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                        <input 
                                                        type="text" 
                                                        required 
                                                        class="form-control currency" 
                                                        ng-value="data.old_acctotal | numberFormat" 
                                                        id="old_acctotal" 
                                                        name = "old_acctotal"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--1-->
                                    <br>
                                    <!--2-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="new_acctotal" class="col-md-4 control-label text-right">New Accumulated Total</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                        <input 
                                                        type="text" 
                                                        required 
                                                        class="form-control emphasize" 
                                                        ng-value="data.new_acctotal  | numberFormat" 
                                                        id="new_acctotal" 
                                                        name = "new_acctotal"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--2-->
                                    <br>
                                    <!--3-->
                                  <div class="row">
                                        <div class="form-group">
                                            <label for="total_gross_sales" class="col-md-4 control-label text-right">Total Gross Sales</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                        <input
                                                        type="text" 
                                                        required 
                                                        class="form-control emphasize" 
                                                        ng-value="data.total_gross_sales  | numberFormat" 
                                                        id="total_gross_sales" 
                                                        name = "total_gross_sales"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <!--3-->

                                    <!--4-->
                                   <div class="row">
                                        <div class="form-group">
                                            <label for="total_nontax_sales" class="col-md-4 control-label text-right">Total Nontax Sales</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                        <input 
                                                        type="text" 
                                                        required 
                                                        class="form-control emphasize" 
                                                        ng-value="data.total_nontax_sales | numberFormat" 
                                                        id="total_nontax_sales" 
                                                        name = "total_nontax_sales"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <!--4-->

                                    <!--5-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="total_sc_discounts" class="col-md-4 control-label text-right">Total SC Discounts</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                        <input 
                                                        type="text" 
                                                        required 
                                                        class="form-control emphasize" 
                                                        ng-value="data.total_sc_discounts | numberFormat" 
                                                        id="total_sc_discounts" 
                                                        name = "total_sc_discounts"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <!--5-->

                                    <!--6-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="other_discounts" class="col-md-4 control-label text-right">Other Discounts</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                        <input 
                                                        type="text" 
                                                        required 
                                                        class="form-control emphasize" 
                                                        ng-value="data.other_discounts | numberFormat" 
                                                        id="other_discounts" 
                                                        name = "other_discounts"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <!--6-->

                                    <!--7-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="total_refund_amount" class="col-md-4 control-label text-right">Total Refund Amount</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                        <input 
                                                        type="text" 
                                                        required 
                                                        class="form-control emphasize" 
                                                        ng-value="data.total_refund_amount  | numberFormat" 
                                                        id="total_refund_amount" 
                                                        name = "total_refund_amount"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--7-->
                                    <br>
                                    <!--8-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="total_taxvat" class="col-md-4 control-label text-right">Total Tax Vat</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                        <input 
                                                        type="text" 
                                                        required 
                                                        class="form-control emphasize" 
                                                        ng-value="data.total_taxvat | numberFormat" 
                                                        id="total_taxvat" 
                                                        name = "total_taxvat"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <!--8-->

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
                                            <label for="total_pwd_discounts" class="col-md-4 control-label text-right">Total PWD Discounts</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                        <input 
                                                        type="text" 
                                                        required 
                                                        class="form-control emphasize" 
                                                        ng-value="data.total_pwd_discounts | numberFormat" 
                                                        id="total_pwd_discounts" 
                                                        name = "total_pwd_discounts"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    
                                    
                                    
                                </div>
                                <!-- Divider -->
                                <div class="col-md-6">
                                  
                                  <!--9-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="total_other_charges" class="col-md-4 control-label text-right">Total Other Charges</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                        <input 
                                                        type="text" 
                                                        required 
                                                        class="form-control emphasize" 
                                                        ng-value="data.total_other_charges  | numberFormat" 
                                                        id="total_other_charges" 
                                                        name = "total_other_charges"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <!--9-->
                                    
                                    <!--10-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="total_service_charge" class="col-md-4 control-label text-right">Total Service Charges</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                        <input 
                                                        type="text" 
                                                        required 
                                                        class="form-control emphasize" 
                                                        ng-value="data.total_service_charge  | numberFormat" 
                                                        id="total_service_charge" 
                                                        name = "total_service_charge"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--10-->
                                    <br>
                                    <!--11-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="total_net_sales" class="col-md-4 control-label text-right">Total Netsales</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                        <input 
                                                        type="text" 
                                                        required 
                                                        class="form-control emphasize" 
                                                        ng-value="data.total_net_sales | numberFormat" 
                                                        id="total_net_sales" 
                                                        name = "total_net_sales"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <!--11-->
                                  <!--12-->
                                   <div class="row">
                                        <div class="form-group">
                                            <label for="total_cash_sales" class="col-md-4 control-label text-right">Total Cash Sales</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                        <input 
                                                        type="text" 
                                                        required 
                                                        class="form-control emphasize" 
                                                        ng-value="data.total_cash_sales | numberFormat" 
                                                        id="total_cash_sales" 
                                                        name = "total_cash_sales"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <!--12-->

                                    <!--13-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="total_charge_sales" class="col-md-4 control-label text-right">Total Charge Sales</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                        <input 
                                                        type="text" 
                                                        required 
                                                        class="form-control emphasize" 
                                                        ng-value="data.total_charge_sales | numberFormat" 
                                                        id="total_charge_sales" 
                                                        name = "total_charge_sales"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <!--13-->

                                    <!--14-->
                                   <div class="row">
                                        <div class="form-group">
                                            <label for="total_gcother_values" class="col-md-4 control-label text-right">Total GC/Other Values</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                        <input 
                                                        type="text" 
                                                        required 
                                                        class="form-control emphasize" 
                                                        ng-value="data.total_gcother_values | numberFormat" 
                                                        id="total_gcother_values" 
                                                        name = "total_gcother_values"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--14-->
                                    <br>
                                    <!--15-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="total_void_amount" class="col-md-4 control-label text-right">Total Void Amount</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                        <input 
                                                        type="text" 
                                                        required 
                                                        class="form-control emphasize" 
                                                        ng-value="data.total_void_amount | numberFormat" 
                                                        id="total_void_amount" 
                                                        name = "total_void_amount"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <!--15-->
                                    
                                    <!--16-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="total_customer_count" class="col-md-4 control-label text-right">Total Customer Count</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="data.total_customer_count" 
                                                    id="total_customer_count" 
                                                    name = "total_customer_count"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <!--16--> 
                                    <br>
                                    <!--17-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="control_num" class="col-md-4 control-label text-right">Control Number</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="data.control_num" 
                                                    id="control_num" 
                                                    name = "control_num"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <!--17--> 
                                    
                                    <!--18-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="total_sales_transaction" class="col-md-4 control-label text-right">Total Sales Transaction</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="data.total_sales_transaction" 
                                                    id="total_sales_transaction" 
                                                    name = "total_sales_transaction"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <!--18--> 
                                    <br>
                                    <!--19-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="sales_type" class="col-md-4 control-label text-right"> Sales Type</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="data.sales_type" 
                                                    id="sales_type" 
                                                    name = "sales_type"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <!--19--> 
                                      
                                     <!--20--> 
                                      <div class="row">
                                        <div class="form-group">
                                            <label for="total_netsales_amount" class="col-md-4 control-label text-right">Total Net Sales Amount</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                        <input 
                                                        type="text" 
                                                        required 
                                                        class="form-control emphasize" 
                                                        ng-value="data.total_netsales_amount | numberFormat" 
                                                        id="total_netsales_amount" 
                                                        name = "total_netsales_amount"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--20-->
                                    <br>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="tenant_type_code" class="col-md-4 control-label text-right">Tenant Type Code</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="data.tenant_type_code" 
                                                    id="tenant_type_code" 
                                                    name = "tenant_type_code"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}"
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
    </div>
    <!--view modal daily-->

    <!--update modal daily-->
<div id="update_modal_daily" class="modal fade" role="dialog" aria-labelledby="tenant_daily_sales">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <h3><i class="fa fa-edit"></i> Update Monthly Total</h3>
                </div>
                <div class="modal-body">
                    <form ng-submit="update_total_monthly_sale($base_url + 'tsms_controller/update_monthly_total/' + data.id , $event)" method="post" name = "frm_update" id = "frm_update">
                       <input type = "text" style = "display:none;" ng-model="data.id" = name = "id_to_update" />
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
                                                    class="form-control currency" 
                                                    ng-model="data.tenant_type" 
                                                    id="tenant_type" 
                                                    name = "tenant_type"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}">
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                     <div class="row">
                                        <div class="form-group">
                                            <label for="trade_name" class="col-md-4 control-label text-right">Trade Name</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control currency" 
                                                    ng-model="data.trade_name" 
                                                    id="trade_name" 
                                                    name = "trade_name"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}">
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
                                                    class="form-control currency" 
                                                    ng-model="data.tenant_code" 
                                                    id="tenant_code" 
                                                    name = "tenant_code"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}">
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="form-group">
                                            <label for="date_end" class="col-md-4 control-label text-right">Transaction Date</label>
                                            <div class="col-md-8">
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
                                            <label for="pos_num" class="col-md-4 control-label text-right">POS No.</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control currency" 
                                                    ng-model="data.pos_num" 
                                                    id="pos_num" 
                                                    name = "pos_num"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}">
                                            </div>
                                        </div>
                                    </div>
                                    <br>


                                <!--1-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="old_acctotal" class="col-md-4 control-label text-right">Old Accumulated Total</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text"
                                                    class="form-control text-right" 
                                                    ng-model="data.old_acctotal" 
                                                    money-mask
                                                    money-mask-prepend="₱"/>
                                                <input
                                                    type="hidden"
                                                    ng-value="data.old_acctotal"
                                                    name="old_acctotal">
                                            </div>
                                        </div>
                                    </div>
                                    <!--1-->
                                    <br>
                                    <!--2-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="new_acctotal" class="col-md-4 control-label text-right">New Accumulated Total</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text"
                                                    class="form-control text-right" 
                                                    ng-model="data.new_acctotal" 
                                                    money-mask
                                                    money-mask-prepend="₱"/>
                                                <input
                                                    type="hidden"
                                                    ng-value="data.new_acctotal"
                                                    name="new_acctotal">
                                            </div>
                                        </div>
                                    </div>
                                    <!--2-->
                                    <br>
                                    <!--3-->
                                  <div class="row">
                                        <div class="form-group">
                                            <label for="total_gross_sales" class="col-md-4 control-label text-right">Total Gross Sales</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text"
                                                    class="form-control text-right" 
                                                    ng-model="data.total_gross_sales" 
                                                    money-mask
                                                    money-mask-prepend="₱"/>
                                                <input
                                                    type="hidden"
                                                    ng-value="data.total_gross_sales"
                                                    name="total_gross_sales">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <!--3-->

                                    <!--4-->
                                   <div class="row">
                                        <div class="form-group">
                                            <label for="total_nontax_sales" class="col-md-4 control-label text-right">Total Nontax Sales</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text"
                                                    class="form-control text-right" 
                                                    ng-model="data.total_nontax_sales" 
                                                    money-mask
                                                    money-mask-prepend="₱"/>
                                                <input
                                                    type="hidden"
                                                    ng-value="data.total_nontax_sales"
                                                    name="total_nontax_sales">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <!--4-->

                                    <!--5-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="total_sc_discounts" class="col-md-4 control-label text-right">Total SC Discounts</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text"
                                                    class="form-control text-right" 
                                                    ng-model="data.total_sc_discounts" 
                                                    money-mask
                                                    money-mask-prepend="₱"/>
                                                <input
                                                    type="hidden"
                                                    ng-value="data.total_sc_discounts"
                                                    name="total_sc_discounts">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <!--5-->

                                    <!--6-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="other_discounts" class="col-md-4 control-label text-right">Other Discounts</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text"
                                                    class="form-control text-right" 
                                                    ng-model="data.other_discounts" 
                                                    money-mask
                                                    money-mask-prepend="₱"/>
                                                <input
                                                    type="hidden"
                                                    ng-value="data.other_discounts"
                                                    name="other_discounts">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <!--6-->

                                    <!--7-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="total_refund_amount" class="col-md-4 control-label text-right">Total Refund Amount</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text"
                                                    class="form-control text-right" 
                                                    ng-model="data.total_refund_amount" 
                                                    money-mask
                                                    money-mask-prepend="₱"/>
                                                <input
                                                    type="hidden"
                                                    ng-value="data.total_refund_amount"
                                                    name="total_refund_amount">
                                            </div>
                                        </div>
                                    </div>
                                    <!--7-->
                                    <br>
                                    <!--8-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="total_taxvat" class="col-md-4 control-label text-right">Total Tax Vat</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text"
                                                    class="form-control text-right" 
                                                    ng-model="data.total_taxvat" 
                                                    money-mask
                                                    money-mask-prepend="₱"/>
                                                <input
                                                    type="hidden"
                                                    ng-value="data.total_taxvat"
                                                    name="total_taxvat">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <!--8-->

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
                                                    name = "rental_type"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}">

                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="form-group">
                                            <label for="total_pwd_discounts" class="col-md-4 control-label text-right">Total PWD Discounts</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text"
                                                    class="form-control text-right" 
                                                    ng-model="data.total_pwd_discounts" 
                                                    money-mask
                                                    money-mask-prepend="₱"/>
                                                <input
                                                    type="hidden"
                                                    ng-value="data.total_pwd_discounts"
                                                    name="total_pwd_discounts">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    
                                    
                                    
                                </div>
                                <!-- Divider -->
                                <div class="col-md-6">
                                  
                                  <!--9-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="total_other_charges" class="col-md-4 control-label text-right">Total Other Charges</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text"
                                                    class="form-control text-right" 
                                                    ng-model="data.total_other_charges" 
                                                    money-mask
                                                    money-mask-prepend="₱"/>
                                                <input
                                                    type="hidden"
                                                    ng-value="data.total_other_charges"
                                                    name="total_other_charges">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <!--9-->
                                    
                                    <!--10-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="total_service_charge" class="col-md-4 control-label text-right">Total Service Charges</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text"
                                                    class="form-control text-right" 
                                                    ng-model="data.total_service_charge" 
                                                    money-mask
                                                    money-mask-prepend="₱"/>
                                                <input
                                                    type="hidden"
                                                    ng-value="data.total_service_charge"
                                                    name="total_service_charge">
                                            </div>
                                        </div>
                                    </div>
                                    <!--10-->
                                    <br>
                                    <!--11-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="total_net_sales" class="col-md-4 control-label text-right">Total Netsales</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text"
                                                    class="form-control text-right" 
                                                    ng-model="data.total_net_sales" 
                                                    money-mask
                                                    money-mask-prepend="₱"/>
                                                <input
                                                    type="hidden"
                                                    ng-value="data.total_net_sales"
                                                    name="total_net_sales">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <!--11-->
                                  <!--12-->
                                   <div class="row">
                                        <div class="form-group">
                                            <label for="total_cash_sales" class="col-md-4 control-label text-right">Total Cash Sales</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text"
                                                    class="form-control text-right" 
                                                    ng-model="data.total_cash_sales" 
                                                    money-mask
                                                    money-mask-prepend="₱"/>
                                                <input
                                                    type="hidden"
                                                    ng-value="data.total_cash_sales"
                                                    name="total_cash_sales">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <!--12-->

                                    <!--13-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="total_charge_sales" class="col-md-4 control-label text-right">Total Charge Sales</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text"
                                                    class="form-control text-right" 
                                                    ng-model="data.total_charge_sales" 
                                                    money-mask
                                                    money-mask-prepend="₱"/>
                                                <input
                                                    type="hidden"
                                                    ng-value="data.total_charge_sales"
                                                    name="total_charge_sales">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <!--13-->

                                    <!--14-->
                                   <div class="row">
                                        <div class="form-group">
                                            <label for="total_gcother_values" class="col-md-4 control-label text-right">Total GC/Other Values</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text"
                                                    class="form-control text-right" 
                                                    ng-model="data.total_gcother_values" 
                                                    money-mask
                                                    money-mask-prepend="₱"/>
                                                <input
                                                    type="hidden"
                                                    ng-value="data.total_gcother_values"
                                                    name="total_gcother_values">
                                            </div>
                                        </div>
                                    </div>
                                    <!--14-->
                                    <br>
                                    <!--15-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="total_void_amount" class="col-md-4 control-label text-right">Total Void Amount</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text"
                                                    class="form-control text-right" 
                                                    ng-model="data.total_void_amount" 
                                                    money-mask
                                                    money-mask-prepend="₱"/>
                                                <input
                                                    type="hidden"
                                                    ng-value="data.total_void_amount"
                                                    name="total_void_amount">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <!--15-->
                                    
                                    <!--16-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="total_customer_count" class="col-md-4 control-label text-right">Total Customer Count</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="data.total_customer_count" 
                                                    id="total_customer_count" 
                                                    name = "total_customer_count"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}">
                                            </div>
                                        </div>
                                    </div>
                                    <!--16--> 
                                    <br>
                                    <!--17-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="control_num" class="col-md-4 control-label text-right">Control Number</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="data.control_num" 
                                                    id="control_num" 
                                                    name = "control_num"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <!--17--> 
                                    
                                    <!--18-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="total_sales_transaction" class="col-md-4 control-label text-right">Total Sales Transaction</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="data.total_sales_transaction" 
                                                    id="total_sales_transaction" 
                                                    name = "total_sales_transaction"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}">
                                            </div>
                                        </div>
                                    </div>
                                    <!--18--> 
                                    <br>
                                    <!--19-->
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="sales_type" class="col-md-4 control-label text-right"> Sales Type</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="data.sales_type" 
                                                    id="sales_type" 
                                                    name = "sales_type"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <!--19--> 
                                      
                                     <!--20--> 
                                      <div class="row">
                                        <div class="form-group">
                                            <label for="total_netsales_amount" class="col-md-4 control-label text-right">Total Net Sales Amount</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text"
                                                    class="form-control text-right" 
                                                    ng-model="data.total_netsales_amount" 
                                                    money-mask
                                                    money-mask-prepend="₱"/>
                                                <input
                                                    type="hidden"
                                                    ng-value="data.total_netsales_amount"
                                                    name="total_netsales_amount">
                                            </div>
                                        </div>
                                    </div>
                                    <!--20-->
                                    <br>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="tenant_type_code" class="col-md-4 control-label text-right">Tenant Type Code</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="data.tenant_type_code" 
                                                    id="tenant_type_code" 
                                                    name = "tenant_type_code"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}">
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                </div>
                            </div>
                        </div>   
                        <div class="modal-footer">
                            <!--<button type="button" data-toggle="modal" data-target="#managerkey_modal_dailyupdate"  ng-disabled = "frm_update.$invalid" class="btn btn-primary"> <i class = "fa fa-save"></i> Save Changes</button>-->
                            <button type="submit" ng-disabled = "frm_update.$invalid" class="btn btn-primary"> <i class = "fa fa-save"></i> Save Changes</button>
                            <button type="button" data-dismiss="modal" class="btn btn-danger"> <i class = "fa fa-close"></i> Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--update modal daily-->
