<h1>Routes</h1>
<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th>Route Name</th>
        <th># of Days</th>
        <th># of Stores</th>
        <th>Duration</th>
        <th>Status</th>
        <th>Last Contact</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php if ($results){?>
        <?php foreach ($results as $state){?>
            <tr>
                <td colspan="7" style="text-align: center;"><strong><?php echo $state['name']?></strong></td>
            </tr>
            <?php foreach ($state['routes'] as $r){?>
                <tr>
                    <td><?php echo $r->title;?></td>
                    <td><?php echo $r->days;?></td>
                    <td><?php echo Rd::model()->countByAttributes(array('route_id' => $r->id));?></td>
                    <td><?php echo $r->duration?> Weeks</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <div class="btn-group">
                            <a class="btn dropdown-toggle btn-mini" data-toggle="dropdown" href="#">
                                Actions
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="/routes/maps/<?php echo $r->id?>"><i class="icon-edit"></i> View Plan</a></li>
                                <li><a href="/routes/start/<?php echo $r->id?>"><i class="icon-edit"></i> Start Route</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php }?>
        <?php }?>
    <?php }?>
    </tbody>
</table>