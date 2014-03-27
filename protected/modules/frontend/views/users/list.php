<h1>Representatives</h1>
<script type="text/javascript">
    $(window).ready(function(){
        $('.promote').on('click', function(){
            var id = $(this).data('id');
            $.ajax({
              type: "POST",
              url: "/users/admin",
              data: { id: id },
              dataType: "JSON",
              success: function(data){
                $('user-'+id).find('role-row').html('admin');
              }
            });
        });
    });
</script>
<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th>Username</th>
        <th>E-Mail</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Role</th>
        <th>Last Contact</th>
        <th>Last Login</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php if ($users){?>
        <?php foreach ($users as $u){?>
            <tr class="user-<?php echo $u->id?>">
                <td><?php echo $u->username?></td>
                <td><?php echo $u->email?></td>
                <td><?php echo $u->fname?></td>
                <td><?php echo $u->lname?></td>
                <td class="role-row"><?php echo $u->role?></td>
                <td></td>
                <td></td>
                <td>
                    <div class="btn-group">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            Actions
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="/users/profile/<?php echo $u->id?>"><i class="icon-eye-open"></i> Details</a></li>
                            <li><a href="mailto:<?php echo $u->email?>"><i class="icon-envelope"></i> E-Mail</a></li>
                            <?php if (Yii::app()->user->role == 'admin'){ ?>
                                <?php if ($u->role != 'admin'){?>
                                    <li><a href="#" class="promote" data-id="<?php echo $u->id?>"><i class="icon-user"></i> Promote to admin</a></li>
                                <?php }?>
                                <li><a href="/users/edit/<?php echo $u->id?>"><i class="icon-edit"></i> Edit</a></li>
                                <li><a href="/users/delete/<?php echo $u->id?>"><i class="icon-trash"></i> Delete</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </td>
            </tr>
        <?php }?>
    <?php }?>
    </tbody>
</table>