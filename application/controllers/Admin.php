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
		$query = $this->db->query("SELECT sale_detail.id AS saleid, sale.date, product_item.name, (SELECT SUM(sale_detail.qty)) AS sold, (SELECT SUM(sale.total_price)) AS total_penjualan
				FROM sale_detail
					INNER JOIN sale ON sale_detail.sale_id = sale.id
					INNER JOIN product_item ON sale_detail.item_id = product_item.id
				-- WHERE (DATE_FORMAT(FROM_UNIXTIME(sale.created), '%m')) >= MONTH(CURRENT_DATE())
				GROUP BY sale_detail.item_id
				ORDER BY sold DESC");
		$result = $query->result();

		$query2 = $this->db->query("SELECT SUM(stock * unit_price) AS outcome FROM item");
		$result2 = $query2->result();

		$query3 = $this->db->query("SELECT sale_detail.id AS saleid, sale.created, sale.date, product_item.name, (SELECT SUM(sale_detail.qty)) AS sold, (SELECT SUM(sale.total_price)) AS total_penjualan
				FROM sale_detail
					INNER JOIN sale ON sale_detail.sale_id = sale.id
					INNER JOIN product_item ON sale_detail.item_id = product_item.id
				WHERE (DATE_FORMAT(FROM_UNIXTIME(sale.created), '%m')) = MONTH(CURRENT_DATE())
				GROUP BY sale_detail.item_id
				ORDER BY sold DESC");
		$result3 = $query3->result();

		$query4 = $this->db->query("SELECT SUM(CASE WHEN DATE_FORMAT(FROM_UNIXTIME(created), '%m') = MONTH(CURRENT_DATE()) THEN 0 ELSE stock * unit_price END) AS outcome FROM item");
		$result4 = $query4->result();

		$query5 = $this->db->query("SELECT stock * unit_price AS total_pengeluaran, created FROM item WHERE (DATE_FORMAT(FROM_UNIXTIME(created), '%m')) = MONTH(CURRENT_DATE()) GROUP BY id");
		$result5 = $query5->result();

		$total_penjualan = 0;
		$total_item_terjual = 0;
		foreach($result as $value){
			$total_penjualan += (int)$value->total_penjualan;
			$total_item_terjual += (int)$value->sold;
		}

		$total_penjualan_bulan_ini = 0;
		$total_item_terjual_bulan_ini = 0;
		foreach($result3 as $value){
			$total_penjualan_bulan_ini += (int)$value->total_penjualan;
			$total_item_terjual_bulan_ini += (int)$value->sold;
		}
		
		$data['chart'] = $result3;
		$data['chart2'] = $result5;
		$data['user'] 	= $this->login_m->ceklogin($this->session->userdata('email'));
		$data['total_penjualan'] = indo_currency($total_penjualan);
		$data['total_item_terjual'] = $total_item_terjual;
		$data['total_pengeluaran'] = indo_currency($result2[0]->outcome);
		$data['total_penjualan_bulan_ini'] = indo_currency($total_penjualan_bulan_ini);
		$data['total_item_terjual_bulan_ini'] = $total_item_terjual_bulan_ini;
		$data['total_pengeluaran_bulan_ini'] = indo_currency($result4[0]->outcome);
		$data['title'] 	= 'Dashboard';

		$this->load->view("templates/header",$data);
		$this->load->view("templates/sidebar",$data);
		$this->load->view("templates/topbar",$data);
		$this->load->view("admin/index",$data);
		$this->load->view("templates/footer_dashboard",$data);
	
	}

	public function index_mingguan()
	{

		$query = $this->db->query("SELECT sale_detail.id AS saleid, sale.date, product_item.name, (SELECT SUM(sale_detail.qty)) AS sold, (SELECT SUM(sale.total_price)) AS total_penjualan
				FROM sale_detail
					INNER JOIN sale ON sale_detail.sale_id = sale.id
					INNER JOIN product_item ON sale_detail.item_id = product_item.id
				-- WHERE (DATE_FORMAT(FROM_UNIXTIME(sale.created), '%m')) >= MONTH(CURRENT_DATE())
				GROUP BY sale_detail.item_id
				ORDER BY sold DESC");
		$result = $query->result();

		$query2 = $this->db->query("SELECT SUM(stock * unit_price) AS outcome FROM item");
		$result2 = $query2->result();

		$query3 = $this->db->query("SELECT sale_detail.id AS saleid, sale.created, sale.date, product_item.name, (SELECT SUM(sale_detail.qty)) AS sold, (SELECT SUM(sale.total_price)) AS total_penjualan
				FROM sale_detail
					INNER JOIN sale ON sale_detail.sale_id = sale.id
					INNER JOIN product_item ON sale_detail.item_id = product_item.id
					WHERE (YEARWEEK(DATE_FORMAT(FROM_UNIXTIME(sale.created), '%Y-%m-%d'), 1) >= YEARWEEK(CURDATE(), 1))
				GROUP BY sale_detail.item_id
				ORDER BY sold DESC");
		$result3 = $query3->result();

		$query4 = $this->db->query("SELECT SUM(CASE WHEN YEARWEEK(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), 1) >= YEARWEEK(CURDATE(), 1) THEN 0 ELSE stock * unit_price END) AS outcome FROM item");
		$result4 = $query4->result();

		$query5 = $this->db->query("SELECT stock * unit_price AS total_pengeluaran, created FROM item WHERE (YEARWEEK(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), 1) >= YEARWEEK(CURDATE(), 1)) GROUP BY id");
		$result5 = $query5->result();

		$total_penjualan = 0;
		$total_item_terjual = 0;
		foreach($result as $value){
			$total_penjualan += (int)$value->total_penjualan;
			$total_item_terjual += (int)$value->sold;
		}

		$total_penjualan_bulan_ini = 0;
		$total_item_terjual_bulan_ini = 0;
		foreach($result3 as $value){
			$total_penjualan_bulan_ini += (int)$value->total_penjualan;
			$total_item_terjual_bulan_ini += (int)$value->sold;
		}
		
		$data['chart'] = $result3;
		$data['chart2'] = $result5;
		$data['user'] 	= $this->login_m->ceklogin($this->session->userdata('email'));
		$data['total_penjualan'] = indo_currency($total_penjualan);
		$data['total_item_terjual'] = $total_item_terjual;
		$data['total_pengeluaran'] = indo_currency($result2[0]->outcome);
		$data['total_penjualan_bulan_ini'] = indo_currency($total_penjualan_bulan_ini);
		$data['total_item_terjual_bulan_ini'] = $total_item_terjual_bulan_ini;
		$data['total_pengeluaran_bulan_ini'] = indo_currency($result4[0]->outcome);
		$data['title'] 	= 'Dashboard';

		$this->load->view("templates/header",$data);
		$this->load->view("templates/sidebar",$data);
		$this->load->view("templates/topbar",$data);
		$this->load->view("admin/index",$data);
		$this->load->view("templates/footer_dashboard",$data);
	
	}

	public function index_tahunan()
	{

		$query = $this->db->query("SELECT sale_detail.id AS saleid, sale.date, product_item.name, (SELECT SUM(sale_detail.qty)) AS sold, (SELECT SUM(sale.total_price)) AS total_penjualan
				FROM sale_detail
					INNER JOIN sale ON sale_detail.sale_id = sale.id
					INNER JOIN product_item ON sale_detail.item_id = product_item.id
				-- WHERE (DATE_FORMAT(FROM_UNIXTIME(sale.created), '%m')) >= MONTH(CURRENT_DATE())
				GROUP BY sale_detail.item_id
				ORDER BY sold DESC");
		$result = $query->result();

		$query2 = $this->db->query("SELECT SUM(stock * unit_price) AS outcome FROM item");
		$result2 = $query2->result();

		$query3 = $this->db->query("SELECT MONTHNAME(DATE_FORMAT(FROM_UNIXTIME(sale.created), '%Y-%m-%d')) AS tgl, sale_detail.id AS saleid, sale.created, sale.date, product_item.name, (SELECT SUM(sale_detail.qty)) AS sold, (SELECT SUM(sale.total_price)) AS total_penjualan
				FROM sale_detail
					INNER JOIN sale ON sale_detail.sale_id = sale.id
					INNER JOIN product_item ON sale_detail.item_id = product_item.id
					WHERE (DATE_FORMAT(FROM_UNIXTIME(sale.created), '%Y') = YEAR(CURDATE()))
				GROUP BY DATE_FORMAT(FROM_UNIXTIME(sale.created), '%Y-%m-%d')
				ORDER BY DATE_FORMAT(FROM_UNIXTIME(sale.created), '%Y-%m-%d') ASC");
		$result3 = $query3->result();
		
		$query4 = $this->db->query("SELECT SUM(CASE WHEN DATE_FORMAT(FROM_UNIXTIME(created), '%Y') >= YEAR(CURDATE()) THEN 0 ELSE stock * unit_price END) AS outcome FROM item");
		$result4 = $query4->result();

		$query5 = $this->db->query("SELECT MONTHNAME(DATE_FORMAT(FROM_UNIXTIME(updated), '%Y-%m-%d')) AS tgl, stock * unit_price AS total_pengeluaran, updated FROM item WHERE (DATE_FORMAT(FROM_UNIXTIME(created), '%Y') = YEAR(CURDATE())) GROUP BY DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d')");
		$result5 = $query5->result();

		// echo "<pre>";
		// print_r($result5);
		// echo "</pre>";
		// exit;

		$total_penjualan = 0;
		$total_item_terjual = 0;
		foreach($result as $value){
			$total_penjualan += (int)$value->total_penjualan;
			$total_item_terjual += (int)$value->sold;
		}

		$total_penjualan_bulan_ini = 0;
		$total_item_terjual_bulan_ini = 0;
		foreach($result3 as $value){
			$total_penjualan_bulan_ini += (int)$value->total_penjualan;
			$total_item_terjual_bulan_ini += (int)$value->sold;
		}
		
		$data['chart'] = $result3;
		$data['chart_year'] = true;
		$data['chart2'] = $result5;
		$data['user'] 	= $this->login_m->ceklogin($this->session->userdata('email'));
		$data['total_penjualan'] = indo_currency($total_penjualan);
		$data['total_item_terjual'] = $total_item_terjual;
		$data['total_pengeluaran'] = indo_currency($result2[0]->outcome);
		$data['total_penjualan_bulan_ini'] = indo_currency($total_penjualan_bulan_ini);
		$data['total_item_terjual_bulan_ini'] = $total_item_terjual_bulan_ini;
		$data['total_pengeluaran_bulan_ini'] = indo_currency($result4[0]->outcome);
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
