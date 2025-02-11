<div class="container" >
    <div class="cover">
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-calendar" aria-hidden="true"></i> Sales Data</div>
        </div>
        <div class="well">
            <div class="upload-control">
                <div class="row">
                    <div class="row" id="tenant-record">  
                    	<form ng-submit="getDataList($base_url + 'tsms_controller/get_sales_data/' + tenant_list + '/' + trade_name + '/' + location_code + '/' + year, 'salesData')">
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
            </div>
            <div class="well" ng-controller="mytablecontroller">
		        <div class="table-computing" id="table1">  
		            <div class="tab-content">
		                <div id="menu1" class="tab-pane fade in active">
		                    <table class="table table-bordered table-hover">
		                        <thead>
		                            <tr>
		                            	<th class="sort" ng-click="sort('tenant_type')">Tenant Type</th>
		                            	<th class="sort" ng-click="sort('trade_name')">Trade Name</th>
		                            	<th class="sort" ng-click="sort('tenant_code')">Tenant Code</th>
		                                <th class="sort" ng-click="sort('date')" style="min-width:100px">Date</th>
		                                <th class="sort" ng-click="sort('sales')">Sales</th>
		                                <th class="sort" ng-click="sort('total_nontax_sales')">Total Nontax Sales</th>
		                                <th class="sort" ng-click="sort('rental_type')">Rental Type</th>
		                                <th class="sort" ng-click="sort('upload_date')">Upload Date</th>
		                                <th class="sort" ng-click="sort('uploaded_by')">Uploaded By</th>
		                                <th>Action</th>
		                            </tr>
		                        </thead>
		                        <tbody >
		                            <tr ng-repeat= "data in salesData | filter:query | sortBy: field : reverse | tableOffset: page : ipp">
		                                <td>{{data.tenant_type}}</td>
		                                <td>{{data.trade_name}}</td>
		                                <td>{{data.tenant_code}}</td>
		                                <td>{{data.date}}</td>
		                                <td>{{data.sales | currency :''}}</td>
		                                <td>{{data.total_nontax_sales | currency :''}}</td>
		                                <td>{{data.rental_type}}</td>
		                                <td>{{data.upload_date}}</td>
		                                <td>{{data.uploaded_by}}</td>
		                                <td>
	                                        <div class="btn-group"> 
	                                            <div class="img_menu">
	                                                <img src="<?php echo base_url(); ?>img/menu3.png" style="height: 15px; width: 13px;" data-toggle="dropdown" id="img_menu">
	                                                <ul style="position:absolute;left: -60px; top: -15px; background: white; border-top: none;" class="dropdown-menu">
		                                                <li>
		                                                  	<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#tenant_sales_modal" ng-click="setData(data)"> <i class="fa fa-search"></i> View</a>
		                                                </li>

		                                                <?php if($this->session->userdata('user_type') == 'Administrator'): ?>
		                                                	<li>
		                                                		<a ng-click="deleteDataAjax($base_url + 'tsms_controller/delete_sales_data/' + data.id, 'salesData', data);"> <i class="fa fa-trash"></i> Delete</a>
		                                                	</li>
		                                              	<?php endif; ?>
	                                                </ul>
                                            </div>
	                                        </div>
	                                    </td>
		                            </tr>
		                            <tr class="ng-cloak" ng-show="!salesData || salesData.length == 0 || (salesData | filter:query).length == 0">
		                                <td colspan="100%"><center>No Data Available.</center></td>
		                            </tr>
		                        </tbody>
		                        <tfoot>
	                               <tr class="ng-cloak">
	                                  <td colspan="14">
	                                      <div>
	                                          <ul class="pagination" ng-show="paginate(salesData | filter:query | sortBy: field : reverse)">
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
        </div><!--end div well-->
    </div><!--end div cover-->
</div><!--end div container-->


<!--view modal daily-->
<div id="tenant_sales_modal" class="modal fade" role="dialog" aria-labelledby="tenant_daily_sales">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4><i class="fa fa-search"></i> Sales Details</h4>
            </div>
            <div class="modal-body">
                <form  action = "#" method="post"  >
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group">
                                <label for="tenant_type" class="col-md-4 control-label text-right">Tenant Type</label>
                                <div class="col-md-6">
                                    <input 
                                        type="text" 
                                        required 
                                        class="form-control currency" 
                                        ng-model="data.tenant_type" 
                                        name = "tenant_type"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="tenant_code" class="col-md-4 control-label text-right">Tenant Code</label>
                                <div class="col-md-6">
                                    <input 
                                        type="text" 
                                        required 
                                        class="form-control currency" 
                                        ng-model="data.tenant_code" 
                                        name = "tenant_code"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="trade_name" class="col-md-4 control-label text-right">Trade Name</label>
                                <div class="col-md-6">
                                    <input 
                                        type="text" 
                                        required 
                                        class="form-control currency" 
                                        ng-model="data.trade_name" 
                                        name = "trade_name"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="rental_type" class="col-md-4 control-label text-right">Rental Type</label>
                                <div class="col-md-6">
                                    <input 
                                        type="text" 
                                        required 
                                        class="form-control currency" 
                                        ng-model="data.rental_type" 
                                        name = "rental_type"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="date_end" class="col-md-4 control-label text-right"> Date</label>
                                <div class="col-md-6">
                                    <input 
                                        type="text"
                                        readonly 
                                        required 
                                        class="form-control currency" 
                                        ng-model="data.date" >
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="total_netsales_amount" class="col-md-4 control-label text-right">Sales</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-addon"><strong>&#8369;</strong></div>
                                        <input 
                                            type="text" 
                                            required 
                                            class="form-control currency" 
                                            ng-value="data.sales | numberFormat" 
                                            name = "sales"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                         <div class="row">
                            <div class="form-group">
                                <label for="total_netsales_amount" class="col-md-4 control-label text-right">Total Non-Tax Sales</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-addon"><strong>&#8369;</strong></div>
                                        <input 
                                            type="text" 
                                            required 
                                            class="form-control currency" 
                                            ng-value="data.total_nontax_sales | numberFormat" 
                                            name = ""
                                            readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="form-group">
                                <label for="total_netsales_amount" class="col-md-4 control-label text-right">Date Uploaded</label>
                                <div class="col-md-6">
                                    <input 
                                        type="text" 
                                        required 
                                        class="form-control currency" 
                                        ng-model="data.upload_date" 
                                        readonly>
                            	</div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="total_netsales_amount" class="col-md-4 control-label text-right">Uploaded By</label>
                                <div class="col-md-6">
                                    <input 
                                        type="text" 
                                        required 
                                        class="form-control currency" 
                                        ng-model="data.uploaded_by" 
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class = "fa fa-close"></i> Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!--view modal daily-->
