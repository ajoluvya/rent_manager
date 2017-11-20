<?php
class Payment extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
				//if user not logged in, take them back to the login page
				if(!isset($_SESSION['user_id'])){
					redirect('user/login');
				}
                $this->load->model('payment_model');
                $this->load->model('account_model');
				$this->load->model('tenancy_model');
        }

        public function index()
        {
				$this->load->library('pagination');
				
				$where = "1 ";
				if($this->input->post('start') !=""||($this->input->post('period') !="" && is_numeric($this->input->post('period')))){
					
					$start	= ($this->input->post('start') !="")?mysql_to_unix(substr($this->input->post('start'),-4,4) . substr($this->input->post('start'),3,2) . substr($this->input->post('start'),0,2) . "235959"):(($this->input->post('period') !="")?(time()-(86400*$this->input->post('period'))):(time()-2592000));
						
					$end = ($this->input->post('end') !="")?mysql_to_unix(substr($this->input->post('end'),-4,4) . substr($this->input->post('end'),3,2) . substr($this->input->post('end'),0,2) . "235959"):time();
						
					$where = "(payment_date BETWEEN $start AND $end)";
				}
					
				if($this->input->post('search') !=""){
					$where .= ((strlen($where)>1)?" AND":"")." names LIKE '%{$this->input->post('search')}%'";
				}
				
				$data['title'] = 'Payments';
				$data['sub_title'] = 'All payments';
				$data['payments'] = $this->payment_model->get_payment($where);
				
							
				$config['base_url'] = 'http://rent-manager/account/';
				$config['total_rows'] = count($data['payments']);
			
				$data['pag_links'] = $this->pagination->create_links();

				$this->load->view('templates/header', $data);
				$this->load->view('payments/index' );
				$this->load->view('templates/footer');
        }

        public function view($payment_id = NULL)
        {
				$data['payment'] = $this->payment_model->get_payment($payment_id);
				$data['title'] = 'Payment';
				
				if (empty($data['payment']))
				{
					$data['sub_title'] = 'No data';
					$data['message'] = 'The payment record was not found';
					
					$this->load->view('templates/header', $data);
					$this->load->view('templates/404', $data);
					$this->load->view('templates/footer');
				}
				else
				{
					$this->load->model('house_model');
					$this->load->model('user_model');
					$data['tenant'] = $this->tenancy_model->get_by_tenant_id($data['payment']['tenant_id']);
					$data['house'] = $this->house_model->get_house($data['tenant'][0]['house_id']);
					$data['staff_detail'] = $this->user_model->get_user($data['payment']['entered_by']);
				
					$data['sub_title'] = "Payment receipt for " . $data['payment']['names'];
					
					$this->load->view('templates/header', $data);
					$this->load->view('payments/view', $data);
					$this->load->view('templates/footer');
				}
				
        }

		public function create($tenant_id = NULL)
		{
			if ($tenant_id !== NULL)
			{
				$this->load->helper('form');
				$this->load->library('form_validation');
				
				$data['title'] = "Payment";
				$data['sub_title'] = "Capture payment details";
				$data['accounts'] = $this->account_model->get_account();
				$tenancies = $this->tenancy_model->get_by_tenant_id($tenant_id);
				$data['tenant'] = $tenancies[0];
				
				$data['tenant_id'] = $tenant_id;
				$data['step_text'] = TRUE;

				$this->form_validation->set_rules('particulars', 'Particulars', 'required', array('required' => '%s is missing.'));
				$this->form_validation->set_rules('amount', 'Amount paid', 'required', array('required' => '%s is missing.'));
				$this->form_validation->set_rules('payment_date', 'Date of payment', 'required|datetime', array('required' => '%s is missing.','datetime' => '%s is invalid, required date format is dd-mm-yyyy.'));
				if ($this->form_validation->run() === FALSE)
				{
					$this->load->view('templates/header', $data);
					$this->load->view('payments/create', $data);
					$this->load->view('templates/footer');

				}
				else
				{
					$payment_id = $this->payment_model->set_payment();
					$this->view($payment_id);
				}
			}
			else
			{
				$this->index();
			}
		}
		
		public function update($payment_id = NULL)
		{
			//if user not admin or boss, redirect them to the index
			if(isset($_SESSION['role'])&&$_SESSION['role']<3)
			{
				$this->index();
			}
			if ($payment_id != NULL)
			{
				$this->load->helper('form');
				$this->load->library('form_validation');
				
				$data['title'] = 'Payment';
				$data['sub_title'] = 'Update payment details';
				$data['btn_text'] = 'Update';
				
				$data['payment'] = $this->payment_model->get_payment($payment_id);
				$data['accounts'] = $this->account_model->get_account();
				$tenancies = $this->tenancy_model->get_by_tenant_id($data['payment']['tenant_id']);
				$data['tenant'] = $tenancies[0];
				
				$data['tenant_id'] = $data['payment']['tenant_id'];

				$this->form_validation->set_rules('particulars', 'Particulars', 'required', array('required' => '%s is missing.'));
				$this->form_validation->set_rules('amount', 'Amount paid', 'required', array('required' => '%s is missing.'));
				$this->form_validation->set_rules('payment_date', 'Date of payment', 'required|datetime', array('required' => '%s is missing.','datetime' => '%s is invalid, required date format is dd-mm-yyyy.'));
				
				if ($this->form_validation->run() === FALSE)
				{
					$this->load->view('templates/header', $data);
					$this->load->view('payments/create', $data);
					$this->load->view('templates/footer');

				}
				else
				{
					$this->payment_model->update_payment($payment_id);
					
					$data['message'] = 'Payment details successfully updated';
					
					$this->load->view('templates/header', $data);
					$this->load->view('payments/success', $data);
					$this->load->view('templates/footer');
				}
			}
			else
			{
				$this->index();
			}
		}
		
		public function del_payment($payment_id = NULL)
		{
			//if user not admin or boss, redirect them to the index
			if(isset($_SESSION['role']) && $_SESSION['role']<3)
			{
				$this->index();
			}
			if ($payment_id != NULL)
			{
				$this->payment_model->del_payment($payment_id);
				
				$data['message'] = 'Payment record deleted';
				$this->load->view('payments/success', $data);
			}
			else
			{
				$data['title'] = 'Payment';
				$data['sub_title'] = 'Payment deleted';
				
				$this->load->view('templates/header', $data);
				$this->load->view('accounts/index');
				$this->load->view('templates/footer');
			}
		}
}