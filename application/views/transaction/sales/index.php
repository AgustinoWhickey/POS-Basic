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
    </div>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Input Data Sales</h6>
      </div>
      <div class="card-body">
        <section class="content">
          <div class="row">
            <div class="col-lg-4">
              <div class="box box-widget">
                <table width="100%">
                  <tr>
                    <td style="vertical-align:top;">
                      <label for="date">Date</label>
                    </td>
                    <td>
                      <div class="form-group">
                        <input type="date" id="date" value="<?= date('Y-m-d')?>" class="form-control">
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="vertical-align:top; width:30%">
                      <label for="user">Kasir</label>
                    </td>
                    <td>
                      <div class="form-group">
                        <input type="text" id="user" class="form-control" value="<?= $this->session->userdata('name')?>" readonly>
                      </div>
                    </td>
                  </tr>
                  <!-- <tr>
                    <td style="vertical-align:top">
                      <label for="customer">Customer</label>
                    </td>
                    <td>
                      <div>
                        <select id="customer" class="form-control">
                          <option value="umum">Umum</option>
                        </select>
                      </div>
                    </td>
                  </tr> -->
                </table>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="box box-widget">
                <div class="box-body">
                  <table width="100%">
                    <tr>
                      <td style="width:30%">
                        <label for="barcode">Kode</label>
                      </td>
                      <td>
                        <div class="form-group input-group">
                          <input type="hidden" id="item_id">
                          <input type="hidden" id="price">
                          <input type="hidden" id="stock">
                          <input type="hidden" id="kode">
                          <input type="text" id="barcode" class="form-control" autofocus>
                          <span class="input-group-btn">
                            <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-item">
                              <i class="fa fa-search"></i>
                            </button>
                          </span>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label for="qty">Qty</label>
                      </td>
                      <td>
                        <div class="form-group">
                          <input type="number" id="qty" value="1" min="1" class="form-control">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td></td>
                      <td>
                        <div>
                          <button class="btn btn-primary" id="add_cart">
                            <i class="fa fa-cart-plus"></i>Add
                          </button>
                        </div>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            
            <div class="col-lg-4">
              <div class="box box-widget">
                <div class="box-body">
                  <div style="text-align:right;">
                    <h4>Invoice <b><span id="invoice"><?= $invoice ?></span></b></h4>
                    <h1><b><span id="grand_total">0</span></b></h1>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <br>
          
          <div class="row">
            <div class="col-lg-12">
              <div class="box box-widget">
                <div class="box-body table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Product Item</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Discount Item</th>
                        <th>Total</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody id="cart_table">
                      <?php $this->view('transaction/sales/cart_data');?>
                    </tbody>
                  </table>
                </div>
                <br>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-lg-3">
              <div class="box box-widget">
                <div class="box-body">
                  <table width="100%">
                    <tr>
                      <td style="vertical-align:top; width:30%">
                        <label for="sub_total">Sub Total</label>
                      </td>
                      <td>
                        <div class="form-group">
                          <input type="number" id="sub_total" readonly class="form-control">
                          <input type="hidden" id="qty_cart">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td style="vertical-align:top">
                        <label for="dicsount">Discount</label>
                      </td>
                      <td>
                        <div class="form-group">
                          <input type="number" id="discount" value="0" min="0" class="form-control">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td style="vertical-align:top">
                        <label for="grand_total">Grand Total</label>
                      </td>
                      <td>
                        <div class="form-group">
                          <input type="number" readonly id="grand_total2" class="form-control">
                        </div>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>

            <div class="col-lg-3">
              <div class="box box-widget">
                <div class="box-body">
                  <table width="100%">
                    <tr>
                      <td style="vertical-align:top; width:30%">
                        <label for="cash">Cash</label>
                      </td>
                      <td>
                        <div class="form-group">
                          <input type="number" value="0" min="0" id="cash" class="form-control">
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td style="vertical-align:top">
                        <label for="change">Change</label>
                      </td>
                      <td>
                        <div>
                          <input type="number" readonly id="change" class="form-control">
                        </div>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>

            <div class="col-lg-3">
              <div class="box box-widget">
                <div class="box-body">
                  <table width="100%">
                    <tr>
                      <td style="vertical-align:top">
                        <label for="note">Note</label>
                      </td>
                      <td>
                        <div>
                          <textarea name="" id="note" rows="3" class="form-control"></textarea>
                        </div>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>

            <div class="col-lg-3">
              <div>
                <button id="cancel_payment" class="btn btn-flat btn-warning">
                  <i class="fa fa-refresh"></i>Cancel
                </button><br><br>
                <button id="process_payment" class="btn btn-flat btn-lg btn-success">
                  <i class="fa fa-paper-plane-o"></i>Process Payment
                </button>
              </div>
            </div>

          </div>
        </section>

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
                                      <button class="btn btn-xs btn-info" id="selectitem" data-price="<?= $item->price; ?>" data-id="<?= $item->id; ?>" data-code="<?= $item->barcode; ?>" data-name="<?= $item->name; ?>" data-stock="<?= $item->stock; ?>">
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

      <div class="modal fade" id="modal-item-edit" tabindex="-1" role="dialog" aria-labelledby="modal-item-edit" aria-hidden="true">
        <div class="modal-dialog" role="document" style="overflow-y: initial;">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="newMenuModalLabel">Input Stock</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"></span>
              </button>
            </div>
            <div class="modal-body"  style="height: 70vh; overflow-y:auto;">     
              <div class="form-group">
                  <label>Kode Item: </label>
                  <input type="text" class="form-control" id="codecart" name="codecart" readonly>
                  <input type="hidden" class="form-control" id="idcart" name="idcart">
                </div>
                <div class="form-group">
                  <label for="unit_name">Price</label>
                  <input type="text" name="pricecart" id="pricecart" class="form-control" readonly>
                </div>
                <div class="form-group">
                  <label>Qty: </label>
                  <input type="number" class="form-control" id="qtycart" name="qtycart" placeholder="Input Qty">
                </div>
                <div class="form-group">
                  <label for="unit_name">Discount</label>
                  <input type="text" name="discountcart" id="discountcart" class="form-control">
                </div>
                <div class="form-group">
                    <label>Total: </label>
                  <input type="text" class="form-control" id="totalcart" name="totalcart" readonly>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button class="btn btn-primary" id="upcart">Update</button>
            </div>
          </div>
        </div>
      </div>

      </div>
    </div>

  </div>
  <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<script>
    $(document).ready(function() {
        $(document).on('click', '#selectitem', function() {
            var itemid = $(this).data('id');
            var code = $(this).data('code');
            var price = $(this).data('price');
            var stock = $(this).data('stock');
            $('#item_id').val(itemid);
            $('#barcode').val(code);
            $('#price').val(price);
            $('#stock').val(stock);
            $('#modal-item').modal('hide');
        });

        $(document).on('click', '#updatecart', function() {
          var cartid = $(this).data('cartid');
          var code = $(this).data('barcode');
          var product = $(this).data('product');
          var price = $(this).data('price');
          var qty = $(this).data('qty');
          var total = $(this).data('total');
          var discount = $(this).data('discount');
          $('#idcart').val(cartid);
          $('#codecart').val(code);
          $('#pricecart').val(price);
          $('#qtycart').val(qty);
          $('#discountcart').val(discount);
          $('#totalcart').val(total);
        });

        $(document).on('click', '#upcart', function() {
          var cartid = $('#idcart').val();
          var code = $('#codecart').val();
          var price = $('#pricecart').val();
          var qty = $('#qtycart').val();
          var total = $('#totalcart').val();
          var discount = $('#discountcart').val();
          if(qty == '' || qty < 1){
            alert('Quantity harus diisi!');
            $('#qtycart').focus();
          } else {
            $.ajax({
              type: 'POST',
              url: '<?= site_url('sale/updatecart') ?>',
              data: {'cartid': cartid, 'qty':qty, 'total':total, 'discount':discount},
              dataType: 'json',
              success: function(result){
                console.log(result);
                if(result == 1){
                  $('#cart_table').load('<?= site_url('sale/cart_data') ?>', function(){
                    alert('Update Cart Berhasil!');
                    calculate();
                    $('#modal-item-edit').modal('hide');
                  });
                }else {
                  alert('Tambah cart gagal')
                }
              }
            });
          }
        });

        $(document).on('change', '#qtycart', function() {
          var qty = $(this).val();
          var price = $('#pricecart').val();
          var newtotal = parseInt(qty) * parseInt(price);
          $('#totalcart').val(newtotal);
        });

        $(document).on('click', '#add_cart', function() {
            var item_id = $('#item_id').val();
            var price = $('#price').val();
            var stock = $('#stock').val();
            var qty = $('#qty').val();
            var qty_cart = $('#qty_cart').val();
            if(item_id == ''){
              alert('Product belum dipilih');
              $('#barcode').focus();
            } else if(stock < 1 || parseInt(stock) < (parseInt(qty_cart) + parseInt(qty))){
              alert('Stock tidak mencukupi');
              $('#item_id').val('');
              $('#barcode').val('');
              $('#barcode').focus();
            } else {
              $.ajax({
                type: 'POST',
                url: '<?= site_url('sale/proses') ?>',
                data: {'add_cart': true, 'item_id':item_id, 'price': price, 'qty':qty},
                dataType: 'json',
                success: function(result){
                  console.log(result);
                  if(result == 1){
                    $('#cart_table').load('<?= site_url('sale/cart_data') ?>', function(){
                      calculate();
                      $('#item_id').val('');
                      $('#barcode').val('');
                      $('#barcode').focus();
                      $('#qty').val(1);
                    });
                  }else {
                    alert('Tambah cart gagal')
                  }
                }
              });
            }
        });

        $(document).on('click', '#del_cart', function() {
            var cartid = $(this).data('cartid');
            $.ajax({
              type: 'POST',
              url: '<?= site_url('sale/delete') ?>',
              data: {'id':cartid},
              dataType: 'json',
              success: function(result){
                if(result == 1){
                  $('#cart_table').load('<?= site_url('sale/cart_data') ?>', function(){
                    console.log('Load Cart Data: Success');
                    calculate();
                  });
                }else {
                  alert('Tambah cart gagal')
                }
              }
            });
        });

        function calculate(){
          var subtotal = 0;
          var qtycart = 0;
          $('#cart_table tr').each(function() {
            subtotal += parseInt($(this).find('#total').text());
            qtycart += parseInt($(this).find('#cart_qty').text());
          });
          isNaN(subtotal) ? $('#sub_total').val(0) : $('#sub_total').val(subtotal);
          isNaN(qtycart) ? $('#qty_cart').val(0) : $('#qty_cart').val(qtycart);

          var discount = $('#discount').val();
          var grand_total = subtotal - discount;
          if(isNaN(grand_total)){
            $('#grand_total').text(0);
            $('#grand_total2').val(0);
          } else {
            $('#grand_total').text(grand_total);
            $('#grand_total2').val(grand_total);
          }

          var cash = $('#cash').val();
          cash != 0 ? $('#change').val(cash - grand_total) : $('#change').val(0);
        }

        $(document).ready(function(){
          calculate();
        });

        $(document).on('keyup mouseup', '#discount, #cash', function(){
          calculate();
        });

        $(document).on('click', '#process_payment', function(){
          var subtotal = $('#sub_total').val();
          var discount = $('#discount').val();
          var grandtotal = $('#grand_total').val();
          var cash = $('#cash').val();
          var change = $('#change').val();
          var note = $('#note').val();
          var date = $('#date').val();
          if(subtotal < 1){
            alert('Belum ada product item yang dipilih!');
            $('#barcode').focus();
          } else if(cash < 1){
            alert('Jumlah uang cash belum diinput');
            $('$cash').focus();
          } else {
            if(confirm('Yakin proses transaksi ini?')){
              $.ajax({
                type: 'POST',
                url: '<?= site_url('sale/process_payment')?>',
                data: {'subtotal': subtotal, 'discount': discount, 'grandtotal': grandtotal, 'cash':cash, 'change': change, 'note':note, 'date':date},
                dataType: 'json',
                success: function(result){
                  if(result != null || result != ''){
                    console.log(result);
                    alert('Transaksi Berhasil!');
                    window.open('<?= site_url('sale/cetak/')?>' + result, '_blank');
                  } else {
                    alert('Transaksi Gagal!');
                  }
                  location.href='<?= site_url('sale') ?>';
                }
              });
            }
          }
        });
    });
</script>