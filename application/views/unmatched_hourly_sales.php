<div class="well" style="margin-top: 20px;margin-left: 10px;margin-right: 10px;">
    <div class="col-md-2 pull-right">
        <input ng-model="query" class="form-control query" placeholder="Search Here..."/>
    </div>
    <div class="tabs">
            <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#menu1" style="font-weight: bold;">Unmatched Hourly Sales</a></li>
            </ul>
        <div class="table-transaction" id="table1">  
            <div class="tab-content">
                <div id="menu1" class="tab-pane fade in active">
                    <table class="table table-bordered" ng-controller="tablecontroller" ng-init="unhourlyInit()">
                        <thead>
                          <tr>
                            <th><a href="#" data-ng-click="sortField = 'tenant_type'; reverse = !reverse">Tenant Type</a></th>
                            <th><a href="#" data-ng-click="sortField = 'trade_name'; reverse = !reverse">Tenant Name</a></th>
                            <th><a href="#" data-ng-click="sortField = 'transac_date'; reverse = !reverse">Transaction Date</a></th>
                            <th><a href="#" data-ng-click="sortField = 'pos_num'; reverse = !reverse">POS No.</a></th>
                            <th><a href="#" data-ng-click="sortField = 'date_upload'; reverse = !reverse">Date Uploaded</a></th>
                            <th><a href="#" data-ng-click="sortField = 'totalnetsales_amount_hour'; reverse = !reverse">Net Sales Amount</a></th>
                            <th><a href="#" data-ng-click="sortField = 'numsales_transac_hour'; reverse = !reverse">Total No. of Sales Tran.</a></th>
                            <th><a href="#" data-ng-click="sortField = 'status'; reverse = !reverse">Rental Type</a></th>
                            <th><a href="#" data-ng-click="sortField = 'status'; reverse = !reverse">Tenant Code</a></th>
                            <th><a href="#" data-ng-click="sortField = 'status'; reverse = !reverse">Status</a></th>
                            <th><a href="#" data-ng-click="sortField = 'status'; reverse = !reverse">Action</a></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr class="ng-cloak" ng-show="unhourlyList.length!=0" ng-repeat= "data in unhourlyList | filter:query | orderBy:sortField:reverse ">
                            <td>{{data.tenant_type }}</td>
                            <td>{{data.trade_name }}</td>
                            <td>{{data.transac_date | date }}</td>
                            <td>{{data.pos_num}}</td>
                            <td>{{data.date_upload}}</td>
                            <td>{{data.totalnetsales_amount_hour | currency : ' &#8369; ' }}</td>
                            <td>{{data.totalnumber_sales_transac}}</td>
                            <td>{{data.rental_type}}</td>
                            <td>{{data.tenant_code}}</td>
                            <td ng-class="{'Confirmed': data.status === 'Confirmed','Unconfirmed': data.status === 'Unconfirmed'}">{{data.status}}</td>
                            <td>
                                <div class="btn-group">
                                    <div class="img_menu">
                                        <img src="<?php echo base_url(); ?>img/menu3.png" style="height: 15px; width: 13px;" data-toggle="dropdown" id="img_menu">
                                        <ul style="position:absulote;left: -40px; top: -5px; background: white; border-top: none;" class="dropdown-menu">
                                          <li><a href="#"  data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#hourly_sales_data" ng-click="viewSales($base_url + 'tsms_controller/view_hourly_sales', data)"> <i class = "fa fa-search"></i> View</a></li>
                                          <li><a href="#" ng-click="deleteDataAjax($base_url + 'tsms_controller/delete_hourly_sales_record/' + data.transac_date  + '/' + data.tenant_code, 'hourlyList', data)"> <i class = "fa fa-trash"></i> Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                          </tr>
                            <tr class="ng-cloak" ng-show="unhourlyList.length==0 || (unhourlyList | filter:query).length == 0">
                                <td colspan="9"><center>No Data Available.</center></td>
                            </tr>
                        </tbody> 
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="loading-screen"></div>

<div class="modal fade" id="hourly_sales_data">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title"><i class="fa fa-search"></i> View Tenant Hourly Sales</h4>
            </div>
            <div class="modal-body">
                <form method="post" ng-submit="confirm_unmatched_hourlysales($event)" action="<?=base_url()?>/tsms_controller/update_unhourly_sales_record" name="frm_updatehourly" id="frm_updatehourly">
                    <table class="table table-bordered" ng-controller="tablecontroller">
                        <thead>
                            <tr>
                                <th>Tenant Type</th>
                                <th>Tenant Name</th>
                                <th>Transaction Date</th>
                                <th>Hour Code</th>
                                <th>Net Sales Amount/Hour</th>
                                <th>Number of Sales Transaction/Hour</th>
                                <th>Customer Count Hour</th>
                                <th>Status</th>
                                <th><a href="#"> <input type="checkbox" name="" ng-click="selectAll('viewData', $event)" ng-checked="allSelected('viewData')" style="width: 18px;height: 18px;"></a></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="sales in viewData ">
                                <td>{{sales.tenant_type }} </td>
                                <td>{{sales.trade_name }}</td>
                                <td>{{sales.transac_date | date }}</td>
                                <td>{{sales.hour_code}}{{':00'}}</td>
                                <td>{{sales.netsales_amount_hour | currency : ' &#8369; ' }}</td>
                                <td>{{sales.numsales_transac_hour}}</td>
                                <td>{{sales.customer_count_hour}}</td>
                                <td>{{sales.status}}</td>
                                <td>
                                    <div ng-init="sales.selected = false">
                                        <input type="checkbox" style="width: 18px;height: 18px;" disabled="" ng-if="sales.status != 'Unmatched'">
                                        <input type="checkbox" ng-value="sales.id" name="checkboxes[]" ng-if="sales.status == 'Unmatched'" ng-model="sales.selected"   style="width: 18px;height: 18px;"> 
                                    </div>
                                </td>
                            </tr>
                        </tbody> 
                    </table>
                    <table class="table table-bordered" ng-controller="tablecontroller">
                        <thead>
                            <tr>
                            <th> POS NO.</th>
                            <th> Total Netsales Amount</th>
                            <th> Compare Netsales Here</th>
                            <th> Total Number Sales Transaction</th>
                            <th> Compare Sales Transaction Here </th>
                            <th> Total Customer Count</th>
                            <th> Compare Customer Count Here </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="sales in viewData | limitTo: total_inhourly_sales" >
                                <td>{{sales.pos_num}}</td>
                                <td>{{sales.totalnetsales_amount_hour | currency : ' &#8369; '}}</td>
                                <td>{{viewData |arrayTotal : 'netsales_amount_hour' | currency : ' &#8369; '}}</td>
                                <td>{{sales.totalnumber_sales_transac}}</td>
                                <td>{{viewData |arrayTotal : 'numsales_transac_hour'}}</td>
                                <td>{{sales.total_customer_count_day}}</td>
                                <td>{{viewData |arrayTotal : 'customer_count_hour'}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="modal-footer">
                        <div class="form-group">

                            <button type="submit" ng-disabled="!hasSelectedHourlySale('Unmatched')" name="submit" value="submit" class="btn btn-success"><i class="fa fa-check"></i> Confirm</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class = "fa fa-close"></i> Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

