
<div class="container">
  	<div class="cover">
    		<div class="panel panel-default">
    			 <div class="panel-heading"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Upload Data </div>
    		</div>
    		<div class="well">
      			<div class="upload-control">
                <div class="col-md-2 pull-right">
                	  <input ng-model="searchText" class="form-control search-query" placeholder="Search Here..."/>
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
    		                <option id="long_term_tenants" name="long_term_tenants">Long Term Tenants</option>
    		                <option id="short_term_tenants">Short Term Tenants</option>
  		                </select>
  		              </div>
  		        	</div>
      		      <div class="form-group">
      		          <div class="col-md-2">
      		              <select
        		                class = "form-control" 
        		                name = "trade_name" 
        		                required
        		                id = "trade_name">
        		                <option ng-repeat = "tenant in tenantlist">{{tenant.trade_name}}</option>
      		              </select>
      		          </div>
      		    	</div>
      			</div><!--end of upload-control-->
      			<div class="left">
      				<div class="well">
      				  	<div class="upload-table-status">
      				   		<table class="table table-bordered">
      				        <thead>
      				          <tr>
      				            <th style="text-align: center;">Tennant Name</th>
      				            <th style="text-align: center;">Upload Status</th>
      				          </tr>
      				        </thead>
      				        <tbody>
      				          <tr ng-repeat="n in list_data">
      				            <td>{{n.sales_type}}</td>
      				            <td>{{n.control_num}}</td>
      				            </tr>    
      				          </tbody>
      				        </table> 
      				    </div>
      				</div>
      			</div><!--end of left-->
    			<div class="right">   
        			<div class="image-container">
    		          <div class="form-group">
    		              <div class="col-md-6">
    		                  <div class="hourly-image">
        		                  <a class="hovertext" title="Upload Hourly Sales" name="uploadfile" id="uploadfile" data-toggle="modal"  href="#upload_hourly_sales">
        		                  <img height="230px" width="250px" class="thumbnail thumbnail-menu" src="<?php echo base_url(); ?>img/download.png" alt="Upload Hourly Sales"></a>
    		                 </div>
    		              </div>
    		          </div>
    		          <div class="form-group">
    		              <div class="col-md-2">
    		                  <div class="daily-image">
    		                      <a class="hovertext" title="Upload Daily Sales" name="uploadfile" id="uploadfile" data-toggle="modal"  href="#upload_daily_sales">
    		                      <img height="230px" width="250px" class="thumbnail thumbnail-menu" src="<?php echo base_url(); ?>img/download.png" alt="Upload Daily Sales"></a>
    		                  </div>
    		              </div>
    		          </div>
              </div>
          </div><!--end of right-->
      	</div><!--den of well-->
  	</div><!--end of cover-->
</div><!--end of container-->

<!--Hourlysales modal-->
<div class="modal fade" id = "upload_hourly_sales">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-upload"></i> Upload Hourly Sales</h4>
        </div>
            <div class="modal-body">
                <div class="well">
                    <form method="post" action="<?php echo site_url('upload/upload_hourly_sales');?>" enctype="multipart/form-data" name="upload" id="form_upload">
                        <div class="upload_form">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                  <select
                                                    class = "form-control" 
                                                    name = "tenant_list"
                                                    ng-model="tenant_list" 
                                                    required
                                                    id = "tenant_list1"
                                                    ng-change="getTenants('<?php echo base_url(); ?>index.php/tsms_controller/get_tenants/' + tenant_list)">
                                                    <option id="" disabled="" selected="" style="display:none" >Tenant Type</option>
                                                    <option id="long_term_tenants" name="long_term_tenants">Long Term Tenants</option>
                                                    <option id="short_term_tenants">Short Term Tenants</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-8">
                                                  <select
                                                  class = "form-control" 
                                                  name = "trade_name" 
                                                  required
                                                  id = "trade_name">
                                                  <option ng-repeat = "tenant in tenantlist">{{tenant.trade_name}}</option>
                                                  </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--half-->
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                  <select
                                                  class = "form-control" 
                                                  name = "rental_type" 
                                                  required
                                                  id = "rental_type">
                                                  <option value="" disabled="" selected="" style="display:none">Rental Type</option>
                                                  <option>Percentage</option>
                                                  <option>Fixed plus Percentage</option>
                                                  <option>Fixed Percentage w/c is higher</option>
                                                  </select>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <input type="file" name="file[]" id="file" multiple>
                                                    <br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--end of div row-->
                            </div><!--end of col-md-12-->                         
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="btn-upload" value="Upload" id="btn-upload" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class=" fa fa-close"></i> Cancel</button>
                        </div>
                    </form>
                </div>
            </div>                       
        </div>
    </div>
</div><!--end of Hourlysales modal-->

<!--daily modal-->
<div class="modal fade" id = "upload_daily_sales">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-upload"></i> Upload Daily Sales</h4>
        </div>
            <div class="modal-body">
                <div class="well">
                    <form method="post" action="<?php echo site_url('upload/upload_daily_sales');?>" enctype="multipart/form-data" name="upload" id="form_upload">
                        <div class="upload_form">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                  <select
                                                  class = "form-control" 
                                                  name = "tenant_list"
                                                  ng-model="tenant_list" 
                                                  required
                                                  id = "tenant_list"
                                                  ng-change="getTenants('<?php echo base_url(); ?>index.php/tsms_controller/get_tenants/' + tenant_list)">
                                                  <option id="" disabled="" selected="" style="display:none" >Tenant Type</option>
                                                  <option id="long_term_tenants" name="long_term_tenants">Long Term Tenants</option>
                                                  <option id="short_term_tenants">Short Term Tenants</option>
                                                  </select>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-8">
                                                  <select
                                                  class = "form-control" 
                                                  name = "trade_name" 
                                                  required
                                                  id = "trade_name">
                                                  <option ng-repeat = "tenant in tenantlist">{{tenant.trade_name}}</option>
                                                  </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--half-->
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                  <select
                                                  class = "form-control" 
                                                  name = "rental_type" 
                                                  required
                                                  id = "rental_type">
                                                  <option value="" disabled="" selected="" style="display:none">Rental Type</option>
                                                  <option>Percentage</option>
                                                  <option>Fixed plus Percentage</option>
                                                  <option>Fixed Percentage w/c is higher</option>
                                                  </select>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <input type="file" name="file[]" id="file" multiple>
                                                    <br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--end of div row-->
                            </div><!--end of col-md-12-->                         
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="btn-upload" value="Upload" id="btn-upload" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class=" fa fa-close"></i> Cancel</button>
                        </div>
                    </form>
                </div>
            </div>                       
        </div>
    </div>
</div><!--end of Hourlysales modal-->