<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Index extends CI_Controller {

    //private $customer;
    private $view;

    /**
     * -------------------------------------------------------------------------
     * Constructor
     * -------------------------------------------------------------------------
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        //require '../libraries/Customer.php';
        //$this->customer = new Customer();
        $this->load->library(array('response', 'request', 'form_validation'));

        $this->view = new stdClass();
        $this->load->model('contacts_model');
        $this->load->model('catalog_model');
        $this->view->head = true;
        $this->view->cart = true;
        $this->view->homeLink = (isset($_SERVER['HTTPS']) == false ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'];
    }

    /**
     * -------------------------------------------------------------------------
     * Index Page for this controller.
     * -------------------------------------------------------------------------
     */
    public function index() {
        $this->checkForLoggedIn();
        $products = $this->catalog->getByCustomer($this->session->userdata('UID'));
        if (!empty($products->status) && $products->status != 'success') {
            // there was an error, handle it here.
            // this is thrown regularly
            echo "there was an error";
        }

        $this->view->contact = $this->session->all_userdata();
        if (!empty($products->resource)) {
            $this->view->navMenu = $this->parseNav($products->resource); // get active category from url
            $this->view->catalog = $products->resource;
        } else {
            $this->view->navMenu = '';
            $this->view->catalog = Array();
        }
        $this->view->content = $this->load->view('home', $this->view, true);
        $this->load->view('templates/fixedflex', $this->view);
    }

    /**
     * -------------------------------------------------------------------------
     * Confirm page for a completed order
     * -------------------------------------------------------------------------
     */
    public function confirm() {
        $this->checkForLoggedIn();
        $this->view->contact = $this->session->all_userdata();

        $this->view->content = $this->load->view('confirm', $this->view, true);
        $this->load->view('templates/home', $this->view);
    }

    /*************************************************************************
     * Login page
     *************************************************************************/
    public function login() {
        $this->view->head = false;
        $this->view->contact = '';
        $this->view->content = $this->load->view('login', $this->view, true);
        $this->load->view('templates/home', $this->view);
    }


    /*************************************************************************
     * logout and redirect to login page
     *************************************************************************/
    public function logout() {
        $this->session->set_userdata('LoggedIn', false);
        redirect('/login');
    }

    /**
     * The contact us page
     *
     */
    public function contactUs() {
        $this->checkForLoggedIn();
        $this->view->sentAttempt = false;
        $this->view->success = false;
        $this->load->helper('form');
        $this->load->library('form_validation');

        // form validation rules
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('email', 'Email', 'valid_email');
        $this->form_validation->set_rules('question', 'Question', 'required');

        $this->view->contact = $this->session->all_userdata();
        //TODO: ensure the email address is valid
        if ($this->form_validation->run() == true) {
            $contactName = $this->session->userdata('ContactName') ? $this->session->userdata('ContactName') : 'Non-signed in Customer';

            $to = "concierge@gulfpackaging.com";
            $subject = 'Customer Inquiry - Store Website';
            $message = $this->input->post('question');
            $headers = 'From: ' . $contactName . ' <' . $this->input->post('email') . '>';
            mail($to, $subject, $message, $headers);


//            include("Mail.php");
//            $headers["From"] = $email;
            // TODO: switch email addresses
//            $headers["To"] = "ken@obdstudios.com";
//            $headers["To"] = "jed@obdstudios.com";
//            $headers["To"]      = "customerservice@gulfpackaging.com";
//            $headers["Subject"] = "Question from {$contactName}";

//            $body = $question;
//
//            $params["host"] = "hub01.ggl.gulfpack.com";
//            $params["port"] = "25";
//            $params["auth"] = false;

            // Create the mail object using the Mail::factory method
//            $mail_object =& Mail::factory("smtp", $params);
//
//            $mail_object->send($recipients, $headers, $body);


            // load the success view
            $this->view->content = $this->load->view('success', $this->view, true);
        } else {
            $this->view->contact = $this->session->all_userdata();
            $this->view->content = $this->load->view('contactus', $this->view, true);
        }

        $this->view->cart = false;
        $this->load->view('templates/home', $this->view);
    }

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
        $cursor = $logs->find();
//        if($date != null){$cursor->where}

        foreach($cursor as $logentry) {
//            console.log('1');
            $datetime = (string)$logentry['datetime'];
            $type = (string)$logentry['type'];
            $ip = (string)$logentry['ip'];
            $email = (string)$logentry['email'];
            $url = (string)$logentry['url'];
            $uarh = json_encode($logentry['user_agent_request_headers']);
            $uarb = json_encode($logentry['user_agent_request_body']);
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
            echo '  <td title="' . str_replace('"','&quot;',$datetime) . '">' . $showdatetime . '</td>';
            echo '  <td title="' . str_replace('"','&quot;',$type) . '">' . $showtype . '</td>';
            echo '  <td title="' . str_replace('"','&quot;',$ip) . '">' . $showip . '</td>';
            echo '  <td title="' . str_replace('"','&quot;',$email) . '">' . $showemail . '</td>';
            echo '  <td title="' . str_replace('"','&quot;',$url) . '">' . $showurl . '</td>';
            echo '  <td title="' . str_replace('"','&quot;',$uarh) . '">' . $showuarh . '</td>';
            echo '  <td title="' . str_replace('"','&quot;',$uarb) . '">' . $showuarb . '</td>';
            echo '  <td title="' . str_replace('"','&quot;',$curl_errno) . '">' . $showcurl_errno . '</td>';
            echo '  <td title="' . str_replace('"','&quot;',$curl_error) . '">' . $showcurl_error . '</td>';
            echo '  <td title="' . str_replace('"','&quot;',$curl_settings) . '">' . $showcurl_settings . '</td>';
            echo '  <td title="' . str_replace('"','&quot;',$curl_body) . '">' . $showcurl_body . '</td>';
            echo '  <td title="' . str_replace('"','&quot;',$response) . '">' . $showresponse . '</td>';
            echo '</tr>';

        }

        echo '</table>';

        // If there is a date then query for all logs for that day
        // if an email is given then filter by that email



//        if(!$log_filename) {
//            $log_files = get_filenames(APPPATH . 'logs');
//            sort($log_files);
//            $log_files = array_reverse($log_files);
//
//            // Display the results in table format
//            echo '<table>';
//            echo '<tr><td>datetime</td><td>type</td></tr>';
//            foreach($log_files as $log) {
//                echo '<tr><td>$log-></td></tr>';
//            }
//            echo '</table>';
//        } else if(!$line_number) { // Show the contents of the log
//            // Get the file into an array delimited by newline
//            $log_lines = array_reverse(file(APPPATH . 'logs/' . $log_filename));
//
//            echo '<pre>';
//            for($i = 0; $i < count($log_lines); $i++) {
//                if (substr($log_lines[$i], 32, 1) == '{') {
//                    echo '<a href="/logs/' . $log_filename . '/' . (count($log_lines) - $i) . '">' . $log_lines[$i] . '</a>';
//                }
//            }
//            echo '</pre>';
//        } else {
//            // Get the file into an array delimited by newline
//            $log_lines = file(APPPATH . 'logs/' . $log_filename);
//            echo '<pre>';
//            echo json_encode(json_decode(strstr($log_lines[$line_number - 1], '{')), JSON_PRETTY_PRINT);
//            echo '</pre>';
//        }
    }

    /**
     * Method turns categories object into unordered list heierarchy for left side nav
     *
     * @param        $categories
     * @param string $nav
     * @param bool   $child
     * @return string
     */
    private function parseNav($categories, $nav = '', $child = FALSE) {
        if ($child) {
            $nav .= '<ul class="nav nav-pills nav-stacked child-nav" style="display: none;">';
        } else {
            $nav .= '<ul class="nav nav-pills nav-stacked">';
            $nav .= '<li class="category"><a id="show-all" class="category-nav">Show All</a></li>';
        }

        foreach ($categories as $category) {
            $nav .= '<li class="category">';
            // only make a link if there are products in the category
            if (!empty($category->Products)) {
                $nav .= '<a class="category-nav" href="ajax/getproductsbycategory/' . $category->CategoryCode . '">' . $category->CategoryCodeDesc;
            } else {
                $nav .= "<a>{$category->CategoryCodeDesc}";
            }

            if (property_exists($category, 'Children')) $nav .= ' <span class="glyphicon glyphicon-chevron-right"></span>';
            $nav .= '</a>';

            if (property_exists($category, 'Children')) {
                $nav = $this->parseNav($category->Children, $nav, TRUE);
            }
            $nav .= '</li>';
        }

        $nav .= '</ul>';
        return $nav;
    }

    private function checkForLoggedIn() {
        if (!$this->session->userdata('LoggedIn')) {
            $this->session->set_userdata('loginRedirect', uri_string());
            redirect('/login/');
        }
    }

    /**
     * -------------------------------------------------------------------------
     * Testing functions
     * -------------------------------------------------------------------------
     */
    public function fixedflex() {
        $this->view->navMenu = '';
        $this->view->content = '';
        $this->load->view('templates/fixedflex', $this->view);
    }

    /**
     * Return the test catalog
     */
    public function gettestcatalog() {
        $this->output->set_header('Content-Type: application/json; charset=utf-8')
            ->set_output(file_get_contents('./js/testcatalog.js', FILE_USE_INCLUDE_PATH));
    }

    public function contact_model($email = 'artie@abf.com', $password = 'timeslip') {
        echo $this->contact->getContactInformation($email, $password);
    }

}

