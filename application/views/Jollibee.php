
<div id="Homepage">
  <div class="cover">
    <div class="upload-table">
      <div class="col-md-3 pull-right">
                        <input type = "text" class="form-control search-query" placeholder="Search Here..." ng-model="query" />
          </div>
        <div class="upload-btn-form">
                        <li style="float:left" a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#hourly_sales" class = "btn btn-success btn-medium"><i class = "fa fa-plus-circle"></i> Upload Hourly Sales</a></li>
  
                        <li style="float:left" a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#add_data" class = "btn btn-success btn-medium"><i class = "fa fa-plus-circle"></i> Upload Dialy Sales</a></li>
          </div>
            </div>
<div ng-app="app">
  <div ng-controller="decontroller">
   <div class="tabs">
        <ul class="tab-links">
        <li style="float:left" class="active"><a href="#tab1">Hourly Sales Record</a></li>3
        <li><a href="#tab2">Daily Sales Record</a></li>
        <li><a href="#tab3">Monthly Sales record</a></li>
        </ul>
      <div class="table-fixed-left">  
<div class="tab-content">
  <div id="tab1" class="tab active">
    <table class="table table-bordered table-condensed">
      <thead>
        <tr>
          <th>Transaction Date</th>
          <th>Hour Code</th>
          <th>Net Sales Amount/Hour</th>
          <th>Number of Sales Transaction/Hour</th>
          <th>Customer Count/Hour</th>
          <th>Total Net Sales/Day</th>
          <th>Total Sales Transaction/Hour</th>
          <th>Total Customer Count/Day</th>
          <th>Action</th>
          <th> Status</th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="n in displaylist">
          <td>{{-2}} {{n.transac_date}}</td>
          <td>{{n.hour_code}}</td>
          <td>{{n.netsales_amount_hour}}</td>
          <td>{{n.total_numsales_transac_hour}}</td>
          <td>{{n.customer_count_hour}}</td>
          <td>{{n.totalnetsales_amount_hour}}</td>
          <td>{{n.totalnumber_sales_transac}}</td>
          <td>{{n.total_customer_count_day}}</td>
          <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-xs btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            <ul class="dropdown-menu">
                                                <li><a href="<?php echo base_url(); ?>#" >Mark checked</a></li>
                                                <li><a href="#" data-backdrop="static" pop-up="left" data-keyboard="false" data-toggle="modal" data-target="#" ng-click="update('<?php echo base_url(); ?>#)"> Update</a></li>
                                                <li><a href="#" data-toggle="modal('<?php echo base_url(); ?>#)"> Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>


        </tr>
      </tbody>
      </table>
    </div>

<div id="tab2" class="tab">
  <table class="table table-bordered table-condensed">
      <thead>
        <tr>
          <th>Aadasasds</th>
          <th>New Accumulated Total</th>
          <th>Total Gross Sales</th>
          <th>Total Nontax Sales</th>
          <th>Total SC Discount</th>
          <th>Other Discount</th>
          <th>Total Refund Amount</th>
          <th>Total Tax Vat</th>
          <th>Total Other Charges</th>
          <th>Total Service Charges</th>
          <th>Total Netsales</th>
          <th>Total Cash Sales</th>
          <th>Total Charge Sales</th>
          <th>Total GC/Other Values</th>
          <th>Total Void Amount</th>
          <th>Total Customer Count</th>
          <th>Control Number</th>
          <th>Total Sales Transaction</th>
          <th>Total Sales Type</th>
          <th>Net Sales Amount</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="n in list_data">
          <td>{{n.old_acctotal}}</td>
          <td>{{n.new_acctotal}}</td>
          <td>{{n.total_gross_sales}}</td>
          <td>{{n.total_nontax_sales}}</td>
          <td>{{n.total_sc_discount}}</td>
          <td>{{n.other_dis}}</td>
          <td>{{n.total_refund_amount}}</td>
          <td>{{n.total_taxvat}}</td>
          <td>{{n.total_other_charges}}</td>
          <td>{{n.total_service_charge}}</td>
          <td>{{n.total_netsales}}</td>
          <td>{{n.total_cashsales}}</td>
          <td>{{n.total_chargesales}}</td>
          <td>{{n.total_gcother_values}}</td>
          <td>{{n.total_void_amount}}</td>
          <td>{{n.total_customer_count}}</td>
          <td>{{n.control_num}}</td>
          <td>{{n.total_sales_transaction}}</td>
          <td>{{n.sales_type}}</td>
          <td>{{n.net_sales_amount}}</td>
          <td>
                                      <div class="btn-group">
                                            <button type="button" class="btn btn-xs btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            <ul class="dropdown-menu">
                                                <li><a href="<?php echo base_url(); ?>#" >Mark checked</a></li>
                                                <li><a href="#" data-backdrop="static" pop-up="left" data-keyboard="false" data-toggle="modal" data-target="#" ng-click="update('<?php echo base_url(); ?>#)"> Update</a></li>
                                                <li><a href="#" data-toggle="modal('<?php echo base_url(); ?>#)"> Delete</a></li>
                                            </ul>
                                        </div>
          </td>

        </tr>
      </tbody>
      </table>
    </div>

<div id="tab3" class="tab">
  <table class="table table-bordered table-condensed">
      <thead>
        <tr>
          <th>Oqweqweqwe</th>
          <th>New Accumulated Total</th>
          <th>Total Gross Sales</th>
          <th>Total Nontax Sales</th>
          <th>Total SC Discount</th>
          <th>Other Discount</th>
          <th>Total Refund Amount</th>
          <th>Total Tax Vat</th>
          <th>Total Other Charges</th>
          <th>Total Service Charges</th>
          <th>Total Netsales</th>
          <th>Total Cash Sales</th>
          <th>Total Charge Sales</th>
          <th>Total GC/Other Values</th>
          <th>Total Void Amount</th>
          <th>Total Customer Count</th>
          <th>Control Number</th>
          <th>Total Sales Transaction</th>
          <th>Total Sales Type</th>
          <th>Net Sales Amount</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="n in list_data">
          <td>{{n.old_acctotal}}</td>
          <td>{{n.new_acctotal}}</td>
          <td>{{n.total_gross_sales}}</td>
          <td>{{n.total_nontax_sales}}</td>
          <td>{{n.total_sc_discount}}</td>
          <td>{{n.other_dis}}</td>
          <td>{{n.total_refund_amount}}</td>
          <td>{{n.total_taxvat}}</td>
          <td>{{n.total_other_charges}}</td>
          <td>{{n.total_service_charge}}</td>
          <td>{{n.total_netsales}}</td>
          <td>{{n.total_cashsales}}</td>
          <td>{{n.total_chargesales}}</td>
          <td>{{n.total_gcother_values}}</td>
          <td>{{n.total_void_amount}}</td>
          <td>{{n.total_customer_count}}</td>
          <td>{{n.control_num}}</td>
          <td>{{n.total_sales_transaction}}</td>
          <td>{{n.sales_type}}</td>
          <td>{{n.net_sales_amount}}</td>
          <td>

                                        <div class="btn-group">
                                            <button type="button" class="btn btn-xs btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            <ul class="dropdown-menu">
                                                <li><a href="<?php echo base_url(); ?>#" >Mark checked</a></li>
                                                <li><a href="#" data-backdrop="static" pop-up="left" data-keyboard="false" data-toggle="modal" data-target="#" ng-click="update('<?php echo base_url(); ?>#)"> Update</a></li>
                                                <li><a href="#" data-toggle="modal('<?php echo base_url(); ?>#)"> Delete</a></li>
                                            </ul>
                                        </div>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
        </td>

    <div id="tab4" class="tab">
  <table class="table table-bordered table-condensed">
      <thead>
        <tr>
          <th>Old Accumulated Total</th>
          <th>New Accumulated Total</th>
          <th>Total Gross Sales</th>
          <th>Total Nontax Sales</th>
          <th>Total SC Discount</th>
          <th>Other Discount</th>
          <th>Total Refund Amount</th>
          <th>Total Tax Vat</th>
          <th>Total Other Charges</th>
          <th>Total Service Charges</th>
          <th>Total Netsales</th>
          <th>Total Cash Sales</th>
          <th>Total Charge Sales</th>
          <th>Total GC/Other Values</th>
          <th>Total Void Amount</th>
          <th>Total Customer Count</th>
          <th>Control Number</th>
          <th>Total Sales Transaction</th>
          <th>Total Sales Type</th>
          <th>Net Sales Amount</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="n in list_data">
          <td>{{n.old_acctotal}}</td>
          <td>{{n.new_acctotal}}</td>
          <td>{{n.total_gross_sales}}</td>
          <td>{{n.total_nontax_sales}}</td>
          <td>{{n.total_sc_discount}}</td>
          <td>{{n.other_dis}}</td>
          <td>{{n.total_refund_amount}}</td>
          <td>{{n.total_taxvat}}</td>
          <td>{{n.total_other_charges}}</td>
          <td>{{n.total_service_charge}}</td>
          <td>{{n.total_netsales}}</td>
          <td>{{n.total_cashsales}}</td>
          <td>{{n.total_chargesales}}</td>
          <td>{{n.total_gcother_values}}</td>
          <td>{{n.total_void_amount}}</td>
          <td>{{n.total_customer_count}}</td>
          <td>{{n.control_num}}</td>
          <td>{{n.total_sales_transaction}}</td>
          <td>{{n.sales_type}}</td>
          <td>{{n.net_sales_amount}}</td>
                                    <div class="btn-group">
                                            <button type="button" class="btn btn-xs btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            <ul class="dropdown-menu">
                                              <li><a href="<?php echo base_url(); ?>#" >Mark checked</a></li>
                                              <li><a href="#" data-backdrop="static" pop-up="left" data-keyboard="false" data-toggle="modal" data-target="#" ng-click="update('<?php echo base_url(); ?>#)"> Update</a></li>
                                              <li><a href="#" data-toggle="modal('<?php echo base_url(); ?>#)"> Delete</a></li>
                                          </ul>
                                        </div>  
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

        <div class="modal fade" id = "add_data">
            <div class="modal-dialog modal-md">
               <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title"><i class="fa fa-pencil"></i>Upload Daily Sales</h4>
                  </div>
                  <div class="modal-body">
                        <div class="upload_form">
                          <form method="post" action="<?php echo site_url('upload/evaluate_file');?>" enctype="multipart/form-data">
                              <input type="file" name="file" id="file">
                              <p>
                              <br>
                              <input type="submit" name="btn-upload" value="Upload" id="btn-upload" class="btn btn-primary">
                          </form>
                        </div>
                    <form action="<?php echo base_url(); ?>#" name="add_form" method="post">
                    </form>
                  </div>

                </div>
              </div>
        </div>

        <div class="modal fade" id = "hourly_sales">
            <div class="modal-dialog modal-md">
               <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title"><i class="fa fa-pencil"></i>Upload Hourly Sales</h4>
                  </div>
                  <div class="modal-body">
                        <div class="upload_form">
                          <form method="post" action="<?php echo site_url('upload/hourly_sales');?>" enctype="multipart/form-data">
                              <input type="file" name="file" id="file">
                              <p>
                              <br>
                              <input type="submit" name="btn-upload" value="Upload" id="btn-upload" class="btn btn-primary">
                          </form>
                        </div>
                    <form action="<?php echo base_url(); ?>#" name="add_form" method="post">
                    </form>
                  </div>
