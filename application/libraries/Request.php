<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Request {

    // Class variables
    var $CI;
    var $curlSession;

    /**
     * Constructor
     *
     * @access   public
     */
    public function __construct() {
        $this->CI =& get_instance();
        $this->curlSession = curl_init();
        curl_setopt($this->curlSession, CURLOPT_RETURNTRANSFER, true);
    }

    /**
     * CURL GET request
     *
     * @param       $url - The request url
     * @param array $options
     * @return array
     */
    public function get($url, $options = array()) {
        // Set default options
        $options['connecttimeout'] = empty($options['connecttimeout']) ? 60 : $options['connecttimeout'];

        // Set options and execute the request
        curl_setopt($this->curlSession, CURLOPT_URL, $url);
        curl_setopt($this->curlSession, CURLOPT_CONNECTTIMEOUT, $options['connecttimeout']);
        $response = json_decode(curl_exec($this->curlSession));

        // TODO: Use the log environment variable to determine what logs get saved
        curl_log($this->curlSession, $response);

        $returnObject = (object)array(
            'status' => curl_errno($this->curlSession) ? 'error' : 'success',
            'code' => curl_getinfo($this->curlSession, CURLINFO_HTTP_CODE),
            'message' => curl_error($this->curlSession),
        );

        // If there is no error
        if (curl_errno($this->curlSession) == 0) {
            $returnObject->body = $response;
        }

        return $returnObject;
    }

    /**
     * Does a post request
     *
     * @param       $url
     * @param       $body
     * @param array $options
     * @return array
     */
    public function post($url, $body, $options = array()) {
        // Set default options
        $options['connecttimeout'] = empty($options['connecttimeout']) ? 60 : $options['connecttimeout'];

        // Set options and execute the request
        curl_setopt($this->curlSession, CURLOPT_URL, $url);
        curl_setopt($this->curlSession, CURLOPT_CONNECTTIMEOUT, $options['connecttimeout']);
        curl_setopt($this->curlSession, CURLOPT_POSTFIELDS, json_encode($body, JSON_UNESCAPED_SLASHES));
        $response = json_decode(curl_exec($this->curlSession));

        // TODO: Use the log environment variable to determine what logs get saved
        curl_log($this->curlSession, $response, $body);

        $returnObject = (object)array(
            'status' => curl_errno($this->curlSession) ? 'error' : 'success',
            'code' => curl_getinfo($this->curlSession, CURLINFO_HTTP_CODE),
            'message' => curl_error($this->curlSession),
        );

        // If there is no error
        if (curl_errno($this->curlSession) == 0) {
            $returnObject->body = $response;
        }

        return $returnObject;
    }
}
