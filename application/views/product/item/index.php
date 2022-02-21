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
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kode</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stock</th>
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
    						<td>
                  <?= $it->name; ?>
                  <a href="<?= site_url('item/print_barcode/'.$it->id); ?>" class="btn btn-default btn-xs">
                    <i class="fa fa-barcode"></i>
                  </a>
                </td>
    						<td><?= $it->barcode; ?></td>
    						<td><?= $it->category_name; ?></td>
    						<td><?= $it->price; ?></td>
    						<td><?= $it->stock; ?></td>
    						<td>
                  <?php if($it->image != ''){ ?>
                    <img src="<?=  base_url('assets/img/upload/products/'.$it->image); ?>" style="width:100px;">
                  <?php } ?>
                </td>
    						<td>
                  <div class="row">
                    <div class="col-md-2">
                      <a href="<?= base_url('item/edit/'.$it->id); ?>" class="badge badge-success">Edit</a>
                    </div>
                    <div class="col-md-6">
                      <form action="<?= site_url('item/delete')?>" method="post">
                        <input type="hidden" name="item_id" value="<?= $it->id?>">
                        <input type="hidden" name="gambar" value="<?= $it->image?>">
                        <button type="submit" onclick="return confirm('Apakah Anda yakin?')" class="badge badge-danger">Delete</button>
                      </form>
                    </div>
                  </div>
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
				<h5 class="modal-title" id="newMenuModalLabel">Tambah Kategori</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
			</div>
			<form action="<?= base_url('item'); ?>" method="post" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="form-group">
            <label>Nama Item: </label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Input Nama">
					</div>
          <div class="form-group">
            <label>Kode: </label>
						<input type="text" class="form-control" id="barcode" name="barcode" placeholder="Input Barcode">
					</div>
          <div class="form-group">
            <label>Kategori: </label>
            <select name="kategori" id="kategori" class="form-control">
              <?php foreach($category as $cat){ ?>
                  <option value="<?= $cat->id ?>"><?= $cat->nama ?></option>
              <?php } ?>
            </select>
					</div>
          <div class="form-group">
            <label>Harga: </label>
						<input type="number" class="form-control" id="harga" name="harga" placeholder="Input Harga">
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