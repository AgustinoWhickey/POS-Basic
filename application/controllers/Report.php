<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Item_model','item_m');
		$this->load->model('Login_model','login_m');
        $this->load->model('Sale_model','sale_m');
        $this->load->model('Stock_model','stock_m');
		is_logged_in();
	}

    public function sales()
	{
		$data['user'] 		= $this->login_m->ceklogin($this->session->userdata('email'));
		$data['sales'] 		= $this->sale_m->getSale()->result();
		$data['title'] 		= 'Laporan Data Penjualan';

		$this->load->view("templates/header",$data);
		$this->load->view("templates/sidebar",$data);
		$this->load->view("templates/topbar",$data);
		$this->load->view("reports/sale_report",$data);
		$this->load->view("templates/footer");
	
	}

	public function sale_product($saleid){
		$result = $this->sale_m->get_sale_detail($saleid)->result();

		echo json_encode($result); 
	}

}