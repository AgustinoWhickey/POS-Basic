<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Category_model','category_m');
		$this->load->model('Login_model','login_m');
		is_logged_in();
	}
	
	public function index()
	{
		$data['title'] 			= 'Kategori Management';
		$data['user'] 			= $this->login_m->ceklogin($this->session->userdata('email'));
		$data['categories'] 	= $this->category_m->getCategories();

		$this->form_validation->set_rules('name','Nama','required');

		if($this->form_validation->run() == false){

			$this->load->view("templates/header",$data);
			$this->load->view("templates/sidebar",$data);
			$this->load->view("templates/topbar",$data);
			$this->load->view("product/category/index",$data);
			$this->load->view("templates/footer");
		} else {

			$data = [
				'nama' => htmlspecialchars($this->input->post('name',true)),
				'created' => time()
			];

			$this->db->insert('product_category', $data); 
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Kategori Baru Berhasil Ditambahkan!</div>');
			redirect('category');
		}
	
	}

	public function edit($id_category)
	{
		$data['user'] 			= $this->login_m->ceklogin($this->session->userdata('email'));
		$data['onecategory'] 	= $this->category_m->getCategory($id_category);
		$data['title'] 			= 'Edit Kategori';

		$this->form_validation->set_rules('nama','Nama','required|trim');
		if($this->form_validation->run() == false)
		{
			if(!$data['onecategory']){
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Data Kategori Tidak Ditemukan!</div>');
				redirect('category');
			} else {
				$this->load->view("templates/header",$data);
				$this->load->view("templates/sidebar",$data);
				$this->load->view("templates/topbar",$data);
				$this->load->view("product/category/edit",$data);
				$this->load->view("templates/footer");
			}
		} else {

			$data = [
				'id' => $this->input->post('category_id'),
				'nama' => htmlspecialchars($this->input->post('nama',true)),
				'updated' => time()
			];

			$this->category_m->updatecategory($data);

			if($this->db->affected_rows() > 0){
				$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Update Kategori Sukses!</div>');
				redirect('category/edit/'.$this->input->post('category_id'));
			} else {
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Update Kategori Gagal! Silahkan Coba Lagi!</div>');
				redirect('category/edit/'.$this->input->post('category_id'));
			}
		}
	}

	public function delete()
	{
		$id = $this->input->post('category_id');
		$this->category_m->deleteCategory($id);

		if($this->db->affected_rows() > 0){
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Kategori Berhasil Dihapus!</div>');
			redirect('category');
		} else {
			$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Hapus Kategori Baru Gagal! Silahkan Coba Lagi!</div>');
			redirect('category');
		}
	}

}
