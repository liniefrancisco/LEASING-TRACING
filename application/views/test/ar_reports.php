<div  ng-controller="testController" id="testController">
    

    <div class="container">
        <div class="cover">
            <div class="well" ng-init="getInitialData()">
                <div class="container-fluid">

                    <div class="col-md-12" style="padding-top: 20px;">
                        <form ng-submit="getGlData($event, 'tracing_controller/get_other_charges_arnt')" class="row">
                            <div class="col-md-3">
                                <select name="store" class="form-control" required="">
                                    <option ng-value="s.store_code" ng-repeat="s in stores">{{s.store_name}}</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="post_date" class="form-control" required="" placeholder="yyyy-mm-dd">
                            </div>

                            <div class="col-md-3">
                                <button class="btn btn-primary" type="submit"> <i class="fa fa-search"> </i></button>
                            </div>
                        </form>
                        <br>
                        <div class="row" ng-if="gl_data">
                            <div class="col-md-12" ng-controller="mytablecontroller" >
                                <table class="table table-bordered" style="font-size: 11px !important;">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>GL Account</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="(key, dt) in groupArrayBy(gl_data, 'gl_account')">
                                            <td align="left">{{key}}</td>
                                            <td align="right">{{getColTotal(dt, 'debit') | numberFormat}}</td>
                                            <td align="right">{{getColTotal(dt, 'credit') |numberFormat}}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="bg-primary">
                                        <tr>
                                            <td>TOTAL</td>
                                            <td align="right">{{getColTotal(gl_data, 'debit')|numberFormat}}</td>
                                            <td align="right">{{getColTotal(gl_data, 'credit') | numberFormat}}</td>
                                        </tr>
                                    </tfoot>

                                </table>
                            </div>
                        </div>

                        <div class="row" ng-if="gl_data">
                            <div class="col-md-12" ng-repeat="invoices in groupArrayBy(gl_data, 'doc_no')">
                                <table class="table table-bordered" style="font-size: 11px !important;">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>ID</th>
                                            <th>Posting Date</th>
                                            <th>Tenant Code</th>
                                            <th>Trade Name</th>
                                            <th>GL Account</th>
                                            <th>Doc. No.</th>
                                            <th>Ref. No.</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                            <th>Doc. Type</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="data in invoices">
                                            <td>{{data.id}}</td>
                                            <td>{{data.posting_date}}</td>
                                            <td>{{data.tenant_id}}</td> 
                                            <td align="left">{{data.trade_name}}</td> 
                                            <td align="left">{{data.gl_account}}</td> 
                                            <td>{{data.doc_no}}</td>
                                            <td>{{data.ref_no}}</td>
                                            <td align="right">{{data.debit |numberFormat}}</td>
                                            <td align="right">{{data.credit  |numberFormat}}</td>
                                            <td>{{data.document_type}}</td>
                                        </tr>
                                        <tr ng-if="invoices.length == 0">
                                            <td colspan="100%" align="center">NO DATA FOUND!</td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="{{(getColTotal(invoices, 'debit') + getColTotal(invoices, 'credit')) != 0 ? 'bg-danger' : 'bg-primary'}}" ng-if="invoices.length > 0">
                                        <tr >
                                            <td>TOTAL</td>
                                            <td colspan="6"></td> 
                                            <td align="right">{{getColTotal(invoices, 'debit')|numberFormat}}</td>
                                            <td align="right">{{getColTotal(invoices, 'credit') | numberFormat}}</td>
                                            <td align="right">{{ (getColTotal(invoices, 'debit') + getColTotal(invoices, 'credit')) | numberFormat}}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <!-- <div class="row" ng-show="gl_data && gl_data.length > 0" style="padding-bottom: 20px;">
                            <div class="col-md-3">
                                <input type="number" class="form-control" placeholder="Find Sum" ng-model="search">
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" ng-model="lookIn">
                                    <option selected disabled="">Lookup In</option>
                                    <option value="debit">Debit</option>
                                    <option value="credit">Credit</option>
                                    option
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="checkbox" ng-model="fastMode" style="zoom: 2.5; margin: 0; padding: 0px;"> 
                                <span style="font-size: 15px; font-weight: bold; position: absolute; top: 3px;">FAST MODE</span>
                            </div>
                            <div class="col-md-2">
                                <input type="number" ng-model="max_variance_allowed" class="form-control" placeholder="Max Variance Allowed"> 
                            </div>
                            
                            <div class="col-md-2">
                                <button type="button" ng-disabled="!lookIn || search.length == 0 || max_variance_allowed.length == 0" class="btn btn-primary" ng-click="lookup()"> <i class="fa fa-search"></i> LOOKUP</button>
                            </div>
                        </div> -->
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
