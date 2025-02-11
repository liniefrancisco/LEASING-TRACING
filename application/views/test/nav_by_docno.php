<div  ng-controller="testController" id="testController">
    

    <div class="">
        <div class="">
        
            <div class="well" ng-init="getInitialData()">

                <div class="container-fluid">

                    <div class="col-md-12" style="padding-top: 20px;">
                        <form ng-submit="getGlData($event, 'tracing_controller/navigate_per_doc_no')" class="row">
                            <div class="col-md-2" style="padding: 0;">
                                <label>Store:</label>
                                <select name="store" class="form-control" required="" style="padding: 0;">
                                    <option selected=""></option>
                                    option
                                    <option ng-value="s.store_code" ng-repeat="s in stores">{{s.store_name}}</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label>Doc Nos. ( comma [ , ] separator ):</label>
                                <input type="text" name="doc_nos" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label>Merge By:</label>
                                <select name="group_by" class="form-control">
                                    <option selected="" value="none">None</option>
                                    <option value="doc_no">Document No.</option>
                                </select>
                            </div>

                            <div class="col-md-1">
                                <label style="padding: 19px 0;"></label>
                                <button class="btn btn-primary" type="submit"> <i class="fa fa-search"> </i></button>
                            </div>
                        </form>
                        <br>

                        <?php load_view('test/table_view'); ?>


                        <!-- <div class="row" ng-if="gl_data">
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
                                        <tr ng-if="invoices.length == 0">
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
                        </div> -->
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
        $('.nav #nav-docno').addClass('active');

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
