<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Peoples_model extends CI_Model
{
    public function getAllPeoples(){
    	$query = $this->db->get('peoples');
    	return $query->result_array();
    }

    public function getPeople($limit, $start, $keyword=null){
        if($keyword){
            $this->db->like('name',$keyword);
            $this->db->or_like('email',$keyword);
        }

        $query = $this->db->get('peoples',$limit, $start);
        return $query->result_array();
    }

     public function countAllPeoples(){
        $query = $this->db->get('peoples');
        return $query->num_rows();
    }
}
