<div class="col-lg-12"><h1>Order #<?php echo $order->id?> Details</h1></div>
<form class="form" action="/orders/submit" role="form" method="POST">
	<div id="step1">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-5 col-sm-12">
					<div class="form-group">
						<label class="control-label" for="inputName">Store Name</label>
						<div class="controls">
							<input class="form-control" name="data[store_title]" type="text" id="inputName" value="<?php echo $distributor->title;?>" disabled="disabled">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label" for="inputTemplate">Used Template</label>
						<div class="controls">
							<?php $template = Templates::model()->findByPk($order->template_id)?>
							<input class="form-control" name="data[template_title]" type="text" id="inputTemplate" value="<?php echo $template->title;?>" disabled="disabled">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12">
			<div id="products">
				<?php 
					$settings = CJSON::decode($template->settings);
					?>
					<table class="table table-striped table-hover">
					    <thead>
					    <tr>
					        <th>Photo</th>
					        <th>Title</th>
					        <th>Promo</th>
					        <th>Pickups</th>
					        <th>Quantity</th>
					        <th>Base Price</th>
					        <th>Total</th>
					    </tr>
					    </thead>
					    <tbody>
					    <?php if ($orderQ){?>
					        <?php foreach ($orderQ as $quantity){?>
					            <?php $product_description = Products::model()->findByPk($quantity->product_id);?>
					            <tr>
					                <td><img width="32px" height="32px" src="/public/products/<?php echo $product_description->photo?>"/></td>
					                <td><?php echo $product_description->title?></td>
					                <td><?php echo $quantity->promo?></td>
					                <td><?php echo $quantity->pickup?></td>
					                <td><?php echo $quantity->quantity?></td>
					                <td>$<?php echo $product_description->price?></td>
					                <td>$
					                	<?php
					                		if ($quantity->quantity < 2){
					                			$price = $quantity->quantity * $product_description->price;
					                		}elseif($quantity->quantity > 1 && $quantity->quantity <6){
					                			$price = round($quantity->quantity * ($product_description->price - ($settings[$product_description->category_id][0]/1000)*$product_description->price),2);
					                		}else{
					                			$price = round($quantity->quantity * ($product_description->price - ($settings[$product_description->category_id][1]/1000)*$product_description->price),2);
					                		}
					                		echo $price;
					                	?>
					                </td>
					            </tr>
					        <?php }?>
					        	<tr>
					        		<td colspan="7" class="text-right"><strong>Final: $<?php echo $order->total?></strong></td>
					        	</tr>
					    <?php }?>
					    </tbody>
					</table>
			</div>
			<button type="submit" class="btn btn-success">Confirm Order</button> <a href="/orders/edit/<?php echo $order->id?>" class="btn btn-default">Edit Order</a>
		</div>
	</div>
</form>