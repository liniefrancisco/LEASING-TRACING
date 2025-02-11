
<div class="container">
  <div class="cover">
    <div class="well">
        <div class="tabs">
          <ul class="nav nav-tabs">
        <li style="float:left" class="active"><a data-toggle="tab" href="#menu1">Hourly Total Sales </a></li>
        <li><a data-toggle="tab" href="#menu2">Daily Total Sales </a></li>
        <li><a data-toggle="tab" href="#menu3">Monthly Total Sales </a></li>
            </ul>
            <br>
      <div class="table" id="table1">  
        <div class="tab-content">
          <div id="menu1" class="tab-pane fade in active">
            <div class="tab-content ng-cloak">
                            <div role="tabpanel" id="">
                                <form action="" method="post" name = "" id="">
                                  <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                      <div class="row">
                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="tenant_type" class="col-md-5 control-label text-right">Tenant Type</label>
                                                    <div class="col-md-7">  
                                                        <select 
                                                            class = "form-control"
                                                            name = "tenant_type"
                                                            ng-model = "tenant_type">
                                                            <option value="" disabled="" selected="" style = "display:none">Please Select One</option>
                                                            <option>Short Term Tenant</option>
                                                            <option>Long Term Tenant</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row"> 
                                                <div class="form-group">
                                                    <label for="tenant_code" class="col-md-5 control-label text-right">Tenant Code</label>
                                                    <div class="col-md-7">
                                                        <div class="input-group">
                                                            <div mass-autocomplete>
                                                                <input 
                                                                    required
                                                                    name = "tenant_code"
                                                                    ng-model = "dirty.value"
                                                                    mass-autocomplete-item = "autocomplete_options"
                                                                    class = "form-control"
                                                                    id = "tenant_code">
                                                            </div>
                                                            <span class="input-group-btn">
                                                                <button 
                                                                    class = "btn btn-info" 
                                                                    type = "button"
                                                                    ng-click = "
                                                                    "><i class = "fa fa-search"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="hour_code" class="col-md-5 control-label text-right">Hour Code</label>
                                                    <div class="col-md-7">  
                                                  <select 
                                                            class = "form-control"
                                                            name = "hour_code"
                                                            ng-model = "hour_code">
                                                            <option value="" disabled="" selected="" style = "display:none">Hour Code</option>
                                                            <option>1:01-2:00</option>
                                                            <option>2:01-3:00</option>
                                                            <option>3:01-4:00</option>
                                                            <option>4:01-5:00</option>
                                                            <option>5:01-6:00</option>
                                                            <option>6:01-7:00</option>
                                                            <option>7:01-8:00</option>
                                                            <option>8:01-9:00</option>
                                                            <option>9:01-10:00</option>
                                                            <option>10:01-11:00</option>
                                                            <option>11:01-12:00</option>
                                                            <option>12:01-13:00</option>
                                                            <option>13:01-14:00</option>
                                                            <option>14:01-15:00</option>
                                                            <option>15:01-16:00</option>
                                                            <option>16:01-17:00</option>
                                                            <option>17:01-18:00</option>
                                                            <option>18:01-19:00</option>
                                                            <option>19:01-20:00</option>
                                                            <option>20:01-21:00</option>
                                                            <option>21:01-22:00</option>
                                                            <option>22:01-23:00</option>
                                                            <option>23:01-24:00</option>
                                                            <option>24:01-1:00</option>
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="pos_num" class="col-md-5 control-label text-right">POS No.</label>
                                                    <div class="col-md-7">  
                                                  <input 
                                                      type = "text"
                                                      readonly 
                                                      ng-model = "pos_num" 
                                                      id="pos_num" 
                                                      name = "pos_num" 
                                                      class = "form-control">
                                                    </div>
                                                </div>
                                            </div>
                                  </div>  <!-- Col-md-6-devide -->
                                          <div class="col-md-6"> 
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="tenant_name" class="col-md-5 control-label text-right">Tenant Name</label>
                                                    <div class="col-md-7">  
                                                  <input 
                                                      type = "text"
                                                      readonly 
                                                      ng-model = "tenant_name" 
                                                      id="tenant_name" 
                                                      name = "tenant_name" 
                                                      class = "form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                              <div class="row">
                                                <div class="form-group">
                                                    <label for="tin" class="col-md-5 control-label text-right">TIN</label>
                                                    <div class="col-md-7">  
                                                  <input 
                                                      type = "text"
                                                      readonly 
                                                      ng-model = "tin" 
                                                      id="tin" 
                                                      name = "tin" 
                                                      class = "form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="rental_type" class="col-md-5 control-label text-right">Rental Type</label>
                                                    <div class="col-md-7">  
                                                  <input 
                                                      type = "text"
                                                      readonly 
                                                      ng-model = "rental_type" 
                                                      id = "rental_type" 
                                                      name = "rental_type" 
                                                      class = "form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="curr_date" class="col-md-5 control-label text-right">Date</label>
                                                    <div class="col-md-7">  
                                                  <input 
                                                      type = "text"
                                                      readonly 
                                                      value="<?php echo date('Y-m-d'); ?>" 
                                                      id="curr_date" 
                                                      name = "curr_date" 
                                                      class = "form-control">
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                  </div>

                                  <hr>
                                  <div class="row"> <!-- table wrapper  --> 
                                    <div class="col-md-12">
                                      <div class="row">
                                  <div class="col-md-3 pull-right">
                                      <input type = "text" class="form-control search-query" placeholder="Search Here..." ng-model="query" />
                                  </div>
                              </div>
                                  <table class="table table-bordered" ng-controller="tableController" ng-init="loadList()">
                                      <thead>
                                          <tr>
          <th><a href="#" data-ng-click="sortField = 'total_gross_sales'; reverse = !reverse">Total Gross Sales</a></th>
          <th><a href="#" data-ng-click="sortField = 'total_nontax_sales'; reverse = !reverse">Total Nontax Sales</a></th>
          <th><a href="#" data-ng-click="sortField = 'total_sc_discounts'; reverse = !reverse">Total SC Discount</a></th>
          <th><a href="#" data-ng-click="sortField = 'total_net_sales'; reverse = !reverse">Total Netsales</a></th>
          <th><a href="#" data-ng-click="sortField = 'total_cash_sales'; reverse = !reverse">Total Cash Sales</a></th>
          <th><a href="#" data-ng-click="sortField = 'total_charge_sales'; reverse = !reverse">Total Charge Sales</a></th>
          <th><a href="#" data-ng-click="sortField = 'total_netsales_amount'; reverse = !reverse">Net Sales Amount</a></th>
                                          </tr>
                                      </thead>
                                      <tbody id = "">
                                          <tr class="ng-cloak" ng-show="dataList.length!=0" ng-repeat= "data in dataList | filter:query | orderBy:sortField:reverse | offset: currentPage*itemsPerPage | limitTo: itemsPerPage">
                                              <td>{{ data.total_gross_sales }}</td>
                                              <td>{{ data.total_nontax_sales }}</td>
                                              <td>{{ data.due_date }}</td>
                                              <td>{{ data.total_sc_discount | currency : '' }}</td>
                                              <td>{{ data.total_net_sales | currency : '' }}</td>
                                              <td>{{ data.total_charge_sales | currency : '' }}</td>
                                              <td>{{ data.total_sales_amount | currency : '' }}</td>
                                          </tr>
                                          <tr class="ng-cloak" ng-show="dataList.length==0 || (dataList | filter:query).length == 0">
                                              <td colspan="7"><center>No Data Available.</center></td>
                                          </tr>
                                      </tbody>
                                      <tfoot>
                                          <tr class="ng-cloak">
                                              <td colspan="7" style="padding: 5px;">
                                                  <div>
                                                      <ul class="pagination">
                                                          <li ng-show="dataList.length!=0 && (dataList | filter:query).length != 0" ng-class="prevPageDisabled()">
                                                              <a href ng-click="prevPage()" style="border-radius: 0px;"><i class="fa fa-toggle-left"></i> Prev</a>
                                                          </li>
                                                          <li ng-show="dataList.length!=0 && (dataList | filter:query).length != 0" ng-repeat="n in range()" ng-class="{active: n == currentPage}" ng-click="setPage(n)">
                                                          <a href="#">{{n+1}}</a>
                                                          </li>
                                                          <li ng-show="dataList.length!=0 && (dataList | filter:query).length != 0" ng-class="nextPageDisabled()">
                                                              <a href ng-click="nextPage()" style="border-radius: 0px;">Next <i class="fa fa-toggle-right"></i></a>
                                                          </li>
                                                      </ul>
                                                  </div>
                                              </td>
                                          </tr>
                                      </tfoot>
                                  </table>
                              </div>
                                  </div>  
                                </form>
                            </div>
                        </div> <!-- End of tab-content -->
                      </div>

        <div id="menu2" class="tab-pane fade">
            <div class="tab-content ng-cloak">
                            <div role="tabpanel" id="">
                                <form action="" onsubmit="('<?php echo base_url(); ?>/'); return false" method="post" name = "" id="">
                                  <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                      <div class="row">
                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="tenant_type" class="col-md-5 control-label text-right">Tenant Type</label>
                                                    <div class="col-md-7">  
                                                        <select 
                                                            class = "form-control"
                                                            name = "tenant_type"
                                                            ng-model = "tenant_type">
                                                            <option value="" disabled="" selected="" style = "display:none">Please Select One</option>
                                                            <option>Short Term Tenant</option>
                                                            <option>Long Term Tenant</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row"> 
                                                <div class="form-group">
                                                    <label for="tenant_code" class="col-md-5 control-label text-right">Tenant Code</label>
                                                    <div class="col-md-7">
                                                        <div class="input-group">
                                                            <div mass-autocomplete>
                                                                <input 
                                                                    required
                                                                    name = "tenant_code"
                                                                    ng-model = "dirty.value"
                                                                    mass-autocomplete-item = "autocomplete_options"
                                                                    class = "form-control"
                                                                    id = "tenant_code">
                                                            </div>
                                                            <span class="input-group-btn">
                                                                <button 
                                                                    class = "btn btn-info" 
                                                                    type = "button"
                                                                    ng-click = "
                                                                    "><i class = "fa fa-search"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="hour_code" class="col-md-5 control-label text-right">Hour Code</label>
                                                    <div class="col-md-7">  
                                               <div class="input-group">
                                                                    <div class="input-group-addon input-date"><strong><i class="fa fa-calendar"></i></strong></div>
                                                                    <datepicker date-format="yyyy-mM-dd">
                                                                        <input 
                                                                            type="text" 
                                                                            required 
                                                                            readonly
                                                                            placeholder="Choose a date" 
                                                                            class="form-control"  
                                                                            ng-model="collection_date"
                                                                            id="collection_date"
                                                                            name = "collection_date"
                                                                            autocomplete="off">
                                                                    </datepicker>
                                                                </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="pos_num" class="col-md-5 control-label text-right">POS No.</label>
                                                    <div class="col-md-7">  
                                                  <input 
                                                      type = "text"
                                                      readonly 
                                                      ng-model = "pos_num" 
                                                      id="pos_num" 
                                                      name = "pos_num" 
                                                      class = "form-control">
                                                    </div>
                                                </div>
                                            </div>
                                  </div>  <!-- Col-md-6-devide -->
                                          <div class="col-md-6"> 
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="tenant_name" class="col-md-5 control-label text-right">Tenant Name</label>
                                                    <div class="col-md-7">  
                                                  <input 
                                                      type = "text"
                                                      readonly 
                                                      ng-model = "tenant_name" 
                                                      id="tenant_name" 
                                                      name = "tenant_name" 
                                                      class = "form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                              <div class="row">
                                                <div class="form-group">
                                                    <label for="tin" class="col-md-5 control-label text-right">TIN</label>
                                                    <div class="col-md-7">  
                                                  <input 
                                                      type = "text"
                                                      readonly 
                                                      ng-model = "tin" 
                                                      id="tin" 
                                                      name = "tin" 
                                                      class = "form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="rental_type" class="col-md-5 control-label text-right">Rental Type</label>
                                                    <div class="col-md-7">  
                                                  <input 
                                                      type = "text"
                                                      readonly 
                                                      ng-model = "rental_type" 
                                                      id = "rental_type" 
                                                      name = "rental_type" 
                                                      class = "form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="curr_date" class="col-md-5 control-label text-right">Date</label>
                                                    <div class="col-md-7">  
                                                  <input 
                                                      type = "text"
                                                      readonly 
                                                      value="<?php echo date('Y-m-d'); ?>" 
                                                      id="curr_date" 
                                                      name = "curr_date" 
                                                      class = "form-control">
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                  </div>

                                  <hr>
                                  <div class="row"> <!-- table wrapper  --> 
                                    <div class="col-md-12">
                                      <div class="row">
                                  <div class="col-md-3 pull-right">
                                      <input type = "text" class="form-control search-query" placeholder="Search Here..." ng-model="query" />
                                  </div>
                              </div>
                                 <table class="table table-bordered" ng-controller="tableController" ng-init="loadList()">
                                      <thead>
                                          <tr>
          <th><a href="#" data-ng-click="sortField = 'total_gross_sales'; reverse = !reverse">Total Gross Sales</a></th>
          <th><a href="#" data-ng-click="sortField = 'total_nontax_sales'; reverse = !reverse">Total Nontax Sales</a></th>
          <th><a href="#" data-ng-click="sortField = 'total_sc_discounts'; reverse = !reverse">Total SC Discount</a></th>
          <th><a href="#" data-ng-click="sortField = 'total_net_sales'; reverse = !reverse">Total Netsales</a></th>
          <th><a href="#" data-ng-click="sortField = 'total_cash_sales'; reverse = !reverse">Total Cash Sales</a></th>
          <th><a href="#" data-ng-click="sortField = 'total_charge_sales'; reverse = !reverse">Total Charge Sales</a></th>
          <th><a href="#" data-ng-click="sortField = 'total_netsales_amount'; reverse = !reverse">Net Sales Amount</a></th>
                                          </tr>
                                      </thead>
                                      <tbody id = "">
                                          <tr class="ng-cloak" ng-show="dataList.length!=0" ng-repeat= "data in dataList | filter:query | orderBy:sortField:reverse | offset: currentPage*itemsPerPage | limitTo: itemsPerPage">
                                              <td>{{ data.total_gross_sales }}</td>
                                              <td>{{ data.total_nontax_sales }}</td>
                                              <td>{{ data.due_date }}</td>
                                              <td>{{ data.total_sc_discount | currency : '' }}</td>
                                              <td>{{ data.total_net_sales | currency : '' }}</td>
                                              <td>{{ data.total_charge_sales | currency : '' }}</td>
                                              <td>{{ data.total_sales_amount | currency : '' }}</td>
                                          </tr>
                                          <tr class="ng-cloak" ng-show="dataList.length==0 || (dataList | filter:query).length == 0">
                                              <td colspan="7"><center>No Data Available.</center></td>
                                          </tr>
                                      </tbody>
                                      <tfoot>
                                          <tr class="ng-cloak">
                                              <td colspan="7" style="padding: 5px;">
                                                  <div>
                                                      <ul class="pagination">
                                                          <li ng-show="dataList.length!=0 && (dataList | filter:query).length != 0" ng-class="prevPageDisabled()">
                                                              <a href ng-click="prevPage()" style="border-radius: 0px;"><i class="fa fa-toggle-left"></i> Prev</a>
                                                          </li>
                                                          <li ng-show="dataList.length!=0 && (dataList | filter:query).length != 0" ng-repeat="n in range()" ng-class="{active: n == currentPage}" ng-click="setPage(n)">
                                                          <a href="#">{{n+1}}</a>
                                                          </li>
                                                          <li ng-show="dataList.length!=0 && (dataList | filter:query).length != 0" ng-class="nextPageDisabled()">
                                                              <a href ng-click="nextPage()" style="border-radius: 0px;">Next <i class="fa fa-toggle-right"></i></a>
                                                          </li>
                                                      </ul>
                                                  </div>
                                              </td>
                                          </tr>
                                      </tfoot>
                                  </table>
                              </div>
                                  </div>  
                                </form>
                            </div>
                        </div> <!-- End of tab-content -->
                      </div>

          <div id="menu3" class="tab-pane fade">
            <div class="tab-content ng-cloak">
                            <div role="tabpanel" id="">
                                <form action="" onsubmit="('<?php echo base_url(); ?>/'); return false" method="post" name = "" id="">
                                  <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                      <div class="row">
                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="tenant_type" class="col-md-5 control-label text-right">Tenant Type</label>
                                                    <div class="col-md-7">  
                                                        <select 
                                                            class = "form-control"
                                                            name = "tenant_type"
                                                            ng-model = "tenant_type">
                                                            <option value="" disabled="" selected="" style = "display:none">Please Select One</option>
                                                            <option>Short Term Tenant</option>
                                                            <option>Long Term Tenant</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row"> 
                                                <div class="form-group">
                                                    <label for="tenant_code" class="col-md-5 control-label text-right">Tenant Code</label>
                                                    <div class="col-md-7">
                                                        <div class="input-group">
                                                            <div mass-autocomplete>
                                                                <input 
                                                                    required
                                                                    name = "tenant_code"
                                                                    ng-model = "dirty.value"
                                                                    mass-autocomplete-item = "autocomplete_options"
                                                                    class = "form-control"
                                                                    id = "tenant_code">
                                                            </div>
                                                            <span class="input-group-btn">
                                                                <button 
                                                                    class = "btn btn-info" 
                                                                    type = "button"
                                                                    ng-click = "
                                                                    "><i class = "fa fa-search"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="hour_code" class="col-md-5 control-label text-right">Hour Code</label>
                                                    <div class="col-md-7">  
                                                  <select 
                                                            class = "form-control"
                                                            name = "hour_code"
                                                            ng-model = "hour_code">
                                                            <option value="" disabled="" selected="" style = "display:none">Hour Code</option>
                                                            <option>1:01-2:00</option>
                                                            <option>2:01-3:00</option>
                                                            <option>3:01-4:00</option>
                                                            <option>4:01-5:00</option>
                                                            <option>5:01-6:00</option>
                                                            <option>6:01-7:00</option>
                                                            <option>7:01-8:00</option>
                                                            <option>8:01-9:00</option>
                                                            <option>9:01-10:00</option>
                                                            <option>10:01-11:00</option>
                                                            <option>11:01-12:00</option>
                                                            <option>12:01-13:00</option>
                                                            <option>13:01-14:00</option>
                                                            <option>14:01-15:00</option>
                                                            <option>15:01-16:00</option>
                                                            <option>16:01-17:00</option>
                                                            <option>17:01-18:00</option>
                                                            <option>18:01-19:00</option>
                                                            <option>19:01-20:00</option>
                                                            <option>20:01-21:00</option>
                                                            <option>21:01-22:00</option>
                                                            <option>22:01-23:00</option>
                                                            <option>23:01-24:00</option>
                                                            <option>24:01-1:00</option>
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="pos_num" class="col-md-5 control-label text-right">POS No.</label>
                                                    <div class="col-md-7">  
                                                  <input 
                                                      type = "text"
                                                      readonly 
                                                      ng-model = "pos_num" 
                                                      id="pos_num" 
                                                      name = "pos_num" 
                                                      class = "form-control">
                                                    </div>
                                                </div>
                                            </div>
                                  </div>  <!-- Col-md-6-devide -->
                                          <div class="col-md-6"> 
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="tenant_name" class="col-md-5 control-label text-right">Tenant Name</label>
                                                    <div class="col-md-7">  
                                                  <input 
                                                      type = "text"
                                                      readonly 
                                                      ng-model = "tenant_name" 
                                                      id="tenant_name" 
                                                      name = "tenant_name" 
                                                      class = "form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                              <div class="row">
                                                <div class="form-group">
                                                    <label for="tin" class="col-md-5 control-label text-right">TIN</label>
                                                    <div class="col-md-7">  
                                                  <input 
                                                      type = "text"
                                                      readonly 
                                                      ng-model = "tin" 
                                                      id="tin" 
                                                      name = "tin" 
                                                      class = "form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="rental_type" class="col-md-5 control-label text-right">Rental Type</label>
                                                    <div class="col-md-7">  
                                                  <input 
                                                      type = "text"
                                                      readonly 
                                                      ng-model = "rental_type" 
                                                      id = "rental_type" 
                                                      name = "rental_type" 
                                                      class = "form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="curr_date" class="col-md-5 control-label text-right">Date</label>
                                                    <div class="col-md-7">  
                                                  <input 
                                                      type = "text"
                                                      readonly 
                                                      value="<?php echo date('Y-m-d'); ?>" 
                                                      id="curr_date" 
                                                      name = "curr_date" 
                                                      class = "form-control">
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                  </div>

                                  <hr>
                                  <div class="row"> <!-- table wrapper  --> 
                                    <div class="col-md-12">
                                      <div class="row">
                                  <div class="col-md-3 pull-right">
                                      <input type = "text" class="form-control search-query" placeholder="Search Here..." ng-model="query" />
                                  </div>
                              </div>
                                  <table class="table table-bordered" ng-controller="tableController" ng-init="loadList()">
                                      <thead>
                                          <tr>
          <th><a href="#" data-ng-click="sortField = 'total_gross_sales'; reverse = !reverse">Total Gross Sales</a></th>
          <th><a href="#" data-ng-click="sortField = 'total_nontax_sales'; reverse = !reverse">Total Nontax Sales</a></th>
          <th><a href="#" data-ng-click="sortField = 'total_sc_discounts'; reverse = !reverse">Total SC Discount</a></th>
          <th><a href="#" data-ng-click="sortField = 'total_net_sales'; reverse = !reverse">Total Netsales</a></th>
          <th><a href="#" data-ng-click="sortField = 'total_cash_sales'; reverse = !reverse">Total Cash Sales</a></th>
          <th><a href="#" data-ng-click="sortField = 'total_charge_sales'; reverse = !reverse">Total Charge Sales</a></th>
          <th><a href="#" data-ng-click="sortField = 'total_netsales_amount'; reverse = !reverse">Net Sales Amount</a></th>
                                          </tr>
                                      </thead>
                                      <tbody id = "">
                                          <tr class="ng-cloak" ng-show="dataList.length!=0" ng-repeat= "data in dataList | filter:query | orderBy:sortField:reverse | offset: currentPage*itemsPerPage | limitTo: itemsPerPage">
                                              <td>{{ data.total_gross_sales }}</td>
                                              <td>{{ data.total_nontax_sales }}</td>
                                              <td>{{ data.due_date }}</td>
                                              <td>{{ data.total_sc_discount | currency : '' }}</td>
                                              <td>{{ data.total_net_sales | currency : '' }}</td>
                                              <td>{{ data.total_charge_sales | currency : '' }}</td>
                                              <td>{{ data.total_sales_amount | currency : '' }}</td>
                                          </tr>
                                          <tr class="ng-cloak" ng-show="dataList.length==0 || (dataList | filter:query).length == 0">
                                              <td colspan="7"><center>No Data Available.</center></td>
                                          </tr>
                                      </tbody>
                                      <tfoot>
                                          <tr class="ng-cloak">
                                              <td colspan="7" style="padding: 5px;">
                                                  <div>
                                                      <ul class="pagination">
                                                          <li ng-show="dataList.length!=0 && (dataList | filter:query).length != 0" ng-class="prevPageDisabled()">
                                                              <a href ng-click="prevPage()" style="border-radius: 0px;"><i class="fa fa-toggle-left"></i> Prev</a>
                                                          </li>
                                                          <li ng-show="dataList.length!=0 && (dataList | filter:query).length != 0" ng-repeat="n in range()" ng-class="{active: n == currentPage}" ng-click="setPage(n)">
                                                          <a href="#">{{n+1}}</a>
                                                          </li>
                                                          <li ng-show="dataList.length!=0 && (dataList | filter:query).length != 0" ng-class="nextPageDisabled()">
                                                              <a href ng-click="nextPage()" style="border-radius: 0px;">Next <i class="fa fa-toggle-right"></i></a>
                                                          </li>
                                                      </ul>
                                                  </div>
                                              </td>
                                          </tr>
                                      </tfoot>
                                  </table>
                              </div>
                                  </div>  
                                </form>
                            </div>
                        </div> <!-- End of tab-content -->
                      </div>

                      </div>
                      </div>
                      </div>

                    </div><!-- End of well -->
                </div><!-- End of cover-->
            </div><!-- End of Container-->
     