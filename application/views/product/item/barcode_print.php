<html>
    <head>
        <title>
            Print Barcode <?= $oneitem->barcode ?>
        </title>
    </head>
    <body>
        <?php 
            $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
            echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($oneitem->barcode, $generator::TYPE_CODE_128)) . '">';
          ?>
    </body>
</html>