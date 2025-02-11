<section id="Homepage">
<div class="col-md-12">
                        <table class="table table-bordered" width="100%" ng-controller="tableController" ng-init="loadList('<?php echo base_url(); ?>index.php/main/add_users')">
                            <thead>
                                <tr>
                                    <th><a href="#" data-ng-click="sortField = 'name'; reverse = !reverse">Tenant Name</a></th>
                                    <th><a href="#" data-ng-click="sortField = 'username'; reverse = !reverse">Tenant Code</a></th>
                                    <th><a href="#" data-ng-click="sortField = 'user_type'; reverse = !reverse">Net Sales</a></th>
                                     <th><a href="#" data-ng-click="sortField = 'name'; reverse = !reverse">Gross Sales</a></th>
                                    <th><a href="#" data-ng-click="sortField = 'username'; reverse = !reverse">Date</a></th>
                                    <th><a href="#" data-ng-click="sortField = 'user_type'; reverse = !reverse">Discount</a></th>
                                
                                </tr>
								<tr>
                                   <td> </td>
                                   <td> </td>
                                   <td> </td>
                                   <td> </td>
                                   <td> </td>
                                   <td> </td>
                                
                                </tr>

                            </thead>
                            </table>
  </div>
                       
</section>