<div class="well" style="margin-top: 20px;margin-left: 10px;margin-right: 10px;">
    <div class="col-md-2 pull-right">
        <input ng-model="query" class="form-control query" placeholder="Search Here..."/>
    </div>
    <div class="tabs">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#menu1" style="font-weight: bold;">Unmatched Daily Sales</a></li>
        </ul>
        <div class="table-transaction" id="table1">  
            <div class="tab-content">
                <div id="menu1" class="tab-pane fade in active">
                    <table class="table table-bordered" ng-controller="tablecontroller" ng-init="undailyInit('<?php echo base_url(); ?>index.php/tsms_controller/get_undaily_sales/')">
                        <thead>
                          <tr>
                            <th><a href="#" data-ng-click="sortField = 'tenant_type'; reverse = !reverse">Tenant Type</a></th>
                              <th><a href="#" data-ng-click="sortField = 'trade_name'; reverse = !reverse">Tenant Name</a></th>
                              <th><a href="#" data-ng-click="sortField = 'transac_date'; reverse = !reverse">Transaction Date</a></th>
                              <th><a href="#" data-ng-click="sortField = 'netsales_amount_hour'; reverse = !reverse">Total Net Sales Amount</a></th>
                              <th><a href="#" data-ng-click="sortField = 'numsales_transac_hour'; reverse = !reverse">Total Cash Sales</a></th>
                              <th><a href="#" data-ng-click="sortField = 'numsales_transac_hour'; reverse = !reverse">Total Gross Sales</a></th>
                              <th><a href="#" data-ng-click="sortField = 'status'; reverse = !reverse">Status</a></th>
                              <th><a href="#" data-ng-click="sortField = 'status'; reverse = !reverse">Action</a></th>
                          </tr>
                        </thead>
                        <tbody>
                         <tr class="ng-cloak" ng-show="undailyList.length!=0" ng-repeat= "data in undailyList | filter:query | orderBy:sortField:reverse ">
                            <td>{{data.tenant_type}}</td>
                            <td>{{data.trade_name}}</td>
                            <td>{{data.transac_date}}</td>
                            <td>{{data.total_netsales_amount | currency : ' &#8369; '}}</td>
                            <td>{{data.total_cash_sales | currency : ' &#8369; '}}</td>
                            <td>{{data.total_gross_sales | currency : ' &#8369; '   }}</td>
                            <td>{{data.status}}</td>
                            <td>
                                <div class="btn-group">
                                    <div class="img_menu">
                                        <img src="<?php echo base_url(); ?>img/menu3.png" style="height: 15px; width: 13px;" data-toggle="dropdown" id="img_menu">
                                           <ul style="position:absulote;left: -40px; top: -5px; background: white; border-top: none;" class="dropdown-menu">
                                              <li><a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#view_modal_daily" ng-click="setData(data)"> <i class = "fa fa-search"></i> View</a></li>
                                              <li><a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#update_modal_daily" ng-click="setData(data)"> <i class = "fa fa-edit"></i> Update</a></li>
                                              <li><a href="#" ng-click="delete_unmatched_daily_sale(data.id)" > <i class = "fa fa-trash"></i> Delete</a></li>
                                            </ul>
                                    </div>
                                </div>
                            </td>
                          </tr>
                          <tr class="ng-cloak" ng-show="undailyList.length==0 || (undailyList | filter:query).length == 0">
                                <td colspan="8"><center>No Data Available.</center></td>
                            </tr>
                        </tbody>
                    </table>
                </div> <!--end of tab2-->
            </div>
        </div>
    </div>
</div>

<!--view modal daily-->
<div id="view_modal_daily" class="modal fade" role="dialog" aria-labelledby="tenant_daily_sales">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <h3><i class="fa fa-search"></i> View Unmatched Daily Sales</h3>
                </div>
                <div class="modal-body">
                    <form  action = "#" method="post" name = "" >
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
                                                    id="tenant_type1" 
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
                                                    id="trade_name1" 
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
                                                    id="tenant_code1" 
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
                                            <label for="transac_date" class="col-md-4 control-label text-right">Transaction Date</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control currency" 
                                                    ng-model="data.transac_date" 
                                                    id="transac_date1" 
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
                                            <label for="pos_num" class="col-md-4 control-label text-right">POS No.</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control currency" 
                                                    ng-model="data.pos_num" 
                                                    id="pos_num1" 
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
                                            <label for="old_acctotal" class="col-md-4 control-label text-right">Old Accumulated Total</label>
                                            <div class="col-md-8">
                                                 <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                        <input 
                                                            type="text" 
                                                            required 
                                                            class="form-control currency" 
                                                            ng-value="data.old_acctotal | numberFormat" 
                                                            id="old_acctotal1"
                                                            name = "old_acctotal"
                                                            readonly>
                                                  </div>
                                            </div>
                                        </div>
                                    </div>

                                    <br>

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
                                                          ng-value="data.new_acctotal | numberFormat"
                                                          id="new_acctotal1" 
                                                          name = "new_acctotal"
                                                          readonly>
                                                  </div>
                                            </div>
                                        </div>
                                    </div>

                                    <br>
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
                                                            ng-value="data.total_gross_sales | numberFormat" 
                                                            id="total_gross_sales1" 
                                                            name = "total_gross_sales"
                                                            readonly>
                                                  </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                  

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
                                                          id="total_nontax_sales1" 
                                                          name = "total_nontax_sales"
                                                          readonly>
                                                  </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>

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
                                                            id="total_sc_discounts1" 
                                                            name = "total_sc_discounts"
                                                            readonly>
                                                  </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                
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
                                                            id="other_discounts1" 
                                                            name = "other_discounts"
                                                            readonly>
                                                  </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                 
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
                                                          ng-value="data.total_refund_amount | numberFormat" 
                                                          readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                              
                                    <br>
                                  
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
                                                          id="total_taxvat1" 
                                                          name = "total_taxvat"
                                                          readonly>
                                                  </div>
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
                                                    id="rental_type1" 
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
                                                          id="total_pwd_discounts1" 
                                                          name = "total_pwd_discounts"
                                                          readonly>
                                                  </div>
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
                                                    id="txtfile_name1" 
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
                                            <label for="total_discounts_w_approval" class="col-md-4 control-label text-right">Discounts w Approval</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-value="data.total_discounts_w_approval | numberFormat" 
                                                    id="total_discounts_w_approval" 
                                                    name = "total_discounts_w_approval"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    
                                    
                                </div>



                                <div class="col-md-6">

                                     <div class="row">
                                        <div class="form-group">
                                            <label for="total_discounts_wo_approval" class="col-md-4 control-label text-right">Discounts w/o Approval</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-value="data.total_discounts_wo_approval | numberFormat" 
                                                    id="total_discounts_wo_approval" 
                                                    name = "total_discounts_wo_approval"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>

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
                                                          ng-value="data.total_other_charges | numberFormat" 
                                                          id="total_other_charges1" 
                                                          name = "total_other_charges"
                                                          readonly>
                                                  </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                  
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
                                                          ng-value="data.total_service_charge | numberFormat" 
                                                          id="total_service_charge1" 
                                                          name = "total_service_charge"
                                                          readonly>
                                                  </div>
                                            </div>
                                        </div>
                                    </div>
                              
                                    <br>
                                
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
                                                          id="total_net_sales1" 
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
                                                          id="total_cash_sales1" 
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
                                                          id="total_charge_sales1" 
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
                                                            id="total_gcother_values1" 
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
                                                        id="total_void_amount1" 
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
                                                    id="total_customer_count1" 
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
                                                    id="control_num1" 
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
                                                    ng-value="data.total_sales_transaction | numberFormat" 
                                                    id="total_sales_transaction1" 
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
                                                    id="sales_type1" 
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
                                                            class="form-control currency"
                                                            ng-value="data.total_netsales_amount | numberFormat"
                                                            id="total_netsales_amount1"
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
                                                    id="tenant_type_code1" 
                                                    name = "tenant_type_code"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                     <div class="row">
                                        <div class="form-group">
                                            <label for="location_code" class="col-md-4 control-label text-right">Location Code</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="data.location_code" 
                                                    id="prospect_id1" 
                                                    name = "location_code"
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
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="data.date_upload" 
                                                    id="date_upload1" 
                                                    name = "date_upload"
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
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="data.status" 
                                                    id="" 
                                                    name = "status"
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
         <h3><i class="fa fa-edit"></i> Update Unmatched Daily Sales</h3>
                </div>
                <div class="modal-body">
                    <form ng-submit="confirm_unmatched_daily_sale(data.id, $event);"  action = "{{'<?php echo base_url();?>index.php/tsms_controller/update_daily_sales/' + data.id }} " method="post" name = "frm_update" id = "frm_update">
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
                                            <label for="transac_date" class="col-md-4 control-label text-right">Transaction Date</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control currency" 
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
                                                            ng-model="data.old_acctotal" 
                                                            id="old_acctotal"
                                                             
                                                            name = "old_acctotal"
                                                            is-unique-update
                                                            is-unique-id = "{{data.id}}"
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
                                                          ng-model="data.new_acctotal"
                                                           
                                                          id="new_acctotal" 
                                                          name = "new_acctotal"
                                                          is-unique-update
                                                          is-unique-id = "{{data.id}}"
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
                                                             
                                                            ng-model="data.total_gross_sales" 
                                                            id="total_gross_sales" 
                                                            name = "total_gross_sales"
                                                            is-unique-update
                                                            is-unique-id = "{{data.id}}"
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
                                                           
                                                          ng-model="data.total_nontax_sales" 
                                                          id="total_nontax_sales" 
                                                          name = "total_nontax_sales"
                                                          is-unique-update
                                                          is-unique-id = "{{data.id}}"
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
                                                             
                                                            ng-model="data.total_sc_discounts" 
                                                            id="total_sc_discounts" 
                                                            name = "total_sc_discounts"
                                                            is-unique-update
                                                            is-unique-id = "{{data.id}}"
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
                                                            ng-model="data.other_discounts"
                                                             
                                                            id="other_discounts" 
                                                            name = "other_discounts"
                                                            is-unique-update
                                                            is-unique-id = "{{data.id}}"
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
                                                           
                                                          ng-model="data.total_refund_amount" 
                                                          id="total_refund_amount" 
                                                          name = "total_refund_amount"
                                                          is-unique-update
                                                          is-unique-id = "{{data.id}}"
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
                                                           
                                                          ng-model="data.total_taxvat" 
                                                          id="total_taxvat" 
                                                          name = "total_taxvat"
                                                          is-unique-update
                                                          is-unique-id = "{{data.id}}"
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
                                                          ng-model="data.total_pwd_discounts" 
                                                          id="total_pwd_discounts" 
                                                          name = "total_pwd_discounts"
                                                          is-unique-update
                                                          is-unique-id = "{{data.id}}"
                                                          readonly>
                                                  </div>
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
                                            <label for="total_discounts_w_approval2" class="col-md-4 control-label text-right">Discounts w Approval</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="data.total_discounts_w_approval" 
                                                    id="total_discounts_w_approval2" 
                                                    name = "total_discounts_w_approval"
                                                    is-unique-update
                                                    ui-number-mask="2"
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
                                            <label for="total_discounts_wo_approval2" class="col-md-4 control-label text-right">Discounts w/o Approval</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="data.total_discounts_wo_approval" 
                                                    id="total_discounts_wo_approval2" 
                                                    name = "total_discounts_wo_approval"
                                                    is-unique-update
                                                    ui-number-mask="2"
                                                    is-unique-id = "{{data.id}}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    
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
                                                           
                                                          ng-model="data.total_other_charges" 
                                                          id="total_other_charges" 
                                                          name = "total_other_charges"
                                                          is-unique-update
                                                          is-unique-id = "{{data.id}}"
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
                                                           
                                                          ng-model="data.total_service_charge" 
                                                          id="total_service_charge" 
                                                          name = "total_service_charge"
                                                          is-unique-update
                                                          is-unique-id = "{{data.id}}"
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
                                                           
                                                          ng-model="data.total_net_sales" 
                                                          id="total_net_sales" 
                                                          name = "total_net_sales"
                                                          is-unique-update
                                                          is-unique-id = "{{data.id}}"
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
                                                          ng-model="data.total_cash_sales"
                                                           
                                                          id="total_cash_sales" 
                                                          name = "total_cash_sales"
                                                          is-unique-update
                                                          is-unique-id = "{{data.id}}"
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
                                                          ng-model="data.total_charge_sales"
                                                           
                                                          id="total_charge_sales" 
                                                          name = "total_charge_sales"
                                                          is-unique-update
                                                          is-unique-id = "{{data.id}}"
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
                                                            ng-model="data.total_gcother_values"
                                                             
                                                            id="total_gcother_values" 
                                                            name = "total_gcother_values"
                                                            is-unique-update
                                                            is-unique-id = "{{data.id}}"
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
                                                        ng-model="data.total_void_amount"
                                                         
                                                        id="total_void_amount" 
                                                        name = "total_void_amount"
                                                        is-unique-update
                                                        is-unique-id = "{{data.id}}"
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
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}"
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
                                                          ng-model="data.total_netsales_amount" 
                                                          id="total_netsales_amount"
                                                           
                                                          name = "total_netsales_amount"
                                                          is-unique-update
                                                          is-unique-id = "{{data.id}}"
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

                                    <div class="row">
                                        <div class="form-group">
                                            <label for="date_upload" class="col-md-4 control-label text-right">Date Upload</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="data.date_upload" 
                                                    id="date_upload" 
                                                    name = "date_upload"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="form-group">
                                            <label for="location_code" class="col-md-4 control-label text-right">Location Code</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="data.location_code" 
                                                    id="location_code" 
                                                    name = "location_code"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="form-group">
                                            <label for="status1" class="col-md-4 control-label text-right">Status</label>
                                            <div class="col-md-8">
                                                <input 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="data.status" 
                                                    id="status1" 
                                                    name = "status1"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                     <!--21--> 
                                      <div class="row">
                                        <div class="form-group">
                                            <label for="status" class="col-md-4 control-label text-right">Select to Update</label>
                                            <div class="col-md-8">
                                              <select 
                                                name = "status" 
                                                required
                                                required class="form-control"
                                                id="status"
                                                is-unique-update
                                                is-unique-id="{{data.id}}">
                                                    <option class="placeholder" selected disabled value="">Select to Update</option>
                                                    <option>Confirm</option>
                                                </select>
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

 <!-- manager's key modal -->

<div class="modal fade" id = "managerkey_modal_dailyupdate">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title"><i class="fa fa-user"></i> Manager's Key Modal</h5>
            </div>
            <form action="#"  method="post" id="frm_managerKey" name = "frm_managerKey">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input 
                                            type="text" 
                                            required
                                            class="form-control" 
                                            ng-model="username"
                                            id="username"
                                            name = "username"
                                            autocomplete="off" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                             <input 
                                              type="password" 
                                              required
                                              class="form-control" 
                                              ng-model="password"
                                              id="password"
                                              name = "password"
                                              autocomplete="off" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                             
                    </div>
                </div><!-- modal-content -->
                <div class="modal-footer">
                    <button type="button" onclick="update_hourlysales('<?php echo base_url(); ?>index.php/tsms_controller/update_hourlysales_data/')" class="btn btn-primary"> Submit</button>
                    <button type="button" class="btn btn-alert" data-dismiss="modal"> <i class="fa fa-close"></i> Close</button>
                </div>
            </form>
        </div><!-- modal-content -->
    </div><!-- modal -->
</div>
<!-- end of manager's key modal -->

 <!-- Delete All Modal -->
<div class="modal fade bounce animated" id = "delete_all_modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-book"></i> Archive Modal</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                    <label for="status" class="col-md-10 control-label text-top"> Archive all Records from Hourly Sales </label>
                                        <div class="input-group">
                                            <button type="button" class="btn btn-default"  data-toggle="modal" data-target="#confirm_truncate" ng-click="truncate('<?php echo base_url(); ?>index.php/tsms_controller/truncate_hourly_sales/')"><i class="fa fa-book"></i> archive </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="status" class="col-md-10 control-label text-top">Archive all Records from Daily Sales </label>
                                        <div class="input-group">
                                             <a href="#" data-toggle="modal" class="btn btn-default" data-target="#confirm_truncate" ng-click="truncate('<?php echo base_url(); ?>index.php/tsms_controller/truncate_daily_sales/')"> <i class = "fa fa-book"></i> archive</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
            </div><!-- modal-content -->
        </div><!-- modal-content -->
    </div><!-- modal -->
</div>
<!-- Delete All Modal -->

<!-- End Confirmation Modal -->
    <div class="modal fade bounce animated" id = "confirm_truncate">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-trash"></i> Confirm Arcive</h4>
                </div>
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <span id="confirm_msg">You wish to delete all this data?</span>
                        </div>        
                    </div>
                    <div class="modal-footer">
                        <a href="#" id="truncate" class="btn btn-danger"><i class="fa fa-trash"></i> Proceed</a>
                        <button type="button" class="btn btn-primary" data-dismiss="modal"> <i class="fa fa-close"></i> Cancel</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
    <!-- End Confirmation Modal -->