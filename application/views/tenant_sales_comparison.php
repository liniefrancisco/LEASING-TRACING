<div class="container">
	<div class="cover">
    	<div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-line-chart" aria-hidden="true"></i> Tenant Sales Comparison </div>
        </div>
        <div class="well">
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
                <div class="col-md-2" >
                    <div class="form-group">
                        <select
                        class = "form-control" 
                        name = "year" 
                        required
                        id = "year"
                        ng-model="year">
                        <option class="placeholder" selected disabled value="">Year</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2" >
                    <div class="form-group">
                        <select
                        class = "form-control" 
                        name = "year1" 
                        required
                        id = "year1"
                        ng-model="year1">
                        <option class="placeholder" selected disabled value="">Year</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-2"  >
                      <button type="button" ng-click="yearly_comparison_button($base_url + 'tsms_controller/yearly_comparison/'+ tenant_list + '/'+ year + '/' + year1)" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
                    </div>
                </div>
            </div><!-- end upload control-->
                <div class="row"  ng-controller="tablecontroller">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tenant Name</th>
                                    <th>{{year}}</th>
                                    <th>{{year1}}</th>
                                    <th>{{year + " vs "  + year1}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="data in yearly_comparison">
                                    <td >{{data.trade_name}}</td>
                                    <td class="text-right">{{data.year  | numberFormat}}</td>
                                    <td class="text-right">{{data.year1 | numberFormat}}</td>
                                    <td><span ng-bind="data.vs"></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
		</div><!--end div well-->
	</div><!--end div cover-->
</div><!--end div container-->