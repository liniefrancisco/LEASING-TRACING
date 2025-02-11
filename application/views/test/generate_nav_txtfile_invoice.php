<div  ng-controller="testController" id="testController">
    

    <div class="container">
        <div class="">
            <div class="well" 
                ng-init="getGLAccounts('invoice'); 
                getStores($base_url+'tracing_controller/get_stores'); 
                entries = [{account_id: '', amount: ''}]">
                <div class="container-fluid">
                    <div class="col-sm-12" style="padding-top: 20px;">
                        <a href="<?=base_url('cntrl_tsms/generate_nav_txtfile/invoice');?>" class="btn  btn-success ">Invoice</a>
                        <a href="<?=base_url('cntrl_tsms/generate_nav_txtfile/payment');?>" class="btn btn-primary">Payment</a>
                    </div>

                    <div class="col-md-12" style="padding-top: 20px;">

                        <div class="panel panel-default">
                            <div class="panel-heading">Invoice Textfile for Nav - Manual Input Amount</div>
                            <div class="panel-body">
                                <form method="post" accept-charset="utf-8" action="{{$base_url+ 'tracing_controller/gen_manual_nav_txtfile'}}">
                                    <div class="col-md-3">
                                        <label>Store:</label>
                                        <select name="store" class="form-control" required="">
                                            <option ng-value="s.store_code" ng-repeat="s in stores">{{s.store_name}}</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Date:</label>
                                        <input type="month" name="month" class="form-control" required="">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button"
                                            ng-click="entries.push({account_id: '', amount: ''});"
                                            class="btn btn-info" 
                                            style="margin-top: 25px;">
                                            <i class="fa fa-plus"></i>
                                        </button>

                                        <button 
                                            class="btn btn-danger" 
                                            style="margin-top: 25px;" 
                                            type="button"
                                            ng-click="entries = [{account_id: '', amount: ''}]">  Clear</button>
                                    </div>

                                    <div class="col-md-3">
                                        <button class="btn btn-lg btn-primary pull-right" style="margin-top: 5px;">  Generate</button>
                                    </div>


                                    <div class="col-sm-12" style="padding: 0;" ng-repeat="entry in entries">

                                        <div class="col-md-3">
                                            <label>GL Account:</label>
                                            <select name="entries[{{$index}}][gl_account_id]" 
                                                class="form-control" 
                                                ng-model="entry.account_id" 
                                                required="">
                                                <option ng-repeat="acc in gl_accounts" ng-value="acc.id">{{acc.gl_account}}</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label>Amount:</label>
                                            <input type="text" 
                                                class="form-control text-right text-bold"
                                                ng-model="entry.amount"
                                                required=""
                                                style="font-weight: bold;">
                                            <input type="hidden" name="entries[{{$index}}][amount]" ng-value="entry.amount">
                                        </div>

                                        <div class="col-md-3">
                                            <button type="button"
                                                ng-if="entries.length > 1"
                                                ng-click="entries.splice($index, 1);"
                                                class="btn btn-danger" 
                                                style="margin-top: 25px;">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-sm-12" style="padding: 0;">
                                        <div class="col-md-3 text-right">
                                            <label style="font-size: 20px; margin-top: 15px;">VARIANCE:</label>
                                        </div>
                                        <div class="col-md-3">
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
