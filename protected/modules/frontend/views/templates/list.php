<div class="col-lg-12">
    <h1>Templates List</h1>
    <br/>
    <div class="btn-group">
        <a href="/templates/add" class="btn btn-success">Add new template</a>
    </div>
    <hr/>
    <table class="table table-striped table-hover" style="width: 100%;">
        <thead>
            <tr>
            	<th>Name</th>
                <th>Products</th>
                <th>Orders</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php if ($templates){?>
            <?php foreach ($templates as $template){?>
                <tr>
                	<td><?php echo $template->title;?></td>
                    <td></td>
                    <td></td>
                    
                    <td style="text-align: right;">
                        <div class="btn-group">
                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">
                                Actions
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" style="text-align: left;">
                                <li>
                                    <a href="/templates/edit/<?php echo $template->id?>" id="edit"><i class="icon-edit"></i> Edit</a>
                                </li>
                                <li>
                                    <a href="/templates/delete/<?php echo $template->id?>" id="delete"><i class="icon-trash"></i> Delete</a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php }?>
        <?php }?>
        </tbody>
    </table>
</div>