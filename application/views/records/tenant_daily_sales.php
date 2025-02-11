<div class="well" style="margin-top: 20px;margin-left: 10px;margin-right: 10px;">
    <div class="tabs">
        <ul class="nav nav-tabs">
            <li style="float:left" class="active"><a data-toggle="tab" href="#menu1" style="font-weight: bold;">Daily Sales Record</a></li>
            <li><a data-toggle="tab" href="#menu2" style="font-weight: bold;">Confirmed Daily Sales Record</a></li>
        </ul>
        <div class="well">
            <div class="row" id="tenant-record">  
            	<form ng-submit="getDataList($base_url + 'tsms_controller/get_daily_sales_record/' + tenant_list + '/' + trade_name + '/' + location_code + '/' + filter_date, 'dailySalesRecord')">
                    <div class="col-md-2">
                        <div class="form-group">
                              <select
                              class = "form-control" 
                              name = "tenant_list"
                              ng-model="tenant_list" 
                              required
                              id = "tenant_list"
                              ng-change="getTenants('<?php echo base_url(); ?>index.php/tsms_controller/get_tenants/' + tenant_list)">
                              <option class="placeholder" selected disabled value="" >Tenant Type</option>
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
                              ng-model="trade_name"
                              ng-change="getLocation('<?php echo base_url(); ?>index.php/tsms_controller/get_location_code/' + trade_name)"
                              >
                              <option class="placeholder" selected disabled value="">Trade Name</option>
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

			        <div class="col-md-2" >
				        <div class="form-group">
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
                        <div class="col-md-2" >
                          <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </div>
                </form>


                <div class="col-md-2 pull-right">
		            <div class="form-group">
		               <input ng-model="query" class="form-control search-query" placeholder="Search Here..."/>
		            </div>
		        </div>

            </div><!-- end upload control-->
        </div>
        <div class="table-history" id="table1">  
            <div class="tab-content">
                <div id="menu1" class="tab-pane fade in active">
                    <div class="well">
			            <div ng-controller="mytablecontroller">
					        <div class="table-computing" id="table1">  
					            <div class="tab-content">
					                <div id="menu1" class="tab-pane fade in active">
					                    <table class="table table-bordered table-hover">
					                        <thead>
					                            <tr>
					                            	<th class="sort" ng-click="sort('tenant_type')">Tenant Type</th>
					                            	<th class="sort" ng-click="sort('trade_name')">Trade Name</th>
					                            	<th class="sort" ng-click="sort('tenant_code')">Tenant Code</th>
					                            	<th class="sort" ng-click="sort('pos_num')">POS No.</th>
					                                <th class="sort" ng-click="sort('transac_date')">Transac. Date</th>
					                                <th class="sort" ng-click="sort('old_acctotal')">Old Accumulated Total</th>
					                                <th class="sort" ng-click="sort('new_acctotal')">New Accumulated Total</th>
					                                <th class="sort" ng-click="sort('total_gross_sales')">Total Gross Sales</th>
					                                <th class="sort" ng-click="sort('total_net_sales')">Total Netsales</th>
					                                <th class="sort" ng-click="sort('status')">Status</th>
					                                <th>Action</th>
					                            </tr>
					                        </thead>
					                        <tbody >
					                            <tr ng-repeat= "data in dailySalesRecord.tds | filter:query | sortBy: field : reverse| tableOffset: page : ipp">
					                                <td>{{data.tenant_type}}</td>
					                                <td>{{data.trade_name}}</td>
					                                <td>{{data.tenant_code}}</td>
					                                <td>{{data.pos_num}}</td>
					                                <td>{{data.transac_date}}</td>
					                                <td>{{data.old_acctotal | currency :''}}</td>
					                                <td>{{data.new_acctotal | currency :''}}</td>
					                                <td>{{data.total_gross_sales | currency :''}}</td>
					                                <td>{{data.total_net_sales | currency :''}}</td>
					                                <td>{{data.status}}</td>
					                                <td>
				                                        <div class="btn-group"> 
				                                            <div class="img_menu">
				                                                <img src="<?php echo base_url(); ?>img/menu3.png" style="height: 15px; width: 13px;" data-toggle="dropdown" id="img_menu">
				                                                <ul style="position:absolute;left: -60px; top: -15px; background: white; border-top: none;" class="dropdown-menu">
					                                                <li>
					                                                  	<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#view_modal_daily" ng-click="setData(data)"> <i class="fa fa-search"></i> View</a>
					                                                </li>

					                                                <?php if($this->session->userdata('user_type') == 'Administrator'): ?>
					                                                	<li>
					                                                		<a ng-click="deleteDataAjax($base_url + 'tsms_controller/delete_daily_sales/' + data.id, 'dailySalesRecord.tds', data);"> <i class="fa fa-trash"></i> Delete</a>
					                                                	</li>
					                                              	<?php endif; ?>
				                                                </ul>
			                                            </div>
				                                        </div>
				                                    </td>
					                            </tr>
					                            <tr class="ng-cloak" ng-show="!dailySalesRecord.tds || dailySalesRecord.tds.length == 0 || (dailySalesRecord.tds | filter:query).length == 0">
					                                <td colspan="100%"><center>No Data Available.</center></td>
					                            </tr>
					                        </tbody>
					                        <tfoot>
				                               <tr class="ng-cloak" ng-init="ipp = 15;">
				                                  <td colspan="14">
				                                      <div>
				                                          <ul class="pagination" ng-show="paginate(dailySalesRecord.tds | filter:query)">
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
					                </div> <!--end of tab2-->
					            </div>
					        </div>
			            </div>
			            <div class="clock-home">
			                <div class="dateTime pull-left ng-cloak" ng-init = "tick('<?php echo base_url(); ?>index.php/chart_controller/get_dateTime')">
			                    <p>{{ clock  | date:'medium'}}</p>
			                </div>
			            </div>
			        </div>
                </div>



                <div id="menu2" class="tab-pane fade">
                    <div class="well">
			            <div ng-controller="mytablecontroller">
					        <div class="table-computing" id="table1">  
					            <div class="tab-content">
					                <div id="menu1" class="tab-pane fade in active">
					                    <table class="table table-bordered table-hover">
					                        <thead>
					                            <tr>
					                            	<th class="sort" ng-click="sort('tenant_type')">Tenant Type</th>
					                            	<th class="sort" ng-click="sort('trade_name')">Trade Name</th>
					                            	<th class="sort" ng-click="sort('tenant_code')">Tenant Code</th>
					                                <th class="sort" ng-click="sort('transac_date')">Transac. Date</th>
					                                <th class="sort" ng-click="sort('old_acctotal')">Old Accumulated Total</th>
					                                <th class="sort" ng-click="sort('new_acctotal')">New Accumulated Total</th>
					                                <th class="sort" ng-click="sort('total_gross_sales')">Total Gross Sales</th>
					                                <th class="sort" ng-click="sort('total_net_sales')">Total Netsales</th>
					                                <th>Action</th>
					                            </tr>
					                        </thead>
					                        <tbody >
					                            <tr ng-repeat= "data in dailySalesRecord.ctds | filter:query| sortBy: field : reverse | tableOffset: page : ipp">
					                                <td>{{data.tenant_type}}</td>
					                                <td>{{data.trade_name}}</td>
					                                <td>{{data.tenant_code}}</td>
					                                <td>{{data.transac_date}}</td>
					                                <td>{{data.old_acctotal | currency :''}}</td>
					                                <td>{{data.new_acctotal | currency :''}}</td>
					                                <td>{{data.total_gross_sales | currency :''}}</td>
					                                <td>{{data.total_net_sales | currency :''}}</td>
					                                <td>
				                                        <div class="btn-group"> 
				                                            <div class="img_menu">
				                                                <img src="http://localhost/AGC-TSMS/img/menu3.png" style="height: 15px; width: 13px;" data-toggle="dropdown" id="img_menu">
				                                                <ul style="position:absolute;left: -60px; top: -15px; background: white; border-top: none;" class="dropdown-menu">
					                                                <li>
					                                                  	<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#view_modal_daily" ng-click="setData(data)"> <i class="fa fa-search"></i> View</a>
					                                                </li>

					                                                <?php if($this->session->userdata('user_type') == 'Administrator'): ?>
					                                                	<li>
					                                                		<a ng-click="deleteDataAjax($base_url + 'tsms_controller/delete_confirmed_daily_sale/' + data.id, 'dailySalesRecord.ctds', data);"> <i class="fa fa-trash"></i> Delete</a>
					                                                	</li>
					                                              	<?php endif; ?>
				                                                </ul>
			                                            </div>
				                                        </div>
				                                    </td>
					                            </tr>
					                            <tr class="ng-cloak" ng-show="!dailySalesRecord.ctds || dailySalesRecord.ctds.length == 0 || (dailySalesRecord.ctds | filter:query).length == 0">
					                                <td colspan="100%"><center>No Data Available.</center></td>
					                            </tr>
					                        </tbody>
					                        <tfoot>
				                               <tr class="ng-cloak" ng-init="ipp = 15;">
				                                  <td colspan="14">
				                                      <div>
				                                          <ul class="pagination" ng-show="paginate(dailySalesRecord.ctds | filter:query | sortBy: field : reverse)">
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
					                </div> <!--end of tab2-->
					            </div>
					        </div>
			            </div>
			            <div class="clock-home">
			                <div class="dateTime pull-left ng-cloak" ng-init = "tick('<?php echo base_url(); ?>index.php/chart_controller/get_dateTime')">
			                    <p>{{ clock  | date:'medium'}}</p>
			                </div>
			            </div>
			        </div>
                </div> <!--end of tab2-->
            </div>
        </div>
    </div>
</div><!--end of well-->



<!--view modal daily-->
<div id="view_modal_daily" class="modal fade" role="dialog" aria-labelledby="tenant_daily_sales">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <h3><i class="fa fa-search"></i> View Daily Sales</h3>
                </div>
                <div class="modal-body">
                    <form>
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
                                                            ng-model="data.old_acctotal" 
                                                            id="old_acctotal1"
                                                            name = "old_acctotal"
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
                                            <label for="new_acctotal" class="col-md-4 control-label text-right">New Accumulated Total</label>
                                            <div class="col-md-8">
                                                 <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                      <input 
                                                          type="text" 
                                                          required 
                                                          class="form-control emphasize" 
                                                          ng-model="data.new_acctotal"
                                                          id="new_acctotal1" 
                                                          name = "new_acctotal"
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
                                            <label for="total_netsales_amount" class="col-md-4 control-label text-right">Total Net Sales Amount</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                        <input 
                                                            type="text" 
                                                            required 
                                                            class="form-control currency"
                                                            ng-disabled = "frm_update.$invalid" 
                                                            ng-model="data.total_netsales_amount"
                                                            id="total_netsales_amount1"
                                                            name = "total_netsales_amount"
                                                            ui-number-mask="2"
                                                            autocomplete="off"
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
                                                          ng-model="data.total_nontax_sales" 
                                                          id="total_nontax_sales1" 
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
                                            <label for="total_sc_discounts" class="col-md-4 control-label text-right">Total SC Discounts</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                        <input 
                                                            type="text" 
                                                            required 
                                                            class="form-control emphasize"
                                                            ng-model="data.total_sc_discounts" 
                                                            id="total_sc_discounts1" 
                                                            name = "total_sc_discounts"
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
                                            <label for="other_discounts" class="col-md-4 control-label text-right">Other Discounts</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                        <input 
                                                            type="text" 
                                                            required 
                                                            class="form-control emphasize" 
                                                            ng-model="data.other_discounts"
                                                            id="other_discounts1" 
                                                            name = "other_discounts"
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
                                            <label for="total_refund_amount" class="col-md-4 control-label text-right">Total Refund Amount</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                      <input 
                                                          type="text" 
                                                          required 
                                                          class="form-control emphasize"
                                                          ng-model="data.total_refund_amount" 
                                                          id="total_refund_amount1" 
                                                          name = "total_refund_amount"
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
                                            <label for="total_taxvat" class="col-md-4 control-label text-right">Total Tax Vat</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                      <input 
                                                          type="text" 
                                                          required 
                                                          class="form-control emphasize"
                                                          ng-model="data.total_taxvat" 
                                                          id="total_taxvat1" 
                                                          name = "total_taxvat"
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
                                                          ng-model="data.total_pwd_discounts" 
                                                          id="total_pwd_discounts1" 
                                                          name = "total_pwd_discounts"
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
                                            <label for="total_discounts_wo_approval" class="col-md-4 control-label text-right">Discounts w/o Approval</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="data.total_discounts_wo_approval" 
                                                    
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
                                            <label for="total_discounts_w_approval" class="col-md-4 control-label text-right">Discounts w Approval</label>
                                            <div class="col-md-8">
                                                <input 
                                                    type="text" 
                                                    required 
                                                    class="form-control emphasize" 
                                                    ng-model="data.total_discounts_w_approval" 
                                                    id="total_discounts_w_approval" 
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

                                <div class="col-md-6">
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
                                            <label for="total_net_sales" class="col-md-4 control-label text-right">Total Netsales</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                      <input 
                                                          type="text" 
                                                          required 
                                                          class="form-control emphasize"
                                                          ng-model="data.total_net_sales" 
                                                          id="total_net_sales1" 
                                                          name = "total_net_sales"
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
                                            <label for="total_gross_sales" class="col-md-4 control-label text-right">Total Gross Sales</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                        <input
                                                            type="text" 
                                                            required 
                                                            class="form-control emphasize"
                                                            ng-model="data.total_gross_sales" 
                                                            id="total_gross_sales1" 
                                                            name = "total_gross_sales"
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
                                            <label for="total_cash_sales" class="col-md-4 control-label text-right">Total Cash Sales</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                      <input 
                                                          type="text" 
                                                          required 
                                                          class="form-control emphasize" 
                                                          ng-model="data.total_cash_sales"
                                                          id="total_cash_sales1" 
                                                          name = "total_cash_sales"
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
                                            <label for="total_other_charges" class="col-md-4 control-label text-right">Total Other Charges</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                      <input 
                                                          type="text" 
                                                          required 
                                                          class="form-control emphasize"
                                                          ng-model="data.total_other_charges" 
                                                          id="total_other_charges1" 
                                                          name = "total_other_charges"
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
                                            <label for="total_service_charge" class="col-md-4 control-label text-right">Total Service Charges</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                      <input 
                                                          type="text" 
                                                          required 
                                                          class="form-control emphasize"
                                                          ng-model="data.total_service_charge" 
                                                          id="total_service_charge1" 
                                                          name = "total_service_charge"
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
                                            <label for="total_charge_sales" class="col-md-4 control-label text-right">Total Charge Sales</label>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><strong>&#8369;</strong></div>
                                                      <input 
                                                          type="text" 
                                                          required 
                                                          class="form-control emphasize" 
                                                          ng-model="data.total_charge_sales"
                                                          id="total_charge_sales1" 
                                                          name = "total_charge_sales"
                                                          is-unique-update
                                                          ui-number-mask="2"
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
                                                            id="total_gcother_values1" 
                                                            name = "total_gcother_values"
                                                            is-unique-update
                                                            ui-number-mask="2"
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
                                                        id="total_void_amount1" 
                                                        name = "total_void_amount"
                                                        is-unique-update
                                                        ui-number-mask="2"
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
                                                    id="total_customer_count1" 
                                                    name = "total_customer_count"
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
                                                    ng-model="data.total_sales_transaction" 
                                                    id="total_sales_transaction1" 
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
                                                    id="sales_type1" 
                                                    name = "sales_type"
                                                    is-unique-update
                                                    is-unique-id = "{{data.id}}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
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
                                                    id="status" 
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