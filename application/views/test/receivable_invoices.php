<div  ng-controller="testController" id="testController">
    

    <div class="">
        <div class="">
            <div class="well" ng-init="getInitialData()">
                <div class="col-sm-12" style="padding-top: 20px;">
                    <a href="<?=base_url('/cntrl_tsms/sl_report');?>" class="btn btn-primary">All Entries</a>
                    <a href="<?=base_url('/cntrl_tsms/receivable_invoices');?>" class="btn btn-success">Invoice Entries</a>
                    <a href="<?=base_url('/cntrl_tsms/payments_ledger');?>" class="btn btn-primary">Payment Entries</a>
                </div>
                <div class="container-fluid">

                    <div class="col-md-12" style="padding-top: 20px;">
                        <form ng-submit="getGlData($event, 'tracing_controller/get_gl_receivable_invoices')" class="row">
                            <div class="col-md-3">
                                <select name="store" class="form-control" required="">
                                    <option ng-value="s.store_code" ng-repeat="s in stores">{{s.store_name}}</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label><input type="checkbox" name="gl_ids[0]" value="4">Rent Receivable</label><br>
                                <label><input type="checkbox" name="gl_ids[1]" value="22">A/R  Non Trade External</label><br>
                                <label><input type="checkbox" name="gl_ids[2]" value="29">A/R Non Trade Internal</label>
                            </div>

                            <div class="col-md-3">
                                <input type="text" name="post_date" class="form-control" placeholder="yyyy-mm-dd">
                            </div>

                            <div class="col-md-3">
                                <button class="btn btn-primary" type="submit"> <i class="fa fa-search"> </i></button>
                            </div>
                        </form>
                        <br>
                        <div class="row" ng-if="gl_data">

                            <div class="col-md-12">
                                <table class="table table-bordered" style="font-size: 11px !important;">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>GL Account</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                            <th>Total</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="(key, dt) in grouped_glData">
                                            <td align="left">{{key}}</td>
                                            <td align="right">{{getColTotal(dt, 'debit') | numberFormat}}</td>
                                            <td align="right">{{getColTotal(dt, 'credit') |numberFormat}}</td>
                                            <td align="right">{{(getColTotal(dt, 'debit') + getColTotal(dt, 'credit')) |numberFormat}}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="bg-primary">
                                        <tr>
                                            <td>TOTAL</td>
                                            <td align="right">{{getRowsTotal(grouped_glData, 'debit')|numberFormat}}</td>
                                            <td align="right">{{getRowsTotal(grouped_glData, 'credit') | numberFormat}}</td>
                                            <td align="right">{{(getRowsTotal(grouped_glData, 'debit') + getRowsTotal(grouped_glData, 'credit'))| numberFormat}}</td>
                                        </tr>
                                    </tfoot>

                                </table>
                            </div>
                        </div>

                        <div class="row" ng-if="gl_data">
                            <div class="col-md-12" ng-repeat="groupedData in groupArrayBy(gl_data, 'document_type')">

                                <div class="panel panel-default">
                                    <div class="panel-heading"> 
                                        <h4 class="text-center">
                                            {{groupedData[0].document_type}} 
                                            <button class="pull-right" 
                                                data-toggle="collapse" 
                                                data-target="#collapse-{{groupedData[0].document_type}}">
                                                -
                                            </button>
                                        </h4> 
                                        
                                    </div>
                                    <div class="panel-body collapse" id="collapse-{{groupedData[0].document_type}}" style="padding: 0px;">
                                        <table class="table table-bordered" style="font-size: 11px !important;">
                                            <thead>
                                                <tr class="bg-info">
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
                                                    <th>#</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="data in groupedData">
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
                                                    <td> <button type="button" class="btn" ng-click="copyToClipRow(data)"> <i class="fa fa-copy"></i></button></td>
                                                </tr>
                                                <tr ng-if="invoices.length == 0">
                                                    <td colspan="100%" align="center">NO DATA FOUND!</td>
                                                </tr>
                                            </tbody>
                                            <tfoot class="bg-info" ng-if="groupedData.length > 0">
                                                <tr >
                                                    <td>TOTAL</td>
                                                    <td colspan="6"></td> 
                                                    <td align="right">{{getColTotal(groupedData, 'debit')|numberFormat}}</td>
                                                    <td align="right">{{getColTotal(groupedData, 'credit') | numberFormat}}</td>
                                                    <td align="right">{{ (getColTotal(groupedData, 'debit') + getColTotal(groupedData, 'credit')) | numberFormat}}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                

                                <!-- <div id="demo" class="collapse">
                                Lorem ipsum dolor text....
                                </div> -->
                                
                            </div>
                        </div>

                        <div class="row" ng-if="gl_data">
                            <div class="col-md-12" ng-init="colGroup='doc_no'; showData = 'all'; glAccGroup='month'">
                                <select ng-model="colGroup">
                                    <option value="doc_no">Document No.</option>
                                    <option value="ref_no">Reference No.</option>
                                    <option value="gl_account">GL Account</option>
                                </select>

                                <select ng-model="showData">
                                    <option value="all">All</option>
                                    <option value="variance">Variance</option>
                                    <option value="balance">Balance</option>
                                </select>

                                <select ng-model="glAccGroup" ng-show="colGroup == 'gl_account'">
                                    <option value="none">None</option>
                                    <option value="month">Monthly</option>
                                    <option value="year">Yearly</option>
                                </select>
                            </div>
                            <div class="col-md-12" 
                                ng-repeat="invoices in groupArrayBy(gl_data, colGroup)"
                                ng-if="showData == 'all' || 
                                    ((getColTotal(invoices, 'debit') + getColTotal(invoices, 'credit')) != 0 
                                        && showData == 'variance') || 
                                    ((getColTotal(invoices, 'debit') + getColTotal(invoices, 'credit')) == 0 
                                        && showData == 'balance')">

                                <div class="panel panel-default">
                                    <div class="panel-heading"> 
                                        <h5 class="text-center">
                                            {{invoices[0][colGroup]}} 
                                            <button class="pull-right" 
                                                data-toggle="collapse" 
                                                data-target="#collapse-{{invoices[0][colGroup] | toKebabCase}}">
                                                -
                                            </button>
                                        </h5> 
                                        
                                    </div>
                                    <div class="panel-body collapse" id="collapse-{{invoices[0][colGroup] |toKebabCase}}" style="padding: 0px;">

                                        <table class="table table-bordered" 
                                            style="font-size: 11px !important;" 
                                            ng-if="glAccGroup != 'none' && colGroup == 'gl_account'">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Debit</th>
                                                    <th>Credit</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="(key, dt) in groupArrayByDate(invoices,'posting_date', glAccGroup)">
                                                    <td align="left">{{key}}</td>
                                                    <td align="right">{{getColTotal(dt, 'debit') | numberFormat}}</td>
                                                    <td align="right">{{getColTotal(dt, 'credit') |numberFormat}}</td>
                                                    <td align="right">
                                                        {{(getColTotal(dt, 'debit') + getColTotal(dt, 'credit')) |numberFormat}}
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot class="bg-primary">
                                                <tr>
                                                    <td>TOTAL</td>
                                                    <td align="right">
                                                        {{
                                                            getRowsTotal(
                                                                groupArrayByDate(invoices,'posting_date', glAccGroup), 
                                                                'debit'
                                                            ) | numberFormat
                                                        }}
                                                    </td>
                                                    <td align="right">
                                                        {{
                                                            getRowsTotal(
                                                                groupArrayByDate(invoices,'posting_date', glAccGroup), 'credit'
                                                            ) | numberFormat
                                                        }}
                                                    </td>
                                                    <td align="right">
                                                        {{
                                                            (getRowsTotal(
                                                                groupArrayByDate(invoices,'posting_date', glAccGroup), 'debit') + 
                                                            getRowsTotal(
                                                                groupArrayByDate(invoices,'posting_date', glAccGroup), 'credit'
                                                            ))| numberFormat
                                                        }}
                                                    </td>
                                                </tr>
                                            </tfoot>

                                        </table>


                                        <table class="table table-bordered table-responsive" style="font-size: 11px !important;" 
                                            ng-if="(colGroup != 'gl_account') ||  (glAccGroup == 'none' && colGroup == 'gl_account')">
                                            <thead class="bg-primary">
                                                <tr>
                                                    
                                                    <th>Posting Date</th>
                                                    <th>Doc. Type</th>
                                                    <th>Tenant Code</th>
                                                    <th>Trade Name</th>
                                                    <th>GL Account</th>
                                                    <th>Doc. No.</th>
                                                    <th>Ref. No.</th>
                                                    <th>Debit</th>
                                                    <th>Credit</th>
                                                    <th>Sub Total</th>
                                                    

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="data in invoices">
                                                    
                                                    <td>{{data.posting_date}}</td>
                                                    <td>{{data.document_type}}</td>
                                                    <td>{{data.tenant_id}}</td> 
                                                    <td align="left">{{data.trade_name}}</td> 
                                                    <td align="left">{{data.gl_account}}</td> 
                                                    <td>{{data.doc_no}}</td>
                                                    <td>{{data.ref_no}}</td>
                                                    <td align="right">{{data.debit |numberFormat}}</td>
                                                    <td align="right">{{data.credit  |numberFormat}}</td>
                                                    <td align="right">{{ toNumber(data.credit) + toNumber(data.debit)  |numberFormat}}</td>
                                                </tr>
                                                <tr ng-if="invoices.length == 0">
                                                    <td colspan="100%" align="center">NO DATA FOUND!</td>
                                                </tr>
                                            </tbody>
                                            <tfoot class="{{(getColTotal(invoices, 'debit') + getColTotal(invoices, 'credit')) != 0 ? 'bg-danger' : 'bg-primary'}}" ng-if="invoices.length > 0">
                                                <tr >
                                                    <td colspan="7" class="text-right">TOTAL</td>
                                                    <td align="right">{{getColTotal(invoices, 'debit')|numberFormat}}</td>
                                                    <td align="right">{{getColTotal(invoices, 'credit') | numberFormat}}</td>
                                                    <td align="right">{{ (getColTotal(invoices, 'debit') + getColTotal(invoices, 'credit')) | numberFormat}} {{ (getColTotal(invoices, 'debit') + getColTotal(invoices, 'credit')) != 0 ? '(Variance)' : ''}}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>


                                    
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
        $('.main-menu li').removeClass('active');
        $('.nav #invoices-ledger').addClass('active');
        
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
