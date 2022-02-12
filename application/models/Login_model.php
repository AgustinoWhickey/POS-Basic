<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model
{

    public function ceklogin($email)
    {
        $aksi = $this->db->get_where('user',['email' => $email])->row_array();
        return $aksi;
    }
}
