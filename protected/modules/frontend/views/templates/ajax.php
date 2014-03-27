<script type="text/javascript">
	$(window).ready(function(){
		$('.header-checkbox').on('click', function(){
			if ($(this).is(':checked')){
				$(this).parent('th').parent('tr').parent('thead').parent('table').find('tbody :checkbox').prop('checked', true);
			}else{
				$(this).parent('th').parent('tr').parent('thead').parent('table').find('tbody :checkbox').prop('checked', false);
			}
		});
		$('.discount').on('click', function(){
			
			if ($(this).is(':checked')){
				var count = parseInt($(this).parent('th').parent('tr').data('discounts'))+1;
				$(this).parent('th').parent('tr').data('discounts', count);
			}else{
				var count = parseInt($(this).parent('th').parent('tr').data('discounts'))-1;
				$(this).parent('th').parent('tr').data('discounts', count);
			}
			if (count > 1){
				$(this).parent('th').parent('tr').find('.discount').each(function(){
					if ($(this).is(":checked")){}else{
						$(this).prop('disabled', true);
					}
				});
			}else{
				$(this).parent('th').parent('tr').find('.discount').each(function(){
					$(this).prop('disabled', false);
				});
			}
		});
	});
</script>
<?php foreach ($search as $category){?>
	<div class="panel panel-default">
		<div class="panel-heading"><h4><?php echo $category['category']->title;?></h4></div>
		<div class="panel-body">
			<table class="table table-striped table-hover" style="width: 100%;">
			    <thead>
			        <tr class="discount-group" data-category="<?php echo $category['category']->id;?>" data-discounts="0">
			            <th><input type="checkbox" class="header-checkbox"/></th>
			            <th>Photo</th>
			            <th>Title</th>
			            <th>Price</th>
			            <?php if ($discounts){ ?>
			            	<?php foreach ($discounts as $discount => $value){?>
			            		<?php if ($value == 'true'){?>
			            			<th><input name="discounts[discount-<?php echo $category['category']->id?>-<?php echo $discount?>]" class="discount" type="checkbox"/> <?php echo (int)$discount/10;?>%</th>
			            		<?php }?>
			            	<?php }?>
			            <?php }?>
			        </tr>
			    </thead>
			    <tbody>
			        <?php foreach ($category['products'] as $p){?>
			            <tr>
			            	<td><input type="checkbox" class="product-checkbox" name="products[id<?php echo $p->id;?>]" value="<?php echo $p->id?>"/></td>
			                <td><img width="32px" height="32px" src="/public/products/<?php echo $p->photo?>"/></td>
			            	<td><?php echo $p->title;?></td>
			            	<td><?php echo $p->price;?>$</td>
				            <?php if ($discounts){ ?>
				            	<?php foreach ($discounts as $discount => $value){?>
				            		<?php if ($value == 'true'){?>
				            			<td><?php echo round(($p->price - ((int)$discount/1000)*$p->price),2);?>$</td>
				            		<?php }?>
				            	<?php }?>
				            <?php }?>
			            </tr>
			        <?php }?>
			    </tbody>
			</table>
		</div>
	</div>
<?php }?>