<?php
class User extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('user_model');
        }

        public function index()
        {
			//if user not logged in, take them to the login page
			if(!isset($_SESSION['user_id']))
			{
				$this->login();
				return;
			}
			//if user not logged in, take them to the login page
			if(isset($_SESSION['role']) && $_SESSION['role']<3)
			{
				redirect('/dash');
				return;
			}
			$this->load->library('pagination');
			
			$where = "";
			if($this->input->post('start') !=""||($this->input->post('period') !="" && is_numeric($this->input->post('period')))){
				
				$start	= ($this->input->post('start') !="")?mysql_to_unix(substr($this->input->post('start'),-4,4) . substr($this->input->post('start'),3,2) . substr($this->input->post('start'),0,2) . "235959"):(($this->input->post('period') !="")?(time()-(86400*$this->input->post('period'))):(time()-2592000));
					
				$end = ($this->input->post('end') !="")?mysql_to_unix(substr($this->input->post('end'),-4,4) . substr($this->input->post('end'),3,2) . substr($this->input->post('end'),0,2) . "235959"):time();
					
				$where = "(reg_date BETWEEN $start AND $end)";
			}
				
			if($this->input->post('search') !=""){
				$where .= ((strlen($where)>1)?" AND":"")." names LIKE '%{$this->input->post('search')}%'";
			}
			
			$data['users'] = $this->user_model->get_user($where);
			$data['title'] = 'Users';
			$data['sub_title'] = 'User list';
			
			$config['base_url'] = 'http://rent-manager/user/';
			$config['total_rows'] = count($data['users']);
			//$this->pagination->initialize($config);
			
			$data['pag_links'] = $this->pagination->create_links();

			$this->load->view('templates/header', $data);
			$this->load->view('user/index', $data);
			$this->load->view('templates/footer');
        }

        public function view($user_id = NULL)
        {
				$data['user'] = $this->user_model->get_user($user_id);
				
				if (empty($data['user']))
				{
						show_404();
				}

				$data['title'] = "User details";
				$data['sub_title'] = $data['user']['fname'] . " ". $data['user']['lname'];

				$this->load->view('templates/header', $data);
				$this->load->view('user/view', $data);
				$this->load->view('templates/footer');
        }
		
        public function login()
        {
			//if user already logged in, redirect them to the dashboard
			if(isset($_SESSION['user_id'])){
				redirect('/tenancy');
				return;
			}
			$this->load->helper('form');
			$this->load->library('form_validation');

			$data['title'] = 'Please login';

			$this->form_validation->set_rules('uname', 'Username', 'required');
			$this->form_validation->set_rules('pwd', 'Password', 'required');

			if ($this->form_validation->run() === FALSE)
			{
				$this->load->view('user/login', $data);

			}
			else
			{
				$data['users'] = $this->user_model->login_user();
				if(empty($data['users']))
				{
					$data['title'] = 'Incorrect Username or password';
					$this->load->view('user/login', $data);
				}
				else
				{
					$user_data = array('username' => $this->input->post('uname'), 'user_id' => $data['users']['userId'], 'fname' =>  $data['users']['fname'], 'lname' =>  $data['users']['lname'], 'role' =>  $data['users']['role_code'], 'reg_date' =>  $data['users']['reg_date']);
					// Add user data in session
					$this->session->set_userdata($user_data);
					
					redirect('/tenancy');
				}
			}
        }
		
		// Logout from admin page
		public function logout()
		{
			$this->load->library('form_validation');
			
			// Removing session data
			$user_data = array('username', 'user_id', 'fname', 'lname', 'role', 'reg_date');
			
			$this->session->unset_userdata($user_data);
			session_write_close();
			
			$data['title'] = 'Successfully Logged out';
			$this->load->view('user/login', $data);
		}
		
		public function create()
		{
			//if user not admin or boss, redirect them to the index
			if(isset($_SESSION['role']) && $_SESSION['role']<3)
			{
				redirect('/tenancy');
				return;
			}
			$this->load->helper('form');
			$this->load->library('form_validation');
            $this->load->model('role_model');

			$data['title'] = 'User';
			$data['sub_title'] = 'Register a new user';
			$data['roles'] = $this->role_model->get_role();

			$this->form_validation->set_rules('fname', 'Firstname', array('required', 'min_length[5]', 'max_length[30]', 'alpha'));
			$this->form_validation->set_rules('lname', 'Lastname', array('required', 'min_length[5]', 'max_length[30]', 'alpha'));
			$this->form_validation->set_rules('uname', 'Username', array('required', 'min_length[5]', 'max_length[30]','is_unique[users.username]'));
			$this->form_validation->set_rules('role_code', 'Role', array('required', 'numeric'));
			/*$this->form_validation->set_rules('pwd', 'Password', array('required', 'min_length[5]', 'max_length[30]'));
			$this->form_validation->set_rules('retype_pwd', 'Confirm password', array('required', 'matches[pwd]'));*/

			if ($this->form_validation->run() === FALSE)
			{
				$this->load->view('templates/header', $data);
				$this->load->view('user/create', $data);
				$this->load->view('templates/footer');

			}
			else
			{
				$this->user_model->set_user();
				$this->load->view('user/success');
			}
		}
		
		public function update($user_id = NULL)
		{
			//if user not admin or boss, redirect them to the index
			if(isset($_SESSION['role']) && $_SESSION['role']<3)
			{
				redirect('/tenancy');
			}
			if ($user_id != NULL)
			{
				$this->load->helper('form');
				$this->load->library('form_validation');
				$this->load->model('role_model');

				$data['title'] = 'User';
				$data['sub_title'] = 'Update user details';
				$data['user'] = $this->user_model->get_user($user_id);
				$data['roles'] = $this->role_model->get_role();
				$data['btn_text'] = 'Update';

				$this->form_validation->set_rules('fname', 'Firstname', array('required', 'min_length[5]', 'max_length[30]', 'alpha'));
				$this->form_validation->set_rules('lname', 'Lastname', array('required', 'min_length[5]', 'max_length[30]', 'alpha'));
				$this->form_validation->set_rules('uname', 'Username', array('required', 'min_length[5]', 'max_length[30]'));
				$this->form_validation->set_rules('role_code', 'Role', array('required', 'numeric'));

				if ($this->form_validation->run() === FALSE)
				{
					$this->load->view('templates/header', $data);
					$this->load->view('user/create', $data);
					$this->load->view('templates/footer');

				}
				else
				{
					$this->user_model->update_user($user_id);
					
					$this->index();
				}
			}
			else
			{
				$this->index();
			}
		}
		
		public function change_pass($user_id = NULL)
		{
			if ($user_id != NULL)
			{
				$this->load->helper('form');
				$this->load->library('form_validation');

				$data['title'] = 'User';
				$data['sub_title'] = 'Change password';
				$data['user'] = $this->user_model->get_user($user_id);
				$data['btn_text'] = 'Change';

				$this->form_validation->set_rules('cur_pwd', 'Current Password', array('required', 'min_length[5]', 'max_length[30]', 'valid_pass['.$_SESSION['user_id'].']'));
				$this->form_validation->set_rules('pwd', 'Password', array('required', 'min_length[5]', 'max_length[30]'));
				$this->form_validation->set_rules('retype_pwd', 'Confirm password', array('required', 'matches[pwd]'));

				if ($this->form_validation->run() === FALSE)
				{
					$this->load->view('templates/header', $data);
					$this->load->view('user/create', $data);
					$this->load->view('templates/footer');

				}
				else
				{
					$this->user_model->update_pass($user_id);
					
					$this->logout();
				}
			}
			else
			{
				$this->logout();
			}
		}
}