<?php

class Membership_model extends CI_Model {

    function validate_user() {
        $this->db->where('username', $this->input->post('username'));
        $this->db->where('password', md5($this->input->post('password')));

        $q = $this->db->get('users');

        if ($q->num_rows == 1) {
            $user = $q->row();
            if ($user->user_type == 'seller') {
                
                $this->db->where('id', $user->id);
                $q = $this->db->get('sellers');
                $user = $q->row();
                if ($user->approved == 'f' ) {
                    return 'not_approved';
                }
			} else if ($user->user_type == 'customer') {
				$this->db->where('id', $user->id);
				$q = $this->db->get('customers');
				$user = $q->row();
				if ($user->activated == 'f') {
					return FALSE;
				}
            }
            return array(
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'id' => $user->id,
                'user_type' => $user->user_type,
                'email' => $user->email
            );
        }
        return FALSE;
    }

    function auto_login($user_id) {
        $this->db->where('id', $user_id);
        $q = $this->db->get('users');

        if ($q->num_rows == 1) {
            $user = $q->row();
            return array(
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'id' => $user->id,
                'user_type' => $user->user_type,
                'email' => $user->email
            );
        }
        return NULL;
    }

    function validate_activation_code($code) {
        $this->db->where('random_string', $code);

        $q = $this->db->get('customers');

        if ($q->num_rows == 1) {
            $user = $q->row();
            return $user->id;
        }
        return NULL;
    }

    function insert_member($random_string) {
        $user_data = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'username' => $this->input->post('username'),
            'password' => md5($this->input->post('password')),
            'email' => $this->input->post('email'),
            'random_string' => $random_string
        );
        $this->db->where('username', $this->input->post('username'));
        $q = $this->db->get('users');
        if ($q->num_rows >= 1) {
            return "NOT UNIQUE";
        } else {
            $insert_result = $this->db->insert('customers', $user_data);
            return $insert_result;
        }
    }

    function update_on_activation($user_id) {
        $data = array(
            'address' => $this->input->post('address'),
            'postal_code' => $this->input->post('postal_code'),
            'phone' => $this->input->post('tel'),
            'activated' => 't',
            'random_string' => NULL
        );
        $this->db->where('id', $user_id);
        $this->db->update('customers', $data);
    }

    function activate($user_id) {
        $data = array(
            'activated' => 't',
            'random_string' => NULL
        );
        $this->db->where('id', $user_id);
        $this->db->update('customers', $data);
    }

    function insert_seller($user_type) {
        $user_data = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'username' => $this->input->post('username'),
            'password' => md5($this->input->post('password')),
            'email' => $this->input->post('email'),
            'display_name' => $this->input->post('seller_display_name'),
            'address' => $this->input->post('address'),
            'phone' => $this->input->post('phone'),
            'user_type' => $user_type,
            'creation_time' => date("Y-m-d H:i:s")
        );

        $this->db->where('username', $this->input->post('username'));
        $q = $this->db->get('users');
        if ($q->num_rows >= 1) {
            return "NOT UNIQUE";
        } else {
            $insert_result = $this->db->insert('sellers', $user_data);
            return $insert_result;
        }
    }

}
