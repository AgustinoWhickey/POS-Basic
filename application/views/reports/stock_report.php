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
        <h6 class="m-0 font-weight-bold text-primary">Table Data Stock</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Produk Item</th>
                <th>Category</th>
                <th>Stock</th>
            </thead>
            <tbody>
    				<?php
    					$i = 1; 
    					foreach($data as $val){ 
					  ?>
    					<tr>
    						<th scope="row"><?= $i++; ?></th>
    						<td><?= $val['item_name']; ?></td>
    						<td><?= $val['category']; ?></td>
    						<td><?= $val['qty']; ?></td>
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