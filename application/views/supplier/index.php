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
          <i class="fa fa-user-plus"></i>  Tambah Supplier
        </a>
      </div>
    </div>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Table Supplier</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </thead>
            <tbody>
    				<?php
    					$i = 1; 
    					foreach($suppliers as $sup){ 
					  ?>
    					<tr>
    						<th scope="row"><?= $i++; ?></th>
    						<td><?= $sup->name; ?></td>
    						<td><?= $sup->phone; ?></td>
    						<td><?= $sup->address; ?></td>
    						<td><?= $sup->description; ?></td>
    						<td>
                    <a href="<?= base_url('supplier/edit/'.$sup->id); ?>" class="btn btn-xs btn-info">Edit</a>
                    <form action="<?= site_url('supplier/delete')?>" method="post">
                      <input type="hidden" name="supplier_id" value="<?= $sup->id?>">
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
				<h5 class="modal-title" id="newMenuModalLabel">Tambah Supplier</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
			</div>
			<form action="<?= base_url('supplier'); ?>" method="post">
				<div class="modal-body">
					<div class="form-group">
            			<label>Nama: </label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Input Nama">
					</div>
					<div class="form-group">
						<label>Telepon: </label>
						<input type="text" class="form-control" id="telepon" name="telepon" placeholder="Input No Telepon">
					</div>
          			<div class="form-group">
           		 		<label>Alamat: </label>
						<textarea class="form-control" id="address" name="address">Input Alamat</textarea> 
					</div>
					<div class="form-group">
           		 		<label>Deskripsi: </label>
						<textarea class="form-control" id="deskripsi" name="deskripsi">Input Deskripsi</textarea> 
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