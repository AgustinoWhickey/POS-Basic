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
      <form action="<?= base_url('item/edit/'.$oneitem->id); ?>" method="post" enctype="multipart/form-data">
        <div class="row">
          <div class="col-lg-4">
            <div class="form-group">
              <label>Nama: </label>
                <input type="hidden" value="<?= $oneitem->id; ?>" name="item_id">
                <input type="hidden" value="<?= $oneitem->image; ?>" name="gambar">
                <input type="text" class="form-control" id="nama" name="nama" value="<?= $oneitem->name; ?>" >
                <?= form_error('nama','<small class="text-danger pl-3">','</small>'); ?>
            </div>
            <div class="form-group">
              <label>Kode: </label>
                <input type="text" class="form-control" id="barcode" name="barcode" value="<?= $oneitem->barcode; ?>" >
				        <?= form_error('nama','<small class="text-danger pl-3">','</small>'); ?>
            </div>
            <div class="form-group">
              <label>Kategori: </label>
              <select name="kategori" id="kategori" class="form-control">
                  <?php foreach($category as $cat){ ?>
                      <option value="<?= $cat->id ?>" <?= $cat->id == $oneitem->category_id ? 'selected' : '' ?>><?= $cat->nama ?></option>
                  <?php } ?>
                </select>
				          <?= form_error('nama','<small class="text-danger pl-3">','</small>'); ?>
            </div>
            <div class="form-group">
              <label>Harga: </label>
                <input type="number" class="form-control" id="price" name="price" value="<?= $oneitem->price; ?>" >
				          <?= form_error('nama','<small class="text-danger pl-3">','</small>'); ?>
            </div>
            <div class="form-group">
              <label>Stock: </label>
              <input type="number" class="form-control" id="stock" name="stock" value="<?= $oneitem->stock; ?>" >
				          <?= form_error('nama','<small class="text-danger pl-3">','</small>'); ?>
            </div>
            <div class="form-group">
              <label>Gambar: </label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="image" name="image">
                <label for="image" class="custom-file-label">Choose file</label>
              </div>
              <?php if($oneitem->image != ''){ ?>
                <img src="<?=  base_url('assets/img/upload/products/'.$oneitem->image); ?>" style="width:80%">
              <?php } ?>
              <?= form_error('nama','<small class="text-danger pl-3">','</small>'); ?>
            </div>
                  <button class="btn btn-primary">Edit</button>
          </div>
          <div class="col-lg-4">
          <div class="form-group">
                  <label>Bahan 1: </label>
                  <select name="bahan1" id="bahan1 bahan" data-no="1" class="form-control">
                    <option value="">-- Pilih Bahan --</option>
                    <?php foreach($unititems as $item){ ?>
                      <?php if(isset($onemenuitem[0])){ ?>
                        <?php if($onemenuitem[0]->item_id == $item->id){?>
                          <option value="<?= $item->id ?>" selected><?= $item->name ?> (<?= $item->unit ?>) </option>
                        <?php } else{ ?>
                          <option value="<?= $item->id ?>"><?= $item->name ?> (<?= $item->unit ?>) </option>
                        <?php } ?>
                      <?php } else{ ?>
                        <option value="<?= $item->id ?>"><?= $item->name ?> (<?= $item->unit ?>) </option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="input-group mb-2">
                  <?php if(isset($onemenuitem[0])){ ?>
                    <input type="hidden" id="menuitem1" name="menuitem1" value="<?= $onemenuitem[0]->id ?>">
                    <input type="text" class="form-control" id="qty1" name="qty1" placeholder="Input Quantity" value="<?= $onemenuitem[0]->qty ?>">
                  <?php }else{ ?>
                    <input type="text" class="form-control" id="qty1" name="qty1" placeholder="Input Quantity">
                  <?php } ?>
                </div>
                <div class="form-group">
                  <label>Bahan 2: </label>
                  <select name="bahan2" id="bahan2 bahan" data-no="2" class="form-control" autocomplete="off">
                  <option value="">-- Pilih Bahan --</option>
                    <?php foreach($unititems as $item){ ?>
                      <?php if(isset($onemenuitem[1])){ ?>
                        <?php if($onemenuitem[1]->item_id == $item->id){?>
                          <option value="<?= $item->id ?>" selected><?= $item->name ?> (<?= $item->unit ?>) </option>
                        <?php }else{ ?>
                          <option value="<?= $item->id ?>"><?= $item->name ?> (<?= $item->unit ?>) </option>
                        <?php } ?>
                      <?php } else{ ?>
                        <option value="<?= $item->id ?>"><?= $item->name ?> (<?= $item->unit ?>) </option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="input-group mb-2">
                  <?php if(isset($onemenuitem[1])){ ?>
                    <input type="hidden" id="menuitem2" name="menuitem2" value="<?= $onemenuitem[1]->id ?>">
                    <input type="text" class="form-control" id="qty2" name="qty2" placeholder="Input Quantity" value="<?= $onemenuitem[1]->qty ?>">
                  <?php }else{ ?>
                    <input type="text" class="form-control" id="qty2" name="qty2" placeholder="Input Quantity">
                  <?php } ?>
                </div>
                <div class="form-group">
                  <label>Bahan 3: </label>
                  <select name="bahan3" id="bahan3 bahan" data-no="3" class="form-control" autocomplete="off">
                  <option value="">-- Pilih Bahan --</option>
                    <?php foreach($unititems as $item){ ?>
                      <?php if(isset($onemenuitem[2])){ ?>
                        <?php if($onemenuitem[2]->item_id == $item->id){?>
                          <option value="<?= $item->id ?>" selected><?= $item->name ?> (<?= $item->unit ?>) </option>
                        <?php }else{ ?>
                          <option value="<?= $item->id ?>"><?= $item->name ?> (<?= $item->unit ?>) </option>
                        <?php } ?>
                      <?php } else{ ?>
                        <option value="<?= $item->id ?>"><?= $item->name ?> (<?= $item->unit ?>) </option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="input-group mb-2">
                  <?php if(isset($onemenuitem[2])){ ?>
                    <input type="hidden" id="menuitem3" name="menuitem3" value="<?= $onemenuitem[2]->id ?>">
                    <input type="text" class="form-control" id="qty3" name="qty3" placeholder="Input Quantity" value="<?= $onemenuitem[2]->qty ?>">
                  <?php }else{ ?>
                    <input type="text" class="form-control" id="qty3" name="qty3" placeholder="Input Quantity">
                  <?php } ?>
                </div>
                <div class="form-group">
                  <label>Bahan 4: </label>
                  <select name="bahan4" id="bahan4 bahan" data-no="4" class="form-control" autocomplete="off">
                    <option value="">-- Pilih Bahan --</option>
                    <?php foreach($unititems as $item){ ?>
                      <?php if(isset($onemenuitem[3])){ ?>
                        <?php if($onemenuitem[3]->item_id == $item->id){?>
                          <option value="<?= $item->id ?>" selected><?= $item->name ?> (<?= $item->unit ?>) </option>
                        <?php }else{ ?>
                          <option value="<?= $item->id ?>"><?= $item->name ?> (<?= $item->unit ?>) </option>
                        <?php } ?>
                      <?php } else{ ?>
                        <option value="<?= $item->id ?>"><?= $item->name ?> (<?= $item->unit ?>) </option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="input-group mb-2">
                  <?php if(isset($onemenuitem[3])){ ?>
                    <input type="hidden" id="menuitem4" name="menuitem4" value="<?= $onemenuitem[3]->id ?>">
                    <input type="text" class="form-control" id="qty4" name="qty4" placeholder="Input Quantity" value="<?= $onemenuitem[3]->qty ?>">
                  <?php }else{ ?>
                    <input type="text" class="form-control" id="qty4" name="qty4" placeholder="Input Quantity">
                  <?php } ?>
                </div>
          </div>
          <div class="col-lg-4">
          <div class="form-group">
                  <label>Bahan 5: </label>
                  <select name="bahan5" id="bahan5 bahan" data-no="5" class="form-control" autocomplete="off">
                    <option value="">-- Pilih Bahan --</option>
                    <?php foreach($unititems as $item){ ?>
                      <?php if(isset($onemenuitem[4])){ ?>
                        <?php if($onemenuitem[4]->item_id == $item->id){?>
                          <option value="<?= $item->id ?>" selected><?= $item->name ?> (<?= $item->unit ?>) </option>
                        <?php }else{ ?>
                          <option value="<?= $item->id ?>"><?= $item->name ?> (<?= $item->unit ?>) </option>
                        <?php } ?>
                      <?php } else{ ?>
                        <option value="<?= $item->id ?>"><?= $item->name ?> (<?= $item->unit ?>) </option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="input-group mb-2">
                  <?php if(isset($onemenuitem[4])){ ?>
                    <input type="hidden" id="menuitem5" name="menuitem5" value="<?= $onemenuitem[4]->id ?>">
                    <input type="text" class="form-control" id="qty5" name="qty5" placeholder="Input Quantity" value="<?= $onemenuitem[4]->qty ?>">
                  <?php }else{ ?>
                    <input type="text" class="form-control" id="qty5" name="qty5" placeholder="Input Quantity">
                  <?php } ?>
                </div>
                <div class="form-group">
                  <label>Bahan 6: </label>
                  <select name="bahan6" id="bahan6 bahan" data-no="6" class="form-control" autocomplete="off">
                    <option value="">-- Pilih Bahan --</option>
                    <?php foreach($unititems as $item){ ?>
                      <?php if(isset($onemenuitem[5])){ ?>
                        <?php if($onemenuitem[5]->item_id == $item->id){?>
                          <option value="<?= $item->id ?>" selected><?= $item->name ?> (<?= $item->unit ?>) </option>
                        <?php }else{ ?>
                          <option value="<?= $item->id ?>"><?= $item->name ?> (<?= $item->unit ?>) </option>
                        <?php } ?>
                      <?php } else{ ?>
                        <option value="<?= $item->id ?>"><?= $item->name ?> (<?= $item->unit ?>) </option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="input-group mb-2">
                  <?php if(isset($onemenuitem[5])){ ?>
                    <input type="hidden" id="menuitem6" name="menuitem6" value="<?= $onemenuitem[5]->id ?>">
                    <input type="text" class="form-control" id="qty6" name="qty6" placeholder="Input Quantity" value="<?= $onemenuitem[5]->qty ?>">
                  <?php }else{ ?>
                    <input type="text" class="form-control" id="qty6" name="qty6" placeholder="Input Quantity">
                  <?php } ?>
                </div>
                <div class="form-group">
                  <label>Bahan 7: </label>
                  <select name="bahan7" id="bahan7 bahan" data-no="7" class="form-control" autocomplete="off">
                    <option value="">-- Pilih Bahan --</option>
                    <?php foreach($unititems as $item){ ?>
                      <?php if(isset($onemenuitem[6])){ ?>
                        <?php if($onemenuitem[6]->item_id == $item->id){?>
                          <option value="<?= $item->id ?>" selected><?= $item->name ?> (<?= $item->unit ?>) </option>
                        <?php }else{ ?>
                          <option value="<?= $item->id ?>"><?= $item->name ?> (<?= $item->unit ?>) </option>
                        <?php } ?>
                      <?php } else{ ?>
                        <option value="<?= $item->id ?>"><?= $item->name ?> (<?= $item->unit ?>) </option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="input-group mb-2">
                  <?php if(isset($onemenuitem[6])){ ?>
                    <input type="hidden" id="menuitem7" name="menuitem7" value="<?= $onemenuitem[6]->id ?>">
                    <input type="text" class="form-control" id="qty7" name="qty7" placeholder="Input Quantity" value="<?= $onemenuitem[6]->qty ?>">
                  <?php }else{ ?>
                    <input type="text" class="form-control" id="qty7" name="qty7" placeholder="Input Quantity">
                  <?php } ?>
                </div>
                <div class="form-group">
                  <label>Bahan 8: </label>
                  <select name="bahan8" id="bahan8 bahan" data-no="8" class="form-control" autocomplete="off">
                  <option value="">-- Pilih Bahan --</option>
                    <?php foreach($unititems as $item){ ?>
                      <?php if(isset($onemenuitem[7])){ ?>
                        <?php if($onemenuitem[7]->item_id == $item->id){?>
                          <option value="<?= $item->id ?>" selected><?= $item->name ?> (<?= $item->unit ?>) </option>
                        <?php } else{ ?>
                          <option value="<?= $item->id ?>"><?= $item->name ?> (<?= $item->unit ?>) </option>
                        <?php } ?>
                      <?php } else{ ?>
                        <option value="<?= $item->id ?>"><?= $item->name ?> (<?= $item->unit ?>) </option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
                <div class="input-group mb-2">
                  <?php if(isset($onemenuitem[7])){ ?>
                    <input type="hidden" id="menuitem8" name="menuitem8" value="<?= $onemenuitem[7]->id ?>">
                    <input type="text" class="form-control" id="qty8" name="qty8" placeholder="Input Quantity" value="<?= $onemenuitem[7]->qty ?>">
                  <?php }else{ ?>
                    <input type="text" class="form-control" id="qty8" name="qty8" placeholder="Input Quantity">
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>

  </div>
  <!-- /.container-fluid -->

</div>
<!-- End of Main Content --> 