<?php

class Tenancy_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_tenancy($filter = FALSE) {
        $this->db->select('`tenancy_id`, `tenancy`.`tenant_id`, `tenancy`.`house_id`, `tenancy`.`start_date`,'
                . '`tenancy`.`end_date`, `tenancy`.`rent_rate`, `tenancy`.`time_interval_id`,`tenancy`.`billing_freq`, `status`, `exit_date`,'
                . '`tenancy`.`billing_starts`,`house_no`,`floor`,`estate_id`, `estate_name`, `tenant`.`names`, `phone1`, `phone2`,'
                . '`passport_photo`,`tbl_time_interval`.`label`,`tbl_time_interval`.`description` `period_desc`,`tbl_time_interval`.`adjective`');
        $this->db->from('tenancy');
        $this->db->join('tbl_time_interval', 'time_interval_id = tbl_time_interval.id');
        $this->db->join('tenant', 'tenant.tenant_id = tenancy.tenant_id');
        $this->db->join('(SELECT `house_id`,`house_no`,`floor`,`estate_name`, `house`.`estate_id` FROM `house` JOIN `estate` ON `house`.`estate_id`=`estate`.`estate_id`) `estate_house`', '`estate_house`.`house_id` = `tenancy`.`house_id`');

        if ($filter === FALSE) {
            $query = $this->db->get();
            return $query->result_array();
        } else {
            if (is_numeric($filter)) {
                $this->db->where('`tenancy_id`', $filter);
                $query = $this->db->get();
                return $query->row_array();
            } else {
                !empty($filter) ? $this->db->where($filter) : "";
                $query = $this->db->get();
                return $query->result_array();
            }
        }
    }

    public function get_tenancy_count($filter = FALSE) {
        $this->db->select('COUNT(`tenancy_id`) `count` ');
        $this->db->from('tenancy');
        //$this->db->where('`status`',1);

        if ($filter === FALSE) {
            
        } else {
            if (is_numeric($filter)) {
                $this->db->where('`tenancy_id`', $filter);
            } else {
                !empty($filter) ? $this->db->where($filter) : "";
            }
        }
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_tenancy_default($filter = FALSE) {
        $this->db->select('`rent_rate`, `end_date`, `exit_date`, `billing_freq`, `status`,`tbl_time_interval`.`label`');
        $this->db->from('tenancy');
        $this->db->join('tbl_time_interval', 'time_interval_id = tbl_time_interval.id');

        if ($filter === FALSE) {
            
        } else {
            if (is_numeric($filter)) {
                $this->db->where('`tenancy_id`', $filter);
                $query = $this->db->get();
                return $query->row_array();
            } else {
                !empty($filter) ? $this->db->where($filter) : "";
            }
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_by_tenant_id($tenant_id = FALSE) {
        $this->db->select('tenancy_id, tenancy.tenant_id, tenancy.house_id, `tenancy`.`time_interval_id`, tenancy.start_date, tenancy.rent_rate,`tenancy`.`billing_freq`, `tenancy`.`billing_starts`, house.house_no, house.estate_id, tenant.home_address, tenant.names, phone1, phone2');
        $this->db->from('tenancy');
        $this->db->join('tenant', 'tenant.tenant_id = tenancy.tenant_id');
        $this->db->join('house', 'house.house_id = tenancy.house_id');
        //$query = $this->db->get_where('tenancy', array('tenant_id' => $tenant_id));

        if ($tenant_id === FALSE) {
            $query = $this->db->get();
            return $query->result_array();
        }

        $this->db->where('tenancy.tenant_id', $tenant_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function set_tenancy() {
        /* $date_array = explode('-', $this->input->post('end_date'));
          $end_date = ($this->input->post('end_date') != NULL) ? mysql_to_unix($date_array[2] . $date_array[1] . $date_array[0] . "235959") : 0; */

        $date_array = explode('-', $this->input->post('start_date'));
        $start_date = ($this->input->post('start_date') != NULL) ? mysql_to_unix($date_array[2] . $date_array[1] . $date_array[0] . "000000") : 0;

        $data = array(
            'tenant_id' => $this->input->post('tenant_id'),
            'house_id' => $this->input->post('house_id'),
            'start_date' => $start_date,
            'end_date' => $start_date,
            'rent_rate' => $this->input->post('rent_rate'),
            'time_interval_id' => $this->input->post('time_interval_id'),
            'billing_freq' => $this->input->post('billing_freq'),
            'full_payment' => $this->input->post('full_payment'),
            'billing_starts' => $this->input->post('billing_starts'),
            'created_by' => $_SESSION['user_id'],
            'date_created' => time(),
            'modified_by' => $_SESSION['user_id']
        );
        $this->db->insert('tenancy', $data);
        return $this->db->insert_id();
    }

    public function update_tenancy($tenancy_id) {
        $date_array = explode('-', $this->input->post('start_date'));
        $hour_min = $this->input->post('hour_select') . $this->input->post('min_select');
        $start_date = ($this->input->post('start_date') != NULL) ? mysql_to_unix($date_array[2] . $date_array[1] . $date_array[0] . (($hour_min ? $hour_min : "0000") . "00")) : 0;

        $data = array(
            'tenant_id' => $this->input->post('tenant_id'),
            'house_id' => $this->input->post('house_id'),
            'start_date' => $start_date,
            'end_date' => $start_date,
            //'end_date' => $start_date,
            'rent_rate' => $this->input->post('rent_rate'),
            'time_interval_id' => $this->input->post('time_interval_id'),
            'billing_freq' => $this->input->post('billing_freq'),
            'full_payment' => $this->input->post('full_payment'),
            'billing_starts' => $this->input->post('billing_starts'),
            'modified_by' => $_SESSION['user_id']
        );
        $this->db->where('tenancy_id', $tenancy_id);
        return $this->db->update('tenancy', $data);
    }

    public function update_tenancy_end_date($end_date_time) {

        $data = array(
            'end_date' => $end_date_time,
            'exit_date' => $end_date_time
        );
        $this->db->where('tenancy_id', $this->input->post('tenancy_id'));
        return $this->db->update('tenancy', $data);
    }

    public function del_tenancy($tenancy_id) {
        $this->db->where('tenancy_id', $tenancy_id);
        return $this->db->delete('tenancy');
    }

    public function change_status() {

        $data = array(
            'status' => $this->input->post('status'),
            'exit_date' => time(),
            'modified_by' => $_SESSION['user_id']
        );

        $this->db->where('tenancy_id', $this->input->post('tenancy_id'));
        return $this->db->update('tenancy', $data);
    }

}
