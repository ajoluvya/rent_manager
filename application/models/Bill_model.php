<?php
class Bill_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }
		
		public function get_bill($bill_id = FALSE)
		{
			$this->db->select('bill_id, bill.tenancy_id, bill_date, amount, house_no');
			$this->db->from('bill');
			
			if ($bill_id === FALSE)
			{
					$query = $this->db->get();
					return $query->result_array();
			}

			$this->db->where('bill_id', $bill_id);
			$query = $this->db->get();
			return $query->row_array();
		}
		
		public function get_by_tenant_id($tenant_id = FALSE)
		{
			$this->db->select('bill_id, bill.tenancy_id, bill_date, amount, house_no');
			$this->db->from('bill');
			
			if ($tenant_id === FALSE)
			{
					$query = $this->db->get();
					return $query->result_array();
			}

			$this->db->where('tenant_id', $tenant_id);
			$query = $this->db->get();
			return $query->result_array();
		}
		
		public function get_sum($tenant_id = FALSE)
		{
			$this->db->select_sum('amount', 'amount');
			$this->db->from('bill');
			
			if ($tenant_id === FALSE)
			{
					$query = $this->db->get();
					return $query->row_array();
			}

			$this->db->where('tenant_id', $tenant_id);
			$query = $this->db->get();
			return $query->row_array();
		}
		
		public function set_bill()
		{
			
			$data = array(
				'tenancy_id' => $this->input->post('tenancy_id'),
				'house_no' => $this->input->post('house_no'),
				'bill_date' => $this->input->post('bill_date'),
				'amount' => $this->input->post('amount')
			);
			/*$MY_QUERY = SELECT `tenancy_id`, `tenant_id`, `house_no`, CURDATE(), `rent_rate` FROM `tenancy` JOIN house ON tenancy.house_id = house.house_id WHERE `end_date` <> NULL AND (FROM_UNIXTIME(`start_date`, '%e') = DAY(CURDATE()) OR (FROM_UNIXTIME(`start_date`, '%e') = 29 AND FROM_UNIXTIME(`start_date`, '%m') = 2 AND DAY(CURDATE())=28));*/
			
			$this->db->insert('tenant', $data);
			return $this->db->insert_id();
		}
			
		public function set_auto_bill()
		{

			$sql = "INSERT INTO `bill`(tenancy_id, `tenant_id`, `house_no`, `bill_date`, `amount`)
			SELECT `tenancy_id`, `tenant_id`, `house_no`, CURDATE(), `rent_rate` 
			FROM `tenancy`
			JOIN `house` ON `tenancy`.`house_id` = `house`.`house_id`
			WHERE `end_date` <> NULL
			AND (FROM_UNIXTIME(`start_date`, '%e') = DAY(CURDATE())
				OR (FROM_UNIXTIME(`start_date`, '%e') = 29
					AND FROM_UNIXTIME(`start_date`, '%m') = 2
					AND DAY(CURDATE())=28
					)
				)";
			
			return $this->db->query($sql);
		}
		public function del_bill($bill_id)
		{
			$this->db->where('bill_id', $bill_id);
			return $this->db->delete('tenant');
		}
}