<?php
    $methods = array(
        1 => 'Visited',
        2 => 'Phoned',
        3 => 'Received a call from',
        4 => 'Cold Called'
    );
    $reasons = array(
        1 => 'Training & Merchandising',
        2 => 'Courtesy Call',
        3 => 'Returning Call',
        4 => 'Store phoned office',
        5 => 'Merchandising',
        6 => 'Other',
        7 => 'Cold Call',
        8 => 'Training'
    );
?>
<h1>Contact Logs List</h1>
<table class="table table-striped table-hover" style="width: 100%;">
    <thead>
    <tr>
    	<th>Status</th>
        <th>Date</th>
        <th>Store</th>
        <th>Representative</th>
        <th>Contact method</th>
        <th>Contact reason</th>
        <th>Comment</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php if ($contact_logs){?>
        <?php foreach ($contact_logs as $log){?>
            <tr>
            	<td>
                  <?php if($log->status == 1){
                      echo '<span class="label label-success">Published</span>';
                  }else{
                      echo '<span class="label">Draft</span>';
                  }
                  ?>
                </td>
                <td style="text-align: center;"><?php echo date("d", strtotime($log->log_date)); ?><br/><?php echo date("F ", strtotime($log->log_date)); ?><br/><?php echo date("Y ", strtotime($log->log_date)); ?></td>
                <td>
                	<?php $distributor = Distributors::model()->findByPk($log->distributor_id);?>                	
                	<a href="/distributors/view/<?php echo $log->distributor_id?>"><?php echo $distributor->title;?></a>
                </td>
                <td><a href="/users/profile/<?php echo $log->user_id?>"><?php echo $users[$log->user_id]; ?></a></td>
                <td><?php echo $methods[$log->contact_method]; ?></td>
                <td><?php echo $reasons[$log->contact_reason]; ?></td>
                <td><?php echo $log->contact_comment; ?></td>
                <td style="text-align: right;">
                    <div class="btn-group">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            Actions
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" style="text-align: left;">
                            <li><a href="/contact/view/<?php echo $log->id?>" id="view"><i class="icon-eye-open"></i> View</a></li>
                            <li><a href="/contact/edit/<?php echo $log->id?>" id="edit"><i class="icon-edit"></i> Edit</a></li>
                            <li><a href="/contact/delete/<?php echo $log->id?>" id="delete"><i class="icon-trash"></i> Delete</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        <?php }?>
    <?php }?>
    </tbody>
</table>