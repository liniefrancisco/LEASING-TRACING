<div class="container" ng-controller="chartController">
    <div class="cover">
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-calendar" aria-hidden="true"></i> Tenants Yearly Record </div>
        </div>
        <div class="well" ng-controller="tablecontroller" ng-controller="decontroller" >
            <div class="upload-control">
                <div class="col-md-12">
                    <div class="row" id="tenant-record">  
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
                                  ng-model="tenant.trade_name">
                                  <option class="placeholder" selected disabled value="">Trade Name</option>
                                  <option ng-repeat = "tenant in tenantlist">{{tenant.trade_name}}</option>
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
                                  <option>2017</option>
                                  <option>2018</option>
                                  <option>2019</option>
                                  <option>2020</option>
                                  </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2" >
                              <button type="button" ng-click="home_view_chart($base_url + 'chart_controller/home_chart_search/'+ tenant_list + '_'+ tenant.trade_name + '/'+ year )" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
                            </div>
                        </div>
                    </div><!-- end upload control-->
                </div>
            </div>
            <div class="well" ng-show="showGraph">
                    <div id="canvasChart" ng-app="app" ng-controller="chartController" >
                        <canvas id="line" class="chart chart-line"
                            chart-data="data" chart-labels="labels" chart-legend="true" chart-colours="colours" chart-series="series">
                        </canvas>
                    </div>
            </div>
            <div class="clock-home">
                <div class="dateTime pull-left ng-cloak" ng-init = "tick('<?php echo base_url(); ?>index.php/chart_controller/get_dateTime')">
                    <p>{{ clock  | date:'medium'}}</p>
                </div>
            </div>
        </div><!--end div well-->
    </div><!--end div cover-->
</div><!--end div container-->


                        