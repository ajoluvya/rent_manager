<?php
class House extends CI_Controller {

        private $floors;
		
		public function __construct()
        {
                parent::__construct();
				//if user not logged in, take them back to the login page
				if(!isset($_SESSION['user_id'])){
					redirect('user/login');
				}
                $this->load->model('house_model');
                $this->load->model('estate_model');
				$this->floors = array('Ground', 'First', 'Second', 'Third', 'Fourth', 'Fifth');
        }

        public function index()
        {
				$this->load->library('pagination');
				
				$data['title'] = 'Houses';
				$data['sub_title'] = 'List of houses';
				$data['houses'] = $this->house_model->get_house();
				
							
				$config['base_url'] = 'http://rent-manager/house/';
				$config['total_rows'] = count($data['houses']);
			
				$data['pag_links'] = $this->pagination->create_links();

				$this->load->view('templates/header', $data);
				$this->load->view('houses/index', $data);
				$this->load->view('templates/footer');
        }

        public function view($house_id = NULL)
        {
				$data['house'] = $this->house_model->get_house($house_id);
				$data['title'] = 'House';
				
				if (empty($data['house']))
				{
					$data['sub_title'] = 'No data';
					$data['message'] = 'The house record was not found';
					
					$this->load->view('templates/header', $data);
					$this->load->view('templates/404', $data);
					$this->load->view('templates/footer');
				}
				else{
					$data['title'] = $data['sub_title'] = $data['house']['house_no'];
					$data['floor'] = $this->floors[$data['house']['floor']];
					
					$this->load->view('templates/header', $data);
					$this->load->view('houses/view', $data);
					$this->load->view('templates/footer');
				}
				
        }

		public function create()
		{
			$this->load->helper('form');
			$this->load->library('form_validation');
			
			$data['title'] = "House";
			$data['sub_title'] = "New apartment/house/room";
			$data['estates'] = $this->estate_model->get_estate();
			$data['floors'] = $this->floors;

			$this->form_validation->set_rules('house_no', 'Apartment/house/room no', 'required|max_length[20]', array('required' => '%s is missing.', 'max_length' => '% must be no more than 20 charaters'));
			$this->form_validation->set_rules('description', 'Description', 'max_length[100]', array('max_length' => '% must be no more than 100 characters'));
			$this->form_validation->set_rules('fixed_amount', 'Fixed amount', 'required|less_than_equal_to[10000000]', array('required' => '%s is missing.', 'less_than_equal_to' => '%s is more than the accepatable amount'));
			$this->form_validation->set_rules('estate_id', 'Estate', 'required', array('required' => '%s was not selected.'));
			
			if ($this->form_validation->run() === FALSE)
			{
				$this->load->view('templates/header', $data);
				$this->load->view('houses/create', $data);
				$this->load->view('templates/footer');

			}
			else
			{
				$data['message'] = 'House details were successfully submitted to the database.';
				$this->house_model->set_house();
				$this->load->view('templates/header', $data);
				$this->load->view('houses/success', $data);
				$this->load->view('templates/footer');
			}
		}
		
		public function update($house_id = NULL)
		{
			//if user not admin or boss, redirect them to the index
			if(isset($_SESSION['role']) && $_SESSION['role']<3)
			{
				$this->index();
				return;
			}
			if ($house_id != NULL)
			{
				$this->load->helper('form');
				$this->load->library('form_validation');
				
				$data['title'] = 'House';
				$data['sub_title'] = 'Update house details';
				$data['btn_text'] = 'Update';
				
				$data['house'] = $this->house_model->get_house($house_id);
				$data['estates'] = $this->estate_model->get_estate();
				$data['floors'] = $this->floors;

				$this->form_validation->set_rules('house_no', 'Apartment/house/room no', 'required|max_length[20]', array('required' => '%s is missing.', 'max_length' => '% must be no more than 20 charaters'));
				$this->form_validation->set_rules('description', 'Description', 'max_length[100]', array('max_length' => '% must be no more than 100 characters'));
				$this->form_validation->set_rules('fixed_amount', 'Fixed amount', 'required|less_than_equal_to[10000000]', array('required' => '%s is missing.', 'less_than_equal_to' => '%s is more than the accepatable amount'));
				$this->form_validation->set_rules('estate_id', 'Estate', 'required', array('required' => '%s was not selected.'));
				
				if ($this->form_validation->run() === FALSE)
				{
					$this->load->view('templates/header', $data);
					$this->load->view('houses/create', $data);
					$this->load->view('templates/footer');

				}
				else
				{
					$this->house_model->update_house($house_id);
					
					$data['message'] = 'House details successfully updated';
					
					$this->load->view('templates/header', $data);
					$this->load->view('houses/success', $data);
					$this->load->view('templates/footer');
				}
			}
			else
			{
				$this->index();
			}
		}
		
		public function del_house($house_id = NULL)
		{
			//if user not admin or boss, redirect them to the index
			if(isset($_SESSION['role']) && $_SESSION['role']<3)
			{
				$this->index();
				return;
			}
			if ($house_id != NULL)
			{
				$this->house_model->del_house($house_id);
				$data['title'] = 'House deleted';
				$data['sub_title'] = 'House deleted';
				
				$data['message'] = 'House successfully deleted';
				
				$this->load->view('templates/header', $data);
				$this->load->view('houses/success', $data);
				$this->load->view('templates/footer');
			}
			else
			{
				$data['title'] = 'Error';
				$data['sub_title'] = 'Error deleting';
				$data['message'] = 'Invalid operation, the item was not deleted';
				
				$this->load->view('templates/header', $data);
				$this->load->view('houses/404', $data);
				$this->load->view('templates/footer');
			}
		}
}