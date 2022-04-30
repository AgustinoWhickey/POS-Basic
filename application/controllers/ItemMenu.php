<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ItemMenu extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Item_model','item_m');
		$this->load->model('Item_menu_model','item_menu_m');
		$this->load->model('Login_model','login_m');
		$this->load->model('Category_model','category_m');
		is_logged_in();
	}
	
	public function index()
	{
		$data['title'] 		= 'Item Management';
		$data['user'] 		= $this->login_m->ceklogin($this->session->userdata('email'));
		$data['items'] 		= $this->item_m->getItems();

		$this->form_validation->set_rules('name','Nama','required');

		if($this->form_validation->run() == false){

			$this->load->view("templates/header",$data);
			$this->load->view("templates/sidebar",$data);
			$this->load->view("templates/topbar",$data);
			$this->load->view("product/item_menu/index",$data);
			$this->load->view("templates/footer");
		} else {
			$image = '';
			$upload_image = $_FILES['image']['name'];

			if($upload_image){
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size'] = '2048';
				$config['upload_path'] = './assets/img/upload/items';
				$config['file_name'] = 'img-'.$this->input->post('name');

				$this->load->library('upload',$config);
				if($this->upload->do_upload('image')){
					$image = $this->upload->data('file_name');
				} else {
					$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">'.$this->upload->display_errors().'</div>');
					redirect('item');
				}
			}

			$data = [
				'name' => htmlspecialchars($this->input->post('name',true)),
				'unit' => htmlspecialchars($this->input->post('unit',true)),
				'price' => htmlspecialchars($this->input->post('harga',true)),
				'stock' => htmlspecialchars($this->input->post('stock',true)),
				'image' => $image,
				'created' => time()
			];

			$this->db->insert('item', $data); 
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Item Baru Berhasil Ditambahkan!</div>');
			redirect('itemmenu');
		}
	
	}

	public function edit($id_item)
	{
		$data['user'] 		= $this->login_m->ceklogin($this->session->userdata('email'));
		$data['oneitem'] 	= $this->item_m->getItem($id_item);
		$data['title'] 		= 'Edit Item';

		$this->form_validation->set_rules('nama','Nama','required|trim');
		if($this->form_validation->run() == false)
		{
			if(!$data['oneitem']){
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Data Item Tidak Ditemukan!</div>');
				redirect('itemmenu');
			} else {
				$this->load->view("templates/header",$data);
				$this->load->view("templates/sidebar",$data);
				$this->load->view("templates/topbar",$data);
				$this->load->view("product/item_menu/edit",$data);
				$this->load->view("templates/footer");
			}
		} else {

			$image = $data['oneitem']->image;
			$upload_image = $_FILES['image']['name'];

			if($upload_image){
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size'] = '2048';
				$config['upload_path'] = './assets/img/upload/products';
				$config['file_name'] = 'img-'.$this->input->post('barcode');

				$this->load->library('upload',$config);
				$fileExt = pathinfo($upload_image, PATHINFO_EXTENSION);
				if($image != ''){
					unlink('./assets/img/upload/products/img-'.$this->input->post('barcode').'.'.$fileExt);
				}
				if($this->upload->do_upload('image')){
					$image = $this->upload->data('file_name');
				} else {
					$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">'.$this->upload->display_errors().'</div>');
					redirect('item');
				}
			}

			$data = [
				'id' => $this->input->post('item_id'),
				'name' => htmlspecialchars($this->input->post('nama',true)),
				'unit' => htmlspecialchars($this->input->post('unit',true)),
				'price' => htmlspecialchars($this->input->post('price',true)),
				'stock' => htmlspecialchars($this->input->post('stock',true)),
				'image' => $image,
				'updated' => time()
			];

			$this->item_m->updateitem($data);

			if($this->db->affected_rows() > 0){
				$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Update Item Sukses!</div>');
				redirect('itemmenu/edit/'.$this->input->post('item_id'));
			} else {
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Update Item Gagal! Silahkan Coba Lagi!</div>');
				redirect('itemmenu/edit/'.$this->input->post('item_id'));
			}
		}
	}

	public function delete()
	{
		$id = $this->input->post('itemmenu_id');
		$this->item_m->deleteItem($id);

		if($this->db->affected_rows() > 0){
			unlink('./assets/img/upload/items/'.$this->input->post('gambar'));
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Item Berhasil Dihapus!</div>');
			redirect('itemmenu');
		} else {
			$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Hapus Item Baru Gagal! Silahkan Coba Lagi!</div>');
			redirect('itemmenu');
		}
	}

	public function print_barcode($id_item)
	{
		$data['user'] 		= $this->login_m->ceklogin($this->session->userdata('email'));
		$data['oneitem'] 	= $this->item_m->getItem($id_item);
		$data['category'] 	= $this->category_m->getCategories();
		$data['title'] 		= 'Barcode Item';

		$this->load->view("templates/header",$data);
		$this->load->view("templates/sidebar",$data);
		$this->load->view("templates/topbar",$data);
		$this->load->view("product/item/barcode",$data);
		$this->load->view("templates/footer");
	} 

	public function printpdf_barcode($id_item)
	{
		$data['oneitem'] 	= $this->item_m->getItem($id_item);
		$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
    
		pdf_generator('<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($data['oneitem']->barcode, $generator::TYPE_CODE_128)) . '"><br>'.$data['oneitem']->barcode,'coba');
	}

}
