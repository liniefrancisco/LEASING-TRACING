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
                                        <tr ng-repeat="(key, dt) in groupArrayBy(gl_data, 'description')">
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

                        <div class="row" ng-if="gl_data">
                            <div class="col-md-12" ng-repeat="groupedData in groupArrayBy(gl_data, 'document_type')">

                                <div class="panel panel-default">
                                    <div class="panel-heading"> 
                                        <h4 class="text-center">
                                            {{groupedData[0].document_type}} 
                                            <button class="pull-right" 
                                                data-toggle="collapse" 
                                                data-target="#collapse-{{groupedData[0].document_type | toKebabCase}}">
                                                -
                                            </button>
                                        </h4> 
                                        
                                    </div>
                                    <div class="panel-body collapse" id="collapse-{{groupedData[0].document_type | toKebabCase}}" style="padding: 0px;">
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
                                                    <td align="left">{{data.description}}</td> 
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
                            </div>
                        </div>

                        <div class="row" ng-if="gl_data">
                            <div class="col-md-12" ng-init="colGroup='doc_no'; showData = 'all'; glAccGroup='month'">
                                <select ng-model="colGroup">
                                    <option value="doc_no">Document No.</option>
                                    <option value="ref_no">Reference No.</option>
                                    <option value="description">Description</option>
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
                                    <div class="panel-heading"
                                        style="{{invoices[0].highlight ? 'background-color: #8bc34a; color: #000000' : ''; }}"> 
                                        <div class="text-center row" style="font-size: 13px; padding: 5px 10px;">

                                            <div class="{{colGroup == 'doc_no' ? 'col-md-3' : 'col-md-5' }} text-left bg-primary" style="padding-right: 30px;">
                                                {{entries[0][colGroup]}}
                                            </div>

                                            <div class="col-md-2 text-left bg-warning" ng-if="colGroup == 'doc_no'">
                                                    <div class="col-md-7" style="padding: 0 !important;">
                                                        Posting Date :
                                                    </div>
                                                    <div  class="col-md-5 text-right" style="padding: 0 !important;">
                                                        {{entries[0].posting_date}}
                                                    </div>
                                            </div>
                                            
                                            <div class="col-md-2 text-left bg-info">
                                                <div class="col-md-5" style="padding: 0 !important;">
                                                    Debit :
                                                </div>
                                                <div  class="col-md-7 text-right" style="padding: 0 !important;">
                                                    {{
                                                        getRowsTotal(
                                                            groupArrayByDate(entries,'posting_date', glAccGroup), 'debit'
                                                        ) | numberFormat
                                                    }}
                                                </div>
                                            </div>

                                            <div class="col-md-2 text-left bg-success">
                                               <div class="col-md-5" style="padding: 0 !important;">
                                                    Credit :
                                                </div>
                                                <div  class="col-md-7 text-right" style="padding: 0 !important;">
                                                    {{
                                                        getRowsTotal(
                                                            groupArrayByDate(entries,'posting_date', glAccGroup), 'credit'
                                                        ) | numberFormat
                                                    }}
                                                </div>
                                            </div>

                                            <div class="col-md-2 text-left bg-danger">
                                               <div class="col-md-5" style="padding: 0 !important;">
                                                    Variance :
                                                </div>
                                                <div  class="col-md-7 text-right" style="padding: 0 !important;">
                                                    {{
                                                        (getRowsTotal(
                                                            groupArrayByDate(entries,'posting_date', glAccGroup), 'debit') + 
                                                        getRowsTotal(
                                                            groupArrayByDate(entries,'posting_date', glAccGroup), 'credit'
                                                        ))| numberFormat
                                                    }}
                                                </div>
                                            </div>

                                            <div class="col-md-1 text-right">   
                                                <button
                                                    ng-click="invoices[0].highlight = (!invoices[0].highlight ? true : false)" 
                                                    style="padding-left: 2px; padding-right: 2px; margin-right: 3px; ">
                                                    <i class="fa fa-star"></i>
                                                </button>

                                                <button 
                                                    data-toggle="collapse" 
                                                    data-target="#collapse-{{entries[0][colGroup] | toKebabCase}}">
                                                    -
                                                </button>
                                            </div>
                                             
                                                
                                        </div> 
                                        
                                    </div>
                                    <div class="panel-body collapse" id="collapse-{{entries[0][colGroup] |toKebabCase}}" style="padding: 0px;">

                                        <table class="table table-bordered" 
                                            style="font-size: 11px !important;" 
                                            ng-if="(glAccGroup != 'none' && colGroup == 'gl_account') || 
                                                   (glAccGroup != 'none' && colGroup == 'description')">
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
                                            ng-if="(colGroup != 'gl_account') ||  (glAccGroup == 'none' && (colGroup == 'gl_account' || colGroup == 'description'))">
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
                                                    <td align="left">{{data.description}}</td> 
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