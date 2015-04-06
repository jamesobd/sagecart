<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Response {


    /**
     * Constructor
     *
     * @access   public
     */
    public function __construct() {

    }

    /**
     * Send a JSON response
     *
     * @param array $data
     * @param int   $status_code
     */
    public function send($data = array(), $status_code = 200) {
        // Default status codes
        $status_code = empty($data) ? 204 : $status_code;

        // If data is empty
        if (empty($data)) {
            http_response_code($status_code);
            exit;
        }

        http_response_code($status_code);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
        exit;
    }
}