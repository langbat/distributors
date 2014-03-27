<?php 
$settings = CJSON::decode($template->settings);
?>
<script type="text/javascript">
    $(window).ready(function(){
        $('.quantity-input').keyup(function(e){
            var value = $(this).val();

            if (value < 1){
                $(this).parent('td').parent('tr').find('.total').html(0);

                $(this).parent('td').parent('tr').find('.base-price').parent('td').removeClass('text-muted').addClass('text-danger');
                $(this).parent('td').parent('tr').find('.discount1').parent('td').removeClass('text-danger').addClass('text-muted');
                $(this).parent('td').parent('tr').find('.discount1').parent('td').removeClass('text-danger').addClass('text-muted');
            }else if(value < 2 && value > 0){
                var price = $(this).data('price');
                $(this).parent('td').parent('tr').find('.total').html(price);

                $(this).parent('td').parent('tr').find('.base-price').parent('td').removeClass('text-muted').addClass('text-danger');
                $(this).parent('td').parent('tr').find('.discount1').parent('td').removeClass('text-danger').addClass('text-muted');
                $(this).parent('td').parent('tr').find('.discount1').parent('td').removeClass('text-danger').addClass('text-muted');
            }else if (value > 1 && value < 6){
                var price = parseFloat($(this).parent('td').parent('tr').find('.discount1').html());
                $(this).parent('td').parent('tr').find('.total').html((price*value).toFixed(2));

                $(this).parent('td').parent('tr').find('.discount1').parent('td').removeClass('text-muted').addClass('text-danger');
                $(this).parent('td').parent('tr').find('.base-price').parent('td').removeClass('text-danger').addClass('text-muted');
                $(this).parent('td').parent('tr').find('.discount2').parent('td').removeClass('text-danger').addClass('text-muted');
            }else{
                var price = parseFloat($(this).parent('td').parent('tr').find('.discount2').html());
                $(this).parent('td').parent('tr').find('.total').html((price*value).toFixed(2));
                
                $(this).parent('td').parent('tr').find('.discount2').parent('td').removeClass('text-muted').addClass('text-danger');
                $(this).parent('td').parent('tr').find('.base-price').parent('td').removeClass('text-danger').addClass('text-muted');
                $(this).parent('td').parent('tr').find('.discount1').parent('td').removeClass('text-danger').addClass('text-muted');
            }
            var total = 0;
            $('.total').each(function(index){
                total = total + parseFloat($(this).html());
            });
            $('#final').html(total.toFixed(2));
            $('#final-input').val(total.toFixed(2));
        });

        $('.type-select').on('change', function(){
            if ($(this).val() == 1 || $(this).val() == 2){
                $(this).parent('td').parent('tr').find('type-quantity').prop('disabled', false);
            }else{
                $(this).parent('td').parent('tr').find('type-quantity').prop('disabled', true);
            }
        });
    });
</script>
<table class="table table-striped table-hover" id="order">
    <thead>
    <tr>
        <th>Photo</th>
        <th>Title</th>
        <th class="text-center" style="width: 70px">Promo<br/><small style="font-size: 9px;" class="text-muted">units</small></th>
        <th class="text-center" style="width: 70px">Pickup<br/><small style="font-size: 9px;" class="text-muted">units</small></th>
        <th class="text-center" style="width: 70px">Order<br/><small style="font-size: 9px;" class="text-muted">inner qty</small></th>
        <th>Base Price</th>
        <th>Discount 1</th>
        <th>Discount 2</th>
        <th class="text-right">Total</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($products){?>
        <?php foreach ($products as $product){?>
            <?php $product_description = Products::model()->findByPk($product->product_id);?>
            <tr>
                <td><img width="32px" height="32px" src="/public/products/<?php echo $product_description->photo?>"/></td>
                <td><?php echo $product_description->title?></td>
                <td class="text-center"><input value="0" name="promo[<?php echo $product_description->id?>]" style="width:50px" type="text" class="form-control text-center promo-quantity"/></td>
                <td class="text-center"><input value="0" name="pickup[<?php echo $product_description->id?>]" style="width:50px" type="text" class="form-control text-center pickup-quantity"/></td>
                <td class="text-center"><input data-price="<?php echo $product_description->price?>" value="0" name="products[<?php echo $product_description->id?>]" style="width:50px" type="text" class="form-control text-center quantity-input"/></td>
                <td class="text-danger">$<span class="base-price"><?php echo $product_description->price?></span></td>
                <td class="text-muted">$<span class="discount1"><?php echo round(($product_description->price - ($product_description->price * ($settings[$product_description->category_id][0]/1000))),2);?></span> <span class="discount-value1" data-discount="<?php echo $settings[$product_description->category_id][0]/10?>" style="font-size: 9px" class="text-muted"><?php echo $settings[$product_description->category_id][0]/10?>%</span></td>
                <td class="text-muted">$<span class="discount2"><?php echo round(($product_description->price - ($product_description->price * ($settings[$product_description->category_id][1]/1000))),2);?></span> <span class="discount-value2" data-discount="<?php echo $settings[$product_description->category_id][1]/10?>" style="font-size: 9px" class="text-muted"><?php echo $settings[$product_description->category_id][1]/10?>%</span></td>
                <td class="text-right">$<span class="total">0</span></td>
            </tr>
        <?php }?>
            <tr>
                <td colspan="9" class="text-right">
                    <strong>Total: $<span id="final">0</span></strong>
                    <input type="hidden" name="data[final]" id="final-input"/>
                </td>
            </tr>
    <?php }?>
    </tbody>
</table>