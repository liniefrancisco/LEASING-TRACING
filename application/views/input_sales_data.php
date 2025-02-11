<div class="container" ng-app="app">
	<div class="cover1">
    	<div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-clipboard" aria-hidden="true"></i> Input Sales Data </div>
        </div>
        <div id="user_control">
                <div class="col-md-2 pull-left">
                    <button type="button" class="btn btn-success" data-target="#input_sales_data" data-toggle="modal"><i class="fa fa-plus"></i> Input Sales Data</button>
                </div>
                <div class="col-md-2 pull-right">
                    <input ng-model="query" class="form-control search-query" placeholder="Search Here..."/>
                </div>
        </div>
        <div class="well" ng-controller="tablecontroller" ng-controller="decontroller">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered" ng-init="input_loadList('<?php echo base_url(); ?>index.php/tsms_controller/get_input_sales_data')">
                        <thead>
                            <tr>
                                <th>Tenant Name</th>
                                <th>Tenant Type</th>
                                <th>Total Gross Sales</th>
                                <th>Total Net Sales</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="ng-cloak"  ng-repeat="data in input_list | filter:query | orderBy:sortField:reverse | offset: currentPage*itemsPerPage | limitTo: itemsPerPage">
                                <td class="text-left">{{data.trade_name}}</td>
                                <td>{{data.tenant_type}}</td>
                                <td class="text-right">{{data.total_gross_sales | currency : ''}}</td>
                                <td class="text-right">{{data.total_netsales_amount | currency : ''}}</td>
                                <td>{{data.date}}</td>
                                <td>
                                    <div class="btn-group"> 
                                        <div class="img_menu">
                                            <img src="<?php echo base_url(); ?>img/menu3.png" style="height: 15px; width: 13px;" data-toggle="dropdown" id="img_menu">
                                            <ul style="position:absulote;left: -40px; top: -5px; background: white; border-top: none;" class="dropdown-menu">
                                              <li><a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#view_sales_data" ng-click="update('<?php echo base_url();?>index.php/tsms_controller/get_inputsales_data/' + data.id)"> <i class = "fa fa-search"></i> View</a></li>
                                              <li><a ng-click="deleteDataAjax($base_url + 'tsms_controller/delete_inputsales_data/' + data.id, 'input_list', data)"> <i class = "fa fa-trash"></i> Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="ng-cloak" ng-show="input_list.length==0 || (input_list | filter:query).length == 0">
                                <td colspan="7"><center>No Data Available.</center></td>
                            </tr>
                        </tbody>
                        <tfoot>
                             <tr class="ng-cloak">
                                <td colspan="7" style="padding: 5px;">
                                    <div>
                                        <ul class="pagination">
                                            <li ng-show="input_list.length!=0 && (input_list | filter:query).length != 0" ng-class="prevPageDisabled3()">
                                                <a href ng-click="firstPage3()" style="border-radius: 0px;"> First</a>
                                                <a href ng-click="prevPage3()" style="border-radius: 0px;"><i class="fa fa-toggle-left"></i> Prev</a>
                                            </li>
                                            <li ng-show="input_list.length!=0 && (input_list | filter:query).length != 0" ng-repeat="n in range3()" ng-class="{active: n == currentPage}" ng-click="setPage3(n)">
                                                <a href="#">{{n+1}}</a>
                                            </li>
                                            <li ng-show="input_list.length!=0 && (input_list | filter:query).length != 0" ng-class="nextPageDisabled3()">
                                                <a href ng-click="nextPage3()" style="border-radius: 0px;">Next <i class="fa fa-toggle-right"></i></a>
                                                <a href ng-click="lastPage3()" style="border-radius: 0px;"> Last</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
		</div><!--end div well-->
	</div><!--end div cover-->
</div><!--end div container-->
<div class="modal fade" id="input_sales_data">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-clipboard"></i> Input Sales Data</h4>
            </div>
            <form ng-submit="submitInputSales($base_url + 'tsms_controller/input_sales_data', $event)" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="row">
                                <div class="form-group">
                                    <label for="trade_name" class="col-md-4 control-label text-right"> Tenant Type</label>
                                    <div class="col-md-8">
                                        <select
                                            class = "form-control" 
                                            name = "tenant_list"
                                            ng-model="tenant_list" 
                                            required
                                            id = "tenant_list1"
                                            ng-change="getTenants('<?php echo base_url(); ?>index.php/tsms_controller/get_fixed_tenants/' + tenant_list)">
                                            <option class="placeholder" selected disabled value="">Select Type of Tenants</option>
                                            <option id="" disabled="" selected="" style="display:none" >Tenant Type</option>
                                            <option id="long_term_tenants" name="long_term_tenants">Long Term Tenants</option>
                                            <option id="short_term_tenants">Short Term Tenants</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <label for="tenant_type" class="col-md-4 control-label text-right"> Trade Name</label>
                                    <div class="col-md-8">
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
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <label for="tenant_type" class="col-md-4 control-label text-right">Location Code</label>
                                    <div class="col-md-8">
                                        <select
                                            class = "form-control" 
                                            name = "location_code"
                                            ng-model="location_code" 
                                            required
                                            id = "location_code"
                                            ng-change="getRental()">
                                            <option class="placeholder" selected disabled value="">Select Id</option>
                                            <option ng-repeat = "tenant in locationcode">{{tenant.location_code}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <label for="rental_type" class="col-md-4 control-label text-right"> Rental Type</label>
                                    <div class="col-md-8">
                                        <select 
                                            class="form-control"
                                            required=""
                                            ng-model="rental_type"
                                            ng-options="r.rental_type as r.rental_type for r in rent">                
                                        </select>
                                        <input type="hidden" name="rental_type" ng-value="rental_type">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <label for="total_gross_sales" class="col-md-4 control-label text-right"> Total Gross Sales</label>
                                    <div class="col-md-8">

                                        <input 
                                            type="text"
                                            class="form-control text-right" 
                                            ng-model="total_gross_sales" 
                                            money-mask
                                            money-mask-prepend="₱"/>
                                        <input
                                            type="hidden"
                                            ng-value="total_gross_sales"
                                            name="total_gross_sales">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <label for="total_netsales_amount" class="col-md-4 control-label text-right"> Total Net Sales Amount</label>
                                    <div class="col-md-8">
                                        <input 
                                            type="text"
                                            class="form-control text-right" 
                                            ng-model="total_netsales_amount" 
                                            money-mask
                                            money-mask-prepend="₱"/>
                                        <input
                                            type="hidden"
                                            ng-value="total_netsales_amount"
                                            name="total_netsales_amount">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <label for="total_netsales_amount" class="col-md-4 control-label text-right"> Date</label>
                                    <div class="col-md-8">  
                                        <div class="input-group">
                                            <div class="input-group-addon input-date"><strong><i class="fa fa-calendar"></i></strong></div>
                                                <datepicker date-format="yyyy-MM-dd">
                                                    <input 
                                                        type="text" 
                                                        required 
                                                        readonly
                                                        placeholder="Choose a date" 
                                                        class="form-control"  
                                                        ng-model="date"
                                                        id="date"
                                                        name = "date"
                                                        autocomplete="off">
                                                </datepicker>
                                          </div>
                                      </div>
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" ng-disabled="input_sales_data.$invalid" class="btn btn-primary"><i class="fa fa-save"></i> Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="view_sales_data">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-clipboard"></i> Input Sales Data</h4>
            </div>
            <div class="modal-body" ng-repeat="data in updateData">
                <div class="row">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="form-group">
                                <label for="trade_name" class="col-md-4 control-label text-right"> Trade Name</label>
                                <div class="col-md-8">
                                    <input
                                    type="text"
                                    class="form-control"
                                    ng-model="data.trade_name"
                                    name="trade_name"
                                    id="trade_name"
                                    readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="tenant_type" class="col-md-4 control-label text-right"> Tenant Type</label>
                                <div class="col-md-8">
                                    <input
                                    type="text"
                                    class="form-control"
                                    ng-model="data.tenant_type"
                                    name="tenant_type"
                                    id="tenant_type"
                                    readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="location_code" class="col-md-4 control-label text-right"> Location Code</label>
                                <div class="col-md-8">
                                    <input
                                    type="text"
                                    class="form-control"
                                    ng-model="data.location_code"
                                    name="location_code"
                                    id="location_code"
                                    readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="rental_type" class="col-md-4 control-label text-right"> Rental Type</label>
                                <div class="col-md-8">
                                    <input
                                    type="text"
                                    class="form-control"
                                    ng-model="data.rental_type"
                                    name="rental_type"
                                    id="rental_type"
                                    readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="total_gross_sales" class="col-md-4 control-label text-right"> Total Gross Sales</label>
                                <div class="col-md-8">
                                    <input
                                    type="text"
                                    class="form-control"
                                    ng-model="data.total_gross_sales"
                                    name="total_gross_sales"
                                    id="total_gross_sales"
                                    ui-number-mask="2"
                                    readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="total_netsales_amount" class="col-md-4 control-label text-right"> Total Net Sales Amount</label>
                                <div class="col-md-8">
                                    <input
                                    type="text"
                                    class="form-control"
                                    ng-model="data.total_netsales_amount"
                                    name="total_netsales_amount"
                                    id="total_netsales_amount"
                                    ui-number-mask="2"
                                    readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="date" class="col-md-4 control-label text-right"> Date</label>
                                <div class="col-md-8">
                                    <input
                                    type="text"
                                    class="form-control"
                                    ng-model="data.date"
                                    name="date"
                                    id="date"
                                    readonly>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            </div>
        </div>
    </div>
</div>