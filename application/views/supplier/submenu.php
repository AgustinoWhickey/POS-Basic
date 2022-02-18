  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
    	<div class="col-lg">
            <?php if(validation_errors()){ ?>
                <div class="alert alert-danger" role="alert"><?= validation_errors(); ?></div>
            <?php } ?>
            <?= $this->session->flashdata('message'); ?>
    		<a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubmenuModal">Add New Submenu</a>
    		<table class="table table-hover">
    			<thead>
    				<tr>
    					<th scope="col">#</th>
    					<th scope="col">Sub Menu</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Url</th>
                        <th scope="col">Icon</th>
                        <th scope="col">Active</th>
    					<th scope="col">Action</th>
    				</tr>
    			</thead>
    			<tbody>
    				<?php
    					$i = 1; 
    					foreach($submenu as $smn){ 
					?>
    					<tr>
    						<th scope="row"><?= $i++; ?></th>
                            <td><?= $smn['title']; ?></td>
                            <td><?= $smn['name']; ?></td>
                            <td><?= $smn['url']; ?></td>
                            <td><?= $smn['icon']; ?></td>
    						<td><?= $smn['is_active']; ?></td>
    						<td>
    							<a href="<?= base_url('menu/edit_menu/'.$smn["id"]); ?>" class="badge badge-success">Edit</a>
    							<a href="<?= base_url('menu/delete_menu/'.$smn["id"]); ?>" class="badge badge-danger">Delete</a>
    						</td>
    					</tr>
    				<?php } ?>
    			</tbody>
    		</table>
    	</div>
    </div>

  </div>
  <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<div class="modal fade" id="newSubmenuModal" tabindex="-1" role="dialog" aria-labelledby="newSubmenuModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="newMenuModalLabel">Add New Submenu</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
			</div>
			<form action="<?= base_url('menu/submenu'); ?>" method="post">
				<div class="modal-body">
					<div class="form-group">
						<input type="text" class="form-control" id="title" name="title" placeholder="Submenu Name">
					</div>
                    <div class="form-group">
                        <select name="menu_id" id="menu_id" class="form-control">
                            <option value="">Select Menu</option>
                            <?php foreach($menu as $mn){ ?>
                                <option value="<?= $mn['id']; ?>"><?= $mn['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="url" name="url" placeholder="Submenu Url">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="icon" name="icon" placeholder="Submenu Icon">
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" value="1" name="is_active" id="is_active" checked>
                            <label for="is_active" class="form-check-label">Active?</label>
                        </div>
                    </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Add</button>
				</div>
			</form>
		</div>
	</div>
</div>

