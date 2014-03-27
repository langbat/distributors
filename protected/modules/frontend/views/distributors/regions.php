
<h2>Regions</h2>
<p><a href="#" class="btn btn-success"><i class="icon-plus icon-white"></i> Create new region</a></p>
<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th>Title</th>
        <th>State</th>
        <th>Distributors</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php if ($regions){?>
        <?php foreach ($regions as $r){?>
            <tr>
                <td><?php echo $r->title?></td>
                <td><?php echo $states[$r->state_id]->title?></td>
                <td>
                    <a href="#"><?php echo count(Distributors::model()->findAllByAttributes(array('region_id' => $r->id)));?></a>
                </td>
                <td style="text-align: right;">
                    <div class="btn-group">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            Actions
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" style="text-align: left;">
                            <li><a href="#" data-id="<?php echo $r->id?>" id="edit"><i class="icon-edit"></i> Edit</a></li>
                            <li><a href="#" data-id="<?php echo $r->id?>" id="delete"><i class="icon-trash"></i> Delete</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        <?php }?>
    <?php }?>
    </tbody>
</table>