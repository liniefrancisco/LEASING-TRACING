<div class="container">
    <div class="cover">
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Upload Data 
                <div class="clock-home" style="float:right;" ng-controller="chartController">
                    <div class="dateTime pull-left ng-cloak" ng-init = "tick('<?php echo base_url(); ?>index.php/chart_controller/get_dateTime')">
                        <p>{{ clock  | date:'medium'}}</p>
                    </div>
                </div> 
            </div>
        </div>
        <div class="well">
        <div class="container-fluid">
            <div class="col-md-12" id="upload-status">
                <div class="left" ng-hide="daily_hide">
                    <div class="alert alert-info">
                        <strong>Info! </strong> List of tenants below are only Percentage Tenants.
                    </div>
                    <div class="panel panel-default" ng-hide="daily_hide">
                        <div class="panel-heading" id="heading-daily">Daily Upload Status </div>
                        <div class="panel-body">
                            <div class="table-responsive" id="table-upload">
                                <div class="upload-table-status" ng-init="tenants_daily('<?php echo base_url(); ?>index.php/tsms_controller/tenantList_daily/')">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">Tennant Name</th>
                                                <th style="text-align: center;">Tenant Code</th>
                                                <th style="text-align: center;">Last Upload</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="n in tenantListD">
                                                <td>{{n.trade_name}}</td>
                                                <td>{{n.location_code}}</td>
                                                <td>{{n.last_upload | date}}</td>
                                            </tr>    
                                        </tbody>          
                                    </table> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="right">
                    <div class="alert alert-info">
                        <strong>Info! </strong> Uploading should be done the day after the EOD report of the tenant is ready.
                    </div>
                    <div class="well col-md-12" style="text-align: center;">   
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="daily-image">
                                    <a class="hovertext" title="Upload Daily Sales" name="uploadfile" id="uploadfile" data-toggle="modal"  href="#upload_daily_sales">
                                    <label><h3>Click Here to Upload</h3></label>
                                    <img height="230px" width="250px" id="asd" class="thumbnail thumbnail-menu" src="<?php echo base_url(); ?>img/upload_hourly.png" alt="Upload Daily Sales"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<div class="loading-screen"></div>

<!--daily modal-->
<div class="modal fade" id = "upload_daily_sales">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-upload"></i> Match and Upload Text Files</h4>
            </div>
            <div class="modal-body">
                <div class="well">
                    <form  action="<?= base_url(); ?>index.php/upload/upload_multi_daily_sales/" ng-submit="uploadMultiSales($base_url + 'upload/upload_multi_daily_sales/', $event);" method="post" enctype="multipart/form-data" name="frm_upload" id="frm_upload" target="_blank">
                        <div class="upload_form">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-10">
                                                    <select
                                                    class = "form-control" 
                                                    name = "tenant_list"
                                                    ng-model="tenant_list" 
                                                    required
                                                    id = "tenant_list1"
                                                    ng-change="getTenants('<?php echo base_url(); ?>index.php/tsms_controller/get_tenants/' + tenant_list)">
                                                    <option class="placeholder" selected disabled value="">Select Type of Tenants</option>
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
                                                <div class="col-md-10">
                                                    <select
                                                    class = "form-control" 
                                                    name = "trade_name"
                                                    ng-model="trade_name" 
                                                    required
                                                    id = "trade_name"
                                                    ng-change="getLocation('<?php echo base_url(); ?>index.php/tsms_controller/get_location_code/' + trade_name)">
                                                    <option class="placeholder" selected disabled value="">Select Trade Name</option>
                                                    <option ng-repeat = "tenant in tenantlist">{{tenant.trade_name}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input type="text"
                                                    style="display: none;" 
                                                    class="form-control currency"
                                                    ng-model="location_code" 
                                                    name="location_code"
                                                    readonly="" 
                                                    >
                                                    <select 
                                                        class="form-control"
                                                        required=""
                                                        ng-model="location_code"
                                                        ng-options="l.location_code as l.location_code for l in locations">                
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--half-->
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-10">
                                                    <input type="text"
                                                    required
                                                    class="form-control currency"
                                                    id="rental_type"
                                                    ng-model="rental_type" 
                                                    name="rental_type"
                                                    readonly
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--end of div row-->
                            </div><!--end of col-md-12-->                         
                        </div> <!-- upload-form -->
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-12 text-right">
                                        <span style="position: absolute; left: 25px;"> <b>{{textFiles.length}} files selected </b> </span>
                                        <input type="file" id="files" onchange="addFiles(this)" multiple="" class="input-file" style="display: none;">
                                        <button type="button" ng-if="textFiles.length > 0" class="btn btn-md btn-gray" ng-click="clearFiles()"> <i class="fa fa-trash"></i> Remove</button>
                                        <button type="button" class="btn btn-md btn-primary" onclick="$('#files').click()"> 
                                        <i class="fa fa-file-text" style="margin-right: 5px;"></i>  Browse Text Files</button>
                                        
                                    </div>
                                    <div class="col-md-12" style="max-height: 150px; overflow-x: auto;">

                                        <div  style="border: solid 1px #ccc; padding: 2px 5px; margin: 5px 2px; display: inline-block; border-radius: 3px;" ng-repeat="text in textFiles"> 
                                            {{text.name}}  
                                            <button ng-click="removeFile($index)" class="btn btn-sm" style="padding: 3px;" type="button"><i class="fa fa-times"></i>
                                            </button>
                                        </div> 
                                    </div>
                                    <div class="col-md-12">
                                        <p class="text-justify text-small text-info">
                                            Update! You can now upload multiple Sales textfile. Just click browse and select the text files.
                                        </p>
                                    </div>
                                    
                                </div>
                            </div>
                            <br>

                       
                            <!-- <div class="row">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label><h4>Daily text file</h4></label>
                                        <input type="file" name="files[]" multiple class="input-file" required="">
                                        <br>
                                    </div>
                                    <div class="col-md-6">
                                        <label><h4>Daily text file</h4></label>
                                        <input type="file" multiple class="input-file" required="">
                                        <br>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                       
                    </form>
                </div> <!-- well -->
            </div>
            <div class="modal-footer">
                <button type="submit" name="btn-upload" value="Upload" id="btn-upload" class="btn btn-primary" form="frm_upload"><i class="fa fa-upload"></i> Match and Upload</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class=" fa fa-close"></i> Close</button>
            </div>                    
        </div>
    </div>
</div>

<!--daily modal-->
<div class="modal fade" id = "result_dialog">
    <div class="modal-dialog modal-md" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-info"></i> Uploading Result</h4>
            </div>
            <div class="modal-body">
                <div class="well">
                    <h3 ng-class="[result.type != 'success' ? 'text-danger' : 'text-primary' ]"> {{result.msg}}</h3>
                    <table class="table table-sm">
                        <tbody>
                            <tr ng-if="result.errors && result.errors.length > 0">
                                <td align="left"> 
                                    <p>{{result.errors.length}} Error/s Found </p>
                                </td>
                                <td align="centert">
                                    <button class="btn btn-sm btn-info" style="padding: 2px !important;" ng-click="viewDetails(result.errors)"> details </button>
                                </td>
                            </tr>
                            <tr ng-if="result.success">
                                <td align="left"> 
                                    <p>{{result.success.length}} Textfile/s uploaded</p>
                                </td>
                                <td align="centert">
                                    <button class="btn btn-sm btn-info" style="padding: 2px !important;" ng-click="viewDetails(result.success)"> details </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div id="details" class="collapse" style="max-height: 250px !important; overflow-x: auto !important;">
                        <table class="table table-info table-sm" >
                            <thead>
                                <tr>
                                    <th class="text-left">File</th>
                                    <th class="text-left">Description</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="detail in details">
                                    <td align="left">{{detail.file}}</td>
                                    <td align="left">{{detail.description}}</td>
                                    <td align="center" ng-class="[detail.status && detail.status == 'Matched'? 'text-info' : 'text-danger']">{{detail.status ? detail.status : 'error' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div> <!-- well -->
            </div> 
            <div class="modal-footer">
                <button class="btn brn-default" data-dismiss="modal"> Close </button>
            </div>                     
        </div>
    </div>
</div>

<script>
    function addFiles(event){
        angular.element($('body')).scope().addFiles(event);
    }

    document.addEventListener("DOMContentLoaded", function(event) { 
        $("#result_dialog").on('hidden.bs.modal', function(){
           $('#details').collapse("hide");
        });
    });
    
</script>
