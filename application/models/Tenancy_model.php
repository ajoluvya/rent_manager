<?php
class Tenancy_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }
		
		public function get_tenancy($filter = FALSE)
		{
			$this->db->select('tenancy_id, tenancy.tenant_id, tenancy.house_id, tenancy.start_date, tenancy.rent_rate, house.house_no, house.estate_id, tenant.names, phone1, phone2');
			$this->db->from('tenancy');
			$this->db->join('tenant', 'tenant.tenant_id = tenancy.tenant_id');
			$this->db->join('house', 'house.house_id = tenancy.house_id');
			$this->db->order_by('tenancy.start_date DESC');
			
			if ($filter === FALSE)
			{
					$query = $this->db->get();
					return $query->result_array();
			}
			else{
				if(is_numeric($filter)){
					$this->db->where('tenancy_id', $filter);
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
		
		public function get_by_tenant_id($tenant_id = FALSE)
		{
			$this->db->select('tenancy_id, tenancy.tenant_id, tenancy.house_id, tenancy.start_date, tenancy.rent_rate, house.house_no, house.estate_id, tenant.home_address, tenant.names, phone1, phone2');
			$this->db->from('tenancy');
			$this->db->join('tenant', 'tenant.tenant_id = tenancy.tenant_id');
			$this->db->join('house', 'house.house_id = tenancy.house_id');
			//$query = $this->db->get_where('tenancy', array('tenant_id' => $tenant_id));
			
			if ($tenant_id === FALSE)
			{
					$query = $this->db->get();
					return $query->result_array();
			}

			$this->db->where('tenancy.tenant_id', $tenant_id);
			$query = $this->db->get();
			return $query->result_array();
		}
		
		public function set_tenancy()
		{
			
			$end_date = ($this->input->post('end_date')!=NULL)?mysql_to_unix(substr($this->input->post('end_date'),-4,4) . substr($this->input->post('end_date'),3,2) . substr($this->input->post('end_date'),0,2) . "235959"):0;
			$data = array(
				'tenant_id' => $this->input->post('tenant_id'),
				'house_id' => $this->input->post('house_id'),
				'start_date' => mysql_to_unix(substr($this->input->post('start_date'),-4,4) . substr($this->input->post('start_date'),3,2) . substr($this->input->post('start_date'),0,2) . "235959"),
				'end_date' => $end_date,
				'rent_rate' => $this->input->post('rent_rate'),
				'assigned_by' => $_SESSION['user_id']
			);
			return $this->db->insert('tenancy', $data);
		}
		
		public function update_tenancy($tenancy_id)
		{
			$end_date = ($this->input->post('end_date')!=NULL)?mysql_to_unix(substr($this->input->post('end_date'),-4,4) . substr($this->input->post('end_date'),3,2) . substr($this->input->post('end_date'),0,2) . "235959"):0;
			$data = array(
				'tenant_id' => $this->input->post('tenant_id'),
				'house_id' => $this->input->post('house_id'),
				'start_date' => mysql_to_unix(substr($this->input->post('start_date'),-4,4) . substr($this->input->post('start_date'),3,2) . substr($this->input->post('start_date'),0,2) . "235959"),
				'end_date' => $end_date,
				'rent_rate' => $this->input->post('rent_rate'),
				'assigned_by' => $_SESSION['user_id']
			);
			$this->db->where('tenancy_id', $tenancy_id);
			return $this->db->update('tenancy', $data);
		}
		
		public function del_tenancy($tenancy_id)
		{
			$this->db->where('tenancy_id', $tenancy_id);
			return $this->db->delete('tenancy');
		}
}