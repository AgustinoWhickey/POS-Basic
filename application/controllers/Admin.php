<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Login_model','login_m');
		is_logged_in();
	}
	
	public function index()
	{
		$query = $this->db->query("SELECT sale_detail.id AS saleid, product_item.name, (SELECT SUM(sale_detail.qty)) AS sold, (SELECT SUM(sale.total_price)) AS total_penjualan
				FROM sale_detail
					INNER JOIN sale ON sale_detail.sale_id = sale.id
					INNER JOIN product_item ON sale_detail.item_id = product_item.id
				GROUP BY sale_detail.item_id
				ORDER BY sold DESC
				LIMIT 10");

		$result = $query->result();

		$total_penjualan = 0;
		$total_item_terjual = 0;
		foreach($result as $value){
			$total_penjualan += (int)$value->total_penjualan;
			$total_item_terjual += (int)$value->sold;
		}
		
		$data['chart'] = $result;
		$data['user'] 	= $this->login_m->ceklogin($this->session->userdata('email'));
		$data['total_penjualan'] = indo_currency($total_penjualan);
		$data['total_item_terjual'] = $total_item_terjual;
		$data['title'] 	= 'Dashboard';

		$this->load->view("templates/header",$data);
		$this->load->view("templates/sidebar",$data);
		$this->load->view("templates/topbar",$data);
		$this->load->view("admin/index",$data);
		$this->load->view("templates/footer_dashboard",$data);
	
	}

	public function role(){

		$data['user'] 	= $this->login_m->ceklogin($this->session->userdata('email'));
		$data['role'] 	= $this->db->get('user_role')->result_array();
		$data['title'] 	= 'Role';

		$this->load->view("templates/header",$data);
		$this->load->view("templates/sidebar",$data);
		$this->load->view("templates/topbar",$data);
		$this->load->view("admin/role",$data);
		$this->load->view("templates/footer");
	
	}


	public function roleaccess($id){

		$data['user'] 	= $this->login_m->ceklogin($this->session->userdata('email'));
		$data['role'] 	= $this->db->get_where('user_role',['id' => $id])->row_array();
		$this->db->where('id !=',1);
		$data['menu']	= $this->db->get('user_menu')->result_array();
		$data['title'] 	= 'Role Access';

		$this->load->view("templates/header",$data);
		$this->load->view("templates/sidebar",$data);
		$this->load->view("templates/topbar",$data);
		$this->load->view("admin/role-access",$data);
		$this->load->view("templates/footer");
	
	}

	public function changeaccess(){

		$menu_id = $this->input->post('menuId');
		$role_id = $this->input->post('roleId');

		$data = [
			'role_id' => $role_id,
			'menu_id' => $menu_id,
		];

		$access = $this->db->get_where('user_access_menu',$data);

		if($access->num_rows() < 1){
			$this->db->insert('user_access_menu',$data);
		} else {
			$this->db->delete('user_access_menu',$data);
		}

		$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Access Changed!</div>');
	
	}

}
