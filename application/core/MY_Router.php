<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH . "third_party/MX/Router.php";
require APPPATH . "helpers/security_helper.php";

class MY_Router extends MX_Router {

    public function __construct() {
        parent::__construct();
        
    }

    public function _validate_request($segments) {
//        $CI = &get_instance();
//        $CI->load->library('session');
        if (count($segments) == 0){
            check_access(0);
            return $segments;
        }

        /* locate module controller */
        if ($located = $this->locate($segments)) {
            check_access($located);
            return $located;
        }

        /* use a default 404_override controller */
        if (isset($this->routes['404_override']) AND $this->routes['404_override']) {
            $segments = explode('/', $this->routes['404_override']);

            if ($located = $this->locate($segments)) {
                check_access($located);
                return $located;
            }
        }

        /* no controller found */
        show_404();
    }

}

/* End of file DK_Router.php */
/* Location: ./application/core/DK_Router.php */
