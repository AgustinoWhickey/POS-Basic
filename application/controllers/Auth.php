<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Login_model','login_m');
	}
	
	public function index()
	{
		if($this->session->userdata('email')){
			redirect('user');
		}

		$this->form_validation->set_rules('email','Email','required|trim|valid_email');
		$this->form_validation->set_rules('password','Password','required|trim');

		if($this->form_validation->run() == false)
		{
			$data['title'] 	= 'Admin Login Page';

			$this->load->view("templates/auth_header",$data);
			$this->load->view("auth/login");
			$this->load->view("templates/auth_footer");

		} else {

			$this->_login();
		
		}
	
	}

	private function _login()
	{
		$email 		= $this->input->post('email');
		$password 	= $this->input->post('password');

		$user = $this->login_m->ceklogin($email);

		if($user){
			if($user['is_active'] == 1){
				if(password_verify($password, $user['password'])){
					$data = [
						'email' => $user['email'],
						'role_id' => $user['role_id'],
					];
					$this->session->set_userdata($data);
					if($user['role_id']==1){
						redirect('admin');
					} else {
						redirect('user');
					}
				} else {
					$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Wrong password!</div>');
					redirect('auth');
				}
			} else {
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">This email has not been activated!</div>');
				redirect('auth');
			}

		} else {
			$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Email is not recognized!</div>');
			redirect('auth');
		}

	}


	public function register()
	{
		if($this->session->userdata('email')){
			redirect('user');
		}
		
		$this->form_validation->set_rules('name','Name','required|trim');
		$this->form_validation->set_rules('email','Email','required|trim|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('password1','Password','required|trim|min_length[3]|matches[password2]',[
			'matches' => 'Password don\'t match!',
			'min_length' => 'Password too short!'
		]);
		$this->form_validation->set_rules('password2','Password','required|trim|matches[password1]');

		if($this->form_validation->run() == false){

			$data['title'] 	= 'Admin Registration Page';

			$this->load->view("templates/auth_header",$data);
			$this->load->view("auth/register");
			$this->load->view("templates/auth_footer");

		} else {
			$data = [
				'name' => htmlspecialchars($this->input->post('name',true)),
				'email' => htmlspecialchars($this->input->post('email',true)),
				'image' => 'default.jpg',
				'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
				'role_id' => 2,
				'is_active' => 1, // type 0 if you want to activate send email
				'date_created' => time()
			];

			$this->db->insert('user',$data); 

			/* $token = base64_encode(random_bytes(32));
			$user_token = [
				'email' => $this->input->post('email',true),
				'token' => $token,
				'date_created' =>  time()
			];

			$this->db->insert('user_token',$user_token); 
			$this->_sendEmail($token, 'verify'); */

			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Congratulation! Your Account Has Been Created!</div>');
			redirect('auth');
		}

	}

	public function verify()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		$user = $this->db->get_where('user',['email' => $email])->row_array();
		if($user){
			$user_token = $this->db->get_where('user_token',['token' => $token])->row_array();
			if($user_token){
				if(time() - $user_token['date_created'] < (60*60*24)){
					$this->session->set_userdata('reset_email',$email);
					$this->changepassword();
				} else {
					$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Account Activation Failed! Token Expired!</div>');
					redirect('auth');
				}
			} else {
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Account Activation Failed! Wrong Token!</div>');
				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Account Activation Failed! Wrong Email!</div>');
			redirect('auth');
		}
	}

	public function changepassword()
	{
		if(!$this->session->userdata('reset_email')){
			redirect('auth');
		}

		$this->form_validation->set_rules('password1','Password','required|trim|min_length[3]|matches[password2]');
		$this->form_validation->set_rules('password2','Repeat Password','required|trim|min_length[3]|matches[password1]');

		if($this->form_validation->run() == false)
		{
			$data['title'] 	= 'Change Password';

			$this->load->view("templates/auth_header",$data);
			$this->load->view("auth/change-password");
			$this->load->view("templates/auth_footer");
		} else {
			$password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
			$email = $this->session->userdata('reset_email');

			$this->db->set('password',$password);
			$this->db->where('email',$email);
			$this->db->update('user');

			$this->session->unset_userdata('reset_email');

			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Password has been changed! Please Login</div>');
			redirect('auth');
		}
	}

	public function resetpassword()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		$user = $this->db->get_where('user',['email' => $email])->row_array();

		if($user){
			if($user['is_active'] == 1){
				$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
				if($user_token){
					$data = [
						'email' => $user['email'],
						'role_id' => $user['role_id'],
					];
					$this->session->set_userdata($data);
					if($user['role_id']==1){
						redirect('admin');
					} else {
						redirect('user');
					}
				} else {
					$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Wrong password!</div>');
					redirect('auth');
				}
			} else {
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">This email has not been activated!</div>');
				redirect('auth');
			}

		} else {
			$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Email is not recognized!</div>');
			redirect('auth/forgotpassword');
		}
	}

	private function _sendEmail($token, $type)
	{
		$config = [
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_user' => 'wpunpas@gmail.com',
			'smtp_pass' => '1234567890',
			'smtp_port' => 465,
			'mailtype' => 'html',
			'charset' => 'utf-8', 
		];

		$this->load->library('email',$config);

		$this->email->from('wpunpas@gmail.com','Web Programing UNPAS');
		$this->email->to($this->input->post('email'));

		if($type=='verify'){
			$this->email->subject('Account Verification');
			$this->email->message('Click this link to verify your account : <a href="'.$base_url('auth/verify?email='.$this->input->post('email')).'&token='.urlencode($token).'">Activate</a>');
		} else if($type=='forgot'){
			$this->email->subject('Reset Password');
			$this->email->message('Click this link to reset your password : <a href="'.$base_url('auth/resetpassword?email='.$this->input->post('email')).'&token='.urlencode($token).'">Reset</a>');
		}

		if($this->email->send()){
			return true;
		} else {
			echo $this->email->print_debugger();
		}

	}

	public function logout(){
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('role_id');

		$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Congratulation! Your Have Been Logout!</div>');
		redirect('auth');
	}

	public function blocked()
	{
		$this->load->view("auth/blocked");
	}

	public function forgotpassword()
	{

		$this->form_validation->set_rules('email','Email','required|trim|valid_email');

		if($this->form_validation->run() == false)
		{
			$data['title'] 	= 'Forgot Password';

			$this->load->view("templates/auth_header",$data);
			$this->load->view("auth/forgot-password");
			$this->load->view("templates/auth_footer");

		} else {

			$email = $this->input->post('email');
			$user = $this->db->get_where('user',['email' => $email, 'is_active' => 1])->row_array();
			if($user) {
				$token = base64_encode(random_bytes(32));
				$user_token = [
					'email' => $email,
					'token' => $token,
					'date_created' =>  time()
				];
				$this->db->insert('user_token',$user_token);
				$this->_sendEmail($token,'forgot');

				$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Please check your email to reset your password!</div>');
				redirect('auth/forgotpassword');

			} else {
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Email is not registered or activated!</div>');
				redirect('auth/forgotpassword');
			}
		
		}
	}

}
