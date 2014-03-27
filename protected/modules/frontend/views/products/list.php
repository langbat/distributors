<div class="col-lg-12">
    <h1>Products List</h1>
    <br/>
    <div class="btn-group">
        <a href="/products/add" class="btn btn-success">Add product</a>
        <a href="/category/add" class="btn btn-default">Add category</a>
        <a href="/category/list" class="btn btn-default">View categories</a>
    </div>
    <hr/>
    <table class="table table-striped table-hover" style="width: 100%;">
        <thead>
            <tr>
                <th>Photo</th>
            	<th>Name</th>
                <th>Base Price</th>
                <th>Category</th>
                <th>API #</th>
                <th>Company #</th>
                <th>Company</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php if ($products){?>
            <?php foreach ($products as $p){?>
                <tr>
                    <td><img width="32px" height="32px" src="/public/products/<?php echo $p->photo?>"/></td>
                	<td><?php echo $p->title;?></td>
                    <td>$<?php echo $p->price;?></td>
                    <td><?php echo $categories[$p->category_id]->title;?></td>
                    <td><?php echo $p->api_pde;?></td>
                    <td><?php echo $p->company_pde;?></td>
                    <td><?php echo $companies[$categories[$p->category_id]->company_id]->title;?></td>
                    <td style="text-align: right;">
                        <div class="btn-group">
                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">
                                Actions
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" style="text-align: left;">
                                <li>
                                    <a href="/products/edit/<?php echo $p->id?>" id="edit"><i class="icon-edit"></i> Edit</a>
                                </li>
                                <li>
                                    <a href="/products/delete/<?php echo $p->id?>" id="delete"><i class="icon-trash"></i> Delete</a>
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