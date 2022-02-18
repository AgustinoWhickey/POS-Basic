  <!-- Begin Page Content -->
  <div class="container-fluid">

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <?php if(validation_errors()){ ?>
            <h3>Edit Supplier Gagal!</h3>
            <div class="alert alert-danger" role="alert"><?= validation_errors(); ?></div>
        <?php } else { ?>
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
        <?php } ?>
        <?= $this->session->flashdata('message'); ?>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-8">
            <form action="<?= base_url('supplier/edit/'.$onesupplier->id); ?>" method="post" enctype="multipart/form-data">
              <div class="form-group row">
                <label for="nama" class="col-sm-2 col-form-label">Nama Supplier</label>
                <div class="col-sm-10">
                  <input type="hidden" value="<?= $onesupplier->id; ?>" name="supplier_id">
                  <input type="text" class="form-control" id="nama" name="nama" value="<?= $onesupplier->name; ?>" >
				  <?= form_error('nama','<small class="text-danger pl-3">','</small>'); ?>
                </div>
              </div>
              <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Telepon</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="phone" name="phone" value="<?= $this->input->post('phone') ?? $onesupplier->phone; ?>">
                </div>
              </div>
			  <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="address" name="address" value="<?= $this->input->post('address') ?? $onesupplier->address; ?>">
                </div>
              </div>
			  <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Deskripsi</label>
                <div class="col-sm-10">
					<textarea class="form-control" id="deskripsi" name="deskripsi" value=""><?= $this->input->post('deskripsi') ?? $onesupplier->description; ?></textarea>
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