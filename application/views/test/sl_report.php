<div  ng-controller="testController" id="testController">
    

    <div class="">
        <div class="">
            <div class="well" ng-init="getInitialData()">

                <div class="col-sm-12" style="padding-top: 20px;">
                    <a href="<?=base_url('/cntrl_tsms/sl_report');?>" class="btn btn-success">All Entries</a>
                    <a href="<?=base_url('/cntrl_tsms/receivable_invoices');?>" class="btn btn-primary">Invoice Entries</a>
                    <a href="<?=base_url('/cntrl_tsms/payments_ledger');?>" class="btn btn-primary">Payment Entries</a>
                </div>
                <div class="container-fluid">



                    <div class="col-md-12" style="padding-top: 20px;">
                        <form ng-submit="getGlData($event, 'tracing_controller/get_sl_report_data')" class="row">
                            <div class="col-md-1" style="padding: 0;">
                                <label>Store:</label>
                                <select name="store" class="form-control" required="" style="padding: 0;">
                                    <option ng-value="s.store_code" ng-repeat="s in stores">{{s.store_code}}</option>
                                </select>
                            </div>
                            <div class="col-md-3" >
                                <label>GL Accounts:</label>
                                <!-- <select name="gl_ids[]" multiple="multiple" class="form-control">
                                    <option ng-value="acc.id" ng-repeat="acc in gl_accounts">{{acc.gl_account}}</option>
                                </select> -->

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
                                <label>Merge By:</label>
                                <select name="group_by" class="form-control">
                                    <option selected="" value="none">None</option>
                                    <option value="doc_no">Document No.</option>
                                </select>
                            </div>

                            <div class="col-md-1">
                                <label>CSV:</span></label> <br>
                                <input type="checkbox" name="csv" value="1" style="zoom: 1.5"> <span style="font-size: 13px; padding-bottom: 12px;">
                            </div>


                            <div class="col-md-1" style="padding: 0;">
                                <br> 

                                <button class="btn btn-primary" type="submit"> <i class="fa fa-search"> </i></button>
                            </div>
                        </form>
                        <br>
                        <?php load_view('test/table_view'); ?>
                        <!-- 
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
                                                <td align="right">{{(getColTotal(dt, 'credit') + getColTotal(dt, 'debit')) |numberFormat}}</td>
                                            </tr>
                                        </tbody>
                                        <tfoot class="bg-primary">
                                            <tr>
                                                <td>TOTAL</td>
                                                <td align="right">{{getRowsTotal(grouped_glData, 'debit')|numberFormat}}</td>
                                                <td align="right">{{getRowsTotal(grouped_glData, 'credit') | numberFormat}}</td>
                                                <td align="right">{{(getRowsTotal(grouped_glData, 'credit') + getRowsTotal(grouped_glData, 'debit')) | numberFormat}}</td>
                                            </tr>
                                        </tfoot>

                                    </table>
                                </div>
                            </div>
                         -->

                        <!-- 
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
                                                    <tr ng-if="groupedData.length == 0">
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
       
                                </div>
                            </div> 
                        -->

                        <!-- 
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
                                    ng-repeat="entries in groupArrayBy(gl_data, colGroup)"
                                    ng-if="showData == 'all' || 
                                        ((getColTotal(entries, 'debit') + getColTotal(entries, 'credit')) != 0 
                                            && showData == 'variance') || 
                                        ((getColTotal(entries, 'debit') + getColTotal(entries, 'credit')) == 0 
                                            && showData == 'balance')">

                                    <div class="panel panel-default">
                                        <div class="panel-heading"> 
                                            <h5 class="text-center">
                                                {{entries[0][colGroup]}} 
                                                <button class="pull-right" 
                                                    data-toggle="collapse" 
                                                    data-target="#collapse-{{entries[0][colGroup] | toKebabCase}}">
                                                    -
                                                </button>
                                            </h5> 
                                            
                                        </div>
                                        <div class="panel-body collapse" id="collapse-{{entries[0][colGroup] |toKebabCase}}" style="padding: 0px;">

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
                                                    <tr ng-repeat="(key, dt) in groupArrayByDate(entries,'posting_date', glAccGroup)">
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
                                                                    groupArrayByDate(entries,'posting_date', glAccGroup), 
                                                                    'debit'
                                                                ) | numberFormat
                                                            }}
                                                        </td>
                                                        <td align="right">
                                                            {{
                                                                getRowsTotal(
                                                                    groupArrayByDate(entries,'posting_date', glAccGroup), 'credit'
                                                                ) | numberFormat
                                                            }}
                                                        </td>
                                                        <td align="right">
                                                            {{
                                                                (getRowsTotal(
                                                                    groupArrayByDate(entries,'posting_date', glAccGroup), 'debit') + 
                                                                getRowsTotal(
                                                                    groupArrayByDate(entries,'posting_date', glAccGroup), 'credit'
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
                                                    <tr ng-repeat="data in entries">
                                                        
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
                                                    <tr ng-if="entries.length == 0">
                                                        <td colspan="100%" align="center">NO DATA FOUND!</td>
                                                    </tr>
                                                </tbody>
                                                <tfoot class="{{(getColTotal(entries, 'debit') + getColTotal(entries, 'credit')) != 0 ? 'bg-danger' : 'bg-primary'}}" ng-if="entries.length > 0">
                                                    <tr >
                                                        <td colspan="7" class="text-right">TOTAL</td>
                                                        <td align="right">{{getColTotal(entries, 'debit')|numberFormat}}</td>
                                                        <td align="right">{{getColTotal(entries, 'credit') | numberFormat}}</td>
                                                        <td align="right">{{ (getColTotal(entries, 'debit') + getColTotal(entries, 'credit')) | numberFormat}} {{ (getColTotal(entries, 'debit') + getColTotal(entries, 'credit')) != 0 ? '(Variance)' : ''}}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>


                                        
                                </div>
                            </div> 
                        -->

                        <!-- 
                            <div class="row" ng-if="gl_data">
                                <div class="col-md-12" ng-init="colGroup='ref_no'; showData = 'all'">
                                    <select ng-model="colGroup">
                                        <option value="doc_no">Document No.</option>
                                        <option value="ref_no">Reference No.</option>
                                    </select>

                                    <select ng-model="showData">
                                        <option value="all">All</option>
                                        <option value="variance">Variance</option>
                                        <option value="balance">Balance</option>
                                    </select>
                                </div>

                                <div class="col-md-12" 
                                    ng-repeat="groupedData in groupArrayBy(gl_data, colGroup)" 
                                    ng-if="showData == 'all' || 
                                        ((getColTotal(groupedData, 'debit') + getColTotal(groupedData, 'credit')) != 0 
                                            && showData == 'variance') || 
                                        ((getColTotal(groupedData, 'debit') + getColTotal(groupedData, 'credit')) == 0 
                                            && showData == 'balance')"
                                    >
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
                                            </tr>
                                            <tr ng-if="groupedData.length == 0">
                                                <td colspan="100%" align="center">NO DATA FOUND!</td>
                                            </tr>
                                        </tbody>
                                        <tfoot class="{{(getColTotal(groupedData, 'debit') + getColTotal(groupedData, 'credit')) != 0 ? 'bg-danger' : 'bg-primary'}}" ng-if="groupedData.length > 0">
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
                        -->
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
        $('.nav #sl-report').addClass('active');

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
