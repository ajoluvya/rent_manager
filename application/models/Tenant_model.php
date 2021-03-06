<?php

class Tenant_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    /*SELECT `tenant`.`tenant_id`, `names`, `phone1`, `phone2`, `home_address`,`label`, `billing_starts`, `period_desc`, `district`, `tenant`.`district_id`, `tenant`.`date_created`, `passport_photo`, `id_card_no`, `id_card_url`, `tenancy_id`, `status`, `house_id`, `start_date`, `end_date`,`exit_date`, `rent_rate`, `house_no`,`floor`,`estate_name`, `estate_id`, `status`,`billing_freq`,`time_interval_id` FROM `tenant` LEFT JOIN (SELECT `tenancy`.`tenancy_id`, `tenant_id`, `tenancy`.`house_id`,`start_date`,`end_date`,`rent_rate`, `house_no`, `time_interval_id`, `estate_id`, `floor`, `estate_name`, `status`, `tenancy`.`billing_freq`, `tenancy`.`billing_starts`, `exit_date`, `tbl_time_interval`.`label`,`tbl_time_interval`.`description` `period_desc` FROM `tenancy` JOIN `tbl_time_interval` ON `tbl_time_interval`.`id` = `tenancy`.`time_interval_id` JOIN (SELECT `house_id`,`house_no`,`floor`,`estate_name`, `house`.`estate_id` FROM `house` JOIN `estate` ON `house`.`estate_id`=`estate`.`estate_id`) `estate_house` ON `tenancy`.`house_id` = `estate_house`.`house_id`) `tenant_house` ON `tenant`.`tenant_id` = `tenant_house`.`tenant_id` LEFT JOIN `district` ON tenant.district_id = district.district_id*/
    
    public function get_tenant($filter = FALSE) {
        $this->db->select('`tenant`.`tenant_id`, `names`, `phone1`, `phone2`, `home_address`,`label`, `billing_starts`,'
                . '`period_desc`, `district`, `tenant`.`district_id`, `tenant`.`date_created`, `passport_photo`,`tenant`.`date_created`'
                . ' `id_card_no`, `id_card_url`, `tenancy_id`, `status`, `house_id`, `start_date`, `end_date`,`exit_date`, '
                . '`rent_rate`, `house_no`,`floor`,`estate_name`, `estate_id`, `status`,`billing_freq`,`time_interval_id`');
        $this->db->from('tenant');
        $this->db->join('(SELECT `tenancy`.`tenancy_id`, `tenant_id`, `tenancy`.`house_id`,`start_date`,`end_date`,`rent_rate`, `house_no`, '
                . '`time_interval_id`, `estate_id`, `floor`, `estate_name`, `status`, `tenancy`.`billing_freq`, `tenancy`.`billing_starts`, '
                . '`exit_date`, `tbl_time_interval`.`label`,`tbl_time_interval`.`description` `period_desc` FROM `tenancy`'
                . ' JOIN `tbl_time_interval` ON `tbl_time_interval`.`id` = `tenancy`.`time_interval_id`'
                . ' JOIN (SELECT `house_id`,`house_no`,`floor`,`estate_name`, `house`.`estate_id`'
                . ' FROM `house` JOIN `estate` ON `house`.`estate_id`=`estate`.`estate_id`) `estate_house`'
                . ' ON `tenancy`.`house_id` = `estate_house`.`house_id`) `tenant_house`',
                '`tenant`.`tenant_id` = `tenant_house`.`tenant_id`', 'left');
        $this->db->join('district', 'tenant.district_id = district.district_id', 'left');

        if ($filter === FALSE) {
            $query = $this->db->get();
            return $query->result_array();
        } else {
            if (is_numeric($filter)) {
                $this->db->where('`tenant`.`tenant_id`', $filter);
                $query = $this->db->get();
                return $query->row_array();
            } else {
                !empty($filter) ? $this->db->where($filter) : "";
                $query = $this->db->get();
                return $query->result_array();
            }
        }
    }

    public function set_tenant($data) {
        //we'll append to the photo_urls, the other data from the forms
        $data['names'] = $this->input->post('names');
        $data['phone1'] = $this->input->post('phone1');
        $data['phone2'] = $this->input->post('phone2');
        $data['id_card_no'] = $this->input->post('id_card_no');
        $data['home_address'] = $this->input->post('home_address');
        $data['district_id'] = $this->input->post('district_id');
        $data['created_by'] = $_SESSION['user_id'];
        $data['date_created'] = time();
        $data['modified_by'] = $_SESSION['user_id'];
        
        $this->db->insert('tenant', $data);
        return $this->db->insert_id();
    }

    public function update_tenant($tenant_id, $data) {
        //we'll append to the photo_urls, the other data from the forms
        $data['names'] = $this->input->post('names');
        $data['phone1'] = $this->input->post('phone1');
        $data['phone2'] = $this->input->post('phone2');
        $data['id_card_no'] = $this->input->post('id_card_no');
        $data['home_address'] = $this->input->post('home_address');
        $data['district_id'] = $this->input->post('district_id');
        $data['modified_by'] = $_SESSION['user_id'];
        
        $this->db->where('tenant_id', $tenant_id);
        return $this->db->update('tenant', $data);
    }

    public function deactivate_tenant($tenant_id) {
        $data = array(
            'status' => 0,
            'modified_by' => $_SESSION['user_id']
        );
        $this->db->where('tenant_id', $tenant_id);
        return $this->db->update('tenant', $data);
    }

    public function del_tenant($tenant_id) {
        $this->db->where('tenant_id', $tenant_id);
        return $this->db->delete('tenant');
    }

}
