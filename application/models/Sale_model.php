<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sale_model extends CI_Model
{

    public function getInvoice()
    {
        $query = $this->db->query("SELECT MAX(MID(invoice,9,4)) AS invoice_no FROM sale WHERE MID(invoice,3,6) = DATE_FORMAT(CURDATE(), '%y%m%d')");
        if($query->num_rows() > 0){
            $row = $query->row();
            $n = ((int)$row->invoice_no) + 1;
            $no = sprintf("%'.04d", $n);
        } else {
            $no = "0001";
        }
        $invoice = "MP".date('ymd').$no;
        return $invoice;
    }

    public function getCart($params = null){
        $this->db->select('cart.*, product_item.barcode, product_item.name as item_name, cart.price as cart_price');
        $this->db->from('cart');
        $this->db->join('product_item', 'cart.item_id = product_item.id');
        if($params != null){
            $this->db->where($params);
        }
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $query = $this->db->get();
        return $query;
    }

    public function addCart($data)
    {
        $query = $this->db->query("SELECT MAX(id) AS cart_no FROM cart");
        if($query->num_rows() > 0){
            $row = $query->row();
            $cart_no = ((int)$row->cart_no) + 1;
        } else {
            $cart_no = "1";
        }

        $params = [
			'id' => $cart_no,
			'item_id' => (int)$data['item_id'],
			'price' => $data['price'],
			'qty' => $data['qty'],
			'total' => ($data['qty'] * $data['price']),
			'user_id' => $this->session->userdata('user_id'),
			'created' => time()
		];

        $aksi = $this->db->insert('cart', $params); 
        if ($aksi) {
			echo 1;
		} else {
			echo 0;
		}
    }

    public function deleteCart($id)
    {
		$aksi = $this->db->where('id', $id)->delete('cart');
		if ($aksi) {
			echo 1;
		} else {
			echo 0;
		}
    }

    public function deleteCartbyUser()
    {
		$aksi = $this->db->where('user_id', $this->session->userdata('user_id'))->delete('cart');
		if ($aksi) {
			return 1;
		} else {
			return 0;
		}
    }

    function updateCartQty($data){
        $sql = "UPDATE cart SET price = '$data[price]', qty = qty + '$data[qty]', total = '$data[price]' * qty WHERE item_id = '$data[item_id]'";
        $aksi = $this->db->query($sql);
        if ($aksi) {
			echo 1;
		} else {
			echo 0;
		}
    }

    public function updatecart($data)
	{
        $id = $data['id'];
        $qty = $data['qty'];
        $total = $data['total'];
        $discount = $data['discount'];
        $updated = $data['updated'];

        $sql = "UPDATE cart SET qty = '$qty', discount_item = '$discount', total = '$total', updated = '$updated' WHERE id = '$id'";

        $aksi = $this->db->query($sql);

		if ($aksi) {
			echo 1;
		} else {
			echo 0;
		}
	
	}

    public function add_sale($data)
    {
        $params = array(
            'invoice' => $this->getInvoice(),
            'total_price' => $data['subtotal'],
            'discount' => $data['discount'],
            'final_price' => $data['grandtotal'],
            'cash' => $data['cash'],
            'remaining' => $data['change'],
            'note' => $data['note'],
            'user_id' => $this->session->userdata('user_id'),
            'date' => $data['date'],
            'created' => time(),
        );

        $aksi = $this->db->insert('sale', $params); 
        if ($aksi) {
			return $this->db->insert_id();
		} else {
			echo 0;
		}
    }

    public function add_sale_detail($data)
    {
        $aksi = $this->db->insert_batch('sale_detail', $data);
        if ($aksi) {
			return 1;
		} else {
			return 0;
		}
    }

    public function getSale($id = null)
    {
        $this->db->select('sale.*, user.name as user_name, sale.created as sale_created');
        $this->db->from('sale');
        $this->db->join('user', 'sale.user_id = user.id');
        if($id != null){
            $this->db->where('sale.id', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function get_sale_detail($sale_id = null)
    {
        $this->db->select('sale_detail.*, product_item.name as name');
        $this->db->from('sale_detail');
        $this->db->join('product_item', 'sale_detail.item_id = product_item.id');
        if($sale_id != null){
            $this->db->where('sale_detail.sale_id', $sale_id);
        }
        $query = $this->db->get();
        return $query;
    }


}
