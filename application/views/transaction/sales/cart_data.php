<?php
    $no = 1;
    if($cart->num_rows() > 0){
        foreach($cart->result() as $data){ ?>
        <tr>
            <td><?=$no++?></td>   
            <td><?=$data->barcode?></td>   
            <td><?=$data->item_name?></td>   
            <td class="text-right"><?=$data->cart_price?></td>   
            <td class="text-center" id="cart_qty"><?=$data->qty?></td>   
            <td class="text-right"><?=$data->discount_item?></td>   
            <td class="text-right" id="total"><?=$data->total?></td>   
            <td>
            <button id="updatecart" data-toggle="modal" data-target="#modal-item-edit" data-cartid="<?= $data->id?>" data-barcode="<?= $data->barcode?>" data-product="<?= $data->item_name;?>" data-price="<?= $data->cart_price;?>" data-qty="<?= $data->qty?>" data-discount="<?= $data->discount_item?>" data-total="<?= $data->total?>" class="btn btn-xs btn-primary">
                <i class="fa fa-pencil"></i>Update
            </button>
            <button id="del_cart" class="btn btn-xs btn-danger" data-cartid="<?= $data->id?>">
                <i class="fa fa-trash"></i>Delete
            </button>
            </td>   
        <?php }
    } else {
    ?>
    <tr>
    <td class="text-center" colspan="9">Tidak ada item</td>
    </tr>
<?php } ?>