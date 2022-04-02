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
                <th>Kode</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stock</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </thead>
            <tbody>
    				
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
		<div class="modal-content" style="width:200%;margin-left:-40%;">
			<div class="modal-header">
				<h5 class="modal-title" id="newMenuModalLabel">Tambah Kategori</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
			</div>
			<form action="<?= base_url('item'); ?>" method="post" enctype="multipart/form-data">
				<div class="modal-body">
          <div class="container">
            <div class="row">
              <div class="col-md-4">
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
              <div class="col-md-4">
                <div class="form-group">
                  <label>Bahan 1: </label>
                  <select name="bahan1" id="bahan1 bahan" data-no="1" class="form-control">
                    <option value="" selected>-- Pilih Bahan --</option>
                    <?php foreach($unititems as $item){ ?>
                        <option value="<?= $item->id ?>"><?= $item->name ?> (<?= $item->unit ?>) </option>
                    <?php } ?>
                  </select>
                </div>
                <div class="input-group mb-2">
                  <input type="text" class="form-control" id="qty1" name="qty1" placeholder="Input Quantity">
                  <div class="input-group-append">
                    <span class="input-group-text"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label>Bahan 2: </label>
                  <select name="bahan2" id="bahan2 bahan" data-no="2" class="form-control" autocomplete="off">
                  <option value="" selected>-- Pilih Bahan --</option>
                    <?php foreach($unititems as $item){ ?>
                        <option value="<?= $item->id ?>"><?= $item->name ?> (<?= $item->unit ?>) </option>
                    <?php } ?>
                  </select>
                </div>
                <div class="input-group mb-2">
                  <input type="text" class="form-control" id="qty2" name="qty2" placeholder="Input Quantity">
                  <div class="input-group-append">
                    <span class="input-group-text"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label>Bahan 3: </label>
                  <select name="bahan3" id="bahan3 bahan" data-no="3" class="form-control" autocomplete="off">
                  <option value="" selected>-- Pilih Bahan --</option>
                    <?php foreach($unititems as $item){ ?>
                        <option value="<?= $item->id ?>"><?= $item->name ?> (<?= $item->unit ?>) </option>
                    <?php } ?>
                  </select>
                </div>
                <div class="input-group mb-2">
                  <input type="text" class="form-control" id="qty3" name="qty3" placeholder="Input Quantity">
                  <div class="input-group-append">
                    <span class="input-group-text"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label>Bahan 4: </label>
                  <select name="bahan4" id="bahan4 bahan" data-no="4" class="form-control" autocomplete="off">
                    <option value="" selected>-- Pilih Bahan --</option>
                    <?php foreach($unititems as $item){ ?>
                        <option value="<?= $item->id ?>"><?= $item->name ?> (<?= $item->unit ?>) </option>
                    <?php } ?>
                  </select>
                </div>
                <div class="input-group mb-2">
                  <input type="text" class="form-control" id="qty4" name="qty4" placeholder="Input Quantity">
                  <div class="input-group-append">
                    <span class="input-group-text"></span>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Bahan 5: </label>
                  <select name="bahan5" id="bahan5 bahan" data-no="5" class="form-control" autocomplete="off">
                    <option value="" selected>-- Pilih Bahan --</option>
                    <?php foreach($unititems as $item){ ?>
                        <option value="<?= $item->id ?>"><?= $item->name ?> (<?= $item->unit ?>) </option>
                    <?php } ?>
                  </select>
                </div>
                <div class="input-group mb-2">
                  <input type="text" class="form-control" id="qty5" name="qty5" placeholder="Input Quantity">
                  <div class="input-group-append">
                    <span class="input-group-text"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label>Bahan 6: </label>
                  <select name="bahan6" id="bahan6 bahan" data-no="6" class="form-control" autocomplete="off">
                    <option value="" selected>-- Pilih Bahan --</option>
                    <?php foreach($unititems as $item){ ?>
                        <option value="<?= $item->id ?>"><?= $item->name ?> (<?= $item->unit ?>) </option>
                    <?php } ?>
                  </select>
                </div>
                <div class="input-group mb-2">
                  <input type="text" class="form-control" id="qty6" name="qty6" placeholder="Input Quantity">
                  <div class="input-group-append">
                    <span class="input-group-text"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label>Bahan 7: </label>
                  <select name="bahan7" id="bahan7 bahan" data-no="7" class="form-control" autocomplete="off">
                    <option value="" selected>-- Pilih Bahan --</option>
                    <?php foreach($unititems as $item){ ?>
                        <option value="<?= $item->id ?>"><?= $item->name ?> (<?= $item->unit ?>) </option>
                    <?php } ?>
                  </select>
                </div>
                <div class="input-group mb-2">
                  <input type="text" class="form-control" id="qty7" name="qty7" placeholder="Input Quantity">
                  <div class="input-group-append">
                    <span class="input-group-text"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label>Bahan 8: </label>
                  <select name="bahan8" id="bahan8 bahan" data-no="8" class="form-control" autocomplete="off">
                    <option value="" selected>-- Pilih Bahan --</option>
                    <?php foreach($unititems as $item){ ?>
                        <option value="<?= $item->id ?>"><?= $item->name ?> (<?= $item->unit ?>) </option>
                    <?php } ?>
                  </select>
                </div>
                <div class="input-group mb-2">
                  <input type="text" class="form-control" id="qty8" name="qty8" placeholder="Input Quantity">
                  <div class="input-group-append">
                    <span class="input-group-text"></span>
                  </div>
                </div>
              </div>
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
    $('#table1').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?= site_url('item/get_ajax'); ?>",
        "type": "POST"
      },
      "columnDefs": [
        {
          "targets": [4,5],
          "className": 'text-right'
        },
        {
          "targets": [6],
          "className": 'text-center'
        }
      ]
    });

    $('#bahan1').select2();
    $('#bahan1').on('change', function(e){
      alert('ahha');
    });
  });
</script>