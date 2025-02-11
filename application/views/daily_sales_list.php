<h1>Orders</h1>

<table class="table table-striped"> <thead>
    <tr>
        <th>ID</th>
        <th>Customer</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
        <tr data-toggle="modal" data-id="1" data-target="#orderModal">
            <td>1</td>
            <td>24234234</td>
            <td>A</td>
        </tr>
        <tr data-toggle="modal" data-id="2" data-target="#orderModal">
            <td>2</td>
            <td>24234234</td>
            <td>A</td>
        </tr>
        <tr data-toggle="modal" data-id="3" data-target="#orderModal">
            <td>3</td>
            <td>24234234</td>
            <td>A</td>
        </tr>
    </tbody>
</table>
<div id="orderModal" class="modal hide fade" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
         <h3>Order</h3>

    </div>
    <div id="orderDetails" class="modal-body"></div>
    <div id="orderItems" class="modal-body"></div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    </div>
</div>