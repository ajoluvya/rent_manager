<?php
class Tenant extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
				//if user not logged in, take them back to the login page
				if(!isset($_SESSION['user_id'])){
					redirect('user/login');
				}
                $this->load->model('tenant_model');
                $this->load->model('district_model');
                $this->load->model('house_model');
                $this->load->model('estate_model');
        }

        public function index()
        {
				$this->load->helper('form');
				$this->load->library('pagination');
				
				$where = "";
				
				if($this->input->post('search') !=""){
					$where .= "names LIKE '%{$this->input->post('search')}%'";
				}
				
				$data['title'] = 'Tenants';
				$data['sub_title'] = 'List of tenants';
				$data['tenants'] = $this->tenant_model->get_tenant($where);				
							
				$config['base_url'] = 'http://rent_manager/tenant/';
				$config['total_rows'] = count($data['tenants']);
			
				$data['pag_links'] = $this->pagination->create_links();
				

				$this->load->view('templates/header', $data);
				$this->load->view('tenants/index' );
				$this->load->view('templates/footer');
        }

        public function view($tenant_id = NULL)
        {
				$data['tenant'] = $this->tenant_model->get_tenant($tenant_id);
				$data['title'] = 'Tenant';
				
				if (empty($data['tenant']))
				{
					$data['sub_title'] = 'No data';
					$data['message'] = 'The tenant record was not found';
					//show_404();
					$this->load->view('templates/header', $data);
					$this->load->view('templates/404', $data);
					$this->load->view('templates/footer');
				}
				else{
					
					$this->load->model('payment_model');
					$this->load->model('tenancy_model');
				
					$data['sub_title'] = $data['tenant']['names'];
					$data['houses'] = $this->tenancy_model->get_tenancy("`tenancy`.`tenant_id`=".$tenant_id);
					$data['payments'] = $this->payment_model->get_by_tenant_id($tenant_id);
					$data['total_payments'] = $this->payment_model->get_sum($tenant_id);
					
					$this->load->view('templates/header', $data);
					$this->load->view('tenants/view', $data);
					$this->load->view('templates/footer');
				}
				
        }

		public function create()
		{
			$this->load->helper('form');
			$this->load->library('form_validation');
			
			$data['title'] = "Tenant";
			$data['sub_title'] = "Capture tenant data";
			$data['districts'] = $this->district_model->get_district();
			$data['step_text'] = TRUE;

			$this->form_validation->set_rules('names', 'Tenant names', 'required|max_length[50]', array('required' => '%s is missing.', 'max_length' => '% must be less than 50 characters'));
			$this->form_validation->set_rules('phone1', 'Phone number', 'required|exact_length[10]|numeric', array('required' => '%s is missing.', 'exact_length' => '% must be exactly 10 digits'));
			$this->form_validation->set_rules('phone2', 'Second phone no', 'exact_length[10]|numeric', array('exact_length' => '%s must be exactly 10 digits.'));
			$this->form_validation->set_rules('home_address', 'Home address', 'required', array('required' => '%s is missing.'));
			$this->form_validation->set_rules('district_id', 'Home district', 'required', array('required' => '%s is missing.'));
			if ($this->form_validation->run() === FALSE)
			{
				$this->load->view('templates/header', $data);
				$this->load->view('tenants/create', $data);
				$this->load->view('templates/footer');

			}
			else
			{
				$data['tenant_id'] = $this->tenant_model->set_tenant();
				$data['tenant_names'] = $this->input->post('names');
				$data['houses'] = $this->house_model->get_house();
				$data['estates'] = $this->estate_model->get_estate();
				$data['step_text'] = TRUE;
				
				$this->load->view('templates/header', $data);
				$this->load->view('tenancy/create', $data);
				$this->load->view('templates/footer');
			}
		}
		
		public function update($tenant_id = NULL)
		{
			//if user not admin or boss, redirect them to the index
			/* if(isset($_SESSION['role']) && $_SESSION['role']<3)
			{
				$this->index();
				return;
			} */
			if ($tenant_id != NULL)
			{
				$this->load->helper('form');
				$this->load->library('form_validation');
				
				$data['title'] = 'Tenant';
				$data['sub_title'] = 'Update tenant details';
				$data['btn_text'] = 'Update';
				
				$data['tenant'] = $this->tenant_model->get_tenant($tenant_id);
				$data['districts'] = $this->district_model->get_district();

				$this->form_validation->set_rules('names', 'Tenant names', 'required', array('required' => '%s is missing.'));
				$this->form_validation->set_rules('phone1', 'Phone number1', 'required|exact_length[10]|numeric', array('required' => '%s is missing.', 'exact_length' => '% must be exactly 10 digits'));
				$this->form_validation->set_rules('phone2', 'Second phone no', 'exact_length[10]|numeric', array('exact_length' => '%s must be exactly 10 digits.'));
				$this->form_validation->set_rules('home_address', 'Home address', 'required', array('required' => '%s is missing.'));
				$this->form_validation->set_rules('district_id', 'Home district', 'required', array('required' => '%s is missing.'));
				
				if ($this->form_validation->run() === FALSE)
				{
					$this->load->view('templates/header', $data);
					$this->load->view('tenants/create', $data);
					$this->load->view('templates/footer');

				}
				else
				{
					$this->tenant_model->update_tenant($tenant_id);
					
					$data['message'] = 'Tenant details successfully updated';
					
					$this->load->view('templates/header', $data);
					$this->load->view('tenants/success', $data);
					$this->load->view('templates/footer');
				}
			}
			else
			{
				$this->index();
			}
		}
		
		public function del_tenant($tenant_id = NULL)
		{
			//if user not admin or boss, redirect them to the index
			if(isset($_SESSION['role']) && $_SESSION['role']<3)
			{
				$this->index();
				return;
			}
			if ($tenant_id != NULL)
			{
				$this->tenant_model->del_tenant($tenant_id);
				
				$data['title'] = 'Delete tenant';
				$data['sub_title'] = 'Tenant details deleted';
				$data['message'] = 'Tenant details deleted from database';
				
				$this->load->view('templates/header', $data);
				$this->load->view('tenants/success', $data);
				$this->load->view('templates/footer');
			}
			else
			{
				$data['title'] = 'Delete tenant';
				$data['sub_title'] = 'Failure';
				$data['message'] = 'Delete operation unsuccessful';
				
				$this->load->view('templates/header', $data);
				$this->load->view('templates/404', $data);
				$this->load->view('templates/footer');
			}
		}
}