<?php
class Payment_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }
		
		public function get_payment($filter = FALSE)
		{
			$this->db->select('`payment_id`, `payment`.`tenancy_id`, `tenant_id`, `payment_date`, `particulars`, `start_date`, `end_date`, TIMESTAMPDIFF(MONTH, `start_date`, `end_date`) `no_of_months`, `amount`, `created_by`, `account`.`acc_id`, `bank_name`, `acc_no`, `names`, `house_id`, `house_no`,`floor`');
			$this->db->from('payment');
			$this->db->join('account', 'account.acc_id = payment.account_id', 'left');
			$this->db->join("(SELECT `tenant`.`tenant_id`, `names`,`tenant_house`.`tenancy_id`, `house_id`, `house_no`,`floor` FROM `tenant` JOIN (SELECT `tenancy_id`, `tenant_id`, `tenancy`.`house_id`, `house_no`,`floor` FROM `tenancy` JOIN `house` ON `house`.`house_id`=`tenancy`.`house_id`) `tenant_house` ON `tenant`.`tenant_id` = `tenant_house`.`tenant_id`) `tenancy_house`", '`tenancy_house`.`tenancy_id` = `payment`.`tenancy_id`');
			$this->db->order_by('`payment`.`payment_date` ASC');
			
			if ($filter == FALSE)
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
			$this->db->select('`payment_id`, `payment`.`tenancy_id`, `payment_date`, `particulars`, `start_date`, `end_date`, TIMESTAMPDIFF(MONTH, `start_date`, `end_date`) `no_of_months`, `amount`, `created_by`,`account`.`acc_id`, `bank_name`, `acc_no`, `names`, `house_id`, `house_no`,`floor`');
			$this->db->from('payment');
			$this->db->join('account', 'account.acc_id = payment.account_id', 'left');
			$this->db->join("(SELECT `tenant`.`tenant_id`, `names`,`tenant_house`.`tenancy_id`, `house_id`, `house_no`,`floor` FROM `tenant` JOIN (SELECT `tenancy_id`, `tenant_id`, `tenancy`.`house_id`,`house_no`,`floor` FROM `tenancy` JOIN `house` ON `house`.`house_id`=`tenancy`.`house_id`) `tenant_house` ON `tenant`.`tenant_id`=`tenant_house`.`tenant_id` WHERE `tenant`.`tenant_id` = $tenant_id) `tenancy_house`", '`tenancy_house`.`tenancy_id` = `payment`.`tenancy_id`');
			
			$query = $this->db->get();
			return $query->result_array();
		}
		
		public function get_by_tenancy_id($tenancy_id)
		{
			$this->db->select('`payment_id`, `payment`.`tenancy_id`, `payment_date`, `particulars`,`start_date`, `end_date`, TIMESTAMPDIFF(MONTH, `start_date`, `end_date`) `no_of_months`, `amount`, `created_by`, `account`.`acc_id`, `bank_name`, `acc_no`, `house_id`');
			$this->db->from('payment');
			$this->db->join('account', 'account.acc_id = payment.account_id', 'left');
			$this->db->join('tenancy', '`tenancy`.`tenancy_id` = `payment`.`tenancy_id`');
			
			$query = $this->db->where('`payment`.`tenancy_id`',$tenancy_id);
			$query = $this->db->get();
			return $query->result_array();
		}
		
		public function set_payment()
		{
			$payment_date = explode('-',$this->input->post('payment_date'));
			
			$data = array(
				'tenancy_id' => $this->input->post('tenancy_id'),
				'payment_date' => mysql_to_unix($payment_date[2] . $payment_date[1] . $payment_date[0] . "235959"),
				'account_id' => $this->input->post('account_id'),
				'particulars' => $this->input->post('particulars'),
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date'),
				'rent_rate' => $this->input->post('rent_rate'),
				'amount' => $this->input->post('amount'),
				'created_by' => $_SESSION['user_id'],
				'date_created' => time(),
				'modified_by' => $_SESSION['user_id']
			);
			$this->db->insert('payment', $data);
			return $this->db->insert_id();
		}
		
		public function update_payment($payment_id)
		{
			$payment_date = explode('-',$this->input->post('payment_date'));
			
			$data = array(
				'tenancy_id' => $this->input->post('tenancy_id'),
				'payment_date' => mysql_to_unix($payment_date[2] . $payment_date[1] . $payment_date[0] . "235959"),
				'account_id' => $this->input->post('account_id'),
				'particulars' => $this->input->post('particulars'),
				'start_date' => $this->input->post('start_date'),
				'end_date' => $this->input->post('end_date'),
				'rent_rate' => $this->input->post('rent_rate'),
				'amount' => $this->input->post('amount'),
				'modified_by' => $_SESSION['user_id']
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