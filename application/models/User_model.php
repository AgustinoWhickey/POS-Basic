<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
	public function getUsers()
    {
        return $this->db->get('user')->result();
    }

    public function insertuser($data)
    {
        $aksi = $this->db->insert('user', $data);
		if ($aksi) {
			echo 1;
		} else {
			echo 0;
		}
    }
	
	public function deleteUser($id)
    {
		$aksi = $this->db->where('id', $id)->delete('user');
		return $this->db->affected_rows();
    }
	
	public function updateuser($data)
	{
		$arr = [
			'nama_user' => $data['nama_user'],
			'role' => $data['role']
		];

		$this->db->update('user', $data, ['id' => $data['id']]);

		return $this->db->affected_rows() == 1;
	
	}
	
	
	public function getUser($iduser)
    {
        $this->db->select('*');
        $this->db->where('id', $iduser);
        $aksi = $this->db->get('user')->row();
        return $aksi;
    }
}
