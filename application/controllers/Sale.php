<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Item_model','item_m');
		$this->load->model('Login_model','login_m');
        $this->load->model('Supplier_model','supplier_m');
        $this->load->model('Stock_model','stock_m');
		is_logged_in();
	}

    public function index()
	{
		$data['user'] 	= $this->login_m->ceklogin($this->session->userdata('email'));
		$data['users'] 	= $this->user_m->getUsers();
		$data['title'] 	= 'Data User';

		$this->form_validation->set_rules('name','Nama','required|trim');
		$this->form_validation->set_rules('email','Email','required|trim|is_unique[user.email]');
		$this->form_validation->set_rules('pass','Password','required|trim|min_length[3]|matches[confpass]');
		$this->form_validation->set_rules('confpass','Repeat Password','required|trim|min_length[3]|matches[pass]');

		if($this->form_validation->run() == false)
		{
			$this->load->view("templates/header",$data);
			$this->load->view("templates/sidebar",$data);
			$this->load->view("templates/topbar",$data);
			$this->load->view("user/index",$data);
			$this->load->view("templates/footer");
		} else {

			$data = [
				'name' => htmlspecialchars($this->input->post('name',true)),
				'email' => htmlspecialchars($this->input->post('email',true)),
				'image' => 'default.jpg',
				'password' => password_hash($this->input->post('pass'), PASSWORD_DEFAULT),
				'role_id' =>  $this->input->post('role') ?? 3,
				'is_active' => 1, // type 0 if you want to activate send email
				'date_created' => time()
			];

			$this->db->insert('user', $data); 

			if($this->db->affected_rows() > 0){
				$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">User Baru Telah Ditambahkan!</div>');
				redirect('user');
			} else {
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Input User Baru Gagal! Silahkan Coba Lagi!</div>');
				redirect('user');
			}
		}
	
	}
}