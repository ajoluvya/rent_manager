<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Dashboard
 *
 * @author Allan Jes
 */
class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        //if user not logged in, take them back to the login page
        if (!isset($_SESSION['user_id'])) {
            redirect('user/login');
        }
        $this->load->model('dashboard_model');
    }

    public function index() {
        $this->load->model('payment_model');
        $this->load->model('tenancy_model');
        $this->load->model('house_model');

        $data['title'] = 'Dashboard';
        $data['sub_title'] = 'Dashboard';
        $data['summaries']['payments']['total'] = $this->payment_model->get_sum();
        $data['summaries']['tenancy']['current'] = $this->tenancy_model->get_tenancy_count("`status` = 1");
        $data['summaries']['tenancy']['un_occupied_rooms'] = $this->house_model->get_house_count("`house_id` NOT IN (SELECT `house_id` FROM `tenancy` WHERE `status` = 1 AND (UNIX_TIMESTAMP() BETWEEN `start_date` AND `end_date`))");
        $data['summaries']['tenancy']['total'] = $this->house_model->get_house_count();
        $data['summaries']['tenancy']['max_tenancies'] = $this->house_model->get_possible_tenancy_count();

        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/index');
        $this->load->view('templates/footer');
    }

    public function dashboard_json_data() {
        $this->load->model('payment_model');
        $this->load->model('tenancy_model');
        $this->load->model('house_model');
        $where = $where2 = $where3 = "";
        if ($this->input->post('start_date') != "" && $this->input->post('end_date') != "") {

            $where .= "(`payment_date` BETWEEN " . $this->input->post('start_date') . " AND " . $this->input->post('end_date') . ")";
        }

        $data['summaries']['payments']['total'] = $this->payment_model->get_sum();
        $data['summaries']['tenancy']['current'] = $this->tenancy_model->get_tenancy_count("`status` = 1");
        $data['summaries']['tenancy']['un_occupied_rooms'] = $this->house_model->get_house_count("`house_id` NOT IN (SELECT `house_id` FROM `tenancy` WHERE `status` = 1 AND (UNIX_TIMESTAMP() BETWEEN `start_date` AND `end_date`))");
        $data['summaries']['tenancy']['total'] = $this->house_model->get_house_count();
        $data['summaries']['tenancy']['max_tenancies'] = $this->house_model->get_possible_tenancy_count();
        
        echo json_encode($data);
    }
    
}
