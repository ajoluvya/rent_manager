<?php
class District_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }
		
		public function get_district($district_id = FALSE)
		{
			if ($district_id === FALSE)
			{
					$query = $this->db->get('district');
					return $query->result_array();
			}

			$query = $this->db->get_where('district', array('district_id' => $district_id));
			return $query->row_array();
		}
}