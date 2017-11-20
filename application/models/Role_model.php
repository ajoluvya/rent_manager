<?php
class Role_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }
		
		public function get_role($role_code = FALSE)
		{
			if ($role_code === FALSE)
			{
					$query = $this->db->get('role');
					return $query->result_array();
			}

			$query = $this->db->get_where('role', array('role_code' => $role_code));
			return $query->row_array();
		}
		
		public function set_role()
		{

			$data = array(
				'role_name' => $this->input->post('role_name')
			);

			return $this->db->insert('role', $data);
		}
}