<h1>Orders List</h1>
<table class="table table-striped table-hover" style="width: 100%;">
    <thead>
    <tr>
    	<th>Status</th>
        <th>Date</th>
        <th>Store</th>
        <th>Representative</th>
        <th>Total</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php if ($orders){?>
        <?php foreach ($orders as $order){?>
            <tr>
            	<td>
                  <?php if($order->status == 1){
                      echo '<span class="label label-success">Processed</span>';
                  }else{
                      echo '<span class="label label-info">Pending</span>';
                  }
                  ?>
                </td>
                <td style="text-align: left;"><?php echo date("d", strtotime($order->date)); ?> - <?php echo date("F ", strtotime($order->date)); ?> - <?php echo date("Y ", strtotime($order->date)); ?></td>
                <td>
                	<?php $distributor = Distributors::model()->findByPk($order->distributor_id);?>                	
                	<a href="/distributors/view/<?php echo $order->distributor_id?>"><?php echo $distributor->title;?></a>
                </td>
                <td><a href="/users/profile/<?php echo $order->user_id?>"><?php echo $users[$order->user_id]; ?></a></td>
                <td>$<?php echo $order->total?></td>
                <td style="text-align: right;">
                    <div class="btn-group">
                        <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">
                            Actions
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" style="text-align: left;">
                            <li><a href="/orders/view/<?php echo $order->id?>" id="view"><i class="icon-eye-open"></i> View</a></li>
                            <li><a href="/orders/delete/<?php echo $order->id?>" id="delete"><i class="icon-trash"></i> Delete</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        <?php }?>
    <?php }?>
    </tbody>
</table>