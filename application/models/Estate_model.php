<?php

class Estate_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_estate($estate_id = FALSE) {
        $this->db->select('estate_id, estate_name, description, phone, phone2, address,'
                . 'district.district, estate.district_id, time_interval_id, billing_freq, period_starts, full_payment');
        $this->db->from('estate');
        $this->db->join('district', 'district.district_id = estate.district_id');

        if ($estate_id === FALSE) {
            $query = $this->db->get();
            return $query->result_array();
        }

        $this->db->where('estate_id', $estate_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function set_estate() {

        $data = array(
            'estate_name' => $this->input->post('estate_name'),
            'description' => $this->input->post('description'),
            'address' => $this->input->post('address'),
            'phone' => $this->input->post('phone'),
            'phone2' => $this->input->post('phone2'),
            'district_id' => $this->input->post('district'),
            'time_interval_id' => $this->input->post('time_interval_id'),
            'billing_freq' => $this->input->post('billing_freq'),
            'period_starts' => $this->input->post('period_starts'),
            'full_payment' => 1,
            'created_by' => $_SESSION['user_id'],
            'date_created' => time(),
            'modified_by' => $_SESSION['user_id']
        );
        return $this->db->insert('estate', $data);
    }

    public function update_estate($estate_id) {

        $data = array(
            'estate_name' => $this->input->post('estate_name'),
            'description' => $this->input->post('description'),
            'address' => $this->input->post('address'),
            'phone' => $this->input->post('phone'),
            'phone2' => $this->input->post('phone2'),
            'district_id' => $this->input->post('district'),
            'time_interval_id' => $this->input->post('time_interval_id'),
            'billing_freq' => $this->input->post('billing_freq'),
            'period_starts' => $this->input->post('period_starts'),
            //'full_payment' => $this->input->post('full_payment'),
            'modified_by' => $_SESSION['user_id']
        );
        $this->db->where('estate_id', $estate_id);
        return $this->db->update('estate', $data);
    }

    public function del_estate($estate_id) {
        $this->db->where('estate_id', $estate_id);
        return $this->db->delete('estate');
    }

}
