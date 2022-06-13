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
        <a data-toggle="modal" href="#newUserModal" class="btn btn-primary">
            <i class="fa fa-user-plus"></i>  Input Stock Out
        </a>
      </div>
    </div>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Table Stock Out</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Produk Item</th>
                <th>Qty</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </thead>
            <tbody>
    				<?php
    					$i = 1; 
    					foreach($stocks as $stock){ 
					  ?>
    					<tr>
    						<th scope="row"><?= $i++; ?></th>
    						<td><?= $stock->product_barcode; ?></td>
    						<td><?= $stock->product_name; ?></td>
    						<td><?= $stock->qty; ?></td>
    						<td><?= date("d-m-Y",$stock->date); ?></td>
    						<td>
                  <div class="row">
                    <div class="col-md-2">
                      <a data-toggle="modal" id="show_detail" href="#modal-detail" class="badge badge-default" 
                        data-id="<?= $stock->id; ?>" 
                        data-kode="<?= $stock->product_barcode; ?>" 
                        data-name="<?= $stock->product_name; ?>" 
                        data-detail="<?= $stock->detail; ?>" 
                        data-supplier="<?= $stock->supplier_name; ?>" 
                        data-inputdate="<?= date("d-m-Y",$stock->date); ?>" 
                        data-qty="<?= $stock->qty; ?>">
                      Detail</a>
                    </div>
                    <div class="col-md-6">
                      <form action="<?= site_url('stock/stockout_delete')?>" method="post">
                        <input type="hidden" name="idproduct" value="<?= $stock->product_id?>">
                        <input type="hidden" name="idstock" value="<?= $stock->id?>">
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
	<div class="modal-dialog" role="document" style="overflow-y: initial;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="newMenuModalLabel">Input Stock Out</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
			</div>
			<form action="<?= base_url('stock/stockout'); ?>" method="post">
				<div class="modal-body"  style="height: 70vh; overflow-y:auto;">
                    <div class="form-group">
						<label>Tanggal: </label>
						<input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d')?>" required>
					</div>
                    <div>
                        <label for="kode">Kode Barang</label>
                    </div>
                    <div class="form-group input-group">
                        <input type="hidden" name="item_id" id="item_id" >
                        <input type="text" name="kode_barang" id="kode_barang" class="form-control" required autofocus>
                        <span class="input-group-btn">
                            <a data-toggle="modal" href="#modal-item" class="btn btn-primary">
                                <i class="fa fa-search"></i>
                            </a>
                            <!-- <button class="btn btn-info btn-flat" type="button" data-toggle="modal" data-target="modal-item">
                                <i class="fa fa-search"></i>
                            </button> -->
                        </span>
                    </div>
					  <div class="form-group">
            			<label>Nama Item: </label>
                <input type="text" class="form-control" id="name" name="name" readonly>
              </div>
          			<div class="form-group">
                        <label for="unit_name">Initial Stock</label>
                        <input type="text" name="stock" id="stock" class="form-control" value="-" readonly>
                      </div>
					<div class="form-group">
           		 		<label>Detail: </label>
						<textarea class="form-control" id="detail" name="detail">Input Detail</textarea> 
					</div>
                    <div class="form-group">
            			<label>Qty: </label>
						<input type="number" class="form-control" id="qty" name="qty" placeholder="Input Qty">
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

<div class="modal fade" id="modal-item">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Select Product Item</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body table-responsive">
                <table class="table table-bordered table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($items as $item){ ?>
                          <tr>
                            <td><?= $item->barcode; ?></td>
                            <td><?= $item->name; ?></td>
                            <td><?= indo_currency($item->price); ?></td>
                            <td><?= $item->stock; ?></td>
                            <td>
                                <button class="btn btn-xs btn-info" id="selectstockout" data-id="<?= $item->id; ?>" data-price="<?= indo_currency($item->price); ?>" data-name="<?= $item->name; ?>" data-stock="<?= $item->stock; ?>">
                                    <i class="fa fa-check"></i> Pilih
                                </button>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-detail">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Stock Item</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body table-responsive">
                <table class="table table-bordered table-striped" id="table1">
                    <tr>
                      <th>Nama</th>
                      <td><span id="det_nama"></span></td>
                    </tr>
                    <tr>
                      <th>Harga per Qty</th>
                      <td><span id="det_harga"></span></td>
                    </tr>
                    <tr>
                      <th>Qty</th>
                      <td><span id="det_qty"></span></td>
                    </tr>
                    <tr>
                      <th>Detail</th>
                      <td><span id="det_detail"></span></td>
                    </tr>
                    <tr>
                      <th>Tanggal Input</th>
                      <td><span id="det_inputdate"></span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(document).on('click', '#selectstockout', function() {
            var itemid = $(this).data('id');
            var name = $(this).data('name');
            var stock = $(this).data('stock');
            $('#item_id').val(itemid);
            $('#kode_barang').val(code);
            $('#name').val(name);
            $('#stock').val(stock);
            $('#modal-item').modal('hide');
        });

        $(document).on('click', '#show_detail', function() {
            var stockid = $(this).data('id');
            var name = $(this).data('name');
            var detail = $(this).data('detail');
            var inputdate = $(this).data('inputdate');
            var qty = $(this).data('qty');
            $('#det_nama').html(name);
            $('#det_qty').html(qty);
            $('#det_detail').html(detail);
            $('#det_inputdate').html(inputdate);
        });
    });
</script>