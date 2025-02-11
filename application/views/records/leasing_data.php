<div class="well" style="margin-top: 20px;margin-left: 10px;margin-right: 10px;">
    <div class="tabs">
        <ul class="nav nav-tabs">
            <li style="float:left" class="active"><a data-toggle="tab" href="#menu1" style="font-weight: bold;">Leasing Data</a></li>
            <li><a data-toggle="tab" href="#menu2" style="font-weight: bold;">Upload History</a></li>
        </ul>
        <div class="well">
            <div class="row" id="tenant-record">  
            	<form ng-submit="getDataList($base_url + 'tsms_controller/get_leasing_data_records/' + tenant_list + '/' + trade_name + '/' + location_code, 'leasingData')">
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
        <div class="table-history" id="table1">  
            <div class="tab-content">

                <div id="menu1" class="tab-pane fade in active">
                    <div class="well">
			            <div ng-controller="mytablecontroller" class="row">
					        <div class="col-md-12">  		                
			                    <table class="table table-bordered table-hover">
			                        
			                    	<thead>
				                      <tr>
				                        <th class="sort" ng-click="sort('trade_name')">Trade Name</th>
				                        <th class="sort" ng-click="sort('date_end')">Date</th>
				                        <th class="sort" ng-click="sort('rental_type')">Rental Type</th>
				                        <th class="sort" ng-click="sort('total_netsales_amount')">Total Net Sales</th>
				                        <th class="sort" ng-click="sort('tenant_type')">Tenant Type</th>
				                        <th class="sort" ng-click="sort('status')">Status</th>
				                        <th>Action</th>
				                      </tr>
				                    </thead>
				                    <tbody>
				                        <tr ng-repeat="data in leasingData.dl | filter:query | sortBy: field : reverse| tableOffset: page : ipp">
				                            <td>{{data.trade_name}}</td>
				                            <td>{{data.date_end }}</td>
				                            <td>{{data.rental_type}}</td>
				                            <td>{{data.total_netsales_amount | numberFormat : 2 : '₱'}}</td>
				                            <td>{{data.tenant_type}}</td>
				                            <td>{{data.status}} </td>
				                            <td>
				                                <div class="btn-group">
				                                    <div class="img_menu">
				                                        <img src="<?php echo base_url(); ?>img/menu3.png" style="height: 15px; width: 13px;" data-toggle="dropdown" id="img_menu">
				                                        <ul style="position:absulote;left: -40px; top: -5px; background: white; border-top: none;" class="dropdown-menu">
				                                            <li>
				                                            	<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#data_leasing_modal" ng-click="setData(data)"> <i class = "fa fa-search"></i> View</a>
				                                            </li>
				                                            
				                                            <?php if($this->session->userdata('user_type') == 'Administrator'): ?>
			                                                	<li>
			                                                		<a ng-click="deleteDataAjax($base_url + 'tsms_controller/delete_leasing_data/' + data.id, 'leasingData.dl', data);"> <i class="fa fa-trash"></i> Delete</a>
			                                                	</li>
			                                              	<?php endif; ?>
				                                        </ul>
				                                    </div>
				                                </div>
				                            </td> 
				                        </tr>
				                        <tr class="ng-cloak" ng-show="!leasingData.dl || leasingData.dl.length==0 || (leasingData.dl | filter:query).length == 0">
				                            <td colspan="7"><center>No Data Available.</center></td>
				                        </tr>    
				                    </tbody>

			                        <tfoot>
		                               <tr class="ng-cloak" ng-init="ipp = 15;">
		                                  <td colspan="14">
		                                      <div>
		                                          <ul class="pagination" ng-show="paginate(leasingData.dl | filter:query)">
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
			            </div>
			        </div>
                </div>

                <div id="menu2" class="tab-pane fade">
                	<div class="well">
			            <div ng-controller="mytablecontroller" class="row">
					        <div class="col-md-12">             
			                    <table class="table table-bordered table-hover">
			                    	<thead>
				                      <tr>
				                        <th class="sort" ng-click="sort('trade_name')">Trade Name</th>
				                        <th class="sort" ng-click="sort('date')">Date</th>
				                        <th class="sort" ng-click="sort('rental_type')">Rental Type</th>
				                        <th class="sort" ng-click="sort('total_netsales_amount')">Total Net Sales</th>
				                        <th class="sort" ng-click="sort('tenant_type')">Tenant Type</th>
				                        <th class="sort" ng-click="sort('uploaded_by')">Date Uploaded</th>
				                        <th class="sort" ng-click="sort('uploaded_by')">Uploaded By</th>
				                        <th>Action</th>
				                      </tr>
				                    </thead>
				                    <tbody>
				                        <tr ng-repeat="data in leasingData.uh | filter:query | sortBy: field : reverse| tableOffset: page : ipp">
				                            <td>{{data.trade_name}}</td>
				                            <td>{{data.date }}</td>
				                            <td>{{data.rental_type}}</td>
				                            <td>{{data.total_netsales_amount | currency :''}}</td>
				                            <td>{{data.tenant_type}}</td>
				                            <td>{{data.upload_date}} </td>
				                            <td>{{data.uploaded_by}} </td>
				                            <td>
				                                <div class="btn-group">
				                                    <div class="img_menu">
				                                        <img src="<?php echo base_url(); ?>img/menu3.png" style="height: 15px; width: 13px;" data-toggle="dropdown" id="img_menu">
				                                        <ul style="position:absulote;left: -40px; top: -5px; background: white; border-top: none;" class="dropdown-menu">
				                                            <li>
				                                            	<a href="#" data-toggle="modal" data-target="#upload_history_modal" ng-click="setData(data)"> <i class = "fa fa-search"></i> View</a>
				                                            </li>

				                                            <?php if($this->session->userdata('user_type') == 'Administrator'): ?>
			                                                	<li>
			                                                		<a ng-click="deleteDataAjax($base_url + 'tsms_controller/delete_upload_history_data/' + data.id, 'leasingData.uh', data);"> <i class="fa fa-trash"></i> Delete</a>
			                                                	</li>
			                                              	<?php endif; ?>
				                                        </ul>
				                                    </div>
				                                </div>
				                            </td> 
				                        </tr>
				                        <tr class="ng-cloak" ng-show="!leasingData.uh || leasingData.uh.length==0 || (leasingData.uh | filter:query).length == 0">
				                            <td colspan="7"><center>No Data Available.</center></td>
				                        </tr>    
				                    </tbody>

			                        <tfoot>
		                               <tr class="ng-cloak" ng-init="ipp = 15;">
		                                  <td colspan="14">
		                                      <div>
		                                          <ul class="pagination" ng-show="paginate(leasingData.uh | filter:query)">
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
			            </div>
			        </div>
                </div> <!--end of tab2-->
            </div>
        </div>
    </div>
</div><!--end of well-->


<!--view modal daily-->
<div id="data_leasing_modal" class="modal fade" role="dialog" aria-labelledby="tenant_daily_sales">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4><i class="fa fa-search"></i> Data for Leasing</h4>
            </div>
            <div class="modal-body">
                <form  action = "#" method="post" name = "frm_update" >
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
                                <label for="tenant_code" class="col-md-4 control-label text-right">Tenant Code</label>
                                <div class="col-md-6">
                                    <input 
                                        type="text" 
                                        required 
                                        class="form-control currency" 
                                        ng-model="data.tenant_code" 
                                        id="1" 
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
                                <label for="trade_name" class="col-md-4 control-label text-right">Trade Name</label>
                                <div class="col-md-6">
                                    <input 
                                        type="text" 
                                        required 
                                        class="form-control currency" 
                                        ng-model="data.trade_name" 
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
                                <label for="rental_type" class="col-md-4 control-label text-right">Rental Type</label>
                                <div class="col-md-6">
                                    <input 
                                        type="text" 
                                        required 
                                        class="form-control currency" 
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
                                <label for="date_end" class="col-md-4 control-label text-right"> Date</label>
                                <div class="col-md-6">
                                    <input 
                                        type="text"
                                        readonly 
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
                                <label for="total_nontax_sales" class="col-md-4 control-label text-right">Total Nontaxable Sales</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-addon"><strong>&#8369;</strong></div>
                                        <input 
                                            type="text" 
                                            required 
                                            class="form-control currency" 
                                            ng-model="data.total_nontax_sales" 
                                            id="total_nontax_sales" 
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
                                <label for="total_netsales_amount" class="col-md-4 control-label text-right">Sales</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-addon"><strong>&#8369;</strong></div>
                                        <input 
                                            type="text" 
                                            required 
                                            class="form-control currency" 
                                            ng-model="data.total_netsales_amount" 
                                            id="total_netsales_amount" 
                                            name = "total_netsales_amount"
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
                                <label for="total_netsales_amount" class="col-md-4 control-label text-right">Status</label>
                                <div class="col-md-6">
                                    <input 
                                        type="text" 
                                        required 
                                        class="form-control currency" 
                                        ng-model="data.status" 
                                        name = "status"
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



<!--view modal daily-->
<div id="upload_history_modal" class="modal fade" role="dialog" aria-labelledby="tenant_daily_sales">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4><i class="fa fa-search"></i> Upload History</h4>
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
                                            ng-model="data.total_netsales_amount" 
                                            name = "total_netsales_amount"
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