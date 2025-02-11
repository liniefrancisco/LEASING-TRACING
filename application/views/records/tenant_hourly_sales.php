<div class="well" style="margin-top: 20px;margin-left: 10px;margin-right: 10px;">
    <div class="tabs">
        <ul class="nav nav-tabs">
            <li style="float:left" class="active" ng-click="mode = 1;">
            	<a data-toggle="tab" href="#menu1" style="font-weight: bold;">Hourly Sales Record</a>
            </li>
            <li ng-click="mode = 2;">
            	<a data-toggle="tab" href="#menu2" style="font-weight: bold;">Confirmed Hourly Sales Record</a>
            </li>
        </ul>
        <div class="well">
            <div class="row" id="tenant-record">  
            	<form ng-submit="getDataList($base_url + 'tsms_controller/get_hourly_sales_record/' + tenant_list + '/' + trade_name + '/' + location_code + '/' + filter_date, 'hourlySalesRecord')">
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
				                                    <th class="sort" ng-click="sort('trade_name')">Tenant Name</th>
				                                    <th class="sort" ng-click="sort('pos_num')">POS No.</th>
				                                    <th class="sort" ng-click="sort('transac_date')">Transaction Date</th>
				                                    <th class="sort" ng-click="sort('date_upload')">Date Uploaded</th>
				                                    <th class="sort" ng-click="sort('rental_type')">Rental Type</th>
				                                    <th class="sort" ng-click="sort('tenant_code')">Tenant Code</th>
				                                    <th class="sort" ng-click="sort('totalnetsales_amount_hour')" style="width: 170px;">Total Net Sales Amount</th>
					                                <th class="sort" ng-click="sort('status')">Status</th>
					                                <th>Action</th>
					                            </tr>
					                        </thead>
					                        <tbody >
					                            <tr ng-repeat= "data in hourlySalesRecord.hs | filter:query | sortBy: field : reverse| tableOffset: page : ipp">
					                               	<td>{{data.tenant_type }}</td>
				                                    <td>{{data.trade_name }}</td>
				                                    <td>{{data.pos_num}}</td>
				                                    <td>{{data.transac_date}}</td>
				                                    <td>{{data.date_upload}}</td>
				                                    <td>{{data.rental_type}}</td>
				                                    <td>{{data.tenant_code}}</td>
				                                    <td class="text-right">{{data.totalnetsales_amount_hour | currency : ' &#8369; ' }}</td>
					                                <td>{{data.status}}</td>
					                                <td>
				                                        <div class="btn-group"> 
				                                            <div class="img_menu">
				                                                <img src="<?php echo base_url(); ?>img/menu3.png" style="height: 15px; width: 13px;" data-toggle="dropdown" id="img_menu">
				                                                <ul style="position:absolute;left: -60px; top: -15px; background: white; border-top: none;" class="dropdown-menu">
					                                                <li>
					                                                  	<a data-toggle="modal" data-target="#hourly_sales_modal" ng-click="viewSales($base_url + 'tsms_controller/view_hourly_sales', data);" <i class="fa fa-search"></i> View</a>
					                                                </li>

					                                                <?php if($this->session->userdata('user_type') == 'Administrator'): ?>
					                                                	<li>
					                                                		<a ng-click="deleteDataAjax($base_url + 'tsms_controller/delete_hourly_sales_record/' + data.transac_date  + '/' + data.tenant_code, 'hourlySalesRecord.hs', data)"> <i class="fa fa-trash"></i> Delete</a>
					                                                	</li>
					                                              	<?php endif; ?>
				                                                </ul>
			                                            </div>
				                                        </div>
				                                    </td>
					                            </tr>
					                            <tr class="ng-cloak" ng-show="!hourlySalesRecord.hs || hourlySalesRecord.hs.length == 0 || (hourlySalesRecord.hs | filter:query).length == 0">
					                                <td colspan="100%"><center>No Data Available.</center></td>
					                            </tr>
					                        </tbody>
					                        <tfoot>
				                               <tr class="ng-cloak" ng-init="ipp = 15;">
				                                  <td colspan="14">
				                                      <div>
				                                          <ul class="pagination" ng-show="paginate(hourlySalesRecord.hs | filter:query)">
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
				                                    <th class="sort" ng-click="sort('trade_name')">Tenant Name</th>
				                                    <th class="sort" ng-click="sort('pos_num')">POS No.</th>
				                                    <th class="sort" ng-click="sort('transac_date')">Transaction Date</th>
				                                    <th class="sort" ng-click="sort('rental_type')">Rental Type</th>
				                                    <th class="sort" ng-click="sort('tenant_code')">Tenant Code</th>
				                                    <th class="sort" ng-click="sort('totalnetsales_amount_hour')" style="width: 170px;">Total Net Sales Amount</th>
					                                <th class="sort" ng-click="sort('approved_by')">Approved By</th>
					                                <th>Action</th>
					                            </tr>
					                        </thead>
					                        <tbody >
					                            <tr ng-repeat= "data in hourlySalesRecord.chs | filter:query | sortBy: field : reverse| tableOffset: page : ipp">
					                               	<td>{{data.tenant_type }}</td>
				                                    <td>{{data.trade_name }}</td>
				                                    <td>{{data.pos_num}}</td>
				                                    <td>{{data.transac_date}}</td>
				                                    <td>{{data.rental_type}}</td>
				                                    <td>{{data.tenant_code}}</td>
				                                    <td class="text-right">{{data.totalnetsales_amount_hour | currency : ' &#8369; ' }}</td>
					                                <td>{{data.approved_by}}</td>
					                                <td>
				                                        <div class="btn-group"> 
				                                            <div class="img_menu">
				                                                <img src="http://localhost/AGC-TSMS/img/menu3.png" style="height: 15px; width: 13px;" data-toggle="dropdown" id="img_menu">
				                                                <ul style="position:absolute;left: -60px; top: -15px; background: white; border-top: none;" class="dropdown-menu">
					                                                <li>
					                                                  	<a data-toggle="modal" data-target="#hourly_sales_modal" ng-click="viewSales($base_url + 'tsms_controller/view_confirmed_hourly_sales', data) ;" <i class="fa fa-search"></i> View</a>
					                                                </li>

					                                                <?php if($this->session->userdata('user_type') == 'Administrator'): ?>
					                                                	<li>
					                                                		<a ng-click="deleteDataAjax($base_url + 'tsms_controller/delete_confirmed_hourly_sales/' + data.transac_date  + '/' + data.tenant_code, 'hourlySalesRecord.chs', data)"> <i class="fa fa-trash"></i> Delete</a>
					                                                	</li>
					                                              	<?php endif; ?>
				                                                </ul>
			                                            </div>
				                                        </div>
				                                    </td>
					                            </tr>
					                            <tr class="ng-cloak" ng-show="!hourlySalesRecord.chs || hourlySalesRecord.chs.length == 0 || (hourlySalesRecord.chs | filter:query).length == 0">
					                                <td colspan="100%"><center>No Data Available.</center></td>
					                            </tr>
					                        </tbody>
					                        <tfoot>
				                               <tr class="ng-cloak" ng-init="ipp = 15;">
				                                  <td colspan="14">
				                                      <div>
				                                          <ul class="pagination" ng-show="paginate(hourlySalesRecord.chs | filter:query)">
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



<div class="modal fade" id="hourly_sales_modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title"><i class="fa fa-search"></i> View Tenant Hourly Sales</h4>
            </div>
            <div class="modal-body">
                <form method="post" name="frm_updatehourly" id="frm_updatehourly">
                    <table class="table table-bordered" ng-controller="tablecontroller">
                        <thead>
                            <tr>
                                <th>Tenant Type</th>
                                <th>Tenant Name</th>
                                <th>Transaction Date</th>
                                <th>Hour Code</th>
                                <th>Net Sales Amount/Hour</th>
                                <th>Number of Sales Transaction/Hour</th>
                                <th>Customer Count Hour</th>
                                <th>{{ mode == 1 ? 'Status' : 'Approved By'}}</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="sales in viewData ">
                                <td>{{sales.tenant_type }} </td>
                                <td>{{sales.trade_name }}</td>
                                <td>{{sales.transac_date | date }}</td>
                                <td>{{sales.hour_code}}{{':00'}}</td>
                                <td>{{sales.netsales_amount_hour | currency : ' &#8369; ' }}</td>
                                <td>{{sales.numsales_transac_hour}}</td>
                                <td>{{sales.customer_count_hour}}</td>
                                <td>{{ mode == 1 ? sales.status : sales.approved_by}}</td>
                            </tr>
                        </tbody> 
                    </table>
                    <table class="table table-bordered" ng-controller="tablecontroller">
                        <thead>
                            <tr>
                            <th> Total Netsales Amount/Hour</th>
                            <th> Total Number Sales Transaction/Hour</th>
                            <th> Total Customer Count/Hour</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="sales in viewData | limitTo: total_inhourly_sales" >
                                <td>{{sales.totalnetsales_amount_hour | currency : ' &#8369; '}}</td>
                                <td>{{sales.totalnumber_sales_transac}}</td>
                                <td>{{sales.total_customer_count_day}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="modal-footer">
                        <div class="form-group">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class = "fa fa-close"></i> Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>