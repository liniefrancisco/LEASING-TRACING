<div  ng-controller="testController" id="testController">
    

    <div class="">
        <div class="">
            <div class="well" ng-init="getInitialData()">
                <div class="col-sm-12" style="padding-top: 20px;">
                    <a href="<?=base_url('/cntrl_tsms/sl_report');?>" class="btn btn-primary">All Entries</a>
                    <a href="<?=base_url('/cntrl_tsms/receivable_invoices');?>" class="btn btn-primary">Invoice Entries</a>
                    <a href="<?=base_url('/cntrl_tsms/payments_ledger');?>" class="btn btn-success">Payment Entries</a>
                </div>
                <div class="container-fluid">

                    <div class="col-md-12" style="padding-top: 20px;">
                        <form ng-submit="getGlData($event, 'tracing_controller/get_payments_ledger_data')" class="row">
                            <div class="col-md-3">
                                <select name="store" class="form-control" required="">
                                    <option ng-value="s.store_code" ng-repeat="s in stores">{{s.store_name}}</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="group_by" class="form-control">
                                    <option selected="" value="none">Merge By: None</option>
                                    <option value="doc_no">Merge By: Document No.</option>
                                </select>
                            </div>
                            <!-- <div class="col-md-3">
                                <label><input type="checkbox" name="gl_ids[0]" value="4">Rent Receivable</label><br>
                                <label><input type="checkbox" name="gl_ids[1]" value="22">A/R  Non Trade External</label><br>
                                <label><input type="checkbox" name="gl_ids[2]" value="29">A/R Non Trade Internal</label>
                            </div> -->

                            <div class="col-md-3">
                                <input type="text" name="post_date" class="form-control" placeholder="yyyy-mm-dd">
                            </div>

                            <div class="col-md-3">
                                <button class="btn btn-primary" type="submit"> <i class="fa fa-search"> </i></button>
                            </div>
                        </form>
                        <br>
                         <?php load_view('test/table_view'); ?>


                       
                    </div>
                    
                    <br><br>

                    <!-- <div class="col-md-12" ng-if="gl_matches">
                        <h3 class="text-center">MATCHES 
                            <span  style="position: absolute; right: 15px;">
                                <span class="badge badge-primary" style="padding: 10px 20px; display: none" id="copiedToClipText">
                                    DETAILS COPIED TO CLIPBOARD!
                                </span>
                                <button class="btn btn-primary" ng-click="copyToClip()" ng-disabled="gl_matches.length == 0"> 
                                    <i class="fa fa-copy"></i> Copy to Clipboard
                                </button>
                            </span>
                            
                        </h3>
                        <table class="table table-bordered">
                                <thead class="bg-primary">
                                    <tr>
                                        <th>ID</th>
                                        <th>Posting Date</th>
                                        <th>Tenant Code</th>
                                        <th>Trade Name</th>
                                        <th>Doc. No.</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Doc. Type</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="data in gl_matches">
                                        <td>{{data.id}}</td>
                                        <td>{{data.posting_date}}</td>
                                        <td>{{data.tenant_id}}</td> 
                                        <td align="left">{{data.trade_name}}</td> 
                                        <td>{{data.doc_no}}</td>
                                        <td align="right">{{data.debit |numberFormat}}</td>
                                        <td align="right">{{data.credit  |numberFormat}}</td>
                                        <td>{{data.doc_type}}</td>
                                    </tr>
                                    <tr ng-if="gl_matches.length == 0">
                                        <td colspan="100%" align="center">NO MATCHES FOUND!</td>
                                    </tr>
                                </tbody>
                                <tfoot class="bg-primary" ng-if="gl_matches.length > 0">
                                    <tr >
                                        <td>TOTAL</td>
                                        <td colspan="4"></td> 
                                        <td align="right">{{total_match_debit()|numberFormat}}</td>
                                        <td align="right">{{total_match_credit() | numberFormat}}</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                    </div> -->

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
        $('.nav #payments-ledger').addClass('active');

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
