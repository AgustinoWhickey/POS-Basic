<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sale extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Product_item_model','item_m');
		$this->load->model('Item_model','unit_item_m');
		$this->load->model('Item_menu_model','item_menu_m');
		$this->load->model('Login_model','login_m');
        $this->load->model('Sale_model','sale_m');
        $this->load->model('Stock_model','stock_m');
		is_logged_in();
	}

    public function index()
	{
		$data['user'] 		= $this->login_m->ceklogin($this->session->userdata('email'));
		$data['items'] 		= $this->item_m->getItems();
		$data['invoice'] 	= $this->sale_m->getInvoice();
		$data['cart'] 		= $this->sale_m->getCart();
		$data['title'] 		= 'Data Penjualan';

		$this->load->view("templates/header",$data);
		$this->load->view("templates/sidebar",$data);
		$this->load->view("templates/topbar",$data);
		$this->load->view("transaction/sales/index",$data);
		$this->load->view("templates/footer");
	
	}

	public function updatecart(){
		$data = [
			'id' => $this->input->post('cartid'),
			'qty' => htmlspecialchars($this->input->post('qty',true)),
			'total' => htmlspecialchars($this->input->post('total',true)),
			'discount' => htmlspecialchars($this->input->post('discount',true)),
			'updated' => time()
		];

		$result = $this->sale_m->updatecart($data);
		return $result; 
	}

	public function proses(){
		$data = $this->input->post(null, TRUE);

		if(isset($_POST['add_cart'])) {
			$item_id = $this->input->post('item_id');
			$result = $this->sale_m->addCart($data);

			// $cart = $this->sale_m->getCart(['cart.item_id' => $item_id]);
			// if($cart->num_rows() == 1){
			// 	$result = $this->sale_m->addCart($data);
			// } else {
			// 	$result = $this->sale_m->updateCartQty($data);
			// }
			return $result;
		}
	}

	public function cart_data(){
		$data['cart'] 	= $this->sale_m->getCart();
		$this->load->view("transaction/sales/cart_data",$data);
	}

	public function delete()
	{
		$id = $this->input->post('id');
		$result = $this->sale_m->deleteCart($id);

		return $result;
	}

	public function process_payment(){
		$stockbahan = array();
		$data = $this->input->post(null, TRUE);
		$sale_id = $this->sale_m->add_sale($data);
		$carts = $this->sale_m->getCart()->result();
		$row = [];
		foreach($carts as $value){
			array_push($row, array(
				'sale_id' => $sale_id,
				'item_id' => $value->item_id,
				'price' => $value->price,
				'qty' => $value->qty,
				'discount_item' => $value->discount_item,
				'total' => $value->total,
				)
			);

			$stocks = $this->item_menu_m->getMenuItem((int)$value->item_id);

			foreach($stocks as $stock){
				$stockout = [
					'item_id' => (int)$stock->item_id,
					'qty' => $stock->qty,
				];
				$this->unit_item_m->updateitemstockout($stockout);

				$newstock = $this->unit_item_m->getItem((int)$stock->item_id);
				array_push($stockbahan, intval($newstock->stock/$stock->qty));
			} 

			$stockout = [
				'item_id' => $value->item_id,
				'qty' => min($stockbahan),
			];
			$this->item_m->updatestockout($stockout);
		}
		$this->sale_m->add_sale_detail($row);
		$this->sale_m->deleteCartbyUser();

		echo $sale_id;
	}

	public function cetak($id)
	{
		$data = array(
			'sale' => $this->sale_m->getSale($id)->row(),
			'sale_detail' => $this->sale_m->get_sale_detail($id)->result()
		);
		$this->load->view('transaction/sales/receipt_print', $data);
	}
}