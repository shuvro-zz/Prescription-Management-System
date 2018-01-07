<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;

class PaymentHandlerComponent extends Component
{

    public $components = ['Common','TrustCommerce','EmailHandler'];

    public function processPayment($post_data){

        $token = $this->getToken();

        $response = $this->sendPaymentInfo($token,$post_data);

        return $response;

    }

    public function getToken(){

        $returnurl 	= 'http://localhost/cp3/leanhealthatstanford/form/workshops';
        $action 	= 'sale';
        $other_data = array('ticket' => 'trusteeapi');

        $token = $this->TrustCommerce->genToken($action, $returnurl, $other_data);

        return $token;

    }

    public function sendPaymentInfo($token,$post_data){

        $post['token'] = $token;
        $post['action'] = 'sale';
        $post['returnurl'] = 'http://localhost/cp3/leanhealthatstanford/form/workshops';
        $post['amount'] = $this->getAmount($post_data);
        $post['cc'] = $post_data['Payment']['card_number'];
        $post['exp'] = $this->getExp($post_data['Payment']);
        $post['ticket'] = 'trusteeapi';
        $post['avs'] = 'n';
        $post['address1'] = $post_data['Delegate']['address1'];
        $post['zip'] = $post_data['Delegate']['postcode'];

        $page = 'payment.php';

        $this->TrustCommerce->send($page, $post, $debug = 'true');

        $response = $this->TrustCommerce->completeTrans($token);

        $data = $this->TrustCommerce->parseResponse($response);

        $response =array();
        if(!empty($data['status']) && $data['status'] == 'approved'){
            $response['status'] = $data['status'];
            $response['authcode'] = $data['authcode'];
            $response['transid'] = $data['transid'];
        } else {
            $response['status'] = 'failed';
        }

        return $response;
    }

    public function getAmount($post_data){
        /*$total = 0;
        foreach($post_data['Registration']['typePrice'] as $key=>$val){
            $explodedRegType = explode("_", $val);
            $total = $total + ($explodedRegType[2]  * $post_data['Registration']['quantity'][$key] );
        }
        $total = $total + ( 75 * $post_data['Program']['tickets'][0] );*/
        $total = sprintf ("%.2f", $post_data['Payment']['hidden_grand_total']);
        return $total;
    }

    public function getExp($payment_info){
        $payment_info['card_expiry_year'] = substr($payment_info['card_expiry_year'], 2);
        $exp = $payment_info['card_expiry_month'].$payment_info['card_expiry_year'];
        return $exp;
    }

}