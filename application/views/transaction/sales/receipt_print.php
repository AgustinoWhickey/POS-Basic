<html moznomarginboxws mozdisallowselectionprint>
    <head>
        <title>POS - Print Nota</title>
        <style>
            .content{
                width: 80mm;
                font-size: 12px;
                padding: 5px;
            }
            .title{
                text-align: center;
                font-size: 13px;
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
                width: 100%;
                font-size: 12px;
            }
            .thanks{
                margin-top: 10px;
                padding-top: 10px;
                text-align: center;
                border-top: 1px dashed;
            }
            @media print{
                @page{
                    width: 80mm;
                    margin: 0mm;
                }
            }
        </style>
    </head>
</html>
<body onload="window.print()">
    <div class="content">
        <div class="title">
            <b>The Tea</b>
            <br><img src="<?= base_url('assets/img/favicon.png') ?>" style="width:20%;">
        </div>
        <div class="head">
            <table cellspacing="0" cellpadding="0">
                <tr>
                    <td style="width: 200px">
                        <?= Date("d/m/Y", strtotime($sale->date))." ".Date("H:i", strtotime($sale->created)); ?>
                    </td>
                    <td>Kasir</td>
                    <td style="text-align:center; width:10px;">:</td>
                    <td style="text-align:right;">
                        <?= ucfirst($sale->user_name) ?>
                    </td>
                </tr>
                <tr>
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
                            <td><?= $value->name ?></td>
                            <td><?= $value->qty ?></td>
                            <td style="text-align:right;"><?= indo_currency($value->price)?></td>
                            <td style="text-align:right;"><?= indo_currency($value->total - $value->discount_item)?></td>
                        </tr> 
                        <?php
                            if($value->discount_item > 0) {
                                $arr_discount[] = $value->discount_item;
                            } 
                        }

                        foreach($arr_discount as $value){ ?>
                        <tr>
                            <td></td>
                            <td colspan="2" style="text-align:right">Diskon </td>
                            <td style="text-align:right"><?= indo_currency($value) ?></td>
                        </tr>
                        <?php } ?>

                        <tr>
                            <td colspan="4" style="border-bottom: 1px dashed; padding-top:5px;"></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td style="text-align:right; padding-bottom:5px;">Sub Total</td>
                            <td style="text-align:right; padding-bottom:5px;"><?= indo_currency($sale->total_price) ?></td>
                        </tr>
                        <?php if($sale->discount > 0) { ?>
                            <tr>
                                <td colspan="2"></td>
                                <td style="text-align:right; padding-bottom:5px">Disc Sale</td>
                                <td style="text-align:right; padding-bottom:5px;"><?= indo_currency($sale->discount) ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="2"></td>
                            <td style="border-top:1px dashed; text-align:right; padding-top:5px">Cash</td>
                            <td style="border-top:1px dashed; text-align:right; padding-top:5px"><?= indo_currency($sale->cash) ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td style="text-align:right">Change</td>
                            <td style="text-align:right"><?= indo_currency($sale->remaining) ?></td>
                        </tr>
            </table>
        </div>
        <div class="thanks">
            The Tea <br>
            <br><img src="<?= base_url('assets/img/qrcode.jpg') ?>" style="width:20%;">
            <br>thetea.co.id
        </div>
    </div>
</body>