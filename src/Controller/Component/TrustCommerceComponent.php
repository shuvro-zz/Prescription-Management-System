<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class TrustCommerceComponent extends Component
{

    private $base_url = 'https://vault.trustcommerce.com/trusteeapi/';
    private $response_params = array();
    private $custid = '';
    private $password = '';
    private $mode = '';


    function __construct($custid, $password) {

        $this->mode = 'test';
        //$this->mode = 'live';

        if($this->mode == 'live'){
            // TC Live Credential
            $this->custid =  '578623';
            $this->password = 'TagBunk3';
        } else {
            // TC Test Credential
            $this->custid =  '1052004';
            $this->password = 'CrepFmf7';
        }
    }

    // Send data via curl post to $base_url/$page.
    public function send($page, $post, $debug = false) {
        $curl_session = curl_init($this->base_url.$page);

        // So we can get the results
        curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_session, CURLOPT_POST, 1);
        curl_setopt($curl_session, CURLOPT_POSTFIELDS, $post);

        if($this->mode=='live') {
            curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, true);
        }else{
            curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
        }

        // Do the query
        $data = curl_exec($curl_session);

        // if data is empty there was a problem so in testing environment print out the curl error
        // it is not recommended to show this data to customers in a live environment
        if(empty($data) && $debug)
            $data = curl_error($curl_session);

        // Close the curl connection
        curl_close($curl_session);

        return $data;
    }

    /* public function genToken($action, $returnURL, $additional_params)
     * Generate a one time use token for use with TrusteeAPI.
     * @param $action - Name of action to be performed.
     * @param $returnURL - URL to redirect user to after payment information is stored.
     * @param $additional_params -  Any paramters that are to be protected from customer manipulation.
     */
    public function genToken($action, $returnURL, $additional_params = array(), $debug = true) {
        $data = '';

        if (empty($action)) {
            $data = 'error Action Missing';
        } else if (!preg_match("/^\w+$/",$action)) {
            $data = 'error Invalid Action';
        } else if (empty($returnURL)) {
            $data = 'error Return URL Missing';
        } else {

            $post = 'custid=' . urlencode($this->custid) . '&' .
                'password=' . urlencode($this->password) . '&' .
                'action=' . urlencode($action) . '&' .
                'returnurl=' . urlencode($returnURL);

            foreach($additional_params as $param => $val)
            {
                $post .= '&' . urlencode($param) . '=' . urlencode($val);
            }

            $data = $this->send('token.php', $post, $debug);
        }

        return $data;
    }

    /* public function paymentURL()
     * Return the fully qualified URL that payment information is submitted to by
     * the card holder
     */
    public function paymentURL() {
        return $this->base_url.'payment.php';
    }

    /* public function completeTrans($token)
     * Send a transaction completion request to TC TrusteeAPI.
     * @param $token - TrusteeAPI Token for the transaction in progress
     * @return text string containing new line separated parameter=value pairs
     */
    public function completeTrans($token, $debug = false) {

        $data = '';

        if (empty($token)) {
            $data = 'error Missing Token';
        } else {

            $post = 'token=' . urlencode($token) . '&' .
                'password=' . urlencode($this->password);

            $data = $this->send('complete.php', $post, $debug);

            $this->response_params = $this->parseResponse($data);
        }
        return $data;
    }

    /* public function parseResponse($response)
     * Parse the newline separated parameter=value pairs into an associative array
     * @param $response - Newline separated parameter=value pair string
     * @return associatve array containing all parameter value pairs from the response
     */
    public function parseResponse($response) {
        $data = array();

        $lines = explode("\n",$response);

        foreach($lines as $line) {
            if(!empty($line)){
                list($param, $val) = explode('=',$line,2);
                $data[$param] = $val;
            }
        }

        return $data;
    }

    /* public function validateRedirect($parameterstring)
     * Verify the hash provided in the response was provided by TC.
     * @param $parameterstring - the unmodified query string, everything in the url after the ?.
     * @return true/false to indicate if the hash matches.
     */
    public function validateRedirect($parameterstring) {
        parse_str($parameterstring, $params);

        $parameterstring = preg_replace("/&hash=\w+$/",'',$parameterstring);

        return (isset($params['hash']) && $params['hash'] == hash_hmac('sha1', $parameterstring, $this->password));
    }

    /* public function getResposneParams()
     * Grab the entire results array for the transaction response
     * @return array containing all parameter = value pairs provided in the response from TC.
     */
    public function &getResponseParams() {
        return $this->response_params;
    }

    /* public function getResposneParameter($param)
     * Grab the value for the given parameter
     * @param param - name of paramter provided in the response from TC.
     * @return string value for the given prameter name
     */
    public function getResponseParameter($param) {
        if (array_key_exists($param, $this->response_params))
            return $this->response_params[$param];
        else
            return;
    }


}
