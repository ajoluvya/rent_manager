<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

    protected $CI;

    function __construct() {
        parent::__construct();
        $this->CI = & get_instance();
    }

    public function datetime($date) {
        $date_values = explode('-', $date);
        if ((sizeof($date_values) != 3) || !checkdate((int) $date_values[1], (int) $date_values[0], (int) $date_values[2])) {
            return FALSE;
        }

        return TRUE;
    }

    /* public function datetime($str)
      {
      $date_time = explode(' ',$str);
      if(sizeof($date_time)==2)
      {
      $date = $date_time[0];
      $date_values = explode('-',$date);
      if((sizeof($date_values)!=3) || !checkdate( (int) $date_values[1], (int) $date_values[2], (int) $date_values[0]))
      {
      return FALSE;
      }
      $time = $date_time[1];
      $time_values = explode(':',$time);
      if((int) $time_values[0]>23 || (int) $time_values[1]>59 || (int) $time_values[2]>59)
      {
      return FALSE;
      }
      return TRUE;
      }
      return FALSE;
      } */

    public function valid_date($date, $format = 'dd-mm-yyyy') {
        $d = DateTime::createFromFormat($format, $date);
        if ($d && $d->format($format) == $date) {
            return true;
        }
        //else
        //{
        //$this->set_message('valid_date', 'The {field} field must have a DATE (dd-mm-yyyy) format.');
        return false;
        //}
    }

    public function valid_user($pass, $user_id) {
        return isset($this->CI->db) ? ($this->CI->db->limit(1)->get_where('users', array('id' => $user_id, 'password' => md5($pass)))->num_rows() > 0) : FALSE;
    }

}
