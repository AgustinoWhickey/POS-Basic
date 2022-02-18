<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Supplier_model','supplier_m');
		$this->load->model('Login_model','login_m');
		is_logged_in();
	}
	
	public function index()
	{
		$data['title'] 		= 'Supplier Management';
		$data['user'] 		= $this->login_m->ceklogin($this->session->userdata('email'));
		$data['suppliers'] 	= $this->supplier_m->getSuppliers();

		$this->form_validation->set_rules('name','Nama','required');

		if($this->form_validation->run() == false){

			$this->load->view("templates/header",$data);
			$this->load->view("templates/sidebar",$data);
			$this->load->view("templates/topbar",$data);
			$this->load->view("supplier/index",$data);
			$this->load->view("templates/footer");
		} else {

			$data = [
				'name' => htmlspecialchars($this->input->post('name',true)),
				'phone' => htmlspecialchars($this->input->post('telepon',true)),
				'address' => htmlspecialchars($this->input->post('address',true)),
				'description' => htmlspecialchars($this->input->post('deskripsi',true)),
				'created' => time()
			];

			$this->db->insert('supplier', $data); 
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Supplier Baru Berhasil Ditambahkan!</div>');
			redirect('supplier');
		}
	
	}

	public function edit($id_supplier)
	{
		$data['user'] 			= $this->login_m->ceklogin($this->session->userdata('email'));
		$data['onesupplier'] 	= $this->supplier_m->getSupplier($id_supplier);
		$data['title'] 			= 'Edit Supplier';

		$this->form_validation->set_rules('nama','Nama','required|trim');
		if($this->form_validation->run() == false)
		{
			if(!$data['onesupplier']){
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Data Supplier Tidak Ditemukan!</div>');
				redirect('supplier');
			} else {
				$this->load->view("templates/header",$data);
				$this->load->view("templates/sidebar",$data);
				$this->load->view("templates/topbar",$data);
				$this->load->view("supplier/edit",$data);
				$this->load->view("templates/footer");
			}
		} else {

			$data = [
				'id' => $this->input->post('supplier_id'),
				'name' => htmlspecialchars($this->input->post('nama',true)),
				'phone' => htmlspecialchars($this->input->post('phone',true)),
				'address' => htmlspecialchars($this->input->post('address',true)),
				'description' => htmlspecialchars($this->input->post('deskripsi',true)),
				'updated' => time()
			];

			$this->supplier_m->updatesupplier($data);

			if($this->db->affected_rows() > 0){
				$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Update Supplier Sukses!</div>');
				redirect('supplier/edit/'.$this->input->post('supplier_id'));
			} else {
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Update Supplier Gagal! Silahkan Coba Lagi!</div>');
				redirect('supplier/edit/'.$this->input->post('supplier_id'));
			}
		}
	}

	public function delete()
	{
		$id = $this->input->post('supplier_id');
		$this->supplier_m->deleteSupplier($id);

		if($this->db->affected_rows() > 0){
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Supplier Berhasil Dihapus!</div>');
			redirect('supplier');
		} else {
			$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Hapus Supplier Baru Gagal! Silahkan Coba Lagi!</div>');
			redirect('supplier');
		}
	}

}
