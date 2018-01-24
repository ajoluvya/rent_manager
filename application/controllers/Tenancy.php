<?php

class Tenancy extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //if user not logged in, take them back to the login page
        if (!isset($_SESSION['user_id'])) {
            redirect('user/login');
        }
        $this->load->model('tenancy_model');
        $this->load->model('tenant_model');
        $this->load->model('payment_model');
        $this->load->model('bill_model');
        $this->load->model('house_model');
        $this->load->model('estate_model');
    }

    public function index() {
        $this->load->helper('form');
        $this->load->library('pagination');

        $where = "";
        if ($this->input->post('start') != "" || ($this->input->post('period') != "" && is_numeric($this->input->post('period')))) {

            $start = ($this->input->post('start') != "") ? mysql_to_unix(substr($this->input->post('start'), -4, 4) . substr($this->input->post('start'), 3, 2) . substr($this->input->post('start'), 0, 2) . "235959") : (($this->input->post('period') != "") ? (time() - (86400 * $this->input->post('period'))) : (time() - 2592000));

            $end = ($this->input->post('end') != "") ? mysql_to_unix(substr($this->input->post('end'), -4, 4) . substr($this->input->post('end'), 3, 2) . substr($this->input->post('end'), 0, 2) . "235959") : time();

            $where = "(start_date BETWEEN $start AND $end)";
        }

        $where_status = ((strlen($where) > 1) ? " AND" : "") . " end_date = 0";
        if ($this->input->post('status') != "" && is_numeric($this->input->post('status'))) {
            if ($this->input->post('status') == 2) {
                $where_status = ((strlen($where) > 1) ? " AND" : "") . " end_date > 0";
            }
            if ($this->input->post('status') == 3) {
                $where_status = "";
            }
        }
        $where .= $where_status;

        if ($this->input->post('search') != "") {
            $where .= ((strlen($where) > 1) ? " AND" : "") . " names LIKE '%{$this->input->post('search')}%'";
        }

        $data['tenancies'] = $this->tenancy_model->get_tenancy($where);

        $data['title'] = 'Tenancies';
        $data['sub_title'] = 'List of tenants';
        $config['base_url'] = 'tenancy/';
        $config['total_rows'] = count($data['tenancies']);

        $data['pag_links'] = $this->pagination->create_links();


        $this->load->view('templates/header', $data);
        $this->load->view('tenancy/index', $data);
        $this->load->view('templates/footer');
    }

    public function view($tenancy_id = NULL) {
        $data['tenancy'] = $this->tenancy_model->get_tenancy($tenancy_id);
        $data['title'] = 'Tenancy';

        if (empty($data['tenancy'])) {
            $data['sub_title'] = 'No data';
            $data['message'] = 'The tenancy record was not found';
            //show_404();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/404', $data);
            $this->load->view('templates/footer');
        } else {
            $data['sub_title'] = $data['tenancy']['names'];
            $data['payments'] = $this->payment_model->get_by_tenancy_id($tenancy_id);

            $this->load->view('templates/header', $data);
            $this->load->view('tenancy/view', $data);
            $this->load->view('templates/footer');
        }
    }

    public function view_by_tenant_id($tenant_id) {
        $data['tenancy'] = $this->tenancy_model->get_by_tenant_id($tenant_id);
        $data['title'] = 'Tenancy';

        if (empty($data['tenancy'])) {
            $data['sub_title'] = 'No data';
            $data['message'] = 'The tenant record was not found';
            //show_404();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/404', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->library('pagination');


            $config['base_url'] = 'tenancy/';
            $config['total_rows'] = count($data['tenancy']);

            $data['pag_links'] = $this->pagination->create_links();

            $data['sub_title'] = $data['tenant']['names'];

            $this->load->view('templates/header', $data);
            $this->load->view('tenants/view', $data);
            $this->load->view('templates/footer');
        }
    }

    public function create($tenant_id = NULL) {
        //the $tenant_id above could prove useful in circumstances when the registration was initiated but room assignment was incomplete
        $this->load->helper('form');
        $this->load->library('form_validation');

        if ($tenant_id !== NULL) {
            $data['tenant_id'] = $tenant_id;
            $data['tenant'] = $this->tenant_model->get_tenant($tenant_id);
        }
        $data['title'] = "Tenancy";
        $data['sub_title'] = "Assign apartment/house/room";
        $data['houses'] = $this->house_model->get_house("`house_id` NOT IN (SELECT `house_id` FROM `tenancy` WHERE `status` = 1)");
        $data['estates'] = $this->estate_model->get_estate();
        $data['step_text'] = TRUE;

        $this->form_validation->set_rules('tenant_id', 'Tenant', 'required', array('required' => '%s is missing.'));
        $this->form_validation->set_rules('house_id', 'House', 'required', array('required' => '%s has not been selected.'));
        $this->form_validation->set_rules('start_date', 'Start date', 'required|valid_date[d-m-Y]', array('required' => '%s is missing.', 'datetime' => '%s is invalid, required date format is dd-mm-yyyy.'));
        $this->form_validation->set_rules('end_date', 'End date', 'valid_date[d-m-Y]', array('valid_date' => '%s is invalid, required date format is dd-mm-yyyy.'));
        $this->form_validation->set_rules('rent_rate', 'Amount', 'required|numeric', array('required' => '%s is missing.', 'numeric' => '%s must be a number.'));
        if($this->input->post('time_interval_id')<3){
            $this->form_validation->set_rules('hour_select', 'hour', 'required', array('required' => 'Please select %s.'));
            $this->form_validation->set_rules('min_select', 'minute', 'required', array('required' => 'Please select %s.'));
            $this->form_validation->set_rules('ampm_select', 'AM/PM', 'required', array('required' => 'Please select %s.'));
        }
        if ($this->form_validation->run() === FALSE) {
            $this->load->model('timeInterval_model');
            $data['time_intervals'] = $this->timeInterval_model->get_time_interval();
            $this->load->view('templates/header', $data);
            $this->load->view('tenancy/create', $data);
            $this->load->view('templates/footer');
        } else {
            $tenancy_id = $this->tenancy_model->set_tenancy();
            redirect("/payment/create/" . $tenancy_id);
        }
    }

    public function update($tenancy_id = NULL) {
        //if user not admin or boss, redirect them to the index
        if (isset($_SESSION['role']) && $_SESSION['role'] < 3) {
            $this->index();
            return;
        }
        if ($tenancy_id != NULL) {
            $this->load->helper('form');
            $this->load->library('form_validation');

            $data['title'] = 'Tenancy';
            $data['sub_title'] = 'Update apartment/house/room details';
            $data['btn_text'] = 'Update';

            $data['tenancy'] = $this->tenancy_model->get_tenancy($tenancy_id);
            $data['tenant_id'] = $data['tenancy']['tenant_id'];
            $data['houses'] = $this->house_model->get_house("`house_id` NOT IN (SELECT `house_id` FROM `tenancy` WHERE `end_date` > UNIX_TIMESTAMP())");
            $data['estates'] = $this->estate_model->get_estate();

            $this->form_validation->set_rules('tenant_id', 'Tenant', 'required', array('required' => '%s is missing.'));
            $this->form_validation->set_rules('house_id', 'House', 'required', array('required' => '%s has not been selected.'));
            $this->form_validation->set_rules('start_date', 'Start date', 'required|datetime', array('required' => '%s is missing.', 'datetime' => '%s is invalid, required date format is dd-mm-yyyy.'));
            $this->form_validation->set_rules('end_date', 'End date', 'datetime', array('datetime' => '%s is invalid, required date format is dd-mm-yyyy.'));
            $this->form_validation->set_rules('rent_rate', 'Amount', 'required|numeric', array('required' => '%s is missing.'));

            if ($this->form_validation->run() === FALSE) {
                $this->load->model('timeInterval_model');
                $data['time_intervals'] = $this->timeInterval_model->get_time_interval();
                $this->load->view('templates/header', $data);
                $this->load->view('tenancy/create', $data);
                $this->load->view('templates/footer');
            } else {
                $this->tenancy_model->update_tenancy($tenancy_id);

                $data['message'] = 'Tenancy details successfully updated';
                redirect("tenant/view/" . $data['tenancy']['tenant_id']);
                /* $this->load->view('templates/header', $data);
                  $this->load->view('tenancy/success', $data);
                  $this->load->view('templates/footer'); */
            }
        } else {
            $this->index();
        }
    }

    public function del_tenancy($tenancy_id = NULL) {
        //if user not admin or boss, redirect them to the index
        if (isset($_SESSION['role']) && $_SESSION['role'] < 3) {
            $this->index();
            return;
        }
        if ($tenancy_id != NULL) {
            $this->tenancy_model->del_tenancy($tenancy_id);
            $data['title'] = 'Tenancy';
            $data['sub_title'] = 'Tenancy deleted';

            $data['message'] = 'Tenancy details deleted';
            $this->load->view('templates/header', $data);
            $this->load->view('tenancy/success', $data);
            $this->load->view('templates/footer');
        } else {
            $this->index();
        }
    }

    public function change_status() {
        $data['message'] = "Access denied. You do not have the permission to perform this operation, contact the admin for further assistance.";
        $data['success'] = FALSE;
        //if (isset($_SESSION['role']) && $_SESSION['role'] > 3) {
            $data['message'] = $this->tenancy_model->change_status();
            if ($data['message'] === true) {
                $data['success'] = TRUE;
            }
        //}
        echo json_encode($data);
    }

}
