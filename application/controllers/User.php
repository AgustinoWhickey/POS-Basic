<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('User_model','user_m');
		$this->load->model('Login_model','login_m');
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
				'role_id' => 2,
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

	public function delete()
	{
		$id = $this->input->post('user_id');
		$this->user_m->deleteUser($id);

		if($this->db->affected_rows() > 0){
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">User Berhasil Dihapus!</div>');
			redirect('user');
		} else {
			$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Hapus User Baru Gagal! Silahkan Coba Lagi!</div>');
			redirect('user');
		}
	}

	public function edit($id_user)
	{
		$data['user'] 		= $this->login_m->ceklogin($this->session->userdata('email'));
		$data['oneuser'] 	= $this->user_m->getUser($id_user);
		$data['title'] 		= 'Edit User';

		$this->form_validation->set_rules('name','Nama','required|trim');
		if($this->input->post('pass')){
			$this->form_validation->set_rules('pass','Password','required|trim|min_length[3]|matches[confpass]');
			$this->form_validation->set_rules('confpass','Repeat Password','required|trim|min_length[3]|matches[pass]');
		}
		if($this->form_validation->run() == false)
		{
			if(!$data['oneuser']){
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Data User Tidak Ditemukan!</div>');
				redirect('user');
			} else {
				$this->load->view("templates/header",$data);
				$this->load->view("templates/sidebar",$data);
				$this->load->view("templates/topbar",$data);
				$this->load->view("user/edit",$data);
				$this->load->view("templates/footer");
			}
		} else {

			$data = [
				'id' => $this->input->post('user_id'),
				'name' => htmlspecialchars($this->input->post('name',true)),
				'image' => 'default.jpg',
				'is_active' => 1, // type 0 if you want to activate send email
				'date_created' => time()
			];

			if(!empty($this->input->post('pass'))){
				$data['password'] = password_hash($this->input->post('pass'), PASSWORD_DEFAULT);
			}

			$this->user_m->updateuser($data);

			if($this->db->affected_rows() > 0){
				$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Update User Sukses!</div>');
				redirect('user/edit/'.$this->input->post('user_id'));
			} else {
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Update User Gagal! Silahkan Coba Lagi!</div>');
				redirect('user/edit/'.$this->input->post('user_id'));
			}
		}
	}

	public function changepassword()
	{
		$data['user'] 	= $this->db->get_where('user',['email' => $this->session->userdata('email')])->row_array();
		$data['title'] 	= 'Change Password';

		$this->form_validation->set_rules('currentpassword','Current Password','required|trim');
		$this->form_validation->set_rules('newpassword1','New Password','required|trim|min_length[3]|matches[newpassword2]');
		$this->form_validation->set_rules('newpassword2','Repeat Password','required|trim|min_length[3]|matches[newpassword1]');

		if($this->form_validation->run() == false)
		{
			$this->load->view("templates/header",$data);
			$this->load->view("templates/sidebar",$data);
			$this->load->view("templates/topbar",$data);
			$this->load->view("user/change-password",$data);
			$this->load->view("templates/footer");
		} else {
			$current_password 	= $this->input->post('currentpassword');
			$new_password 		= $this->input->post('newpassword1');
			if(!password_verify($current_password, $data['user']['password'])){
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Wrong current password!</div>');
				redirect('user/changepassword');
			} else {
				if($current_password == $new_password){
					$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Current password cannot be the same!</div>');
					redirect('user/changepassword');
				} else {
					$password_hash = password_hash($new_password, PASSWORD_DEFAULT);
					$this->db->set('password',$password_hash);
					$this->db->where('email',$this->session->userdata('email'));
					$this->db->update('user');

					$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Password Changed!</div>');
					redirect('user/changepassword');
				}
			}
		}
	
	}

}
