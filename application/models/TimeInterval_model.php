<?php

/**
 * Description of TimeInterval_model
 *
 * @author Allan Jes
 * This class models the operations necessary for the addition, modification,
 * deletion and retrieval of various time intervals.
 * 
 */
class TimeInterval_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }
    public function get_time_interval($filter = FALSE) {
        $this->db->from('tbl_time_interval');

        if ($filter === FALSE) {
            $query = $this->db->get();
            return $query->result_array();
        } else {
            if (is_numeric($filter)) {
                $this->db->where('`id`', $filter);
                $query = $this->db->get();
                return $query->row_array();
            } else {
                !empty($filter) ? $this->db->where($filter) : "";
                $query = $this->db->get();
                return $query->result_array();
            }
        }
    }
}
