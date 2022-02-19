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
            <form action="<?= base_url('item/edit/'.$oneitem->id); ?>" method="post" enctype="multipart/form-data">
              <div class="form-group row">
                <label for="nama" class="col-sm-2 col-form-label">Nama Kategori</label>
                <div class="col-sm-10">
                  <input type="hidden" value="<?= $oneitem->id; ?>" name="item_id">
                  <input type="text" class="form-control" id="nama" name="nama" value="<?= $oneitem->name; ?>" >
				          <?= form_error('nama','<small class="text-danger pl-3">','</small>'); ?>
                </div>
              </div>
              <div class="form-group row">
                <label for="nama" class="col-sm-2 col-form-label">Kode</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="barcode" name="barcode" value="<?= $oneitem->barcode; ?>" >
				          <?= form_error('nama','<small class="text-danger pl-3">','</small>'); ?>
                </div>
              </div>
              <div class="form-group row">
                <label for="nama" class="col-sm-2 col-form-label">Kategori</label>
                <div class="col-sm-10">
                <select name="kategori" id="kategori" class="form-control">
                  <?php foreach($category as $cat){ ?>
                      <option value="<?= $cat->id ?>" <?= $cat->id == $oneitem->category_id ? 'selected' : '' ?>><?= $cat->nama ?></option>
                  <?php } ?>
                </select>
				          <?= form_error('nama','<small class="text-danger pl-3">','</small>'); ?>
                </div>
              </div>
              <div class="form-group row">
                <label for="nama" class="col-sm-2 col-form-label">Harga</label>
                <div class="col-sm-10">
                  <input type="number" class="form-control" id="price" name="price" value="<?= $oneitem->price; ?>" >
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