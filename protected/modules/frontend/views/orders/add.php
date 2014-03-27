<div class="col-lg-12"><h1>New Order</h1></div>
<script type="text/javascript">
	$(window).ready(function(){
		$('#continue').on('click', function(){
			$('#step1').hide();
			$.ajax({
                type: "POST",
                url: "/orders/ajax",
                data: {
                    template_id: $('#inputTemplate').val(),
                },
                dataType: "HTML",
                success: function(data){
                    $('#products').html(data);
                    $('#step2').removeClass('hidden');
                }
            });
		});
	});
</script>
<form class="form" action="" role="form" method="POST">
	<div id="step1">
		<div class="col-lg-12">
			<div class="row">
				<h2>Step 1. Template</h2>
				<div class="col-lg-5 col-sm-12">
					<div class="form-group">
						<label class="control-label" for="inputName">Store Name</label>
						<div class="controls">
							<input type="hidden" name="data[store_id]" value="<?php echo $distributor->id?>"/>
							<input class="form-control" name="data[store_title]" type="text" id="inputName" value="<?php echo $distributor->title;?>" disabled="disabled">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label" for="inputTemplate">Template</label>
						<div class="controls">
							<select class="form-control" name="data[template_id]" id="inputTemplate">
								<?php foreach ($templates as $template){?>
									<option value="<?php echo $template->id?>"><?php echo $template->title?></option>
								<?php }?>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12" style="margin-bottom: 20px; margin-top: 15px;">
			<a href="#" id="continue" class="btn btn-primary">Continue</a>
		</div>
	</div>
	<div id="step2" class="hidden">
		<div class="col-lg-12">
			<h2>Step 2. Prices</h2>
			<div id="products">

			</div>
			<button type="submit" class="btn btn-success">Create Order</button>
		</div>
	</div>
</form>