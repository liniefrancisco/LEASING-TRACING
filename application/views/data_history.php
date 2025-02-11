<div class="well" style="margin-top: 20px;margin-left: 10px;margin-right: 10px;">
  <div class="col-md-12">
        <div class=" pull-right">
            <input ng-model="query" class="form-control query" placeholder="Search Here..."/>
        </div>
        <div class="col-md-2 pull-right">
            <button type="button" data-toggle="modal" data-target="#filter_daily_history" class="btn btn-default"><i class="fa fa-search"></i> Filter Daily History</button>
        </div>
        <div class="pull-right">
            <button type="button" data-toggle="modal" data-target="#filter_hourly_history" class="btn btn-default"><i class="fa fa-search"></i> Filter Hourly History</button>
        </div>
        <div class="pull-right" style="margin-right: 10px;">
            <button type="button" class="btn btn-default" title="Reload all data" ng-click="loadDaily($base_url + 'tsms_controller/history_daily_sales/'); loadHourly($base_url + 'tsms_controller/history_hourly_sales/')"><i class="fa fa-retweet"></i></button>
        </div>
    </div>

    <div class="tabs">
        <ul class="nav nav-tabs">
            <li style="float:left" class="active"><a data-toggle="tab" href="#menu1" style="font-weight: bold;">Hourly Sales Record</a></li>
            <li><a data-toggle="tab" href="#menu2" style="font-weight: bold;">Daily Sales Record</a></li>
        </ul>
        <br>
        <div class="table-history" id="table1">  
            <div class="tab-content">
                <div id="menu1" class="tab-pane fade in active">
                    <table class="table table-bordered" ng-controller="mytablecontroller" ng-init="loadHourly($base_url + 'tsms_controller/history_hourly_sales/')">
                        <thead>
                            <tr>
                                <th class="sort" ng-click="sort('tenant_type')">Tenant Type</th>
                                <th class="sort" ng-click="sort('tenant_code')">Tenant Code</th>
                                <th class="sort" ng-click="sort('pos_num')">Pos No.</th>
                                <th class="sort" ng-click="sort('trade_name')">Tenant Name</th>
                                <th class="sort" ng-click="sort('transac_date')">Transaction Date</th>
                                <th class="sort" ng-click="sort('hour_code')">Hour Code</th>
                                <th class="sort" ng-click="sort('netsales_amount_hour')">Net Sales Amount/Hour</th>
                                <th class="sort" ng-click="sort('numsales_transac_hour')">Number of Sales Transaction/Hour</th>
                                <th class="sort" ng-click="sort('customer_count_hour')">Customer Count/Hour</th>
                                <th class="sort" ng-click="sort('totalnetsales_amount_hour')">Total Net Sales/Hour</th>
                                <th class="sort" ng-click="sort('totalnumber_sales_transac')">Total Sales Transaction/Hour</th>
                                <th class="sort" ng-click="sort('total_customer_count_day')">Total Customer Count/Day</th>
                                <th class="sort" ng-click="sort('rental_type')">Rental Type</th>
                                <th class="sort" ng-click="sort('status')">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                          <tr class="ng-cloak" ng-repeat= "data in hourlyHistory | filter:query | sortBy:field:reverse | tableOffset: page : ipp">
                            <td>{{data.tenant_type }}</td>
                            <td>{{data.tenant_code }}</td>
                            <td>{{data.pos_num}}</td>
                            <td>{{data.trade_name }}</td>
                            <td>{{data.transac_date | date }}</td>
                            <td>{{data.hour_code}}{{':00'}}</td>
                            <td>{{data.netsales_amount_hour | numberFormat : 2 : '₱'}}</td>
                            <td>{{data.numsales_transac_hour}}</td>
                            <td>{{data.customer_count_hour}}</td>
                            <td>{{data.totalnetsales_amount_hour | numberFormat : 2 : '₱'}}</td>
                            <td>{{data.totalnumber_sales_transac  | numberFormat : 2 : '₱'}}</td>
                            <td>{{data.total_customer_count_day}}</td>
                            <td>{{data.rental_type}}</td>
                            <td>{{data.status}}</td>
                            </tr>
                            <tr class="ng-cloak" ng-show="hourlyHistory.length==0 || (hourlyHistory | filter:query).length == 0">
                              <td colspan="14"><center>No Data Available.</center></td>
                           </tr>   
                        </tbody>
                        <tfoot>
                           <tr class="ng-cloak" ng-init="ipp = 24; ppr = 15; leaps = true">
                              <td colspan="14">
                                  <div>
                                      <ul class="pagination" ng-show="paginate(hourlyHistory | filter:query | orderBy:sortField:reverse)">
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
                <div id="menu2" class="tab-pane fade">
                    <table class="table table-bordered" ng-controller="mytablecontroller" ng-init="loadDaily($base_url + 'tsms_controller/history_daily_sales/')">
                        <thead>
                          <tr>
                            <th class="sort" ng-click="sort('tenant_type')">Tenant Type</th>
                            <th class="sort" ng-click="sort('tenant_code')">Tenant Code</th>
                            <th class="sort" ng-click="sort('pos_num')">POS No.</th>
                            <th class="sort" ng-click="sort('trade_name')">Trade Name</th>
                            <th class="sort" ng-click="sort('transac_date')">Transaction Date</th>
                            <th class="sort" ng-click="sort('old_acctotal')">Old Accumulated Total</th>
                            <th class="sort" ng-click="sort('new_acctotal')">New Accumulated Total</th>
                            <th class="sort" ng-click="sort('total_gross_sales')">Total Gross Sales</th>
                            <th class="sort" ng-click="sort('total_nontax_sales')">Total Nontax Sales</th>
                            <th class="sort" ng-click="sort('total_sc_discounts')">Total SC Discount</th>
                            <th class="sort" ng-click="sort('total_pwd_discounts')">Total PWD Discount</th>
                            <th class="sort" ng-click="sort('other_discounts')">Other Discount</th>
                            <th class="sort" ng-click="sort('total_refund_amount')">Total Refund Amount</th>
                            <th class="sort" ng-click="sort('total_taxvat')"> &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;Total Tax Vat</th>
                            <th class="sort" ng-click="sort('total_other_charges')">Total Other Charges</th>
                            <th class="sort" ng-click="sort('total_service_charge')">Total Service Charges</th>
                            <th class="sort" ng-click="sort('total_net_sales')">Total Netsales</th>
                            <th class="sort" ng-click="sort('total_cash_sales')">Total Cash Sales</th>
                            <th class="sort" ng-click="sort('total_charge_sales')">Total Charge Sales</th>
                            <th class="sort" ng-click="sort('total_gcother_values')">Total GC/Other Values</th>
                            <th class="sort" ng-click="sort('total_void_amount')">Total Void Amount<</th>
                            <th class="sort" ng-click="sort('total_customer_count')">Total Customer Count</th>
                            <th class="sort" ng-click="sort('control_num')">Control Number</th>
                            <th class="sort" ng-click="sort('total_sales_transaction')">Total Sales Transaction</th>
                            <th class="sort" ng-click="sort('sales_type')">Total Sales Type</th>
                            <th class="sort" ng-click="sort('total_netsales_amount')">Net Sales Amount</th>
                            <th class="sort" ng-click="sort('rental_type')">Rental_type</th>
                            <th class="sort" ng-click="sort('status')">Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr ng-show="dailyHistory.length!=0" ng-repeat= "data in dailyHistory | filter:query | sortBy:field:reverse | tableOffset: page : ipp">
                            <td>{{data.tenant_type}}</td>
                            <td>{{data.tenant_code}}</td>
                            <td>{{data.pos_num}}</td>
                            <td>{{data.trade_name}}</td>
                            <td>{{data.transac_date}}</td>
                            <td>{{data.old_acctotal  | currency : ' &#8369; ' }}</td>
                            <td>{{data.new_acctotal  | currency : ' &#8369; ' }}</td>
                            <td>{{data.total_gross_sales  | currency : ' &#8369; ' }}</td>
                            <td>{{data.total_nontax_sales  | currency : ' &#8369; ' }}</td>
                            <td>{{data.total_sc_discounts  | currency : ' &#8369; ' }}</td>
                            <td>{{data.total_pwd_discounts  | currency : ' &#8369; ' }}</td>
                            <td>{{data.other_discounts  | currency : ' &#8369; ' }}</td>
                            <td>{{data.total_refund_amount  | currency : ' &#8369; ' }}</td>
                            <td>{{data.total_taxvat  | currency :' &#8369; ' }}</td>
                            <td>{{data.total_other_charges  | currency : ' &#8369; ' }}</td>
                            <td>{{data.total_service_charge  | currency : ' ' }}</td>
                            <td>{{data.total_net_sales  | currency : ' &#8369; ' }}</td>
                            <td>{{data.total_cash_sales  | currency : ' &#8369; ' }}</td>
                            <td>{{data.total_charge_sales  | currency : ' ' }}</td>
                            <td>{{data.total_gcother_values  | currency : ' ' }}</td>
                            <td>{{data.total_void_amount  | currency : ' ' }}</td>
                            <td>{{data.total_customer_count}}</td>
                            <td>{{data.control_num}}</td>
                            <td>{{data.total_sales_transaction  | currency : ' ' }}</td>
                            <td>{{data.sales_type}}</td>
                            <td>{{data.total_netsales_amount  | currency : ' &#8369; ' }}</td>
                            <td>{{data.rental_type}}</td>
                            <td>{{data.status}}</td>
                          </tr>
                          <tr class="ng-cloak" ng-show="dailyHistory.length==0 || (dailyHistory | filter:query).length == 0">
                                <td colspan="28"><center>No Data Available.</center></td>
                          </tr>
                        </tbody>

                        <tfoot>
                           <tr class="ng-cloak" ng-init="ipp = 15; ppr = 15; leaps = true">
                              <td colspan="14">
                                  <div>
                                      <ul class="pagination" ng-show="paginate(dailyHistory | filter:query | orderBy:sortField:reverse)">
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





                        <!-- <tfoot>
                            <tr class="ng-cloak">
                                <td colspan="28" >
                                    <div>
                                        <ul class="pagination">
                                            <li ng-show="dailyHistory.length!=0 && (dailyHistory | filter:query).length != 0" ng-class="prevPageDisabled2()">
                                                <a href ng-click="firstPage2()" style="border-radius: 0px;">First</a>
                                                <a href ng-click="prevPage2()" style="border-radius: 0px;"><i class="fa fa-toggle-left"></i> Prev</a>
                                            </li>
                                            <li ng-show="dailyHistory.length!=0 && (dailyHistory | filter:query).length != 0" ng-repeat="n in range2()" ng-class="{active: n == currentPage}" ng-click="setPage2(n)">
                                                <a href>{{n+1}}</a>
                                            </li>
                                            <li ng-show="dailyHistory.length!=0 && (dailyHistory | filter:query).length != 0" ng-class="nextPageDisabled2()">
                                                <a href ng-click="nextPage2()" style="border-radius: 0px;">Next <i class="fa fa-toggle-right"></i></a>
                                                <a href ng-click="lastPage2()" style="border-radius: 0px;">Last</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tfoot> -->
                    </table>
                </div> <!--end of tab2-->
            </div>
        </div>
    </div>
</div><!--end of well-->


<!-- Filter Daily -->
<div class="modal fade bounce animated" id = "filter_daily_history">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-filter"></i> Filter Daily Data</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form ng-submit="getDataList($base_url + 'tsms_controller/filter_daily_history_sales/' + tenant_list + '/' + trade_name + '/' + location_code + '/' + filter_date, 'dailyHistory')" id="form-daily">
                      <div class="col-md-12">
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
                      <div class="col-md-12" >
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

                      <div class="col-md-12" >
                        <div class="form-group">
                            <select 
                                class="form-control"
                                required=""
                                ng-model="location_code"
                                ng-options="l.location_code as l.location_code for l in locations">                
                            </select>
                        </div>
                      </div>

                      <div class="col-md-12" >
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
                  </form> 
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default" form="form-daily"><i class="fa fa-filter"></i> Filter</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal"> <i class="fa fa-close"></i> Close</button>
            </div>
        </div><!-- modal-content -->
    </div><!-- modal -->
</div>
<!-- Filer Daily -->

<!-- Filter Daily -->
<div class="modal fade bounce animated" id = "filter_hourly_history">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-filter"></i> Filter Hourly Data</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form ng-submit="getDataList($base_url + 'tsms_controller/filter_hourly_history_sales/' + tenant_list + '/' + trade_name + '/' + location_code + '/' + filter_date2, 'hourlyHistory')" id="form-hourly">
                      <div class="col-md-12">
                          <div class="form-group">
                                <select
                                class = "form-control" 
                                name = "tenant_list"
                                ng-model="tenant_list" 
                                required
                                ng-change="getTenants('<?php echo base_url(); ?>index.php/tsms_controller/get_tenants/' + tenant_list)">
                                <option class="placeholder" selected disabled value="" >Tenant Type</option>
                                <option id="long_term_tenants">Long Term Tenants</option>
                                <option id="short_term_tenants">Short Term Tenants</option>
                                </select>
                          </div>
                      </div>
                      <div class="col-md-12" >
                          <div class="form-group">
                                <select
                                class = "form-control" 
                                name = "trade_name" 
                                required
                                ng-model="trade_name"
                                ng-change="getLocation('<?php echo base_url(); ?>index.php/tsms_controller/get_location_code/' + trade_name)"
                                >
                                <option class="placeholder" selected disabled value="">Trade Name</option>
                                <option ng-repeat = "tenant in tenantlist">{{tenant.trade_name}}</option>
                                </select>
                          </div>
                      </div>

                      <div class="col-md-12" >
                        <div class="form-group">
                            <select 
                                class="form-control"
                                required=""
                                ng-model="location_code"
                                ng-options="l.location_code as l.location_code for l in locations">                
                            </select>
                        </div>
                      </div>

                      <div class="col-md-12" >
                        <div class="form-group">
                              <div class="input-group">
                                  <div class="input-group-addon input-date"><strong><i class="fa fa-calendar"></i></strong></div>
                                  <datepicker date-format="yyyy-MM-dd">
                                      <input 
                                          type="text" 
                                          required 
                                          placeholder="Choose a date" 
                                          class="form-control"  
                                          ng-model="filter_date2"
                                          name = "filter_date"
                                          autocomplete="off">
                                  </datepicker>
                              </div>
                  
                          </div>
                      </div>
                  </form> 
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default" form="form-hourly"><i class="fa fa-filter"></i> Filter</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal"> <i class="fa fa-close"></i> Close</button>
            </div>
        </div><!-- modal-content -->
    </div><!-- modal -->
</div>
<!-- Filer Daily -->
                  
