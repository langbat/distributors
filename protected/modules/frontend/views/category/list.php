<div class="col-lg-12">
    <h1>Categories List</h1>
    <br/>
    <div class="btn-group">
        <a href="/category/add" class="btn btn-success">Add new category</a>
        <a href="/category/list" class="btn btn-default">View categories</a>
    </div>
    <hr/>
    <table class="table table-striped table-hover" style="width: 100%;">
        <thead>
            <tr>
            	<th>Name</th>
                <th>Products</th>
                <th>Company</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php if ($categories){?>
            <?php foreach ($categories as $category){?>
                <tr>
                	<td><?php echo $category->title;?></td>
                    <td></td>
                    <td><?php echo $companies[$category->company_id]->title;?></td>
                    <td style="text-align: right;">
                        <div class="btn-group">
                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">
                                Actions
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" style="text-align: left;">
                                <li>
                                    <a href="/category/edit/<?php echo $category->id?>" id="edit"><i class="icon-edit"></i> Edit</a>
                                </li>
                                <li>
                                    <a href="/category/delete/<?php echo $category->id?>" id="delete"><i class="icon-trash"></i> Delete</a>
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