<?php

class House_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_house($filter = FALSE) {
        //$query = $this->db->get_where('house', array('house_id' => $house_id));
        $this->db->select('house_id, house_no, house.description, fixed_amount, floor, house.time_interval_id,'
                . 'house.billing_freq, house.period_starts, max_tenants, estate.estate_name, estate.address,'
                . 'estate.phone, estate.phone2, house.estate_id');
        $this->db->from('house');
        $this->db->join('estate', 'estate.estate_id = house.estate_id');

        if ($filter === FALSE) {
            $query = $this->db->get();
            return $query->result_array();
        } else {
            if (is_numeric($filter)) {
                $this->db->where('house_id', $filter);
                $query = $this->db->get();
                return $query->row_array();
            } else {
                !empty($filter) ? $this->db->where($filter) : "";
                $query = $this->db->get();
                return $query->result_array();
            }
        }
    }

    public function get_house_tenants($house_id) {
        $this->db->select('`tenant`.`tenant_id`, `names`, `phone1`, `phone2`, `home_address`, `district`, `tenant`.`district_id`, `tenancy_id`, `house_id`, `rent_rate`,, `start_date`,`end_date`');
        $this->db->from('tenant');
        $this->db->join("(SELECT `tenancy_id`, `tenant_id`, `tenancy`.`house_id`, `start_date`,`end_date`,`rent_rate`, `house_no`, `estate_id`,`floor`,`estate_name` FROM `tenancy` JOIN (SELECT `house_id`,`house_no`,`floor`,`estate_name`, `house`.`estate_id` FROM `house` JOIN `estate` ON `house`.`estate_id`=`estate`.`estate_id`) `estate_house` ON `tenancy`.`house_id` = `estate_house`.`house_id` WHERE `tenancy`.`house_id` = $house_id) `tenant_house`", "`tenant_house`.`tenant_id` = `tenant`.`tenant_id`");
        $this->db->join('district', 'district.district_id = tenant.district_id');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function set_house() {

        $data = array(
            'house_no' => $this->input->post('house_no'),
            'floor' => $this->input->post('floor'),
            'description' => $this->input->post('description'),
            'estate_id' => $this->input->post('estate_id'),
            'fixed_amount' => $this->input->post('fixed_amount'),
            'time_interval_id' => $this->input->post('time_interval_id'),
            'billing_freq' => $this->input->post('billing_freq'),
            'max_tenants' => $this->input->post('max_tenants'),
            'full_payment' => $this->input->post('full_payment'),
            'period_starts' => $this->input->post('period_starts'),
            'created_by' => $_SESSION['user_id'],
            'date_created' => time(),
            'modified_by' => $_SESSION['user_id']
        );
        $this->db->insert('house', $data);
        return $this->db->insert_id();
    }

    public function update_house($house_id) {

        $data = array(
            'house_no' => $this->input->post('house_no'),
            'description' => $this->input->post('description'),
            'floor' => $this->input->post('floor'),
            'estate_id' => $this->input->post('estate_id'),
            'fixed_amount' => $this->input->post('fixed_amount'),
            'time_interval_id' => $this->input->post('time_interval_id'),
            'billing_freq' => $this->input->post('billing_freq'),
            'max_tenants' => $this->input->post('max_tenants'),
            'full_payment' => $this->input->post('full_payment'),
            'period_starts' => $this->input->post('period_starts'),
            'modified_by' => $_SESSION['user_id']
        );
        $this->db->where('house_id', $house_id);
        return $this->db->update('house', $data);
    }

    public function del_house($house_id) {
        $this->db->where('house_id', $house_id);
        return $this->db->delete('house');
    }

}
