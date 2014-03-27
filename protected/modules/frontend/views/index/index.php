<h1>Dashboard</h1>
<div class="row">
	<div class="col-lg-4">
	    <h3>Pending Orders</h3>
	</div>
	<div class="col-lg-4">
	    <h3>Last Visited Stores</h3>
	    <ul>
		    <?php if ($contact_logs){?>
		    	<?php foreach ($contact_logs as $log){?>
		    		<?php $store = Distributors::model()->findByPk($log->distributor_id);?>
		    		<?php $user = User::model()->findByPk($log->user_id);?>
		    		<?php $days = round((time() - strtotime($log->log_date))/(3600*24));?>
		    		<?php if ($days == 0){
		    			$days = 'today';
		    		}elseif ($days == 1){
		    			$days = 'yesterday';
		    		}else{
		    			$days = $days . ' ago';
		    		}?>
		    		<li>
		    			<a href="/distributors/view/<?php echo $store->id?>"><?php echo $store->title?></a> by <a href="/users/profile/<?php echo $user->id?>"><?php echo $user->fname . ' ' . $user->lname?></a> <?php echo $days;?>.
		    		</li>
		    	<?php }?>
		    <?php }?>
	    </ul>
	</div>
	<div class="col-lg-4">
	    <h3>Alerts</h3>
	</div>
</div>