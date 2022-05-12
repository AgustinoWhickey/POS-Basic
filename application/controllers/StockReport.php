<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class StockReport extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Product_item_model','item_m');
		$this->load->model('Item_model','unit_item_m');
		$this->load->model('Login_model','login_m');
        $this->load->model('Supplier_model','supplier_m');
        $this->load->model('Stock_model','stock_m');
		is_logged_in();
	}

    public function index()
	{
		$data['title'] 		= 'Data Stock';
		$data['user'] 		= $this->login_m->ceklogin($this->session->userdata('email'));
		$data['stocks'] 	= $this->stock_m->getStocks();

		$resultStock = array();
		$result = array();

		foreach($data['stocks']  as $value){
			$resultStock[$value->item_id][] = $value;
		}

		foreach($resultStock as $value){
			$qty = 0;
			foreach($value as $val){
				if($val->type == 'in'){
					$qty += $val->qty; 
				}else{
					$qty -= $val->qty;
				}
			}
			array_push($result, array(
				'qty' => $qty.' cup',
				'item_name' => $value[0]->item_name,
				'category' => $value[0]->category_name,
			));
		}

		$data['data'] = $result;

		$this->load->view("templates/header",$data);
		$this->load->view("templates/sidebar",$data);
		$this->load->view("templates/topbar",$data);
		$this->load->view("reports/stock_report",$data);
		$this->load->view("templates/footer");
		
	}
}