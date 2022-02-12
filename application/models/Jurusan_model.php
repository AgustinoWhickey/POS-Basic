<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Jurusan_model extends CI_Model
{
    public function getAllJurusan(){
    	$query = $this->db->get('data_jurusan');
    	return $query->result_array();
    }
}
