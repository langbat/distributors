<h2>Professional Groups</h2>
<p><a href="/distributors/professional/add" class="btn btn-success"><i class="icon-plus icon-white"></i> Create new group</a></p>
<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th>Title</th>
        <th>Distributors</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php if ($pro){?>
        <?php foreach ($pro as $p){?>
            <tr>
                <td><?php echo $p->title?></td>
                <td>
                    <a href="#"><?php echo count(Distributors::model()->findAllByAttributes(array('professional_id' => $p->id)));?></a>
                </td>
                <td style="text-align: right;">
                    <div class="btn-group">
                        <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">
                            Actions
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" style="text-align: left;">
                            <li><a href="/distributors/professional/edit/<?php echo $p->id?>" data-id="<?php echo $p->id?>" id="edit"><i class="icon-edit"></i> Edit</a></li>
                            <li><a href="/distributors/professional/delete/<?php echo $p->id?>" data-id="<?php echo $p->id?>" id="delete"><i class="icon-trash"></i> Delete</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        <?php }?>
    <?php }?>
    </tbody>
</table>