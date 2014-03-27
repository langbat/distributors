<script type="text/javascript">
	$(window).ready(function(){
		$('#continue').on('click', function(){
			var company_id = $('#inputCompany').val();
			$('#step1').addClass('hide');
			$('#step2').removeClass('hide');
			$.ajax({
			  type: "POST",
			  url: "/templates/ajax",
			  data: { company: company_id},
			  dataType: "HTML",
			  success: function(data){
			  	$('#products').html(data);
			  }
			});
		});
	});
</script>
<div class="col-lg-12 clearfix">
	<h1>Create new template</h1>
	<form class="form-horizontal" action="" method="POST" role="form">
		<div id="step1">
			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				<h3>Step 1. Basic settings.</h3>
				<hr/>
				<div class="form-group">
					<label class="form-label" for="inputName">Template Name</label>
					<div class="controls">
						<input class="form-control" name="data[name]" type="text" id="inputName" placeholder="Template name">
					</div>
				</div>
				<div class="form-group">
					<label class="form-label" for="inputDescription">Tempalate Description</label>
					<div class="controls">
						<textarea class="form-control" name="data[description]" id="inputDescription"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="form-label" for="inputCompany">Company</label>
					<div class="controls">
						<select class="form-control" name="data[company_id]" id="inputCompany">
							<?php foreach($companies as $company){?>
								<option value="<?php echo $company->id;?>"><?php echo $company->title;?></option>
							<?php }?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<a href="#" id="continue" class="btn btn-primary">Continue</a>
			</div>
		</div>
		<div id="step2" class="hide">
			<div class="col-lg-12">
				<h3>Step 4. Products.</h3>
				<div id="products"></div>
				<button type="submit" name="data[action]" value="save" class="btn btn-primary">Add Template</button>
			</div>
		</div>
	</form>
</div>
<br/>