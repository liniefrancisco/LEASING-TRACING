<div  ng-controller="testController" id="testController">
    

    <div class="">
        <div class="">
        
            <div class="well" ng-init="getInitialData()">
                <div class="col-sm-12" style="padding-top: 20px;">
                    <a href="<?=base_url('/cntrl_tsms/per_tenant');?>" class="btn btn-success">All Entries</a>
                    <a href="<?=base_url('/cntrl_tsms/per_tenant_invoices_ledger');?>" class="btn btn-primary">Invoice Entries</a>
                    <a href="<?=base_url('/cntrl_tsms/per_tenant_payment_ledger');?>" class="btn btn-primary">Payment Entries</a>
                </div>

                <div class="container-fluid">

                    <div class="col-md-12" style="padding-top: 20px;">
                        <form ng-submit="getGlData($event, 'tracing_controller/get_per_tenant_report')" class="row">
                            <div class="col-md-2">
                                <label>Tenant ID:</label>
                                <input type="text" name="tenant_id" class="form-control">
                            </div>
                            <div class="col-md-3" >
                                <label>GL Accounts:</label>
                                <div style="max-height: 100px; overflow-y: auto; background: #fff; padding: 0 5px;">
                                    <div ng-repeat="acc in gl_accounts">
                                        <label>
                                            <input type="checkbox" name="gl_ids[{{$index}}]" ng-value="acc.id"> {{acc.gl_account}}
                                        </label>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="col-md-2">
                                <label>Date From:</label>
                                <input type="date" name="date_from" class="form-control" placeholder="Date From" required="" value="2000-01-01">
                            </div>
                            <div class="col-md-2">
                                <label>Date To:</label>
                                <input type="date" name="date_to" class="form-control" placeholder="Date To" required="" value="<?=date('Y-m-d')?>">
                            </div>
                            <div class="col-md-2">
                                <div style="width: 125px; display: inline-block">
                                     <label>Merge By:</label>
                                    <select name="group_by" class="form-control">
                                        <option selected="" value="none">None</option>
                                        <option value="doc_no">Document No.</option>
                                    </select>
                                    
                                </div>
                                <div style="width: 50px; display: inline-block; margin-left: 5px;">
                                    <label>CSV:</span></label> <br>
                                    <input type="checkbox" name="csv" value="1" style="zoom: 1.5"> <span style="font-size: 13px; padding-bottom: 12px;">
                                    
                                </div>
                               
                            </div>

                            <div class="col-md-1">
                                <label style="padding: 19px 0;"></label>
                                <button class="btn btn-primary" type="submit"> <i class="fa fa-search"> </i></button>
                            </div>
                        </form>
                        <br>

                        <?php load_view('test/table_view'); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="loading-modal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <h1 class="text-center text-light wavy-loader" style="color: #fff !important; margin-top: 300px; font-weight: bold">
            Processing... Please wait...
        </h1>
      </div>
    </div>

</div>

<script>

    document.addEventListener("DOMContentLoaded", function(event) {

        $('.main-menu li').removeClass('active');
        $('.nav #per-tenant').addClass('active');

        $('#loading-modal').modal({
            backdrop : 'static',
            keyboard : false,
            show : false
        });


        $('#loading-modal').on('hidden.bs.modal', function (e) {
           angular.element($('#testController')).scope().progress = 0;
        })

        $('#addField').on('keyup', (event)=>{
            // Number 13 is the "Enter" key on the keyboard
            if (event.keyCode === 13) {
                event.preventDefault();
                // Trigger the button element with a click
                $('#add').click();
            }
        }).focus();


    });

    var abort = ()=>{
        throw new Error('This is not an error. This is just to abort javascript');
        console.clear();
    }

</script>
