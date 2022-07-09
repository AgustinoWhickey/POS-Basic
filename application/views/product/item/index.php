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
        <div class="container">
          <div class="row">
            <div class="col-lg-6">
                <h1 class="h3 mb-4 text-gray-800">Tambah Product</h1>
            </div>
          </div>
        </div>
			</div>

			<form action="<?= base_url('item'); ?>" id="menuform" method="post" enctype="multipart/form-data">
				<div class="modal-body">
          <div class="container">
            <div class="row">
                <div class="col-md-2 form-group">
                  <label>Nama Item: </label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Input Nama">
                </div>
                <div class="col-md-2 form-group">
                  <label>Kode: </label>
                  <input type="text" class="form-control" id="barcode" name="barcode" placeholder="Input Barcode">
                </div>
                <div class="col-md-2 form-group">
                  <label>Kategori: </label>
                  <select name="kategori" id="kategori" class="form-control">
                    <?php foreach($category as $cat){ ?>
                        <option value="<?= $cat->id ?>"><?= $cat->nama ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-md-2 form-group">
                  <label>Harga: </label>
                  <input type="number" class="form-control" id="harga" name="harga" placeholder="Input Harga">
                </div>
                <div class="col-md-3 form-group">
                  <label>Gambar: </label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="image" name="image">
                    <label for="image" class="custom-file-label">Choose file</label>
                  </div>
                </div>

              </div>
            </div>
          </div>

            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Table Menu Product</h6>
              </div>
              <div class="card-body">
                  <div class="row">
                      <div class="col-md-3 form-group">
                        <label>Nama Bahan: </label>
                        <input type="hidden" id="idbahan" name="idbahan" value="1">
                        <input type="hidden" id="selectedbahan" name="selectedbahan">
                        <select name="namabahan" id="namabahan" class="form-control">
                          <option value="" selected>-- Pilih Bahan --</option>
                          <?php foreach($unititems as $item){ ?>
                              <option value="<?= $item->id ?>" desc="<?= $item->name ?>"><?= $item->name ?> (<?= $item->unit ?>) </option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="col-md-3 form-group">
                        <label>Qty: </label>
                        <input type="number" class="form-control" id="qtybahan" name="qtybahan">
                      </div>
                      
                      <div class="col-md-2" style="padding-top: 31px;">
                          <a href="#" class="btn btn-primary mb-3" id="tambahbahan"> Tambah  </a>
                      </div>
                      
                  </div>

                <div class="table-responsive">
                  <table class="table table-bordered" id="tablebahan" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Bahan</th>
                        <th>Qty</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                    
                  </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" id="submitmenu" class="btn btn-primary">Simpan</button>
            </div>

          </div>
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

    $("#namabahan").change(function(){ 
        var element = $(this).find('option:selected'); 
        var myTag = element.attr("desc");

        $('#selectedbahan').val(myTag); 
    }); 

    $("#submitmenu").click(function(event){
      event.preventDefault();
      var nama = $('#name').val();
      var barcode = $('#barcode').val();
      if(nama == '' && barcode == ''){
        alert('Masukkan Nama Item atau Barcode terlebih dahulu!');
      } else {
        $('form#menuform').submit();
      }
    });

    $('#tambahbahan').on('click', function(e){
      var idbahan = $('#idbahan').val();
      var namaid = $('#namabahan').val();
      var selectedbahan = $('#selectedbahan').val();
      var qty = $('#qtybahan').val();

      if(namaid != '' && qty != ''){
        id = parseInt(idbahan);
        $('#idbahan').val(id+1);
        $('#namabahan').val('');
        $('#qtybahan').val('');

        var newdata = "<tr><td>"+idbahan+"</td><td>"+selectedbahan+"</td><td>"+qty+"</td><td><input type='hidden' name='bahan"+idbahan+"' value='"+namaid+"'><input type='hidden' name='qty"+idbahan+"' value='"+qty+"'><a href='#' id='deletebahan' class='btn btn-xs btn-danger'>Delete</a></td></tr>";

        $("#tablebahan tbody").append(newdata);
      } else {
        alert('Pilih bahan dan masukkan quantity terlebih dahulu!');
      }
    });

    $("#tablebahan").on('click', '#deletebahan', function () {
      $(this).closest('tr').remove();
  });
  });
</script>