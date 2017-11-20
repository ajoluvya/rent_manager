<?php
class Account_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }
		
		public function get_account($account_id = FALSE)
		{
			if ($account_id === FALSE)
			{
					$query = $this->db->get('account');
					return $query->result_array();
			}

			$query = $this->db->get_where('account', array('acc_id' => $account_id));
			return $query->row_array();
		}
		
		public function set_account()
		{
			
			$data = array(
				'acc_no' => $this->input->post('acc_no'),
				'bank_name' => $this->input->post('bank_name'),
				'acc_name' => $this->input->post('acc_name')
			);
			return $this->db->insert('account', $data);
		}
		
		public function update_account($acc_id)
		{
			
			$data = array(
				'acc_no' => $this->input->post('acc_no'),
				'bank_name' => $this->input->post('bank_name'),
				'acc_name' => $this->input->post('acc_name')
			);
			$this->db->where('acc_id', $acc_id);
			return $this->db->update('account', $data);
		}
		
		public function del_account($acc_id)
		{
			$this->db->where('acc_id', $acc_id);
			return $this->db->delete('account');
		}
}