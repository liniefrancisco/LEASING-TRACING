<div id="Homepage">
 <div ng-app="app" ng-controller="decontroller" >
  <div class="cover-discounts">
    <div class="home-container">
           <div class="form-group">
             <div class="col-md-6">
               <select
               class = "form-control" 
               name = "user_type" 
               required
                ng-model=""
                id = "tenant_list">
                <option value="" disabled="" selected="" style="display:none">Tenant Type</option>
                <option>Long Term Tenants</option>
                <option>Short Term Tenants</option>
                </select>
                </div>
              </div>

              <div class="upload-btn-form">
              <div class="col-md-4">
                <li style="float:left" a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#add_data" class = "btn btn-success btn-medium"><i class = "fa fa-plus-circle"></i> Add Data</a></li>
                  </div>
                  </div>
                  <br></br>
     <div class="outer-cover-discounts">             
      <div class="table-discounts" style="margin-left: 140px;">
       <table class="table table-bordered table-condensed">
        <thead>
          <tr>
            <th>Tennat ID</th>
            <th>Tennant Name</th>
            <th>Type of Discounts and Deductions</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <tr ng-repeat="n in discountlist">
            <td data-toggle="modal" data-id="" type="number" data-target="#edit_hourly_sales">{{n.tennant_id}}</td>
            <td data-toggle="modal" data-id="" type="number" data-target="#edit_hourly_sales">{{n.tennant_name}}</td>
            <td data-toggle="modal" data-id="" type="number" data-target="#edit_hourly_sales">{{n.discounts_and_deduction_type}}</td>
            <td data-toggle="modal" data-id="" type="number" data-target="#edit_hourly_sales">{{n.date}}</td>
            </tr>    
          </tbody>
          <tfoot>
         <tr>
            <th>Effective Date</th>
            <th>Tennat ID</th>
            <th>Tennant Name</th>
            <th>Type of Discounts and Deductions</th>
          </tr>
        </tfoot>
            </table>
            </div><!--end of class Discounts-->
          </div><!--end of outer cover dis-->

              </div><!--app-->
            </div><!--home-container-->
          </div><!--cover-->
        </div><!--Homepage-->
     
  <div id="edit_hourly_sales" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
         <h3>Discounts and Deductions</h3>

    </div>
    <div id="orderDetails" class="modal-body">
    <p>Tennat ID: <input type="text" name="tennat_id"></p>
    <p>Tennat Name: <input type="text" name="tennant_name"></p>
    <p>Type of Discounts and Deductions: <input type="text" name="discounts_and_deduction_type"></p>
    <p>Transaction Date: <input type="text" name="date"></p>
    
    </div>
    <div id="orderItems" class="modal-body"></div>
    <div class="modal-footer">
    <form method="POST" action="<?php echo site_url('tsms_controller/')?>" enctype="multipart/form-data">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Delete</button>
                <button type="submit" value="submit" class="btn btn-primary">Save changes</button>
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                </form>
         </div>
      </div>
    </div>
  </div> <!--Edit modal-->


     <div class="modal fade" id = "add_data">
            <div class="modal-dialog modal-md">
               <div class="modal-content">
                  <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
         <h3>Add Data</h3>

    </div>
<form action="" name="add_form" method="post">
    <div id="orderDetails" class="modal-body">
     <p>Tennat ID: <input type="text" name="tennant_id"></p>
    <p>Tennat Name: <input type="text" name="tennant_name"></p>
    <p>Discount and Deduction Type: <div class="col-md-5">
                                            <select
                                                class = "form-control" 
                                                name = "discount_deduction_types" 
                                                required
                                                ng-model=""
                                                id = "discount_deduction_types">
                                                <option value="" disabled="" selected="" style="display:none">Discount Type</option>
                                                <option>Senior Citizen</option>
                                                <option>Employee</option>
                                            
                                        </div> </p>
    <p>Transaction Date: <input type="text" name="date"></p>

    </div>
    <div id="orderItems" class="modal-body"></div>
    <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Clear</button>
                <button type="submit" value="submit" class="btn btn-primary">Save changes</button>
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                </form>
                  </div>
                </div>
              </div>
           </div><!--Add data modal-->