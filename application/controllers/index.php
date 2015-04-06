<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Index extends CI_Controller {


    /**
     * -------------------------------------------------------------------------
     * Constructor
     * -------------------------------------------------------------------------
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library(array('response', 'request', 'form_validation'));
    }

    /**
     * -------------------------------------------------------------------------
     * Index Page for this controller.
     * -------------------------------------------------------------------------
     */
    public function index() {
        $contact = $this->session->userdata('contact');

        // If the user is not authenticated
        if (!$contact) {
            redirect('/login/', 'refresh');
        } else {
            $this->load->view('pages/home');
        }
    }


    public function login() {
        $contact = $this->session->userdata('contact');

        // If the user is not authenticated
        if (!$contact) {
            $this->load->view('pages/login');
        } else {
            redirect('/', 'refresh');
        }
    }

    /**
     * Displays the logs saved in the database
     *
     * @param null $date
     * @param null $email
     */
    public function logs($date = null, $email = null) {

        echo '<table>';
        echo '<tr>';
        echo '  <th>datetime</th>';
        echo '  <th>type</th>';
        echo '  <th>ip</th>';
        echo '  <th>email</th>';
        echo '  <th>url</th>';
        echo '  <th>user agent request headers</th>';
        echo '  <th>user agent request body</th>';
        echo '  <th>curl errno</th>';
        echo '  <th>curl error</th>';
        echo '  <th>curl settings</th>';
        echo '  <th>curl body</th>';
        echo '  <th>response</th>';
        echo '</tr>';

        $logs = (new MongoClient())->gulf->logs;
        $query = $date != null ? "'date' => $date," : "";
        $query = $query + $email != null ? "'email' => $email," : "";
//        $cursor = $logs->find(array($query));
        $cursor = $logs->find()->sort(array('datetime' => -1))->limit(200);
//        if($date != null){$cursor->where}

        foreach ($cursor as $logentry) {
//            console.log('1');
            $datetime = (string)$logentry['datetime'];
            $type = (string)$logentry['type'];
            $ip = (string)$logentry['ip'];
            $email = (string)$logentry['email'];
            $url = (string)$logentry['url'];
            $uarh = json_encode($logentry['user_agent_request_headers']);
            $uarb = json_encode($logentry['user_agent_request_body']['email']);
            $curl_errno = (string)$logentry['curl_errno'];
            $curl_error = (string)$logentry['curl_error'];
            $curl_settings = json_encode($logentry['curl_settings']);
            $curl_body = ($logentry['curl_body'] != null) ? json_encode($logentry['curl_body']) : '';
            $response = json_encode($logentry['response']);

            $showdatetime = substr($datetime, 0, 30);
            $showtype = substr($type, 0, 30);
            $showip = substr($ip, 0, 30);
            $showemail = substr($email, 0, 30);
            $showurl = substr($url, 0, 30);
            $showuarh = substr($uarh, 0, 30);
            $showuarb = substr($uarb, 0, 30);
            $showcurl_errno = substr($curl_errno, 0, 30);
            $showcurl_error = substr($curl_error, 0, 30);
            $showcurl_settings = substr($curl_settings, 0, 30);
            $showcurl_body = substr($curl_body, 0, 30);
            $showresponse = substr($response, 0, 30);

            echo '<tr>';
            echo '  <td title="' . str_replace('"', '&quot;', $datetime) . '">' . $showdatetime . '</td>';
            echo '  <td title="' . str_replace('"', '&quot;', $type) . '">' . $showtype . '</td>';
            echo '  <td title="' . str_replace('"', '&quot;', $ip) . '">' . $showip . '</td>';
            echo '  <td title="' . str_replace('"', '&quot;', $email) . '">' . $showemail . '</td>';
            echo '  <td title="' . str_replace('"', '&quot;', $url) . '">' . $showurl . '</td>';
            echo '  <td title="' . str_replace('"', '&quot;', $uarh) . '">' . $showuarh . '</td>';
            echo '  <td title="' . str_replace('"', '&quot;', $uarb) . '">' . $showuarb . '</td>';
            echo '  <td title="' . str_replace('"', '&quot;', $curl_errno) . '">' . $showcurl_errno . '</td>';
            echo '  <td title="' . str_replace('"', '&quot;', $curl_error) . '">' . $showcurl_error . '</td>';
            echo '  <td title="' . str_replace('"', '&quot;', $curl_settings) . '">' . $showcurl_settings . '</td>';
            echo '  <td title="' . str_replace('"', '&quot;', $curl_body) . '">' . $showcurl_body . '</td>';
            echo '  <td title="' . str_replace('"', '&quot;', $response) . '">' . $showresponse . '</td>';
            echo '</tr>';

        }

        echo '</table>';
    }


    /**
     * -------------------------------------------------------------------------
     * Testing functions
     * -------------------------------------------------------------------------
     */

}

