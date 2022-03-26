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
      <!-- <div class="col-lg-6 text-right">
        <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newUserModal">
          <i class="fa fa-user-plus"></i>  Tambah Kategori
        </a>
      </div> -->
    </div>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Table Kategori</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered display" id="reportTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Invoice</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Discount</th>
                <th>Pembayaran</th>
                <th>Actions</th>
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

<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="modal-detailLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-detailLabel">Tambah Kategori</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
			</div>
			<div class="modal-body table-responsive">
                <table class="table table-bordered no-margin">
                    <tbody>
                        <tr>
                            <th style="width:20%;">Invoice</th>
                            <td style="width:30%;"><span id="invoice"></span></td>
                            <th style="width:20%;">Date Time</th>
                            <td style="width:30%;"><span id="datetime"></span></td>
                        </tr>
                        <tr>
                            <th>Grand Total</th>
                            <td><span id="grandtotal"></span></td>
                            <th>Kasir</th>
                            <td><span id="kasir"></span></td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td><span id="total"></span></td>
                            <th>Cash</th>
                            <td><span id="cash"></span></td>
                        </tr>
                        <tr>
                            <th>Discount</th>
                            <td><span id="discount"></span></td>
                            <th>Change</th>
                            <td><span id="change"></span></td>
                        </tr>
                        <tr>
                            <th>Note</th>
                            <td colspan="3"><span id="note"></span></td>
                        </tr>
                        <tr>
                            <th>Product</th>
                            <td colspan="3"><span id="product"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
		</div>
	</div>
</div>
<script>

    $(document).on('click', '#detail', function(){
        var ini = $(this);
        $('#invoice').text(ini.data('invoice'));
        $('#datetime').text(ini.data('date'));
        $('#total').text(ini.data('total'));
        $('#discount').text(ini.data('discount'));
        $('#change').text(ini.data('remaining'));
        $('#cash').text(ini.data('cash'));
        $('#grandtotal').text(ini.data('grandtotal'));
        $('#note').text(ini.data('note'));
        $('#kasir').text(ini.data('kasir'));
        $('#product').text(ini.data('product'));

        var product = '<table class="table no-margin">';
        product += '<tr><th>Item</th><th>Price</th><th>Qty</th><th>Disc</th><th>Total</th>';
        $.getJSON('<?= site_url('report/sale_product/')?>'+ini.data('saleid'), function(data){
            $.each(data, function(key, val){
                product += '<tr><td>'+val.name+'</td><td>'+val.price+'</td><td>'+val.qty+'</td><td>'+val.discount_item+'</td></td><td>'+val.total+'</td></tr>';
            });
            product += '</table>';
            $('#product').html(product);
        });
    });
</script>