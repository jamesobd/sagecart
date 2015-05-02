<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


function curl_log($session, $response, $request_body = '')
{
    $CI =& get_instance();
    $logs = (new MongoClient())->sagecart->logs;
    $log = array(
        'datetime' => date('Y-m-d H-i-s'),
        'type' => 'curl',
        'ip' => $CI->input->ip_address(),
        'email' => $CI->session->userdata('EmailAddress'),
        'url' => $CI->uri->uri_string(),
        'user_agent_request_headers' => $CI->input->request_headers(),
        'user_agent_request_body' => $CI->input->post(),
        'curl_errno' => curl_errno($session),
        'curl_error' => curl_error($session),
        'curl_settings' => curl_getinfo($session),
        'curl_body' => $request_body,
        'response' => $response,
    );

    $logs->insert($log);
}
