<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Item_model extends CI_Model
{
    public function getItems()
    {
        $this->db->select('product_item.*, product_category.nama as category_name');
        $this->db->from('product_item');
        $this->db->join('product_category','product_category.id = product_item.category_id');
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

    public function updateitem($data)
	{
		$this->db->update('product_item', $data, ['id' => $data['id']]);

		return $this->db->affected_rows() == 1;
	
	}

}
