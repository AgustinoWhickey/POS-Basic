  <!-- Begin Page Content -->
  <div class="container-fluid">

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <?php if(validation_errors()){ ?>
            <h3>Edit Item Gagal!</h3>
            <div class="alert alert-danger" role="alert"><?= validation_errors(); ?></div>
        <?php } else { ?>
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
        <?php } ?>
        <?= $this->session->flashdata('message'); ?>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-8">
            <form action="<?= base_url('itemMenu/edit/'.$oneitem->id); ?>" method="post" enctype="multipart/form-data">
              <div class="form-group row">
                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                  <input type="hidden" value="<?= $oneitem->id; ?>" name="item_id">
                  <input type="hidden" value="<?= $oneitem->image; ?>" name="gambar">
                  <input type="text" class="form-control" id="nama" name="nama" value="<?= $oneitem->name; ?>" >
				          <?= form_error('nama','<small class="text-danger pl-3">','</small>'); ?>
                </div>
              </div>
              <div class="form-group row">
                <label for="nama" class="col-sm-2 col-form-label">Unit</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="unit" name="unit" value="<?= $oneitem->unit; ?>" >
				          <?= form_error('nama','<small class="text-danger pl-3">','</small>'); ?>
                </div>
              </div>
              <div class="form-group row">
                <label for="nama" class="col-sm-2 col-form-label">Harga Per Unit</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="unit_price" name="unit_price" value="<?= $oneitem->unit_price; ?>" >
				          <?= form_error('nama','<small class="text-danger pl-3">','</small>'); ?>
                </div>
              </div>
              <div class="form-group row">
                <label for="nama" class="col-sm-2 col-form-label">Stock</label>
                <div class="col-sm-10">
                  <input type="number" class="form-control" id="stock" name="stock" value="<?= $oneitem->stock; ?>" >
				          <?= form_error('nama','<small class="text-danger pl-3">','</small>'); ?>
                </div>
              </div>
              <div class="form-group row">
                <label for="nama" class="col-sm-2 col-form-label">Gambar</label>
                <div class="col-sm-10">
                  <div class="custom-file  mb-2">
                    <input type="file" class="custom-file-input" id="image" name="image">
                    <label for="image" class="custom-file-label">Choose file</label>
                  </div>
                  <?php if($oneitem->image != ''){ ?>
                    <img src="<?=  base_url('assets/img/upload/items/'.$oneitem->image); ?>" style="width:80%">
                  <?php } ?>
				          <?= form_error('nama','<small class="text-danger pl-3">','</small>'); ?>
                </div>
              </div>

              <div class="form-group row justify-content-end">
                <div class="col-sm-10">
                  <button class="btn btn-primary">Edit</button>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- /.container-fluid -->

</div>
<!-- End of Main Content --> 