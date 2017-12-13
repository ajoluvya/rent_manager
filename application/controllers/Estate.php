<?php

class Estate extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //if user not logged in, take them back to the login page
        if (!isset($_SESSION['user_id'])) {
            redirect('user/login');
        }
        $this->load->model('estate_model');
        $this->load->model('district_model');
        $this->floors = array('Ground', 'First', 'Second', 'Third', 'Fourth', 'Fifth');
    }

    public function index() {
        $this->load->library('pagination');

        $data['title'] = 'Estates';
        $data['sub_title'] = 'List of estates';
        $data['estates'] = $this->estate_model->get_estate();


        $config['base_url'] = 'rent_manager/estate/';
        $config['total_rows'] = count($data['estates']);

        $data['pag_links'] = $this->pagination->create_links();

        $this->load->view('templates/header', $data);
        $this->load->view('estates/index', $data);
        $this->load->view('templates/footer');
    }

    public function view($estate_id = NULL) {
        $this->load->helper('form');
        $data['estate'] = $this->estate_model->get_estate($estate_id);
        $data['title'] = 'Estate';

        if (empty($data['estate'])) {
            $data['sub_title'] = 'No data';
            $data['message'] = 'The estate record was not found';
            //show_404();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/404', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->model('tenant_model');
            $this->load->model('house_model');
            $this->load->model('payment_model');
            $this->load->model('timeInterval_model');

            $data['sub_title'] = $data['estate']['estate_name'];

            $data['estate_tenants'] = $this->tenant_model->get_tenant("`estate_id`=" . $estate_id);
            $data['estate_houses'] = $this->house_model->get_house("`estate`.`estate_id`=" . $estate_id);
            $data['payments'] = $this->payment_model->get_payment("`house_id` IN (SELECT `house_id` FROM `house` WHERE `estate_id` = $estate_id)");
            $data['floors'] = $this->floors;
            $data['time_intervals'] = $this->timeInterval_model->get_time_interval();

            $data['create_modal'] = $this->load->view('houses/create_modal', $data, TRUE);
            $this->load->view('templates/header', $data);
            $this->load->view('estates/view', $data);
            $this->load->view('templates/footer');
        }
    }

    public function create() {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('timeInterval_model');

        $data['title'] = "Estate";
        $data['sub_title'] = "Capture estate data";
        $data['districts'] = $this->district_model->get_district();

        $this->form_validation->set_rules('estate_name', 'Estate name', 'required|max_length[50]', array('required' => '%s is missing.', 'max_length' => '% must be less than 50 charaters'));
        $this->form_validation->set_rules('description', 'Description', 'required|max_length[100]', array('required' => '%s is missing.', 'max_length' => '% must be less than 100 letters'));
        $this->form_validation->set_rules('phone', 'Phone number', 'required|numeric|exact_length[10]', array('required' => '%s is missing.', 'exact_length' => '% must be exactly 10 digits', 'exact_length' => '% must be exactly 10 digits'));
        $this->form_validation->set_rules('phone2', 'Phone number2', 'exact_length[10]|numeric', array('numeric' => '%s must be a number.', 'exact_length' => '% must be exactly 10 digits'));
        $this->form_validation->set_rules('address', 'Address', 'required|max_length[100]', array('required' => '%s is missing.', 'max_length' => '% must be less than 100 letters'));
        $this->form_validation->set_rules('district', 'District', 'required', array('required' => '%s was not selected.'));

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('estates/create', $data);
            $this->load->view('templates/footer');
        } else {
            $data['message'] = 'Estate details were successfully submitted to the database.';
            $this->estate_model->set_estate();
            $this->load->view('templates/header', $data);
            $this->load->view('estates/success', $data);
            $this->load->view('templates/footer');
        }
    }

    public function update($estate_id = NULL) {
        //if user not admin or boss, redirect them to the index
        if (isset($_SESSION['role']) && $_SESSION['role'] < 3) {
            $this->index();
            return;
        }
        if ($estate_id != NULL) {
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->model('timeInterval_model');

            $data['title'] = 'Estate';
            $data['sub_title'] = 'Update estate details';
            $data['btn_text'] = 'Update';

            $data['estate'] = $this->estate_model->get_estate($estate_id);
            $data['districts'] = $this->district_model->get_district();
            $data['time_intervals'] = $this->timeInterval_model->get_time_interval();

            $this->form_validation->set_rules('estate_name', 'Estate name', 'required|max_length[50]', array('required' => '%s is missing.', 'max_length' => '% must be less than 50 charaters'));
            $this->form_validation->set_rules('description', 'Description', 'required|max_length[100]', array('required' => '%s is missing.', 'max_length' => '% must be less than 100 letters'));
            $this->form_validation->set_rules('phone', 'Phone number', 'required|numeric|exact_length[10]', array('required' => '%s is missing.', 'exact_length' => '% must be exactly 10 digits', 'exact_length' => '% must be exactly 10 digits'));
            $this->form_validation->set_rules('phone2', 'Phone number2', 'exact_length[10]|numeric', array('numeric' => '%s must be a number.', 'exact_length' => '% must be exactly 10 digits'));
            $this->form_validation->set_rules('address', 'Address', 'required|max_length[100]', array('required' => '%s is missing.', 'max_length' => '% must be less than 100 letters'));
            $this->form_validation->set_rules('district', 'District', 'required', array('required' => '%s was not selected.'));

            if ($this->form_validation->run() === FALSE) {
                $this->load->view('templates/header', $data);
                $this->load->view('estates/create', $data);
                $this->load->view('templates/footer');
            } else {
                $this->estate_model->update_estate($estate_id);

                $data['message'] = 'Estate details successfully updated';

                $this->load->view('templates/header', $data);
                $this->load->view('estates/success', $data);
                $this->load->view('templates/footer');
            }
        } else {
            $this->index();
        }
    }

    public function del_estate($estate_id = NULL) {
        //if user not admin or boss, redirect them to the index
        if (isset($_SESSION['role']) && $_SESSION['role'] < 3) {
            $this->index();
            return;
        }
        if ($estate_id != NULL) {
            $this->estate_model->del_estate($estate_id);
            $data['title'] = 'Estate deleted';
            $data['sub_title'] = 'Estate deleted';

            $data['message'] = 'Estate successfully deleted';

            $this->load->view('templates/header', $data);
            $this->load->view('estates/success', $data);
            $this->load->view('templates/footer');
        } else {
            $data['title'] = 'Error';
            $data['sub_title'] = 'Error deleting';
            $data['message'] = 'Invalid operation, the item was not deleted';

            $this->load->view('templates/header', $data);
            $this->load->view('estates/404', $data);
            $this->load->view('templates/footer');
        }
    }

}
