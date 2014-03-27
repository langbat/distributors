<h1>Create new Route</h1>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<style type="text/css">
    #sortable {
        list-style-type: none;
        width: 350px;
    }
    #sortable li {
        width: 300px;
    }
</style>
<div id="step1">
    <h2>Step 1. Route Information.</h2>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <form class="form-horizontal" action="" method="POST" role="form">
            <div class="form-group">
                <label class="control-label" for="inputRouteName">Route Name</label>
                <div class="controls">
                    <input class="form-control" name="data[route_name]" type="text" id="inputRouteName" placeholder="Route Name" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="inputDays">No. of Days</label>
                <div class="controls">
                    <select class="form-control" name="data[days]" id="inputDays">
                        <?php for ($i=1;$i<32;$i++){?>
                            <option value="<?php echo $i?>"><?php echo $i;?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="inputState">State</label>
                <div class="controls">
                    <select class="form-control" name="data[state]" id="inputState">
                        <?php foreach ($states as $s){?>
                            <option value="<?php echo $s->id?>"><?php echo $s->title;?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="inputCid">Company Type</label>
                <div class="controls">
                    <select class="form-control" name="data[company_id]" id="inputCid">
                        <?php foreach ($companies as $company){?>
                            <option value="<?php echo $company->id?>"><?php echo $company->title?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="inputDuration">Duration</label>
                <div class="controls">
                    <select class="form-control" name="data[duration]" id="inputDuration">
                        <option value="6">Every 6 weeks</option>
                        <option value="8">Every 8 weeks</option>
                        <option value="12">Every 12 weeks</option>
                        <option value="16">Every 16 weeks</option>
                    </select>
                </div>
            </div>
            <a href="#" id="step1-next" class="btn btn-primary">Next Step</a>
        </form>
    </div>
</div>
<div id="step2" class="hidden">
    <h2>Step 2. Select stores.</h2>
    <a href="#" id="step2-next" class="btn">Next Step</a>
    <div id="distributors-list"></div>
</div>
<div id="step3" class="hidden">
    <h2>Step 3. Assign days.</h2>
    <div id="pull">
        <h3>Pull list:</h3>
        <p>Drag stores from pull to a specific days of route.</p>
        <ul id="sortable">
            <li class="btn btn-inverse" data-day="0" align="center">Unsorted stores</li>
        </ul>
    </div>
    <a href="#" id="finish" class="btn">Create Route</a>
</div>
<div id="step4" class="hidden">
    <h2>Step 4. Complete.</h2>
    <p>New route was successfully created.</p>
</div>

<script type="text/javascript">
    var distributors = [];
    $(window).ready(function(){
        $( "#sortable" ).sortable({
            revert: true
        });
        $( "ul, li" ).disableSelection();
        $('#step1-next').on('click', function(){
            $('#step1').addClass('hidden');
            $.ajax({
                type: "POST",
                url: "/routes/ajax",
                data: {
                    state_id: $('#inputState').val(),
                    company_id: $('#inputCid').val()
                },
                dataType: "HTML",
                success: function(data){
                    $('#distributors-list').html(data);
                    $('#step2').removeClass('hidden');
                }
            });
        });
        $('#step2-next').on('click', function(){
            $('#step2').addClass('hidden');
            $('#step3').removeClass('hidden');
            distributors.forEach(iterate);
            for(var i=1;i<=$('#inputDays').val();i++){
                $('#sortable').append('<li class="btn btn-inverse" data-day="'+i+'" align="center">Day '+i+'</li>');
            }
        });
        $('#finish').on('click', function(e){
            e.preventDefault();
            var distributors_final = prepare_distributors();
            console.log(distributors_final);
            $.ajax({
                type: "POST",
                url: "/routes/finish",
                data: {
                    title : $('#inputRouteName').val(),
                    days : $('#inputDays').val(),
                    duration : $('#inputDuration').val(),
                    state_id: $('#inputState').val(),
                    company_id: $('#inputCid').val(),
                    distributors: distributors_final
                },
                dataType: "HTML",
                success: function(data){
                    $('#step3').addClass('hidden');
                    $('#step4').removeClass('hidden');
                }
            });
        });
    });
    function iterate(element, index, array){
        var name = $('#distributors').find('.store-name-'+element).html();
        $('#sortable').append('<li class="btn" data-id="'+element+'">'+name + '</li>');
    }
    function prepare_distributors(){
        var result = {};
        var day = 0;
        var id = 0;

        $('#sortable li').each(function(el){
            if ($(this).hasClass('btn-inverse')){
                day = parseInt($(this).data('day'));
                if (day !== 0){
                    result[day] = [];
                }
            }else{
                id = parseInt($(this).data('id'));
                result[day].push(id);
            }
        });
        return result;
    }
</script>