<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller {
	public function index()
	{
		$this->login();
	}
	
	public function login() {
		$this->load->view('login');
	}
	
	public function members() {
		 
		if($this->session->userdata('is_logged_in')) {
			$this->load->view('members');
		} else {
			redirect('site/restricted');
			//echo $this->session->userdata('is_logged-in');
		}
	}
	
	public function restricted() {
		$this->load->view('restricted');
	}
	
	public function login_validation() {
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|callback_validate_credentials');
		$this->form_validation->set_rules('password', 'Password', 'required|md5|trim');
		
		if ($this->form_validation->run()) {
			$data = array (
				'email' => $this->input->post('email'),
				'is_logged_in' => 1
			);
			$this->session->set_userdata($data);
			redirect('site/members');
		} else {
			$this->login();
		}
	}
	
	public function validate_credentials() {
		$this->load->model('model_users');
		
		if($this->model_users->can_log_in()) {
			return true;
		} else {
			$this->form_validation->set_message('validate_credentials', 'Incorrect Username/Password.');
			return false;
		}
	}
	
	public function logout() {
		$this->session->sess_destroy();
		redirect('site/login');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */