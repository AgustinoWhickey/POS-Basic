<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Item_model','item_m');
		$this->load->model('Login_model','login_m');
		$this->load->model('Category_model','category_m');
		is_logged_in();
	}
	
	public function index()
	{
		$data['title'] 		= 'Item Management';
		$data['user'] 		= $this->login_m->ceklogin($this->session->userdata('email'));
		$data['items'] 		= $this->item_m->getItems();
		$data['category'] 	= $this->category_m->getCategories();

		$this->form_validation->set_rules('name','Nama','required');
		$this->form_validation->set_rules('barcode','Kode','required|trim|is_unique[product_item.barcode]');

		if($this->form_validation->run() == false){

			$this->load->view("templates/header",$data);
			$this->load->view("templates/sidebar",$data);
			$this->load->view("templates/topbar",$data);
			$this->load->view("product/item/index",$data);
			$this->load->view("templates/footer");
		} else {

			$upload_image = $_FILES['image']['name'];

			if($upload_image){
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size'] = '2048';
				$config['upload_path'] = './assets/img/upload/products';
				$config['file_name'] = 'img-'.$this->input->post('name');

				$this->load->library('upload',$config);
				if($this->upload->do_upload('image')){
					echo 'Sukses';
				} else {
					echo $this->upload->display_errors();
				}
			}

			$data = [
				'barcode' => htmlspecialchars($this->input->post('barcode',true)),
				'name' => htmlspecialchars($this->input->post('name',true)),
				'category_id' => htmlspecialchars($this->input->post('kategori',true)),
				'price' => htmlspecialchars($this->input->post('harga',true)),
				'stock' => htmlspecialchars($this->input->post('stock',true)),
				'created' => time()
			];

			$this->db->insert('product_item', $data); 
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Item Baru Berhasil Ditambahkan!</div>');
			redirect('item');
		}
	
	}

	public function edit($id_item)
	{
		$data['user'] 		= $this->login_m->ceklogin($this->session->userdata('email'));
		$data['oneitem'] 	= $this->item_m->getItem($id_item);
		$data['category'] 	= $this->category_m->getCategories();
		$data['title'] 		= 'Edit Item';

		$this->form_validation->set_rules('nama','Nama','required|trim');
		if($this->form_validation->run() == false)
		{
			if(!$data['oneitem']){
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Data Item Tidak Ditemukan!</div>');
				redirect('item');
			} else {
				$this->load->view("templates/header",$data);
				$this->load->view("templates/sidebar",$data);
				$this->load->view("templates/topbar",$data);
				$this->load->view("product/item/edit",$data);
				$this->load->view("templates/footer");
			}
		} else {

			$data = [
				'id' => $this->input->post('item_id'),
				'barcode' => htmlspecialchars($this->input->post('barcode',true)),
				'name' => htmlspecialchars($this->input->post('nama',true)),
				'category_id' => htmlspecialchars($this->input->post('kategori',true)),
				'price' => htmlspecialchars($this->input->post('price',true)),
				'stock' => htmlspecialchars($this->input->post('stock',true)),
				'updated' => time()
			];

			$this->item_m->updateitem($data);

			if($this->db->affected_rows() > 0){
				$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Update Item Sukses!</div>');
				redirect('item/edit/'.$this->input->post('item_id'));
			} else {
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Update Item Gagal! Silahkan Coba Lagi!</div>');
				redirect('item/edit/'.$this->input->post('item_id'));
			}
		}
	}

	public function delete()
	{
		$id = $this->input->post('item_id');
		$this->item_m->deleteItem($id);

		if($this->db->affected_rows() > 0){
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Item Berhasil Dihapus!</div>');
			redirect('item');
		} else {
			$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Hapus Item Baru Gagal! Silahkan Coba Lagi!</div>');
			redirect('item');
		}
	}

}
