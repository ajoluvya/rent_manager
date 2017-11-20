<?php
class User_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }
		
		public function get_user($filter = FALSE)
		{
			$this->db->select('userId, email, phone, users.role_code, fname, lname, username, reg_date, role_name');
			$this->db->from('users');
			$this->db->join('role', 'role.role_code = users.role_code');
			
			if ($filter === FALSE)
			{
					$query = $this->db->get();
					return $query->result_array();
			}
			else{
				if(is_numeric($filter)){
					$this->db->where('userId', $filter);
					$query = $this->db->get();
					return $query->row_array();
				}
				else{
					!empty($filter)?$this->db->where($filter):"";
					$query = $this->db->get();
					return $query->result_array();
				}
			}
		}
		public function login_user()
		{
			$query = $this->db->get_where('users', array('username' => $this->input->post('uname'), 'password' => md5($this->input->post('pwd'))));
			return $query->row_array();
		}
		
		public function set_user()
		{

			$data = array(
				'fname' => $this->input->post('fname'),
				'lname' => $this->input->post('lname'),
				'username' => $this->input->post('uname'),
				'phone' => $this->input->post('phone'),
				'email' => $this->input->post('email'),
				'password' => md5(strtolower($this->input->post('fname').$this->input->post('lname'))."123"),
				'role_code' => $this->input->post('role_code'),
				'reg_date' => now()
			);

			return $this->db->insert('users', $data);
		}
		
		public function update_user($user_id)
		{
			
			$data = array('fname' => $this->input->post('fname'),
				'lname' => $this->input->post('lname'),
				'username' => $this->input->post('uname'),
				'phone' => $this->input->post('phone'),
				'email' => $this->input->post('email'),
				'role_code' => $this->input->post('role_code')
			);
			$this->db->where('userId', $user_id);
			return $this->db->update('users', $data);
		}
		
		public function update_pass($user_id)
		{
			
			$data = array('password' => md5($this->input->post('pwd')));
			
			$this->db->where('userId', $user_id);
			return $this->db->update('users', $data);
		}
		
		public function del_user($user_id)
		{
			$this->db->where('userId', $user_id);
			return $this->db->delete('users');
		}
}