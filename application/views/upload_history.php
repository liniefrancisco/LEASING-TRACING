<div class="container">
    <div class="cover">
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Upload History </div>
        </div>
        <div class="well" ng-controller="tablecontroller" ng-controller="decontroller" >
            <div class="col-md-2 pull-right">
                <input ng-model="query" class="form-control search-query" placeholder="Search Here..."/>
            </div>
            <div class="tabs">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#menu2" data-toggle="tab" style="font-weight: bold;">Data for Leasing </a></li>
                </ul>
            </div>
            <br>
            <table class="table table-bordered" ng-controller="tablecontroller" ng-init="loadList('<?php echo base_url(); ?>index.php/tsms_controller/get_upload_history')">
                <thead>
                  <tr>
                    <th>Trade Name</th>
                    <th>Date End</th>
                    <th>Rental Type</th>
                    <th>Percentage of Monthly Sales</th>
                    <th>Tenant Type</th>
                    <th>Time Uploaded</th>

                  </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="data in dataList | filter:query">
                        <td>{{data.trade_name}}</td>
                        <td>{{data.date}}</td>
                        <td>{{data.rental_type}}</td>
                        <td class="text-right" style="padding-right: 50px;">{{data.total_netsales_amount | numberFormat}}</td>
                        <td>{{data.tenant_type}}</td>
                        <td class="text-left" style="padding-left: 30px;">{{data.upload_date}}</td>
                    </tr>    
                </tbody>
            </table>
        </div><!--end div well-->
    </div><!--end div cover-->
</div><!--end div container-->

