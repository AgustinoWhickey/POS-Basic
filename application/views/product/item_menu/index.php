  <!-- Begin Page Content -->
  <div class="container-fluid">

    <div class="row">
      <div class="col-lg-6">
        <!-- Page Heading -->
        <?php if(validation_errors()){ ?>
            <h3>Tambah Data Gagal!</h3>
            <div class="alert alert-danger" role="alert"><?= validation_errors(); ?></div>
        <?php } else { ?>
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
        <?php } ?>
        <?= $this->session->flashdata('message'); ?>
      </div>
      <div class="col-lg-6 text-right">
        <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newUserModal">
          <i class="fa fa-user-plus"></i>  Tambah Item
        </a>
      </div>
    </div>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Table Item</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="table1" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Stock</th>
                <th>Unit</th>
                <th>Harga Per Unit</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </thead>
            <tbody>
            <?php
    					$i = 1; 
    					foreach($items as $it){ 
					  ?>
    					<tr>
    						<th scope="row"><?= $i++; ?></th>
    						<td><?= $it->name; ?></td>
                <td><?= $it->stock; ?></td>
    						<td><?= $it->unit; ?></td>
    						<td><?= indo_currency($it->unit_price); ?></td>
    						<td><img src=<?= base_url('assets/img/upload/items/'.$it->image) ?> class="img" style="width:100px"></td>
    						<td>
                    <a href="<?= base_url('itemMenu/edit/'.$it->id); ?>" class="btn btn-xs btn-info">Edit</a>
                    <form action="<?= site_url('itemMenu/delete')?>" method="post">
                      <input type="hidden" name="itemmenu_id" value="<?= $it->id?>">
                      <button type="submit" onclick="return confirm('Apakah Anda yakin?')" class="btn btn-xs btn-danger">Delete</button>
                    </form>
    						</td>
    					</tr>
    				<?php } ?>
    			</tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
  <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<div class="modal fade" id="newUserModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="newMenuModalLabel">Tambah Item</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
			</div>
			<form action="<?= base_url('itemMenu'); ?>" method="post" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="form-group">
            <label>Nama Item: </label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Input Nama">
					</div>
          <div class="form-group">
            <label>Unit: </label>
						<input type="text" class="form-control" id="unit" name="unit" placeholder="Input Unit">
					</div>
          <div class="form-group">
            <label>Harga Per Unit: </label>
						<input type="text" class="form-control" id="unit_price" name="unit_price" placeholder="Input Harga">
					</div>
          <div class="form-group">
            <label>Stock: </label>
						<input type="number" class="form-control" id="stock" name="stock" placeholder="Input Stock">
					</div>
          <div class="form-group">
            <label>Gambar: </label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="image" name="image">
              <label for="image" class="custom-file-label">Choose file</label>
            </div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Tambah</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
  $(document).ready(function() {
    $('#table1').DataTable();
  });
</script>