<html moznomarginboxws mozdisallowselectionprint>
    <head>
        <title>POS - Print Nota</title>
        <style>
            .content{
                font-family: 'Verdana';
                width: 40mm;
                font-size: 8px;
                padding: 5px;
            }
            .title{
                text-align: center;
                font-size: 8px;
                padding-bottom: 5px;
                border-bottom: 1px dashed;
            }
            .head{
                margin-top: 5px;
                margin-bottom: 10px;
                padding-bottom: 10px;
                border-bottom: 1px solid;
            }
            table{
                font-family: 'Verdana';
                width: 100%;
                font-size: 8px;
            }
            .thanks{
                margin-top: 10px;
                padding-top: 10px;
                text-align: center;
                border-top: 1px dashed;
            }
            @media print{
                @page{
                    width: 58mm;
                    margin: 0mm;
                }
            }
        </style>
    </head>
</html>
<body onload="window.print()">
    <div class="content">
        <div class="title">
            <br><img src="<?= base_url('assets/img/nikmatea.png') ?>" style="width:20%;">
            <div class="thanks">
            <br>Nikmatea Pondok Cabe
            <br>Jl. Cabe V RT.002/RW.05, Pd. Cabe Ilir, Kec. Pamulang, Kota Tangerang Selatan, Banten 15418
            <br>0857-1451-7797
            </div>
        </div>
        <div class="head">
            <table cellspacing="0" cellpadding="0">
                <tr>
                    <td>Date </td>
                    <td style="text-align:center; width:10px;">:  </td>
                    <td style="width: 200px">
                        <?= Date("d/m/Y", strtotime($sale->date))." ".Date("H:i", strtotime($sale->created)); ?>
                    </td>
                </tr>
                <tr>
                    <td>Kasir</td>
                    <td style="text-align:center; width:10px;">:  </td>
                    <td>
                        <?= ucfirst($sale->user_name) ?>
                    </td>
                </tr>
                <tr>
                    <td>No Invoice</td>
                    <td style="text-align:center; width:10px;">:  </td>
                    <td>
                        <?= $sale->invoice ?>
                    </td>
                </tr>
            </table>
        </div>

        <div class="transaction">
            <table class="transaction-table" cellspacing="0" cellpadding="0">
                <?php
                    $arr_discount = array();
                    foreach($sale_detail as $value){ ?>
                        <tr>
                            <td><?= $value->qty." x ".indo_currency($value->price) ?></td>
                            <td></td>
                            <td></td>
                            <td style="text-align:right;"><?= indo_currency($value->total - $value->discount_item)?></td>
                        </tr> 
                        <tr>
                            <td><?= $value->name ?></td>
                        </tr>
                        <?php
                            if($value->discount_item > 0) {
                                $arr_discount[] = $value->discount_item;
                            } 
                        }

                        foreach($arr_discount as $value){ ?>
                        <tr>
                            <td></td>
                            <td colspan="2">Diskon </td>
                            <td style="text-align:right;"><?= indo_currency($value) ?></td>
                        </tr>
                        <?php } ?>

                        <tr>
                            <td colspan="4" style="border-bottom: 1px dashed; padding-top:5px; padding-bottom:5px;"></td>
                        </tr>
                        <tr>
                            <td style="padding-bottom:5px;">Sub Total</td>
                            <td></td>
                            <td></td>
                            <td style="padding-bottom:5px; text-align:right;"><?= indo_currency($sale->total_price) ?></td>
                        </tr>
                        <?php if($sale->discount > 0) { ?>
                            <tr>
                                <td style="padding-bottom:5px">Disc Sale</td>
                                <td></td>
                                <td></td>
                                <td style="padding-bottom:5px; text-align:right;"><?= indo_currency($sale->discount) ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td style="border-top:1px dashed; padding-top:5px">Cash</td>
                            <td></td>
                            <td></td>
                            <td style="text-align:right; border-top:1px dashed; padding-top:5px"><?= indo_currency($sale->cash) ?></td>
                        </tr>
                        <tr>
                            <td>Change</td>
                            <td></td>
                            <td></td>
                            <td style="text-align:right;"><?= indo_currency($sale->remaining) ?></td>
                        </tr>
            </table>
        </div>
        <div class="thanks">
            -- Selamat MeNikmatea -- <br>
            <br>Info Kemitraan dll: 
            <br>0812-5757-6708
            <br>www.nikmateagroup.com
        </div>
    </div>
</body>