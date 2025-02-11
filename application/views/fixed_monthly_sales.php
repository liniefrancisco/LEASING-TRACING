<div class="container">
	<div class="cover">
    	<div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-money" aria-hidden="true"></i> Fixed tenants Monthly Sales </div>
        </div>
        <div class="well" ng-controller="tablecontroller" ng-controller="decontroller" >
            <div class="table-totalsales">
                <form action="<?=base_url()?>reports/fixed_monthly_sales" target="_blank" method="post" name = "frm_print" id="frm_print">  
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
                                      ng-change="getTenants($base_url + 'tsms_controller/get_fixed_tenants/' + tenant_list)">
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
                                  <button type="button" ng-click="fixed_total_button($base_url + 'tsms_controller/fixed_monthly_total/'+ tenant_list + '_'+ filter_date)" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
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
                                            <th>Rental Type</th>
                                            <th>Monthly Net Sales</th>
                                            <th>Monthly Gross Sales</th>
                                            <th>Tenant Type</th>
                                            <th>Action</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="data in monthly_total | filter:query">
                                                <td>{{data.trade_name}}</td>
                                                <td>{{data.rental_type}}</td>
                                                <td>{{data.total_netsales_amount | currency : ''}}</td>
                                                <td>{{data.total_gross_sales | currency : ''}}</td>
                                                <td>{{data.tenant_type}}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <div class="img_menu">
                                                            <img src="<?php echo base_url(); ?>img/menu3.png" style="height: 15px; width: 13px;" data-toggle="dropdown" id="img_menu">
                                                            <ul style="position:absulote;left: -40px; top: -5px; background: white; border-top: none;" class="dropdown-menu">
                                                                <li><a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#view_sales_data" ng-click="update('<?php echo base_url();?>index.php/tsms_controller/get_inputsales_data/' + data.id)"> <i class = "fa fa-search"></i> View</a></li>
                                                                <li><a href="#" ng-click="deleteDataAjax($base_url + 'tsms_controller/delete_inputsales_data/' + data.id, 'monthly_total', data)"> <i class = "fa fa-trash"></i> Delete</a></li>
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
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
