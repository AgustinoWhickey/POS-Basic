<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_model extends CI_Model
{
    public function getStocks()
    {
        $this->db->select('stock.*, product_item.name as product_name, product_item.barcode as product_barcode, supplier.name as supplier_name, user.name as user_name');
        $this->db->from('stock');
        $this->db->join('product_item','product_item.id = stock.item_id');
        $this->db->join('supplier','supplier.id = stock.supplier_id','left');
        $this->db->join('user','user.id = stock.user_id');
        $this->db->where('type','in');

        return $this->db->get()->result();
    }

    public function insertitem($data)
    {
        $aksi = $this->db->insert('product_item', $data);
		if ($aksi) {
			echo 1;
		} else {
			echo 0;
		}
    }

    public function deleteItem($id)
    {
		$aksi = $this->db->where('id', $id)->delete('product_item');
		return $this->db->affected_rows();
    }

    public function getItem($iditem)
    {
        $this->db->select('*');
        $this->db->where('id', $iditem);
        $aksi = $this->db->get('product_item')->row();
        return $aksi;
    }

    public function updatestockproduct($data)
	{
        $qty = $data['qty'];
        $id = $data['item_id'];

        $sql = "UPDATE product_item SET stock = stock + '$qty' WHERE id = '$id'";

        $this->db->query($sql);

		return $this->db->affected_rows() == 1;
	
	}

}
