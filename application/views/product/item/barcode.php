  <!-- Begin Page Content -->
  <div class="container-fluid">

    <div class="card shadow mb-4">
      <div class="card-header py-3">
          <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
          <?= $this->session->flashdata('message'); ?>
      </div>
      <div class="card-body">
          <?php 
            $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
            echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($oneitem->barcode, $generator::TYPE_CODE_128)) . '">';
          ?>
          <p><?= $oneitem->barcode?></p>
          <a href="<?= site_url('item/printpdf_barcode/'.$oneitem->id); ?>" target="_blank" class="btn btn-default btn-xs">
            <i class="fa fa-print"></i>
          </a>
      </div>
      <div class="card-body">
          <?php 
            // $qr = new Endroid\QrCode\QrCode($oneitem->barcode);
            // header('Content-Type: '.$qr->getContentType());
            // echo $qr->writeString();
          ?>
      </div>
    </div>

  </div>
  <!-- /.container-fluid -->

</div>
<!-- End of Main Content --> 