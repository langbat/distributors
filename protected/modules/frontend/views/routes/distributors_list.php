<h3>Distributors</h3>
<style type="text/css">
    .add-store {
        width: 53px;
    }
</style>
<table id="distributors" class="table table-striped table-hover">
    <thead>
    <tr>
        <th>Status</th>
        <th>Company</th>
        <th>API</th>
        <th>Address</th>
        <th>City</th>
        <th>Contact</th>
        <th>Phone</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php if ($distributors){?>
        <?php foreach ($distributors as $d){?>
            <tr>
                <td>
                    <?php switch ($d->status){
                        default:
                        case "1":
                            echo '<span class="label label-success">Active</span>';
                            break;
                        case "0":
                            echo '<span class="label label-important">Inactive</span>';
                            break;
                        case "2":
                            echo '<span class="label">Pending</span>';
                            break;
                    }
                    ?>

                </td>
                <td class="store-name-<?php echo $d->id?>"><?php echo $d->title?></td>
                <td><?php echo $d->api?></td>
                <td><?php echo $d->address; if ($d->address2 != ''){ echo "<br/>".$d->address2; } ?></td>
                <td><?php echo $d->city?></td>
                <td><?php echo $d->contact_name?></td>
                <td><?php echo $d->phone?></td>
                <td><?php if ($d->supplier_id != 0) { echo $suppliers[$d->supplier_id]->title; }else{ echo '-'; }?></td>
                <td><a href="#" data-id="<?php echo $d->id?>" class="btn btn-success add-store">Add</a></td>
            </tr>
        <?php }?>
    <?php }?>
    </tbody>
</table>

<script type="text/javascript">
    $(window).ready(function(){
        $('.add-store').on('click', function(e){
            e.preventDefault();
            if ($(this).hasClass('selected')){
                var index = distributors.indexOf($(this).data('id'));
                if (index > -1) {
                    distributors.splice(index, 1);
                }
                $(this).addClass('btn-success').removeClass('selected').removeClass('btn-danger').html('Add');
            }else{
                distributors.push($(this).data('id'));
                $(this).removeClass('btn-success').addClass('selected').addClass('btn-danger').html('Remove');
            }
        });
    });
</script>