<h2>Suppliers</h2>
<p><a href="/distributors/suppliers/add" class="btn btn-success"><i class="icon-plus icon-white"></i> Create new supplier</a></p>
<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th>Title</th>
        <th>Distributors</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php if ($suppliers){?>
        <?php foreach ($suppliers as $s){?>
            <tr>
                <td><?php echo $s->title?></td>
                <td>
                    <a href="#"><?php echo count(Distributors::model()->findAllByAttributes(array('supplier_id' => $s->id)));?></a>
                </td>
                <td style="text-align: right;">
                    <div class="btn-group">
                        <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">
                            Actions
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" style="text-align: left;">
                            <li><a href="/distributors/suppliers/edit/<?php echo $s->id?>" id="edit"><i class="icon-edit"></i> Edit</a></li>
                            <li><a href="/distributors/suppliers/delete/<?php echo $s->id?>" id="delete"><i class="icon-trash"></i> Delete</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        <?php }?>
    <?php }?>
    </tbody>
</table>