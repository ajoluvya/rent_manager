<?php
class Tenant_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }
		
		public function get_tenant($filter = FALSE)
		{
			$this->db->select('tenant_id, names, phone1, phone2, home_address, district, tenant.district_id');
			$this->db->from('tenant');
			$this->db->join('district', 'district.district_id = tenant.district_id');
			
			if ($filter === FALSE)
			{
					$query = $this->db->get();
					return $query->result_array();
			}
			else{
				if(is_numeric($filter)){
					$this->db->where('tenant_id', $filter);
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
		
		public function set_tenant()
		{
			
			$data = array(
				'names' => $this->input->post('names'),
				'phone1' => $this->input->post('phone1'),
				'phone2' => $this->input->post('phone2'),
				'home_address' => $this->input->post('home_address'),
				'district_id' => $this->input->post('district_id')
			);
			$this->db->insert('tenant', $data);
			return $this->db->insert_id();
		}
		
		public function update_tenant($tenant_id)
		{
			
			$data = array(
				'names' => $this->input->post('names'),
				'phone1' => $this->input->post('phone1'),
				'phone2' => $this->input->post('phone2'),
				'home_address' => $this->input->post('home_address'),
				'district_id' => $this->input->post('district_id')
			);
			$this->db->where('tenant_id', $tenant_id);
			return $this->db->update('tenant', $data);
		}
		
		public function del_tenant($tenant_id)
		{
			$this->db->where('tenant_id', $tenant_id);
			return $this->db->delete('tenant');
		}
}