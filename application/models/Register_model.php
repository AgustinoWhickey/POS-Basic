<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Register_model extends CI_Model
{

    public function insertregister($data)
    {
        $aksi = $this->db->insert('user', $data);
		if ($aksi) {
			echo 1;
		} else {
			echo 0;
		}
    }
}
