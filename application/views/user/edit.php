  <!-- Begin Page Content -->
  <div class="container-fluid">

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <?php if(validation_errors()){ ?>
            <h3>Edit Data Gagal!</h3>
            <div class="alert alert-danger" role="alert"><?= validation_errors(); ?></div>
        <?php } else { ?>
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
        <?php } ?>
        <?= $this->session->flashdata('message'); ?>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-8">
            <form action="<?= base_url('user/edit/'.$oneuser->id); ?>" method="post" enctype="multipart/form-data">
              <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                  <input type="hidden" value="<?= $oneuser->id; ?>" name="user_id">
                  <input type="text" class="form-control" id="email" name="email" value="<?= $oneuser->email; ?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Full Name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="name" name="name" value="<?= $this->input->post('name') ?? $oneuser->name; ?>">
                  <?= form_error('name','<small class="text-danger pl-3">','</small>'); ?>
                </div>
              </div>
              <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" id="pass" name="pass" value="<?= $this->input->post('pass') ?>">
                  <?= form_error('pass','<small class="text-danger pl-3">','</small>'); ?>
                </div>
              </div>
              <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Confirm Password</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" id="confpass" name="confpass" value="<?= $this->input->post('confpass') ?>">
                  <?= form_error('confpass','<small class="text-danger pl-3">','</small>'); ?>
                </div>
              </div>
              <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Status</label>
                <div class="col-sm-10">
                <select name="status" id="status" class="form-control">
                  <?php $level = $this->input->post('name') ?? $oneuser->name; ?>
                  <option value="1" <?= $level == 1 ? "selected" : null; ?>>Aktif</option>
                  <option value="2" <?= $level == 2 ? "selected" : null; ?>>Tidak Aktif</option>
                </select>
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