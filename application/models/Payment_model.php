<?php
class Payment_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }
		
		public function get_payment($filter = FALSE)
		{
			$this->db->select('payment_id, payment.tenant_id, payment_date, account.acc_id, bank_name, acc_no, particulars, amount, entered_by, tenant.names');
			$this->db->from('payment');
			$this->db->join('account', 'account.acc_id = payment.account_id', 'left');
			$this->db->join('tenant', 'tenant.tenant_id = payment.tenant_id');
			
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

			$this->db->where('tenant_id', $tenant_id);
			$query = $this->db->get();
			return $query->row_array();
		}
		
		public function get_by_tenant_id($tenant_id = FALSE)
		{
			$this->db->select('payment_id, payment.tenant_id, payment_date, account.acc_id, bank_name, acc_no, particulars, amount, entered_by, tenant.names');
			$this->db->from('payment');
			$this->db->join('account', 'account.acc_id = payment.account_id', 'left');
			$this->db->join('tenant', 'tenant.tenant_id = payment.tenant_id');
			
			if ($tenant_id === FALSE)
			{
					$query = $this->db->get();
					return $query->result_array();
			}

			$this->db->where('payment.tenant_id', $tenant_id);
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