<?php

class Tenant extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //if user not logged in, take them back to the login page
        if (!isset($_SESSION['user_id'])) {
            redirect('user/login');
        }
        $this->load->model('tenant_model');
        $this->load->model('district_model');
        $this->load->model('house_model');
        $this->load->model('estate_model');
    }

    public function index() {
        $data['title'] = 'Tenants';
        $data['sub_title'] = 'List of tenants';

        $data['paymentReportModal'] = $this->load->view('tenants/paymentReportModal', NULL, TRUE);

        $this->load->view('templates/header', $data);
        $this->load->view('tenants/index');
        $this->load->view('templates/footer');
    }

    public function tenantsJsonList($status = FALSE) {
        $this->load->helper('form');
        $where = "";
        if ($this->input->post('start_date') != "" && $this->input->post('end_date') != "") {
            $where .= "(". (($this->input->post('tenant_id') == NULL)?"`tenant`.`date_created`":"start_date"). " BETWEEN " . $this->input->post('start_date') . " AND " . $this->input->post('end_date') . ")";
        }
        if ($this->input->post('tenant_id') != "") {
            $where .= (strlen($where) > 1 ? " AND " : "") . " tenant.`tenant_id` = " . $this->input->post('tenant_id');
        }
        if ($this->input->post('estate_id') != "") {
            $where .= (strlen($where) > 1 ? " AND " : "") . " `estate_id` = " . $this->input->post('estate_id');
        }
        if ($this->input->post('house_id') != "") {
            $where .= (strlen($where) > 1 ? " AND " : "") . " `house_id` = " . $this->input->post('house_id');
        }
        $tenants['data'] = $this->tenant_model->get_tenant($where);
        echo json_encode($tenants);
    }

    public function view($tenant_id = NULL) {
        $data['tenant'] = $this->tenant_model->get_tenant($tenant_id);
        $data['title'] = 'Tenant';

        if (empty($data['tenant'])) {
            $data['sub_title'] = 'No data';
            $data['message'] = 'The tenant record was not found';
            //show_404();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/404', $data);
            $this->load->view('templates/footer');
        } else {

            $this->load->model('payment_model');
            $this->load->model('tenancy_model');

            $data['sub_title'] = $data['tenant']['names'];
            $data['paymentReportModal'] = $this->load->view('tenants/paymentReportModal', NULL, TRUE);

            $this->load->view('templates/header', $data);
            $this->load->view('tenants/view', $data);
            $this->load->view('templates/footer');
        }
    }

    public function create() {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = "Tenants";
        $data['sub_title'] = "New tenant";
        $data['districts'] = $this->district_model->get_district();
        $data['houses'] = $this->house_model->get_house();
        $data['estates'] = $this->estate_model->get_estate();
        $data['step_text'] = TRUE;

        $this->form_validation->set_rules('names', 'Tenant names', 'required|max_length[100]', array('required' => '%s is missing.', 'max_length' => '%s must be less than 100 characters'));
        $this->form_validation->set_rules('id_card_no', 'ID Card No', 'required|max_length[20]', array('required' => '%s is missing.', 'max_length' => '%s must be less than 20 characters'));
        $this->form_validation->set_rules('names', 'Tenant names', 'required|max_length[50]', array('required' => '%s is missing.', 'max_length' => '% must be less than 50 characters'));
        $this->form_validation->set_rules('phone1', 'Phone number', 'required|exact_length[10]|numeric', array('required' => '%s is missing.', 'exact_length' => '%s must be exactly 10 digits'));
        $this->form_validation->set_rules('phone2', 'Second phone no', 'exact_length[10]|numeric', array('exact_length' => '%s must be exactly 10 digits.'));
        $this->form_validation->set_rules('home_address', 'Home address', 'required', array('required' => '%s is missing.'));
        $this->form_validation->set_rules('district_id', 'Home district', 'required', array('required' => '%s is missing.'));
        if (empty($_FILES['id_card_url']['name'])) {
            $this->form_validation->set_rules('id_card_file', 'ID card atttachment', 'required');
        }
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('tenants/create', $data);
            $this->load->view('templates/footer');
        } else {
            //upload the photos
            $this->load->library('upload');
            $id_card_file_data = $this->process_upload('id_card_url', 'tenants');
            $passport_photo_data = $this->process_upload('passport_photo', 'tenants');
            $photo_urls = array();
            if (isset($id_card_file_data['file_name'])) {
                $photo_urls['id_card_url'] = $id_card_file_data['file_name'];
            } else {
                $this->form_validation->set_rules('id_card_file', 'ID card atttachment', 'required', array('required' => '%s was not uploaded, try again.'));
            }
            if (isset($passport_photo_data['file_name'])) {
                $photo_urls['passport_photo'] = $passport_photo_data['file_name'];
            }
            $data['tenant_id'] = $this->tenant_model->set_tenant($photo_urls);
            //$data['tenant_names'] = $this->input->post('names');
            //$data['step_text'] = TRUE;
            redirect('tenancy/create/'.$data['tenant_id']);
            //$this->load->view('templates/header', $data);
            //$this->load->view('tenancy/create', $data);
            //$this->load->view('templates/footer');
        }
    }

    private function process_upload($file_index, $save_folder, $previous_file = "no_file.jpg") {
        $config['upload_path'] = "./uploads/" . $save_folder;
        $config['allowed_types'] = 'pdf|gif|GIF|jpg|JPG|jpeg|JPEG|png|PNG';
        $config["max_size"] = '1024000';
        $config["file_ext_tolower"] = TRUE;
        $config['encrypt_name'] = TRUE;


        //if the folder doesn't exist
        if (!is_dir($config["upload_path"])) {
            mkdir($config["upload_path"], 0777, true);
        } else {
            if (strlen($previous_file)>1 && file_exists($config["upload_path"] . "/" . $previous_file)) {
                $old = getcwd(); // Save the current directory
                chdir($config["upload_path"]);
                unlink($previous_file);
                chdir($old); // Restore the old working directory
            }
        }
        $this->upload->initialize($config);

        if ($this->upload->do_upload($file_index)) {
            //echo ("Upload fine\n");
            return $this->upload->data();
        } else {
            //echo $this->upload->display_errors();
            return array('error' => $this->upload->display_errors());
        }
    }

    public function update($tenant_id = NULL) {
        if ($tenant_id != NULL) {
            $this->load->helper('form');
            $this->load->library('form_validation');

            $data['title'] = 'Tenant';
            $data['btn_text'] = 'Update';

            $data['tenant'] = $this->tenant_model->get_tenant($tenant_id);
            $data['sub_title'] = "{$data['tenant']['names']} details";
            $data['districts'] = $this->district_model->get_district();

            $this->form_validation->set_rules('names', 'Tenant names', 'required', array('required' => '%s is missing.'));
            $this->form_validation->set_rules('phone1', 'Phone number1', 'required|exact_length[10]|numeric', array('required' => '%s is missing.', 'exact_length' => '% must be exactly 10 digits'));
            $this->form_validation->set_rules('phone2', 'Second phone no', 'exact_length[10]|numeric', array('exact_length' => '%s must be exactly 10 digits.'));
            $this->form_validation->set_rules('id_card_no', 'ID Card No', 'required|max_length[20]', array('required' => '%s is missing.', 'max_length' => '% must be less than 20 characters'));
            $this->form_validation->set_rules('home_address', 'Home address', 'required', array('required' => '%s is missing.'));
            $this->form_validation->set_rules('district_id', 'Home district', 'required', array('required' => '%s is missing.'));

            if ($this->form_validation->run() === FALSE) {
                $this->load->view('templates/header', $data);
                $this->load->view('tenants/create', $data);
                $this->load->view('templates/footer');
            } else {
                //upload the photos
                $this->load->library('upload');
                $photo_urls = array();
                if (!empty($_FILES['id_card_url']) && isset($_FILES['id_card_url']['name'])) {
                    $id_card_file_data = $this->process_upload('id_card_url', 'tenants', $data['tenant']['id_card_url']);
                    if (isset($id_card_file_data['file_name'])) {
                        $photo_urls['id_card_url'] = $id_card_file_data['file_name'];
                    }
                }
                if (!empty($_FILES['passport_photo']) && isset($_FILES['passport_photo']['name'])) {
                    $passport_photo_data = $this->process_upload('passport_photo', 'tenants', $data['tenant']['passport_photo']);

                    if (isset($passport_photo_data['file_name'])) {
                        $photo_urls['passport_photo'] = $passport_photo_data['file_name'];
                    }
                }
                $this->tenant_model->update_tenant($tenant_id, $photo_urls);

                $data['message'] = 'Tenant details successfully updated';

                $this->load->view('templates/header', $data);
                $this->load->view('tenants/success', $data);
                $this->load->view('templates/footer');
                /* print_r($_FILES); */
            }
        } else {
            $this->index();
        }
    }

    public function del_tenant($tenant_id = NULL) {
        //if user not admin or boss, redirect them to the index
        if (isset($_SESSION['role']) && $_SESSION['role'] < 3) {
            $this->index();
            return;
        }
        if ($tenant_id != NULL) {
            $this->tenant_model->del_tenant($tenant_id);

            $data['title'] = 'Delete tenant';
            $data['sub_title'] = 'Tenant details deleted';
            $data['message'] = 'Tenant details deleted from database';

            $this->load->view('templates/header', $data);
            $this->load->view('tenants/success', $data);
            $this->load->view('templates/footer');
        } else {
            $data['title'] = 'Delete tenant';
            $data['sub_title'] = 'Failure';
            $data['message'] = 'Delete operation unsuccessful';

            $this->load->view('templates/header', $data);
            $this->load->view('templates/404', $data);
            $this->load->view('templates/footer');
        }
    }

}
