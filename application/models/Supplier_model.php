<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_model extends CI_Model
{
    public function getSuppliers()
    {
        return $this->db->get('supplier')->result();
    }

    public function insertuser($data)
    {
        $aksi = $this->db->insert('supplier', $data);
		if ($aksi) {
			echo 1;
		} else {
			echo 0;
		}
    }

    public function deleteSupplier($id)
    {
		$aksi = $this->db->where('id', $id)->delete('supplier');
		return $this->db->affected_rows();
    }

    public function getSupplier($idsupplier)
    {
        $this->db->select('*');
        $this->db->where('id', $idsupplier);
        $aksi = $this->db->get('supplier')->row();
        return $aksi;
    }

    public function updatesupplier($data)
	{
		$arr = [
			'name' => $data['name'],
			'phone' => $data['phone'],
			'address' => $data['address'],
			'description' => $data['description'],
			'updated' => $data['updated'],
		];

		$this->db->update('supplier', $data, ['id' => $data['id']]);

		return $this->db->affected_rows() == 1;
	
	}

}
