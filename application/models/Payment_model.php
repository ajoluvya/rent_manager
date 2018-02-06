<?php

class Payment_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_payment($filter = FALSE) {
        $this->db->select('`payment`.`payment_id`, `payment`.`tenancy_id`, `tenant_id`, `payment_date`, `particulars`, payment_summary.`start_date`, payment_summary.`end_date`, `amount`, `no_of_periods`, `created_by`, `account`.`acc_id`, `bank_name`, `acc_no`, `names`, `house_id`, `house_no`,`floor`, `label`, `period_desc`, `billing_starts`, `billing_freq`, `time_interval_id`');
        $this->db->from('payment');
        $this->db->join('account', 'account.acc_id = payment.account_id', 'left');
        $this->db->join("(SELECT `payment_id`, MIN(`start_date`) `start_date`, MAX(`end_date`) `end_date` FROM `payment_line` GROUP BY `payment_id`) `payment_summary`", '`payment_summary`.`payment_id` = `payment`.`payment_id`');
        $this->db->join("(SELECT `tenant`.`tenant_id`, `names`,`tenant_house`.`tenancy_id`,`start_date`, `end_date`, `house_id`, `house_no`,`floor`, `label`, `period_desc`, `billing_freq`, `billing_starts`, `time_interval_id` FROM `tenant` JOIN (SELECT `tenancy_id`, `start_date`, `end_date`, `tenant_id`, `tenancy`.`house_id`, `house_no`,`floor`, `tbl_time_interval`.`label`,`tbl_time_interval`.`description` `period_desc`, `tenancy`.`billing_starts`, `tenancy`.`billing_freq`, `tenancy`.`time_interval_id` FROM `tenancy` JOIN `house` ON `house`.`house_id`=`tenancy`.`house_id` JOIN `tbl_time_interval` ON `tbl_time_interval`.`id` = `tenancy`.`time_interval_id`) `tenant_house` ON `tenant`.`tenant_id` = `tenant_house`.`tenant_id`) `tenancy_house`", '`tenancy_house`.`tenancy_id` = `payment`.`tenancy_id`');
        $this->db->order_by('`payment`.`payment_date` ASC');

        if ($filter == FALSE) {
            $query = $this->db->get();
            return $query->result_array();
        } else {
            if (is_numeric($filter)) {
                $this->db->where('`payment`.`payment_id`', $filter);
                $query = $this->db->get();
                return $query->row_array();
            } else {
                !empty($filter) ? $this->db->where($filter) : "";
                $query = $this->db->get();
                return $query->result_array();
            }
        }
    }

    public function get_payment_lines($filter = FALSE) {
        $this->db->select('`payment`.`payment_id`, `payment`.`tenancy_id`, `tenant_id`, `payment_date`, `particulars`, payment_line.`start_date`, payment_line.`end_date`, payment_line.`amount`, `created_by`, `names`, `house_id`, `house_no`,`floor`, `label`, `period_desc`, `billing_starts`, `billing_freq`, `time_interval_id`');
        $this->db->from('payment');
        $this->db->join('payment_line', 'payment_line.payment_id = payment.payment_id');
        $this->db->join("(SELECT `tenant`.`tenant_id`, `names`,`tenant_house`.`tenancy_id`,`start_date`, `end_date`, `house_id`, `house_no`,`floor`, `label`, `period_desc`, `billing_freq`, `billing_starts`, `time_interval_id` FROM `tenant` JOIN (SELECT `tenancy_id`, `start_date`, `end_date`, `tenant_id`, `tenancy`.`house_id`, `house_no`,`floor`, `tbl_time_interval`.`label`,`tbl_time_interval`.`description` `period_desc`, `tenancy`.`billing_starts`, `tenancy`.`billing_freq`, `tenancy`.`time_interval_id` FROM `tenancy` JOIN `house` ON `house`.`house_id`=`tenancy`.`house_id` JOIN `tbl_time_interval` ON `tbl_time_interval`.`id` = `tenancy`.`time_interval_id`) `tenant_house` ON `tenant`.`tenant_id` = `tenant_house`.`tenant_id`) `tenancy_house`", '`tenancy_house`.`tenancy_id` = `payment`.`tenancy_id`');
        $this->db->order_by('`payment`.`payment_date` ASC');

        if ($filter == FALSE) {
            $query = $this->db->get();
            return $query->result_array();
        } else {
            if (is_numeric($filter)) {
                $this->db->where('`payment`.`payment_id`', $filter);
                $query = $this->db->get();
                return $query->row_array();
            } else {
                !empty($filter) ? $this->db->where($filter) : "";
                $query = $this->db->get();
                return $query->result_array();
            }
        }
    }

    public function get_payment_line($filter = FALSE) {
        $this->db->select('`id`, `payment_id`, `start_date`, `end_date`, `amount`');
        $this->db->from('payment_line');

        if ($filter == FALSE) {
            $query = $this->db->get();
            return $query->result_array();
        } else {
            if (is_numeric($filter)) {
                $this->db->where('id', $filter);
                $query = $this->db->get();
                return $query->row_array();
            } else {
                !empty($filter) ? $this->db->where($filter) : "";
                $query = $this->db->get();
                return $query->result_array();
            }
        }
    }

    public function get_sum($filter = FALSE) {
        $this->db->select_sum('amount', 'amt_paid');
        $this->db->from('payment');

        if ($filter === FALSE) {
            
        } else {
            if (is_numeric($filter)) {
                $this->db->where('payment_id', $filter);
            } else {
                !empty($filter) ? $this->db->where($filter) : "";
            }
            $query = $this->db->get();
            return $query->row_array();
        }

        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_by_tenant_id($tenant_id) {
        $this->db->select('`payment_id`, `payment`.`tenancy_id`, `payment_date`, `particulars`, tenancy_house.`tenant_id`, tenancy_house.`start_date`, tenancy_house.`end_date`, TIMESTAMPDIFF(MONTH, tenancy_house.`start_date`, tenancy_house.`end_date`) `no_of_months`, `amount`, `account`.`acc_id`, `bank_name`, `acc_no`, `names`, `house_id`, `house_no`,`floor`');
        $this->db->from('payment');
        $this->db->join('account', 'account.acc_id = payment.account_id', 'left');
        $this->db->join("(SELECT `tenant`.`tenant_id`, `names`,`tenant_house`.`tenancy_id`,`start_date`, `end_date`, `house_id`, `house_no`,`floor` FROM `tenant` JOIN (SELECT `tenancy_id`, `tenant_id`, `start_date`, `end_date`, `tenancy`.`house_id`, `house_no`, `floor` FROM `tenancy` JOIN `house` ON `house`.`house_id`=`tenancy`.`house_id`) `tenant_house` ON `tenant`.`tenant_id`=`tenant_house`.`tenant_id` WHERE `tenant`.`tenant_id` = $tenant_id) `tenancy_house`", "`tenancy_house`.`tenancy_id` = `payment`.`tenancy_id`");

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_by_tenancy_id($tenancy_id) {
        $this->db->select('`payment_id`, `payment`.`tenancy_id`, `payment_date`, `particulars`,tenancy.`start_date`, tenancy.`end_date`, TIMESTAMPDIFF(MONTH, tenancy.`start_date`, tenancy.`end_date`) `no_of_months`, `amount`, tenancy.`created_by`, `account`.`acc_id`, `bank_name`, `acc_no`, `house_id`');
        $this->db->from('payment');
        $this->db->join('account', 'account.acc_id = payment.account_id', 'left');
        $this->db->join('tenancy', '`tenancy`.`tenancy_id` = `payment`.`tenancy_id`');

        $query = $this->db->where('`payment`.`tenancy_id`', $tenancy_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function set_payment() {
        $payment_date = explode('-', $this->input->post('payment_date'));

        $data = array(
            'tenancy_id' => $this->input->post('tenancy_id'),
            'payment_date' => mysql_to_unix($payment_date[2] . $payment_date[1] . $payment_date[0] . "000000"),
            'particulars' => $this->input->post('particulars'),
            'rent_rate' => $this->input->post('rent_rate'),
            'amount' => $this->input->post('amount'),
            'no_of_periods' => $this->input->post('no_of_periods'),
            'created_by' => $_SESSION['user_id'],
            'date_created' => time(),
            'modified_by' => $_SESSION['user_id']
        );
        $this->db->insert('payment', $data);
        return $this->db->insert_id();
    }

    public function set_payment_line($payment_data) {
        $this->db->insert('payment_line', $payment_data);
        return $this->db->insert_id();
    }

    public function update_payment($payment_id) {
        $payment_date = explode('-', $this->input->post('payment_date'));

        $data = array(
            'tenancy_id' => $this->input->post('tenancy_id'),
            'payment_date' => mysql_to_unix($payment_date[2] . $payment_date[1] . $payment_date[0] . "000000"),
            'account_id' => $this->input->post('account_id'),
            'particulars' => $this->input->post('particulars'),
            'rent_rate' => $this->input->post('rent_rate'),
            'amount' => $this->input->post('amount'),
            'modified_by' => $_SESSION['user_id']
        );
        $this->db->where('payment_id', $payment_id);
        return $this->db->update('payment', $data);
    }

    public function update_payment_line($payment_line_data) {

        return $this->db->replace('payment', $payment_line_data);
    }

    public function del_payment($payment_id) {
        $this->db->where('payment_id', $payment_id);
        return $this->db->delete('payment');
    }

    public function del_payment_line($payment_line_id) {
        $this->db->where('id', $payment_line_id);
        return $this->db->delete('payment_line');
    }

}
