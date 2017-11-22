<?php
class Payment_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }
		
		public function get_payment($filter = FALSE)
		{
			$this->db->select('`payment_id`, `payment`.`tenancy_id`, `tenant_id`, `payment_date`, `account`.`acc_id`, `bank_name`, `acc_no`, particulars, `amount`, `created_by`, `names`, `house_id`, `house_no`,`floor`');
			$this->db->from('payment');
			$this->db->join('account', 'account.acc_id = payment.account_id', 'left');
			$this->db->join("(SELECT `tenant`.`tenant_id`, `names`,`tenant_house`.`tenancy_id`, `house_id`, `house_no`,`floor` FROM `tenant` JOIN (SELECT `tenancy_id`, `tenant_id`, `tenancy`.`house_id`, `house_no`,`floor` FROM `tenancy` JOIN `house` ON `house`.`house_id`=`tenancy`.`house_id`) `tenant_house` ON `tenant`.`tenant_id` = `tenant_house`.`tenant_id`) `tenancy_house`", '`tenancy_house`.`tenancy_id` = `payment`.`tenancy_id`');
			
			if ($filter === FALSE)
			{
					$query = $this->db->get();
					return $query->result_array();
			}
			else{
				if(is_numeric($filter)){
					$this->db->where('payment_id', $filter);
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
		
		public function get_sum($tenant_id = FALSE)
		{
			$this->db->select_sum('amount', 'amt_paid');
			$this->db->from('payment');
			$this->db->join('account', 'account.acc_id = payment.account_id', 'left');
			
			if ($tenant_id === FALSE)
			{
					$query = $this->db->get();
					return $query->row_array();
			}

			$this->db->where("`tenancy_id` IN (SELECT `tenancy`.`tenancy_id` FROM `tenancy` WHERE `tenant_id` = $tenant_id)");
			$query = $this->db->get();
			return $query->row_array();
		}
		
		public function get_by_tenant_id($tenant_id)
		{
			$this->db->select('`payment_id`, `payment`.`tenancy_id`, `payment_date`, `account`.`acc_id`, `bank_name`, `acc_no`, particulars, `amount`, `created_by`, `names`, `house_no`,`floor`');
			$this->db->from('payment');
			$this->db->join('account', 'account.acc_id = payment.account_id', 'left');
			$this->db->join("(SELECT `tenant`.`tenant_id`, `names`,`tenant_house`.`tenancy_id`, `house_no`,`floor` FROM `tenant` JOIN (SELECT `tenancy_id`, `tenant_id`, `house_no`,`floor` FROM `tenancy` JOIN `house` ON `house`.`house_id`=`tenancy`.`house_id`) `tenant_house` WHERE `tenant`.`tenant_id` = $tenant_id) `tenancy_house`", '`tenancy_house`.`tenancy_id` = `payment`.`tenancy_id`');
			
			$query = $this->db->get();
			return $query->result_array();
		}
		
		public function set_payment()
		{
			
			$data = array(
				'tenant_id' => $this->input->post('tenant_id'),
				'payment_date' => mysql_to_unix(substr($this->input->post('payment_date'),-4,4) . substr($this->input->post('payment_date'),3,2) . substr($this->input->post('payment_date'),0,2) . "235959"),
				'account_id' => $this->input->post('account_id'),
				'particulars' => $this->input->post('particulars'),
				'amount' => $this->input->post('amount'),
				'entered_by' => $_SESSION['user_id']
			);
			$this->db->insert('payment', $data);
			return $this->db->insert_id();
		}
		
		public function update_payment($payment_id)
		{
			
			$data = array(
				'tenant_id' => $this->input->post('tenant_id'),
				'payment_date' => mysql_to_unix(substr($this->input->post('payment_date'),-4,4) . substr($this->input->post('payment_date'),3,2) . substr($this->input->post('payment_date'),0,2) . "235959"),
				'account_id' => $this->input->post('account_id'),
				'particulars' => $this->input->post('particulars'),
				'amount' => $this->input->post('amount'),
				'entered_by' => $_SESSION['user_id']
			);
			$this->db->where('payment_id', $payment_id);
			return $this->db->update('payment', $data);
		}
		
		public function del_payment($payment_id)
		{
			$this->db->where('payment_id', $payment_id);
			return $this->db->delete('payment');
		}
}