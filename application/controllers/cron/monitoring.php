<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class _Resource_
 */
class Monitoring extends CI_Controller {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

        // If this is not a CLI call then let's just die
        if (php_sapi_name() !== 'cli' OR !defined('STDIN')) {
            exit;
        }

        if (!file_exists(APPPATH . 'controllers/cron/monitoring_status.json')) {
            file_put_contents(APPPATH . 'controllers/cron/monitoring_status.json', json_encode(["status" => "OK", "timestamp" => time()]), JSON_UNESCAPED_SLASHES);
        }
    }

    /**
     * MAS API heartbeat
     *
     */
    public function masHeartbeat() {
        $url = $this->config->item('sage_api_url') . 'heartbeat';
        $curlSession = curl_init();
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlSession, CURLOPT_URL, $url);
        curl_setopt($curlSession, CURLOPT_CONNECTTIMEOUT, 30);

        // Ping the MAS API heartbeat.  Multiple times if it fails.
        for ($i = 0; $i < 6; $i++) {
            $response = json_decode(curl_exec($curlSession));

            // If it succeeds then exit
            if (!empty($response->status) && $response->status == 'success') {
                return;
            }
        }

        // Log the error
        $log = array(
            'datetime' => date('Y-m-d H-i-s'),
            'type' => 'MAS API heartbeat',
            'curl_errno' => curl_errno($curlSession),
            'curl_error' => curl_error($curlSession),
            'curl_settings' => curl_getinfo($curlSession),
            'response' => $response,
        );
        log_message('error', json_encode($log, JSON_UNESCAPED_SLASHES));

        // Email people about the error
        $to = "rnordin@erpdevelopers.net,tom@obdstudios.com,james@obdstudios.com,mas@xsysinc.com,jfleck@gulfpackaging.com";
        $subject = 'MAS API heartbeat failure';
        $message = "An error has occurred.  This automated message is to inform you that the MAS API failed to respond multiple times.\n\n" . json_encode($log, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
        $headers = 'From: Gulf Store System <noreply@gulfpackaging.com>';
        mail($to, $subject, $message, $headers);
    }

    public function test() {
        //file_put_contents(APPPATH . 'controllers/cron/monitoring_status.json', json_encode(["status" => "OK", "timestamp" => time()]), JSON_UNESCAPED_SLASHES);
        $lastStatus = json_decode(file_get_contents(APPPATH . 'controllers/cron/monitoring_status.json'));
        echo json_encode($lastStatus);
    }
}