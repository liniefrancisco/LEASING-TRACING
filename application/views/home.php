<div class="container" ng-app="app">
	<div class="cover">
		<div class="panel panel-default">
	      	<div class="panel-heading">Tenant Sales and Monitoring System
                <div class="clock-home" style="float:right;" ng-controller="chartController">
                    <div class="dateTime pull-left ng-cloak" ng-init = "tick('<?php echo base_url(); ?>index.php/chart_controller/get_dateTime')">
                        <p>{{ clock  | date:'medium'}}</p>
                    </div>
                </div> 
            </div>
	    </div>	
		<div class="well">
			<div class="row" ng-init="getDashboardData($base_url + 'tsms_controller/dashboard_data')">
				<div class="col-md-3" style="margin-bottom: 10px;">
					<div class="card text-center bg-primary" style="padding: 10px 25px; border-radius: 5px;">
					  <p class="card-header" style="border-bottom: solid 1.1px #ccc; padding-bottom: 10px; font-size: 15px;">DAILY SALES</p>
					  <div class="card-body">
					  	<h1 class="card-title"> <i class="fa fa-calendar"></i></h1>
					    <div class="row">
						  	<div class="col-sm-6 text-center">
						  		<p  style="color: inherit;">
						  			<b style="font-size: 15px;">{{dashboardData.daily.unconfirmed}}</b> 
						  			<span style="font-size: 12px;">unconfirmed</span>
						  		</p>
						  	</div>
						  	<div class="col-sm-6 text-center">
						  		<p style="color: inherit;" >
						  			<b style="font-size: 15px;">{{dashboardData.daily.unmatched}}</b> 
						  			<span style="font-size: 12px;">unmatched</span>
						  		</p>
						  	</div>
					    </div>
					  </div>
					</div>
				</div>
				<div class="col-md-3" style="margin-bottom: 10px;">
					<div class="card text-center" style="padding: 10px 25px; border-radius: 5px; background: #6200ee; color: #fff">
					  <p class="card-header" style="border-bottom: solid 1.1px #ccc; padding-bottom: 10px; font-size: 15px;">HOURLY SALES</p>
					  <div class="card-body">
					  	<h1 class="card-title"> <i class="fa fa-hourglass-start"></i></h1>
					  	<div class="row">
						  	<div class="col-sm-6 text-center">
						  		<p style="color: inherit;">
						  			<b style="font-size: 15px;">{{dashboardData.hourly.unconfirmed}}</b> 
						  			<span style="font-size: 12px;">unconfirmed</span>
						  		</p>
						  	</div>
						  	<div class="col-sm-6 text-center">
						  		<p style="color: inherit;" >
						  			<b style="font-size: 15px;">{{dashboardData.hourly.unmatched}}</b> 
						  			<span style="font-size: 12px;">unmatched</span>
						  		</p>
						  	</div>
					    </div>
					  </div>
					</div>
				</div>
				<div class="col-md-3" style="margin-bottom: 10px;">
					<div class="card text-center" style="padding: 10px 25px; border-radius: 5px; background: #FF0266; color: #fff">
					  <p class="card-header" style="border-bottom: solid 1.1px #ccc; padding-bottom: 10px; font-size: 15px;">VARIANCE REPORT</p>
					  <div class="card-body">
					  	<h1 class="card-title"> <i class="fa fa-bug"></i></h1>
					  	<p style="color: inherit; margin: 0; letter-spacing: 1px; padding-bottom: 7px;">
				  			<b style="font-size: 15px;">{{dashboardData.variance}}</b> 
				  			<span style="font-size: 12px; ">pending</span>
				  		</p>
					  </div>
					</div>
				</div>
				<div class="col-md-3" style="margin-bottom: 10px;">
					<div class="card text-center" style="padding: 10px 25px; border-radius: 5px; background: #09AF00; color: #FFF">
					  <p class="card-header" style="border-bottom: solid 1.1px #ccc; padding-bottom: 10px; font-size: 15px;">LEASING DATA</p>
					  <div class="card-body">
					  	<h1 class="card-title"> <i class="fa fa-cloud-upload"></i></h1>
				  		<p style="color: inherit; margin: 0; letter-spacing: 1px;  padding-bottom: 7px;">
				  			<b style="font-size: 15px;">{{dashboardData.leasing}}</b> 
				  			<span style="font-size: 12px; ">pending</span>
				  		</p>
					  </div>
					</div>
				</div>
			</div>
			<div class="row" style="margin-top: 30px;">
				<div class="col-md-6" ng-controller="chartController" ng-init="chart_view($base_url + 'chart_controller/monthly_sales/')">
					<div class="card text-left bg-info" style="padding: 10px 25px; border-radius: 5px;">
					  <p class="card-header text-center" style="padding-bottom: 10px; font-size: 18px;">TENANT MONTHLY SALES</p>
					  <div class="card-body">
					  	<div class="input-group col-md-4 col-md-offset-8">
	                    	<div class="input-group-addon input-date"><strong><i class="fa fa-calendar"></i></strong></div>
		                    
		                	<datepicker date-format="yyyy-MM">
		                        <input 
		                            type="text" 
		                            required 
		                            placeholder="Choose a date" 
		                            class="form-control"  
		                            ng-model="date"
		                            autocomplete="off"
		                            ng-change="chart_view($base_url + 'chart_controller/monthly_sales/'+ date)">
		                    </datepicker>
		                </div>
					  	<canvas id="bar" class="chart chart-bar"
			  				chart-data="data" chart-labels="labels" chart-legend="true" chart-colours="colours" chart-series="series">
						</canvas>
					  </div>
					</div>
				</div>
				<div class="col-md-6" ng-controller="chartController" ng-init="chartLatest12MonthSale($base_url + 'chart_controller/latest_12_month_sale/')">
					<div class="card text-left bg-info" style="padding: 10px 25px; border-radius: 5px;">
					  <p class="card-header text-center" style="padding-bottom: 10px; font-size: 18px;">
					  	YEARLY SALES GRAPH (from 12 latest month available)
					  </p>
					  <div class="card-body" style="padding-top: 35px;">
					  	<canvas id="bar" class="chart chart-line"
			  				chart-data="data" chart-labels="labels" chart-legend="true" chart-colours="colours" chart-series="series">
						</canvas>
					  </div>
					</div>
				</div>
			</div>

        </div>	      
    </div>
</div>
     