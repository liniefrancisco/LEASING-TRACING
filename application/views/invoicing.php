<div class="container">
    <div class="cover">
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-print" aria-hidden="true"></i> Reports </div>
        </div>
        <div class="well" ng-controller="tablecontroller" ng-controller="decontroller">
            <div class="table-transaction" id="table1">
                <form action="<?php echo base_url();?>reports/monthly_sales/" method="post" name="frm_print" id="frm_print" target="_blank">  
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
                                          ng-change="getTenants('<?php echo base_url(); ?>index.php/tsms_controller/get_tenants/' + tenant_list)">
                                          <option id="" disabled="" selected="" style="display:none" >Tenant Type</option>
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
                                          <option ng-repeat = "tenant in tenantlist">{{tenant.trade_name}}</option>
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
                                      <button type="button" ng-click="monthly_report_button($base_url + 'tsms_controller/monthly_report/'+ tenant_list + '_'+ filter_date + '/'+ tenant.trade_name )" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
                                    </div>
                                </div>
                            </div><!-- end upload control-->
                        <div id="menu1" class="tab-pane fade in active">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-hover" id="table-reports">
                                        <thead>
                                          <tr>
                                            <th>Transaction Date</th>
                                            <th>SC Discounts</th>
                                            <th>Other Discounts</th>
                                            <th>Total PWD Discounts</th>
                                            <th>Total Nontax Sales</th>
                                            <th>Total Tax/Vat</th>
                                            <th>Total Cash Sales</th>
                                            <th>Gross Sales</th>
                                            <th>Net Sales</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="data in monthly_report | filter:query">
                                                <td>{{data.transac_date}}</td>
                                                <td>{{data.total_sc_discounts | currency : ''}}</td>
                                                <td>{{data.other_discounts | currency : ''}}</td>
                                                <td>{{data.total_pwd_discounts | currency : ''}}</td>
                                                <td>{{data.total_nontax_sales | currency : ''}}</td>
                                                <td>{{data.total_taxvat | currency : ''}}</td>
                                                <td>{{data.total_cash_sales | currency : ''}}</td>
                                                <td>{{data.total_gross_sales | currency : ''}}</td>
                                                <td>{{data.total_net_sales | currency : ''}}</td>
                                            </tr>
                                            <tr ng-if="!isEmpty(monthly)" style="font-weight: bold !important;">
                                              <td><b> TOTAL :</b> </td>
                                              <td><b>{{monthly.total_sc_discounts | currency : ''}}</b></td>
                                              <td><b>{{monthly.other_discounts | currency : ''}}</b></td>
                                              <td><b>{{monthly.total_pwd_discounts | currency : ''}}</b></td>
                                              <td><b>{{monthly.total_nontax_sales | currency : ''}}</b></td>
                                              <td><b>{{monthly.total_taxvat | currency : ''}}</b></td>
                                              <td><b>{{monthly.total_cash_sales | currency : ''}}</b></td>
                                              <td><b>{{monthly.total_gross_sales | currency : ''}}</b></td>
                                              <td><b>{{monthly.total_net_sales | currency : ''}}</b></td>
                                            </tr>
                                            <tr ng-if="(!monthly || monthly.length == 0) && monthly_report.length > 0 ">
                                              <td colspan="100" class="text-center"><b>NO MONTHLY CALCULATION FOUND. PLEASE CALCULATE MONTHLY SALE.</b></td>
                                            </tr>
                                            <tr class="ng-cloak" ng-show="!monthly_report || monthly_report.length==0 || (monthly_report | filter:query).length == 0">
                                                <td colspan="7"><center>No Data Available.</center></td>
                                            </tr>     
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1" id="print_button">
                                    <button type="submit" ng-disabled="monthly_report.length==0 || frm_print.$invalid "  class="btn btn-primary"><i class="fa fa-print"> Print</i></button>
                                </div>
                            </div>
                        </div><!--  menu1 -->
                    </div> <!-- tab-content -->
                </form>
            </div> <!-- table transaction -->
        </div><!--end div well-->
    </div><!--end div cover-->
</div><!--end div container-->


