<?php
class Event extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('bill_model');
        }
		
		public function set()
		{
			$this->bill_model->set_auto_bill();
		}
}