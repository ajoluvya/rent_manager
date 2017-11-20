<?php
class Account extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
				//if user not logged in, take them back to the login page
				if(!isset($_SESSION['user_id'])){
					redirect('user/login');
				}
                $this->load->model('account_model');
        }

        public function index()
        {
				$this->load->library('pagination');
				
				$data['title'] = 'Accounts';
				$data['sub_title'] = 'List of accounts';
				$data['accounts'] = $this->account_model->get_account();
							
				$config['base_url'] = 'http://rent-manager/account/';
				$config['total_rows'] = count($data['accounts']);
			
				$data['pag_links'] = $this->pagination->create_links();
				
				$this->load->view('templates/header', $data);
				$this->load->view('accounts/index', $data);
				$this->load->view('templates/footer');
        }

        public function view($account_id = NULL)
        {
				$data['account'] = $this->account_model->get_account($account_id);
				if (empty($data['account']))
				{
					show_404();
				}
				
				$data['title'] = $data['account']['acc_name'];
				
				$this->load->view('templates/header', $data);
				$this->load->view('accounts/view', $data);
				$this->load->view('templates/footer');
        }

		public function create()
		{
			$this->load->helper('form');
			$this->load->library('form_validation');
			$data['title'] = 'Bank account';
			$data['sub_title'] = 'Add bank account';
			

			$this->form_validation->set_rules('acc_no', 'Account no', 'required', array('required' => '%s is missing.'));
			$this->form_validation->set_rules('bank_name', 'Bank name', 'required', array('required' => '%s is missing.'));
			$this->form_validation->set_rules('acc_name', 'Account name', 'required', array('required' => '%s is missing.'));
			if ($this->form_validation->run() === FALSE)
			{
				$this->load->view('templates/header', $data);
				$this->load->view('accounts/create', $data);
				$this->load->view('templates/footer');

			}
			else
			{
				$data['message'] = 'Account details were successfully submitted to the database.';
				$this->account_model->set_account();
				$this->load->view('templates/header', $data);
				$this->load->view('accounts/success', $data);
				$this->load->view('templates/footer');
			}
		}
		
		public function update($acc_id = NULL)
		{
			//if user not admin or boss, redirect them to the index
			if(isset($_SESSION['role']) && $_SESSION['role']<3)
			{
				$this->index();
				return;
			}
			if ($acc_id != NULL)
			{
				$this->load->helper('form');
				$this->load->library('form_validation');
				
				$data['title'] = 'Account details';
				$data['sub_title'] = 'Update account details';
				$data['btn'] = 'Update';
				$data['account'] = $this->account_model->get_account($acc_id);
				

				$this->form_validation->set_rules('acc_no', 'Account no', 'required', array('required' => '%s is missing.'));
				$this->form_validation->set_rules('bank_name', 'Bank name', 'required', array('required' => '%s is missing.'));
				$this->form_validation->set_rules('acc_name', 'Account name', 'required', array('required' => '%s is missing.'));
				if ($this->form_validation->run() === FALSE)
				{
					$this->load->view('templates/header', $data);
					$this->load->view('accounts/create', $data);
					$this->load->view('templates/footer');

				}
				else
				{
					$this->account_model->update_account($acc_id);
					
					$data['message'] = 'Account details successfully updated';
					
					$this->load->view('templates/header', $data);
					$this->load->view('accounts/success', $data);
					$this->load->view('templates/footer');
				}
			}
			else
			{
				$this->index();
			}
		}
		
		public function del_acc($acc_id = NULL)
		{
			//if user not admin or boss, redirect them to the index
			if(isset($_SESSION['role']) && $_SESSION['role']<3)
			{
				$this->index();
				return;
			}
			if ($acc_id != NULL)
			{
				$this->account_model->del_account($acc_id);
				
				$data['message'] = 'Account successfully deleted';
				$this->load->view('accounts/success', $data);
			}
			else
			{
				$data['title'] = 'Account deleted';
				$data['sub_title'] = 'Account deleted';
				
				$this->load->view('templates/header', $data);
				$this->load->view('accounts/index');
				$this->load->view('templates/footer');
			}
		}
}