<?php
class Event_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }
		
	public function set_bill_event()
	{

		$sql = "INSERT INTO `bill`(tenancy_id, `tenant_id`, `house_no`, `bill_date`, `amount`)
		SELECT `tenancy_id`, `tenant_id`, `house_no`, CURDATE(), `rent_rate` 
		FROM `tenancy`
		JOIN `house` ON `tenancy`.`house_id` = `house`.`house_id`
		WHERE `end_date` <> NULL
		AND (FROM_UNIXTIME(`start_date`, '%e') = DAY(CURDATE())
			OR (FROM_UNIXTIME(`start_date`, '%e') = 29
				AND FROM_UNIXTIME(`start_date`, '%m') = 2
				AND DAY(CURDATE())=28
				)
			)";
		
		return $this->db->query($sql);
	}
}