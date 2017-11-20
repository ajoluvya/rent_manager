<?php
class House_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }
		
		public function get_house($house_id = FALSE)
		{
			$query = $this->db->get_where('house', array('house_id' => $house_id));
			$this->db->select('house_id, house_no, house.description, fixed_amount, floor, estate.estate_name, estate.address, estate.phone, estate.phone2, house.estate_id');
			$this->db->from('house');
			$this->db->join('estate', 'estate.estate_id = house.estate_id');
			
			if ($house_id === FALSE)
			{
					$query = $this->db->get();
					return $query->result_array();
			}

			$this->db->where('house_id', $house_id);
			$query = $this->db->get();
			return $query->row_array();
		}
		
		public function set_house()
		{
			
			$data = array(
				'house_no' => $this->input->post('house_no'),
				'floor' => $this->input->post('floor'),
				'description' => $this->input->post('description'),
				'estate_id' => $this->input->post('estate_id'),
				'fixed_amount' => $this->input->post('fixed_amount')
			);
			return $this->db->insert('house', $data);
		}
		
		public function update_house($house_id)
		{
			
			$data = array(
				'house_no' => $this->input->post('house_no'),
				'description' => $this->input->post('description'),
				'floor' => $this->input->post('floor'),
				'estate_id' => $this->input->post('estate_id'),
				'fixed_amount' => $this->input->post('fixed_amount')
			);
			$this->db->where('house_id', $house_id);
			return $this->db->update('house', $data);
		}
		
		public function del_house($house_id)
		{
			$this->db->where('house_id', $house_id);
			return $this->db->delete('house');
		}
}