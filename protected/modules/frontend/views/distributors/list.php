<h1>Distributors <small><?php echo count($distributors);?></small><div class="btn-group pull-right">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">
          Export
          <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
          <li><a id="export-excel" href="#">Excel</a></li>
          <li><a id="export-pdf" href="#">PDF</a></li>
          <li><a id="export-csv" href="#">CSV</a></li>
        </ul>
      </div></h1>
<script type="text/javascript">
    $(window).ready(function(){
        $('#export-csv').on('click', function(){
            $('#export').val(1);
            $('form').submit();
        });
    });
</script>
<hr/>
<div class="row">
  <form class="form-inline" style="margin: 0;" method="POST" action="" role="form">
    <div class="col-lg-12">
      <div class="form-group">
        <select name="search[status]" class="input-sm form-control" id="status">
          <option>Status</option>
          <option <?php if ((int)$search['status'] == 1){ echo 'selected="selected"';}?> value="1">Active</option>
          <option <?php if ((int)$search['status'] == 2){ echo 'selected="selected"';}?> value="2">Inactive</option>
          <option <?php if ((int)$search['status'] == 3){ echo 'selected="selected"';}?> value="3">Pending</option>
        </select>
      </div>
      <div class="form-group">
        <select name="search[supplier]" class="input-sm form-control" id="suppliers">
          <option>Supplier</option>
          <option value="0">No supplier</option>
            <?php foreach ($suppliers as $s){?>
              <option <?php if ((int)$search['supplier'] == $s->id){ echo 'selected="selected"';}?> value="<?php echo $s->id?>"><?php echo $s->title;?></option>
            <?php }?>
        </select>
      </div>
      <div class="form-group">
        <select name="search[groups]" class="input-sm form-control" id="groups">
          <option>Groups</option>
          <option value="0">No group</option>
            <?php foreach ($groups as $g){?>
              <option <?php if ((int)$search['groups'] == $g->id){ echo 'selected="selected"';}?> value="<?php echo $g->id?>"><?php echo $g->title;?></option>
            <?php }?>
        </select>
      </div>
      <div class="form-group">
        <select name="search[states]" class="input-sm form-control" id="state">
          <option>State</option>
            <?php foreach ($states as $s){?>
              <option <?php if ((int)$search['states'] == $s->id){ echo 'selected="selected"';}?> value="<?php echo $s->id?>"><?php echo $s->title;?></option>
            <?php }?>
        </select>
      </div>
      <div class="form-group">
        <select name="search[regions]" class="input-sm form-control" id="region">
          <option>Region</option>
            <?php foreach ($regions as $r){?>
              <option <?php if ((int)$search['regions'] == $r->id){ echo 'selected="selected"';}?> value="<?php echo $r->id?>"><?php echo $r->title;?></option>
            <?php }?>
        </select>
      </div>
      <div class="form-group">
        <select name="search[company_id]" class="input-sm form-control" id="company_id">
          <option>Company Type</option>
          <option value="1" <?php if ((int)$search['company_id'] == 1){ echo 'selected="selected"';}?>>MedicalVitaDiet</option>
          <option value="2" <?php if ((int)$search['company_id'] == 2){ echo 'selected="selected"';}?>>BettyBaxter</option>
          <option value="3" <?php if ((int)$search['company_id'] == 3){ echo 'selected="selected"';}?>>Both</option>
        </select>
      </div>
      <div class="form-group">
        <input class="form-group" type="hidden" id="export" name="search[export]" value="0"/>
        <button id="search-distributors" type="submit" class="btn btn-primary btn-sm">Search</button>
      </div>
    </div>
  </form>
</div>
<hr/>
<div class=" table-responsive">
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Status</th>
            <th>Company</th>
            <th>API</th>
            <th>Address</th>
            <th>City</th>
            <th>State</th>
            <th>Contact</th>
            <th>Phone</th>
            <th>Supplier</th>
            <th>Company Type</th>
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
                      echo '<span class="label label-default">Pending</span>';
                      break;
                  }
                  ?>
                  
                </td>
                <td><?php echo $d->title?></td>
                <td><?php echo $d->api?></td>
                <td><?php echo $d->address; if ($d->address2 != ''){ echo "<br/>".$d->address2; } ?></td>
                <td><?php echo $d->city?></td>
                <td><?php echo $states[$d->state_id]->title?></td>
                <td><?php echo $d->contact_name?></td>
                <td><?php echo $d->phone?></td>
                <td><?php if ($d->supplier_id != 0) { echo $suppliers[$d->supplier_id]->title; }else{ echo '-'; }?></td>
                <td>
                  <?php 
                    switch ($d->company_id){
                      default:
                      case '1':
                        echo "MedicalVitaDiet";
                        break;
                      case '2':
                        echo "BettyBaxter";
                        break;
                      case '3':
                        echo "Both";
                        break;
                    }
                  ?>
                </td>
                <td>
                    <div class="btn-group">
                      <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">
                        Actions
                        <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu">
                        <li><a href="/distributors/view/<?php echo $d->id?>"><i class="icon-eye-open"></i> Details</a></li>
                        <li><a href="/orders/add/<?php echo $d->id?>"><i class="icon-shopping-cart"></i> Create Order</a></li>
                        <li><a href="/contact/create/<?php echo $d->id?>"><i class="icon-pencil"></i> Add Contact log</a></li>
                        <li><a href="/contact/photos/<?php echo $d->id?>"><i class="icon-camera"></i> Upload Photos</a></li>
                        <li><a href="mailto:<?php echo $d->email?>"><i class="icon-envelope"></i> E-Mail</a></li>
                        <li><a href="/distributors/edit/<?php echo $d->id?>"><i class="icon-edit"></i> Edit</a></li>
                        <li><a href="/distributors/delete/<?php echo $d->id?>"><i class="icon-trash"></i> Delete</a></li>
                      </ul>
                    </div>
                </td>
            </tr>
          <?php }?>
        <?php }?>
    </tbody>
</table>
</div>