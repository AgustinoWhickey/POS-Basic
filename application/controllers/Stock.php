<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Product_item_model','item_m');
		$this->load->model('Item_model','unit_item_m');
		$this->load->model('Login_model','login_m');
        $this->load->model('Supplier_model','supplier_m');
        $this->load->model('Stock_model','stock_m');
		is_logged_in();
	}

    public function stockin()
	{
		$data['title'] 		= 'Stock In';
		$data['user'] 		= $this->login_m->ceklogin($this->session->userdata('email'));
		$data['suppliers'] 	= $this->supplier_m->getSuppliers();
		$data['items'] 	    = $this->item_m->getItems();
		$data['stocks'] 	= $this->stock_m->getStockItemIns();
		$data['unititems'] 	= $this->unit_item_m->getItems();

		$this->form_validation->set_rules('item','Item','required');

		if($this->form_validation->run() == false){

			$this->load->view("templates/header",$data);
			$this->load->view("templates/sidebar",$data);
			$this->load->view("templates/topbar",$data);
			$this->load->view("transaction/stockin/index",$data);
			$this->load->view("templates/footer");
		} else {

			$data = [
				'item_id' => htmlspecialchars($this->input->post('item',true)),
				'type' => 'in',
				'detail' => htmlspecialchars($this->input->post('detail',true)),
				'supplier_id' => htmlspecialchars($this->input->post('supplier',true)),
				'unit' => htmlspecialchars($this->input->post('unit_name',true)),
				'unit_qty' => htmlspecialchars($this->input->post('qty_unit',true)),
				'unit_price' => htmlspecialchars($this->input->post('qty_price',true)),
				'item_qty' => htmlspecialchars($this->input->post('qty_item',true)),
				'user_id' => $this->session->userdata('user_id'),
				'date' => strtotime($this->input->post('tanggal')),
				'created' => time()
			];

			$this->db->insert('stock_item', $data); 
			if($this->db->affected_rows() > 0){
				$this->stock_m->addstockitem($data);
				update_stock($data);
			}
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Stock Baru Berhasil Ditambahkan!</div>');
			redirect('stock/stockin');
		}
	
	}

	public function stockin_delete()
	{
		$idstock 	= $this->input->post('idstock');
		$iditem 	= $this->input->post('idproduct');
		$getstock 	= $this->stock_m->getStockItem($idstock);

		$newstock = (int)$getstock->unit_qty * (int)$getstock->item_qty; 

		$data = [
			'item_id' => $iditem,
			'qty' =>$newstock,
		];
		$this->stock_m->updatestockoutitem($data);
		$this->stock_m->deleteStock($idstock);
		update_stock($data);

		$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Stock Berhasil Dihapus!</div>');
			redirect('stock/stockin');

		// if($this->db->affected_rows() > 0){
		// 	$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Stock Berhasil Dihapus!</div>');
		// 	redirect('stock/stockin');
		// } 
		// else {
		// 	$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Hapus Stock Baru Gagal! Silahkan Coba Lagi!</div>');
		// 	redirect('stock/stockin');
		// }
	}

	public function stockout()
	{
		$data['title'] 		= 'Stock Out';
		$data['user'] 		= $this->login_m->ceklogin($this->session->userdata('email'));
		$data['suppliers'] 	= $this->supplier_m->getSuppliers();
		$data['items'] 	    = $this->item_m->getItems();
		$data['stocks'] 	= $this->stock_m->getStockOuts();

		$this->form_validation->set_rules('name','Nama','required');

		if($this->form_validation->run() == false){

			$this->load->view("templates/header",$data);
			$this->load->view("templates/sidebar",$data);
			$this->load->view("templates/topbar",$data);
			$this->load->view("transaction/stockout/index",$data);
			$this->load->view("templates/footer");
		} else {

			$data = [
				'item_id' => htmlspecialchars($this->input->post('item_id',true)),
				'type' => 'out',
				'detail' => htmlspecialchars($this->input->post('detail',true)),
				'supplier_id' => '',
				'qty' => htmlspecialchars($this->input->post('qty',true)),
				'user_id' => $this->session->userdata('user_id'),
				'date' => strtotime($this->input->post('tanggal')),
				'created' => time()
			];

			$this->db->insert('stock', $data); 
			$this->stock_m->updatestockoutproduct($data);
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Stock Keluar Berhasil Ditambahkan!</div>');
			redirect('stock/stockout');
		}
	
	}

	public function stockout_delete()
	{
		$idstock 	= $this->input->post('idstock');
		$idproduct 	= $this->input->post('idproduct');
		$getstock 	= $this->stock_m->getStock($idstock)->qty;

		$data = [
			'item_id' => $idproduct,
			'qty' =>$getstock,
		];
		$this->item_m->updatestockin($data);
		$this->stock_m->deleteStock($idstock);

		if($this->db->affected_rows() > 0){
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Stock Berhasil Dihapus!</div>');
			redirect('stock/stockout');
		} else {
			$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Hapus Stock Keluar Gagal! Silahkan Coba Lagi!</div>');
			redirect('stock/stockout');
		}
	}
}