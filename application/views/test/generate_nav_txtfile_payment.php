<div  ng-controller="testController" id="testController">
    

    <div class="container">
        <div class="">
            <div class="well" 
                ng-init="getGLAccounts('payment'); 
                getStores($base_url+'tracing_controller/get_stores'); 
                entries = []">
                <div class="container-fluid">
                    <div class="col-sm-12" style="padding-top: 20px;">
                        <a href="<?=base_url('cntrl_tsms/generate_nav_txtfile/invoice');?>" class="btn btn-primary">Invoice</a>
                        <a href="<?=base_url('cntrl_tsms/generate_nav_txtfile/payment');?>" class="btn btn-success">Payment</a>
                    </div>

                    <div class="col-md-12" style="padding-top: 20px;">

                        <div class="panel panel-default">
                            <div class="panel-heading">Payments Textfile for Nav</div>
                            <div class="panel-body">
                                <form method="post" accept-charset="utf-8" action="{{$base_url+ 'tracing_controller/gen_nav_payment_txtfile'}}">

                                    <div class="col-sm-12" style="padding: 0;">
                                        <div class="col-md-3">
                                            <label>Store:</label>
                                            <select name="store" class="form-control" required="" ng-model="store">
                                                <option ng-value="s.store_code" ng-repeat="s in stores">{{s.store_name}}</option>
                                            </select>
                                        </div>

                                        <div class="col-md-5">
                                            <label>Document No.:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" ng-model="doc_nos">
                                                <span class="input-group-btn">
                                                    <button  type="button" 
                                                        class="btn btn-primary btn-md" 
                                                        style="height: 34px;"
                                                        ng-click="getPaymentsByDocNos({store, doc_nos})">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <button type="button"
                                                ng-click="entries.push({
                                                    gl_accountID    : '', 
                                                    doc_no          : '', 
                                                    posting_date    : '', 
                                                    bank_code       : '', 
                                                    amount          : ''
                                                });"
                                                class="btn btn-info" 
                                                style="margin-top: 25px;">
                                                <i class="fa fa-plus"></i>
                                            </button>

                                            <button 
                                                class="btn btn-danger" 
                                                style="margin-top: 25px;" 
                                                type="button"
                                                ng-click="entries = [{
                                                    gl_accountID    : '', 
                                                    doc_no          : '', 
                                                    posting_date    : '', 
                                                    bank_code       : '', 
                                                    amount          : ''
                                                }]">  Clear</button>
                                        </div>
     
                                        <div class="col-md-2">
                                            <button class="btn btn-lg btn-primary pull-right" style="margin-top: 5px;">  Generate</button>
                                        </div>
                                    </div>

    

                                    <div class="col-sm-12" style="padding: 0;" ng-repeat="entry in entries">

                                        <div class="col-md-3">
                                            <label>GL Account:</label>

                                             <select name="entries[{{$index}}][gl_accountID]" 
                                                class="form-control" 
                                                ng-options="acc.id as acc.gl_account for acc in gl_accounts"
                                                ng-model="entry.gl_accountID"  
                                                required="" 
                                                ng-model-options="{ debounce: 300 }"> 
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <label>Doc No:</label>
                                            <input type="text" 
                                                name="entries[{{$index}}][doc_no]" 
                                                class="form-control" 
                                                ng-model="entry.doc_no">
                                        </div>
                                        
                                        <div class="col-md-2">
                                            <label>Posting Date:</label>
                                            <input type="date" 
                                                name="entries[{{$index}}][posting_date]" 
                                                class="form-control" 
                                                ng-value="entry.posting_date">
                                        </div>

                                         <div class="col-md-2"> 
                                            <label>Bank Code: </label>
                                            <input type="text" 
                                                name="entries[{{$index}}][bank_code]" 
                                                class="form-control"
                                                ng-model="entry.bank_code">
                                        </div>

                                        <div class="col-md-2">
                                            <label>Amount:</label>
                                            <input 
                                                type="text"
                                                step=".01" 
                                                class="form-control text-right text-bold"
                                                ng-model="entry.amount"
                                                required=""
                                                style="font-weight: bold;">
                                            <input type="hidden" name="entries[{{$index}}][amount]" ng-value="entry.amount">
                                        </div>


                                        <div class="col-md-1">
                                            <button type="button"
                                                ng-if="entries.length > 1"
                                                ng-click="entries.splice($index, 1);"
                                                class="btn btn-danger" 
                                                style="margin-top: 25px;">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-sm-12" style="padding: 0;" ng-if="entries.length > 0">
                                        <div class="col-md-1 text-right">
                                            <label style="font-size: 20px; margin-top: 15px;">DEBIT:</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" 
                                                disabled="" 
                                                class="form-control text-right" 
                                                style="margin-top: 10px; font-weight: bold;"
                                                ng-value="getColPosTotal(entries, 'amount') | currency : ''">
                                        </div>

                                        <div class="col-md-2 text-right">
                                            <label style="font-size: 20px; margin-top: 15px;">CREDIT:</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" 
                                                disabled="" 
                                                class="form-control text-right" 
                                                style="margin-top: 10px; font-weight: bold;"
                                                ng-value="getColNegTotal(entries, 'amount') | currency : ''">
                                        </div>

                                        <div class="col-md-2 text-right">
                                            <label style="font-size: 20px; margin-top: 15px;">VARIANCE:</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" 
                                                disabled="" 
                                                class="form-control text-right" 
                                                style="margin-top: 10px; font-weight: bold;"
                                                ng-value="getColTotal(entries, 'amount') | currency : ''">
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <div class="panel-footer text-info">Generates for manual amount of specified GL Account only (For Navision entry).</div>
                        </div>

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
        $('.nav #generate-txtfile').addClass('active');

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
