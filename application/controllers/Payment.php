<?php

class Payment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //if user not logged in, take them back to the login page
        if (!isset($_SESSION['user_id'])) {
            redirect('user/login');
        }
        $this->load->model('payment_model');
        $this->load->model('account_model');
        $this->load->model('tenancy_model');
    }

    public function index() {
        $this->load->helper('form');

        $data['title'] = 'Payments';
        $data['sub_title'] = 'Payments/non-payments';

        $data['paymentReceiptModal'] = $this->load->view('payments/paymentReceiptModal', NULL, TRUE);

        $this->load->view('templates/header', $data);
        $this->load->view('payments/index');
        $this->load->view('templates/footer');
    }

    public function paymentsJsonList($status = FALSE) {
        $this->load->helper('form');
        $where = "";
        if ($this->input->post('start_date') != "" && $this->input->post('end_date') != "") {

            $where .= "(`payment_date` BETWEEN " . $this->input->post('start_date') . " AND " . $this->input->post('end_date') . ")";
        }
        if ($this->input->post('tenant_id') != "") {
            $where .= (strlen($where) > 1 ? " AND " : "") . " `tenant_id` = " . $this->input->post('tenant_id');
        }
        if ($this->input->post('estate_id') != "") {
            $where .= (strlen($where) > 1 ? " AND " : "") . " `house_id` IN (SELECT `house_id` FROM `house` WHERE `estate_id` = " . $this->input->post('estate_id') . ")";
        }
        $payments['data'] = $this->payment_model->get_payment($where);
        echo json_encode($payments);
    }

    public function paymentLinesJsonList($status = FALSE) {
        $this->load->helper('form');
        $where = "";
        if ($this->input->post('start_date') != "" && $this->input->post('end_date') != "") {

            $where .= "(`payment_date` BETWEEN " . $this->input->post('start_date') . " AND " . $this->input->post('end_date') . ")";
        }
        if ($this->input->post('tenant_id') != "") {
            $where .= (strlen($where) > 1 ? " AND " : "") . " `tenant_id` = " . $this->input->post('tenant_id');
        }
        if ($this->input->post('estate_id') != "") {
            $where .= (strlen($where) > 1 ? " AND " : "") . " `house_id` IN (SELECT `house_id` FROM `house` WHERE `estate_id` = " . $this->input->post('estate_id') . ")";
        }
        $payments['data'] = $this->payment_model->get_payment_lines($where);
        echo json_encode($payments);
    }

    public function view($payment_id = NULL) {
        $data['payment'] = $this->payment_model->get_payment($payment_id);
        $data['title'] = 'Payment';

        if (empty($data['payment'])) {
            $data['sub_title'] = 'No data';
            $data['message'] = 'The payment record was not found';

            $this->load->view('templates/header', $data);
            $this->load->view('templates/404', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->model('house_model');
            $this->load->model('user_model');
            $data['tenant'] = $this->tenancy_model->get_by_tenant_id($data['payment']['tenant_id']);
            $data['house'] = $this->house_model->get_house($data['tenant'][0]['house_id']);
            $data['staff_detail'] = $this->user_model->get_user($data['payment']['created_by']);

            $data['sub_title'] = "Payment receipt for " . $data['payment']['names'];

            $this->load->view('templates/header', $data);
            $this->load->view('payments/view', $data);
            $this->load->view('templates/footer');
        }
    }

    public function pdf($payment_id = NULL) {
        $data['payment'] = $this->payment_model->get_payment($payment_id);
        $data['title'] = 'Payment';

        if (empty($data['payment'])) {
            $data['sub_title'] = 'No data';
            $data['message'] = 'The payment record was not found';

            $this->load->view('templates/header', $data);
            $this->load->view('templates/404', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->library('pdf');

            $this->load->model('house_model');
            $this->load->model('user_model');
            $data['tenant'] = $this->tenancy_model->get_by_tenant_id($data['payment']['tenant_id']);
            $data['house'] = $this->house_model->get_house($data['tenant'][0]['house_id']);
            $data['staff_detail'] = $this->user_model->get_user($data['payment']['created_by']);

            $data['sub_title'] = "Payment receipt for " . $data['payment']['names'];

            //$this->pdf->load_view('templates/header', $data);
            $this->pdf->load_view('payments/view', $data);
            //$this->pdf->load_view('templates/footer');
            //$this->pdf->set_option('defaultFont', 'Courier');
            $this->pdf->setPaper('A5', 'landscape');
            $this->pdf->set_option('isHtml5ParserEnabled', true);

            $this->pdf->render();

            $this->pdf->stream("Receipt.pdf");
        }
    }

    public function create($tenancy_id = FALSE) {
        if ($tenancy_id !== FALSE) {
            $data['tenancy'] = $this->tenancy_model->get_tenancy($tenancy_id);
        } else {
            $data['tenancies'] = $this->tenancy_model->get_tenancy("`status`=1 OR `status`=3"); //active tenants and those deactivated with arrears
        }
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = "Payment";
        $data['sub_title'] = "New payment";
        $data['accounts'] = $this->account_model->get_account();

        $data['step_text'] = TRUE;

        //$this->form_validation->set_rules('particulars', 'Particulars', 'required', array('required' => '%s missing.'));
        $this->form_validation->set_rules('rent_rate', 'Rent rate', 'required', array('required' => '%s is missing.'));
        //$this->form_validation->set_rules('amount', 'Total Amount paid', 'required', array('required' => '%s is missing.'));
        $this->form_validation->set_rules('payment[0][amount]', 'Amount paid', 'required|numeric', array('required' => '%s is missing.', 'numeric' => '%s must be a number'));
        $this->form_validation->set_rules('payment_date', 'Date of payment', 'required|datetime', array('required' => '%s is missing.', 'datetime' => '%s is invalid, required date format is dd-mm-yyyy.'));
        //$this->form_validation->set_rules('no_of_periods', 'No of periods', 'required|greater_than[0]', array('required' => '%s is missing.', 'greater_than' => '%s is less than 1.'));
        //$this->form_validation->set_rules('start_date', 'Start date', 'required', array('required' => '%s is missing.'));
        //$this->form_validation->set_rules('end_date', 'End date', 'required', array('required' => '%s is missing.'));
        if ($this->form_validation->run() === FALSE) {
            $this->load->model('timeInterval_model');
            $data['time_intervals'] = $this->timeInterval_model->get_time_interval();
            $this->load->view('templates/header', $data);
            $this->load->view('payments/create', $data);
            $this->load->view('templates/footer');
        } else {
            $payment_id = $this->payment_model->set_payment();
            $payments = $this->input->post('payment');
            $payments_count = count($payments);
            foreach ($payments as $key => $payment) {
                $payment['payment_id'] = $payment_id;
                unset($payment['id']);
                $this->payment_model->set_payment_line($payment);
                if ($key == $payments_count - 1) {
                    $end_date_time = $payment['end_date'];
                    $this->tenancy_model->update_tenancy_end_date($end_date_time);
                }
            }
            redirect("payment/view/$payment_id");
        }
    }

    public function update($payment_id = NULL) {
        //if user not admin or boss, redirect them to the index
        if (isset($_SESSION['role']) && $_SESSION['role'] < 3) {
            $this->index();
        }
        if ($payment_id != NULL) {
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->model('timeInterval_model');
            $data['time_intervals'] = $this->timeInterval_model->get_time_interval();

            $data['title'] = 'Payment';
            $data['sub_title'] = 'Update payment details';
            $data['btn_text'] = 'Update';



            //$this->form_validation->set_rules('particulars', 'Particulars', 'required', array('required' => '%s missing.'));
            $this->form_validation->set_rules('rent_rate', 'Rent rate', 'required', array('required' => '%s is missing.'));
            $this->form_validation->set_rules('amount', 'Amount paid', 'required', array('required' => '%s is missing.'));
            $this->form_validation->set_rules('payment_date', 'Date of payment', 'required|datetime', array('required' => '%s is missing.', 'datetime' => '%s is invalid, required date format is dd-mm-yyyy.'));
            //$this->form_validation->set_rules('no_of_periods', 'No of periods', 'required|greater_than[0]', array('required' => '%s is missing.', 'greater_than' => '%s is less than 1.'));
            //$this->form_validation->set_rules('start_date', 'Start date', 'required', array('required' => '%s is missing.'));
            //$this->form_validation->set_rules('end_date', 'End date', 'required', array('required' => '%s is missing.'));

            $data['payment_line'] = $this->payment_model->get_payment_line("`payment_id`=" . $payment_id);
            if ($this->form_validation->run() === FALSE) {
                $data['payment'] = $this->payment_model->get_payment($payment_id);
                $data['accounts'] = $this->account_model->get_account();
                $data['tenancy'] = $this->tenancy_model->get_tenancy($data['payment']['tenancy_id']);
                $this->load->view('templates/header', $data);
                $this->load->view('payments/create', $data);
                $this->load->view('templates/footer');
            } else {
                $this->payment_model->update_payment($payment_id);
                $end_date_time = $this->insert_payments($this->input->post('payment'), $payment_id, $data['payment_line']);
                //retrieve the list of payments for this tenancy, so as to find out the last payment made
                //This is so that we update the tenancy enddate only if this is the last payment for the given tenancy
                $tenancy_payments = $this->payment_model->get_payment("`tenancy_id`=" . $data['payment']['tenancy_id']);
                $total = count($tenancy_payments);
                if ($tenancy_payments[$total - 1]['payment_id'] == $payment_id) {
                    //this is the last payment, so it is safe to update the tenancy end date
                    $this->tenancy_model->update_tenancy_end_date($end_date_time);
                }
                $data['message'] = 'Payment details successfully updated';

                $this->load->view('templates/header', $data);
                $this->load->view('payments/success', $data);
                $this->load->view('templates/footer');
            }
        } else {
            $this->view($payment_id);
        }
    }

    private function insert_payments($new_payments, $payment_id, $old_payments = FALSE) {
        
        $payments_count = count($new_payments);
        $end_date_time = ""; $updated_keys = [];
        foreach ($new_payments as $key => $new_payment) {
            if( $new_payment['id'] !== '' ){
                $updated_keys[] = $new_payment['id'];
                $this->payment_model->update_payment_line( $new_payment );
            }
            else{
                $payment['payment_id'] = $payment_id;
                unset($payment['id']);
                $this->payment_model->set_payment_line( $new_payment );
            }
            if ($key == $payments_count - 1) {
                $end_date_time = $new_payment['end_date'];
            }
        }
        if(is_array($old_payments) && count($updated_keys)>0){
            $this->delete_payment_line( $updated_keys , $old_payments );
        }
        return $end_date_time;
    }

    private function delete_payment_line( $updated_keys, $payments_array ) {
        foreach ($payments_array as $cur_array) {
            if(!in_array($cur_array['id'], $updated_keys)){
                $this->payment_model->del_payment_line($cur_array['id']);
            }
        }
    }
    public function del_payment($payment_id = NULL) {
        //if user not admin or boss, redirect them to the index
        if (isset($_SESSION['role']) && $_SESSION['role'] < 3) {
            $this->index();
        }
        $data['title'] = 'Payments';
        $data['sub_title'] = 'Payment record deleted';
        if ($payment_id != NULL) {
            $this->payment_model->del_payment($payment_id);

            $data['message'] = 'Payment record deleted';
            $this->load->view('templates/header', $data);
            $this->load->view('payments/success', $data);
            $this->load->view('templates/footer');
        } else {
            $data['title'] = 'Payment';
            $data['sub_title'] = 'Payment deleted';

            $this->load->view('templates/header', $data);
            $this->load->view('accounts/index');
            $this->load->view('templates/footer');
        }
    }

}
