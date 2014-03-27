<h2>Groups</h2>
<p><a href="/distributors/groups/add" class="btn btn-success"><i class="icon-plus icon-white"></i> Create new group</a></p>
<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th>Title</th>
        <th>Distributors</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php if ($groups){?>
        <?php foreach ($groups as $g){?>
            <tr>
                <td><?php echo $g->title?></td>
                <td>
                    <a href="#"><?php echo count(Distributors::model()->findAllByAttributes(array('group_id' => $g->id)));?></a>
                </td>
                <td style="text-align: right;">
                    <div class="btn-group">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            Actions
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" style="text-align: left;">
                            <li><a href="/distributors/groups/edit/<?php echo $g->id?>" id="edit"><i class="icon-edit"></i> Edit</a></li>
                            <li><a href="/distributors/groups/delete/<?php echo $g->id?>" id="delete"><i class="icon-trash"></i> Delete</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        <?php }?>
    <?php }?>
    </tbody>
</table>