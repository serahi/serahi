<?php

class Transactions extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    function load_all_transactions() {
        $this->load->model('transactions_model');
        $user_id = $this->session->userdata('user_id');
        $view_data['transactions'] = $this->transactions_model->all_transactions($user_id);

        $view_data['total_money'] = 0;
        $view_data['discount'] = 0;
        foreach ($view_data['transactions'] as $row) {
            if ($row['status'] == 'delivered') {
                $view_data['total_money'] +=$row['price'];
                $view_data['discount'] += ($row['price'] * $row['base_discount']) / 100;
            }
        }
        $this->load->view('transactions_view', $view_data);
    }

}

