<?php

class Transactions extends MY_Controller {

    function __construct() {
        parent::__construct();
    }


    function load_all_transactions() {

        $this->load->model('transactions_model');
        $view_data['transactions'] = $this->transactions_model->all_transactions(33);
        $this->load->view('transactions_view', $view_data);
    }




}

