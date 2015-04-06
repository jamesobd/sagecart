<?php

class MY_Form_validation extends CI_Form_validation {
    function __construct($config = array()) {
        parent::__construct($config);
    }

    /**
     * Error Array
     *
     * Returns the error messages as an array
     *
     * @return  array
     */
    public function error_array() {
        if (count($this->_error_array) === 0) {
            return FALSE;
        } else {
            return $this->_error_array;
        }
    }

    /**
     * Match one field to another
     *
     * @access    public
     * @param    string
     * @param    field
     * @return    bool
     */
    public function exists($str, $field) {
        list($table, $field) = explode('.', $field);
        $query = $this->CI->db->limit(1)->get_where($table, array($field => $str));

        return $query->num_rows() === 1;
    }

    /**
     * Verify that the user id is the same as what is in the session
     *
     * @param $user_id
     * @return bool
     */
    public function check_identity($user_id) {
        if ($user_id != $this->CI->session->userdata('user_id')) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * Returns true if $json is a valid json_string
     *
     * @param string $json
     * @return bool
     */
    public function valid_json($json) {
        json_decode($json);
        // TODO: Recursively go through and make sure each property in the json object is xss_cleaned
        return json_last_error() == JSON_ERROR_NONE;
    }
}